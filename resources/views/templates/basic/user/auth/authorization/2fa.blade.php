@extends($activeTemplate . 'layouts.auth')
@section('content')
    <div class="account-form__wrap verification-code-wrapper authentication-page">
        <div class="account-form__content">
            <div class="logo mb-0"><a href="{{ route('home') }}"><img src="{{ siteLogo() }}" alt="@lang('Logo')"></a></div>
        </div>
        <form action="{{ route('user.go2fa.verify') }}" method="POST" class="submit-form">
            @csrf
            <div class="mb-3">
                <h3 class="have-account__text">{{ __($pageTitle) }}</h3>
            </div>
            @include($activeTemplate . 'partials.verification_code')
            <div>
                <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
            </div>
        </form>
    </div>
@endsection
