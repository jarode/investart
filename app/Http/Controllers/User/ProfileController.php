<?php

namespace App\Http\Controllers\User;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Carbon\Carbon;


class ProfileController extends Controller
{
    public function profile()
    {
        $pageTitle = "Profile Setting";
        $user      = auth()->user();
        return view($this->activeTemplate. 'user.profile_setting', compact('pageTitle','user'));
    }

    public function submitProfile(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string',
            'lastname'  => 'required|string',
            'position'  => 'required|string',
            'image'     => 'sometimes|mimes:jpg,png,jpeg'
        ],[
            'firstname.required' => 'First name field is required',
            'lastname.required'  => 'Last name field is required',
            'position.required'  => 'Position field is required',
            'image.sometimes'    => 'image format is jpg,png,jpeg'
        ]);

        $user = auth()->user();

        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->position = $request->position;
        $user->about = $request->about;
        if($request->image){
            $user->image = fileUploader($request->image,getFilePath('userProfile'),getFileSize('userProfile'),@$user->image);
        }

        $user->address = [
            'address' => $request->address,
            'state' => $request->state,
            'zip' => $request->zip,
            'country' => @$user->address->country,
            'city' => $request->city,
        ];

        $user->save();
        $notify[] = ['success', 'Profile updated successfully'];
        return back()->withNotify($notify);
    }

    public function changePassword()
    {
        $pageTitle = 'Change Password';
        return view($this->activeTemplate . 'user.password', compact('pageTitle'));
    }

    public function submitPassword(Request $request)
    {

        $passwordValidation = Password::min(6);
        if (gs('secure_password')) {
            $passwordValidation = $passwordValidation->mixedCase()->numbers()->symbols()->uncompromised();
        }

        $this->validate($request, [
            'current_password' => 'required',
            'password' => ['required','confirmed',$passwordValidation]
        ]);

        $user = auth()->user();
        if (Hash::check($request->current_password, $user->password)) {
            $password = Hash::make($request->password);
            $user->password = $password;
            $user->save();
            $notify[] = ['success', 'Password changes successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'The password doesn\'t match!'];
            return back()->withNotify($notify);
        }
    }

    public function enableBadge()
    {

        $user        = auth()->user();

        if($user->verified_badge_active == Status::BADGE_ACTIVE){
            $notify[] = ['error',"Already activated badge"];
            return back()->withNotify($notify);
        }
        $currentDate = Carbon::now();
        $currentDate = Carbon::now();
        $expiredDate = $currentDate->addMonth();
        $price       = gs('verified_badge_price');

        if($user->badge_expired > now()){
            $user->verified_badge_active = Status::BADGE_ACTIVE;
            $user->save();
            $notify[] = ['success', 'Badge activated successfully'];
            return back()->withNotify($notify);
        }


        if($user->balance < $price){
            $notify[] = ['error', 'You do not have sufficient balance for this action'];
            return back()->withNotify($notify);
        }

        $user->balance -= $price;
        $user->verified_badge_active = Status::BADGE_ACTIVE;
        $user->badge_expired = showDateTime($expiredDate,'d M Y H:i:s');
        $user->save();

        $transaction               = new Transaction();
        $transaction->user_id      = $user->id;
        $transaction->amount       = $price;
        $transaction->post_balance = $user->balance;
        $transaction->charge       = 0;
        $transaction->trx_type     = '-';
        $transaction->details      = "verified badge purchase";
        $transaction->trx          = getTrx();
        $transaction->remark       = 'purchase_badge';
        $transaction->save();

        notify($user,'PURCHASE_BADGE',[
            'expire' => showDateTime($expiredDate)
        ]);

        $notify[] = ['success', 'Badge activated successfully'];
        return back()->withNotify($notify);
    }

    public function disableBadge()
    {
        $user = auth()->user();
        $user->verified_badge_active = Status::BADGE_INACTIVE;
        $user->save();

        $notify[] = ['success', 'Badge disable successfully'];
        return back()->withNotify($notify);
    }
}
