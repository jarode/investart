<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\InvestmentCase;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function commentSubmit(Request $request,$id)
    {
        $request->validate([
            'comment' => 'required | max:255'
        ]);

        $case = InvestmentCase::findOrfail($id);
        $user = auth()->user();

        $exist = Comment::where(['user_id' => $user->id,'case_id'=>$case->id])->first();
        if ($exist) {
            $notify[] = ['error', 'You have already commented on this case.'];
            return back()->withNotify($notify);
        }

        $comment = new Comment();
        $comment->user_id = $user->id;
        $comment->case_id = $case->id;
        $comment->comment = $request->comment;
        $comment->save();

        $notify[] = ['success', 'Comment has been submitted successfully been'];
        return back()->withNotify($notify);
    }
}
