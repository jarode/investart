<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CaseCreatorKycMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        
        if ($user->ckv == 0) {
            $notify[] = ['error','You are not Case Creator KYC verified. For being KYC verified, please provide these information'];
            return to_route('user.case.creator.kyc.form')->withNotify($notify);
        }

        if ($user->ckv == 2) {
            $notify[] = ['warning','Your documents for Case Creator KYC verification is under review. Please wait for admin approval'];
            return to_route('user.case.history')->withNotify($notify);
        }
        
        return $next($request);
    }
}
