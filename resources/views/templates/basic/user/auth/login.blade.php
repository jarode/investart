@extends($activeTemplate . 'layouts.auth')
@section('content')
    <div class="account-form__wrap">
        <div class="account-form__content">
            <div class="logo"><a href="{{ route('home') }}"><img src="{{ siteLogo() }}" alt="@lang('Logo')"></a></div>
            @include($activeTemplate . '.user.auth.social_login')
        </div>
        <form method="POST" action="{{ route('user.login') }}" class="verify-gcaptcha">
            @csrf
            <div class="row">
                <div class="col-sm-12 mb-3">
                    <div class="form--floating form-floating">
                        <input type="text" name="username" required value="{{ old('username') }}" placeholder="@lang('Email or Username')"
                            class="form-control form--control">
                        <label>@lang('Email or Username')</label>
                    </div>
                </div>
                <div class="col-sm-12 mb-3">
                    <div class="form--floating form-floating form--floating--password">
                        <input id="password" type="password" name="password" class="form-control form--control" placeholder="@lang('Password')">
                        <label>@lang('Password')</label>
                        <a role="button" data-password-id="password"><i class="far fa-eye"></i></a>
                    </div>
                </div>
                <x-captcha />
                <div class="col-sm-12 mb-3">
                    <div class="d-flex flex-wrap justify-content-between">
                        <div class="form--check">
                            <input class="form-check-input" type="checkbox" value="" id="remember">
                            <label class="form-check-label fs-14" for="remember">@lang('Remember me')</label>
                        </div>
                        <a href="{{ route('user.password.request') }}" class="forgot-password text-white fs-14">@lang('Forgot Your Password')?</a>
                    </div>
                </div>

                <div class="col-sm-12 mb-3">
                    <button type="submit" class="btn btn--base w-100">@lang('Log In')</button>
                </div>
                <div class="col-sm-12 mb-3">
                    <div class="have-account">
                        <p class="have-account__text">
                            @lang("Don't Have an Account")? <a href="{{ route('user.register') }}" class="have-account__link">@lang('Register Now')</a>
                        </p>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
