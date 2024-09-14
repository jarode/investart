@extends($activeTemplate . 'layouts.auth')
@section('content')
    <div class="account-form__wrap authentication-page">
        <div class="account-form__content">
            <div class="logo"><a href="{{ route('home') }}"><img src="{{ siteLogo() }}" alt="@lang('Logo')"></a></div>
            <p class="have-account__text">@lang('To recover your account please provide your email or username to find your account.')</p>
        </div>
        <form method="POST" action="{{ route('user.password.email') }}" class="verify-gcaptcha">
            @csrf
            <div class="row g-3">
                <div class="col-sm-12">

                    <div class="form--floating form-floating">
                        <input type="text" name="value" required value="{{ old('value') }}"
                            placeholder="@lang('Email or Username')" class="form-control form--control">
                        <label>@lang('Email or Username')</label>
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
