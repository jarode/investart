@extends($activeTemplate . 'layouts.auth')
@section('content')
    <div class="account-form__wrap  authentication-page">
        <div class="account-form__content">
            <div class="logo mb-0"><a href="{{ route('home') }}"><img src="{{ siteLogo() }}" alt="@lang('Logo')"></a></div>


        </div>
        <form method="POST" action="{{ route('user.password.update') }}">
            @csrf
            <div class="row g-3">
                <div class="col-sm-12">
                    <input type="hidden" name="email" value="{{ $email }}">
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="mb-3">
                        <h3 class="have-account__text mb-0">{{ __($pageTitle) }}</h3>
                        <p class="have-account__text verification-text mb-0">@lang('Your account is verified successfully. Now you can change your password. Please enter a strong password and don\'t share it with anyone.')</p>
                    </div>
                    <div class="form--floating form-floating mb-3">
                        <input type="password" name="password" required placeholder="@lang('Password')"
                            class="form-control @if ($general->secure_password) secure-password @endif  form--control">
                        <label>@lang('Password')</label>
                    </div>
                    <div class="form--floating form-floating">
                        <input type="password" name="password_confirmation" required placeholder="@lang('Confirm Password')" class="form-control form--control">
                        <label>@lang('Confirm Password')</label>
                    </div>
                </div>

                <div class="col-sm-12">
                    <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                </div>

            </div>
        </form>
    </div>
@endsection

@if ($general->secure_password)
    @push('script-lib')
        <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
    @endpush
@endif
