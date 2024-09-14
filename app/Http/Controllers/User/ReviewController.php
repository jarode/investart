<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\InvestmentCase;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function reviewSubmit(Request $request,$id)
    {
        $request->validate([
            'rating' =>'required|max:5|min:1',
            'comment' =>'required|max:255'
        ]);

        $case = InvestmentCase::findOrFail($id);

        if($case->user_id == auth()->user()->id)
        {
            $notify[] = ['error',"You can't review your case"];
            return back()->withNotify($notify);
        }
        $existing = Review::where(['case_id' => $case->id,'user_id'=>auth()->user()->id])->first();
        if($existing){
            $notify[] = ['error','You have already review on this case.'];
            return back()->withNotify($notify);
        }
        $review = new Review();
        $review->user_id = auth()->user()->id;
        $review->case_id = $case->id;
        $review->rating = $request->rating;
        $review->comment = $request->comment;
        $review->save();

        $notify[] = ['success','Your review successfully submitted.'];
        return back()->withNotify($notify);
    }
}
