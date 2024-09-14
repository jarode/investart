@extends($activeTemplate . 'layouts.auth')
@section('content')
    <div class="account-form__wrap verification-code-wrapper authentication-page">
        <div class="account-form__content">
            <div class="logo mb-0"><a href="{{ route('home') }}"><img src="{{ siteLogo() }}" alt="@lang('Logo')"></a></div>
        </div>
        <form method="POST" action="{{ route('user.verify.email') }}" class="submit-form">
            @csrf
            <div class="mb-3">
                <h3 class="mb-2 have-account__text">{{ __($pageTitle)}}</h3>
                <p class="have-account__text mb-0">@lang('A 6 digit verification code sent to your email address'): {{ showEmailAddress(auth()->user()->email) }}</p>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    @include($activeTemplate . 'partials.verification_code')
                </div>
                <div class="col-sm-12">
                    <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                </div>
                <div class="col-sm-12">
                    <p class="have-account__text">
                        @lang('If you don\'t get any code'), <a href="{{ route('user.send.verify.code', 'email') }}"> @lang('Try again')</a>
                    </p>
                    @if ($errors->has('resend'))
                        <small class="text--danger d-block">{{ $errors->first('resend') }}</small>
                    @endif
                </div>
            </div>
        </form>
    </div>
@endsection

@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/global/css/verification-code.css') }}">
@endpush
