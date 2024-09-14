@extends($activeTemplate . 'layouts.auth')
@section('content')
    <div class="account-form__wrap verification-code-wrapper authentication-page">
        <div class="account-form__content">
            <div class="logo mb-0"><a href="{{ route('home') }}"><img src="{{ siteLogo() }}" alt="@lang('Logo')"></a></div>
        </div>
        <form action="{{ route('user.password.verify.code') }}" method="POST" class="submit-form">
            @csrf
            <h3 class="have-account__text mb-0">{{ __($pageTitle) }}</h3>
            <p class="have-account__text verification-text mb-3">@lang('A 6 digit verification code sent to your email address') : {{ showEmailAddress($email) }}</p>
            <input type="hidden" name="email" value="{{ $email }}">

            @include($activeTemplate . 'partials.verification_code')

            <div class="row g-3">
                <div class="col-sm-12">
                    <div class="form-group have-account__text">
                        @lang('Please check including your Junk/Spam Folder. if not found, you can')
                        <a href="{{ route('user.password.request') }}">@lang('Try to send again')</a>
                    </div>
                </div>
                <x-captcha />
                <div class="col-sm-12">
                    <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                </div>

            </div>
        </form>
    </div>
@endsection

@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/global/css/verification-code.css') }}">
@endpush
