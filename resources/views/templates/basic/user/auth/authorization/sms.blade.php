@extends($activeTemplate . 'layouts.auth')
@section('content')
    <div class="account-form__wrap verification-code-wrapper authentication-page">
        <div class="account-form__content">
            <div class="logo mb-0"><a href="{{ route('home') }}"><img src="{{ siteLogo() }}" alt="@lang('Logo')"></a></div>
        </div>
        <form action="{{ route('user.verify.mobile') }}" method="POST" class="submit-form">
            @csrf
            <div class="mb-3">
                <h3 class="have-account__text mb-2">{{ __($pageTitle)}}</h3>
                <p class="verification-text have-account__text">@lang('A 6 digit verification code sent to your mobile number') : +{{ showMobileNumber(auth()->user()->mobile) }}</p>
            </div>
            @include($activeTemplate . 'partials.verification_code')
            <div class="mb-3">
                <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
            </div>
            <div class="form-group">
                <p class="text-white">
                    @lang('If you don\'t get any code'), <a class="text--base" href="{{ route('user.send.verify.code', 'phone') }}" class="forget-pass">
                        @lang('Try again')</a>
                </p>
                @if ($errors->has('resend'))
                    <br />
                    <small class="text--danger">{{ $errors->first('resend') }}</small>
                @endif
            </div>
        </form>
    </div>
@endsection

@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/global/css/verification-code.css') }}">
@endpush
