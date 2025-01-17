<?php

use Illuminate\Support\Facades\Route;

Route::namespace('User\Auth')->name('user.')->group(function () {

    Route::controller('LoginController')->group(function () {
        Route::get('/login', 'showLoginForm')->name('login');
        Route::post('/login', 'login');
        Route::get('logout', 'logout')->middleware('auth')->name('logout');
    });

    Route::controller('RegisterController')->group(function () {
        Route::get('register', 'showRegistrationForm')->name('register');
        Route::post('register', 'register')->middleware('registration.status');
        Route::post('check-mail', 'checkUser')->name('checkUser');
    });

    Route::controller('ForgotPasswordController')->prefix('password')->name('password.')->group(function () {
        Route::get('reset', 'showLinkRequestForm')->name('request');
        Route::post('email', 'sendResetCodeEmail')->name('email');
        Route::get('code-verify', 'codeVerify')->name('code.verify');
        Route::post('verify-code', 'verifyCode')->name('verify.code');
    });
    Route::controller('ResetPasswordController')->group(function () {
        Route::post('password/reset', 'reset')->name('password.update');
        Route::get('password/reset/{token}', 'showResetForm')->name('password.reset');
    });

    Route::controller('SocialiteController')->group(function () {
        Route::get('social-login/{provider}', 'socialLogin')->name('social.login');
        Route::get('social-login/callback/{provider}', 'callback')->name('social.login.callback');
    });
});

Route::middleware('auth')->name('user.')->group(function () {
    //authorization
    Route::namespace('User')->controller('AuthorizationController')->group(function () {
        Route::get('authorization', 'authorizeForm')->name('authorization');
        Route::get('resend-verify/{type}', 'sendVerifyCode')->name('send.verify.code');
        Route::post('verify-email', 'emailVerification')->name('verify.email');
        Route::post('verify-mobile', 'mobileVerification')->name('verify.mobile');
        Route::post('verify-g2fa', 'g2faVerification')->name('go2fa.verify');
    });

    Route::middleware(['check.status'])->group(function () {

        Route::get('user-data', 'User\UserController@userData')->name('data');
        Route::post('user-data-submit', 'User\UserController@userDataSubmit')->name('data.submit');

        Route::middleware('registration.complete')->namespace('User')->group(function () {

            Route::controller('UserController')->group(function () {
                Route::get('dashboard', 'home')->name('home');

                //2FA
                Route::get('twofactor', 'show2faForm')->name('twofactor');
                Route::post('twofactor/enable', 'create2fa')->name('twofactor.enable');
                Route::post('twofactor/disable', 'disable2fa')->name('twofactor.disable');

                //KYC
                Route::get('kyc-form', 'kycForm')->name('kyc.form');
                Route::get('kyc-data', 'kycData')->name('kyc.data');
                Route::post('kyc-submit', 'kycSubmit')->name('kyc.submit');

                Route::get('case/creator/kyc-form', 'caseCreatorKycForm')->name('case.creator.kyc.form');
                Route::get('case/creator/kyc-data', 'caseCreatorKycData')->name('case.creator.kyc.data');
                Route::post('case/creator/kyc-submit', 'caseCreatorKycSubmit')->name('case.creator.kyc.submit');

                //Report
                Route::any('deposit/history', 'depositHistory')->name('deposit.history');
                Route::get('transactions', 'transactions')->name('transactions');
                Route::get('referrals', 'referrals')->name('referrals');
                Route::get('attachment-download/{fil_hash}', 'attachmentDownload')->name('attachment.download');
            });

            //Profile setting
            Route::controller('ProfileController')->group(function () {
                Route::get('profile-setting', 'profile')->name('profile.setting');
                Route::post('profile-setting', 'submitProfile');
                Route::get('change-password', 'changePassword')->name('change.password');
                Route::post('change-password', 'submitPassword');
                Route::post('enable/badge/verified', 'enableBadge')->name('enable.badge');
                Route::post('disable/badge/verified', 'disableBadge')->name('disable.badge');
            });

            //Investment case
            Route::controller('CaseController')->name('case.')->group(function () {
                Route::get('case', 'investCase')->name('index');

                Route::middleware('ckyc')->group(function () {
                    Route::get('case/form/step-1/{id?}', 'caseFormOne')->name('step.one');
                    Route::get('case/form/step-2/{id}', 'caseFormTwo')->name('step.two');
                    Route::get('case/form/step-3/{id}', 'caseFormThree')->name('step.three');
                    Route::get('case/form/step-4/{id}', 'caseFormFour')->name('step.four');
                    Route::post('case/submit-one/{id?}', 'investCaseSubmitOne')->name('submit.one');
                    Route::post('case/submit-two/{id?}', 'investCaseSubmitTwo')->name('submit.two');
                    Route::post('case/submit-three/{id?}', 'investCaseSubmitThree')->name('submit.three');
                });

                Route::get('case/form/{count}', 'form')->name('form');
                Route::get('case/history', 'investCaseHistory')->name('history');
                Route::get('case/log/{id}', 'caseLog')->name('log');
                Route::post('status/{id}', 'status')->name('status');
                Route::get('case/plan/{code}/{id}', 'planView')->name('segment.view');
                Route::post('case/plan/{code}/{id}', 'investSubmit')->name('segment.submit');
            });

            Route::controller('InvestController')->group(function () {
                Route::get('invest/list', 'investList')->name('invest.list');
                Route::get('profit/return', 'profitReturn')->name('profit.return');
                Route::post('profit/return/submit', 'profitReturnAllSubmit')->name('profit.return.all.submit');
                Route::post('profit/return/{id}', 'profitReturnSubmit')->name('profit.return.submit');
            });

            //Comment
            Route::controller('CommentController')->group(function () {
                Route::post('comment/submit/{id}', 'commentSubmit')->name('comment.submit');
            });

            //Review
            Route::controller('ReviewController')->group(function () {
                Route::post('review/submit/{id}', 'reviewSubmit')->name('review.submit');
            });


            // Withdraw
            Route::controller('WithdrawController')->prefix('withdraw')->name('withdraw')->group(function () {
                Route::middleware('kyc')->group(function () {
                    Route::get('/', 'withdrawMoney');
                    Route::post('/', 'withdrawStore')->name('.money');
                    Route::get('preview', 'withdrawPreview')->name('.preview');
                    Route::post('preview', 'withdrawSubmit')->name('.submit');
                });
                Route::get('history', 'withdrawLog')->name('.history');
            });
        });

        // Payment
        Route::middleware('registration.complete')->prefix('deposit')->name('deposit.')->controller('Gateway\PaymentController')->group(function () {
            Route::any('/', 'deposit')->name('index');
            Route::post('insert', 'depositInsert')->name('insert');
            Route::get('confirm', 'depositConfirm')->name('confirm');
            Route::get('manual', 'manualDepositConfirm')->name('manual.confirm');
            Route::post('manual', 'manualDepositUpdate')->name('manual.update');
        });
    });
});
