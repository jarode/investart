@php
    $credentials = $general->socialite_credentials;
@endphp
@if (
    $credentials->google->status == Status::ENABLE ||
        $credentials->facebook->status == Status::ENABLE ||
        $credentials->linkedin->status == Status::ENABLE)
    <div class="login-option">
        @if ($credentials->facebook->status == Status::ENABLE)
            <a href="{{ route('user.social.login', 'facebook') }}">
                <img src="{{ asset($activeTemplateTrue . 'images/icons/facebook.png') }}" alt="@lang('image')">
            </a>
        @endif

        @if ($credentials->google->status == Status::ENABLE)
            <a href="{{ route('user.social.login', 'google') }}">
                <img src="{{ asset($activeTemplateTrue . 'images/icons/google.png') }}" alt="@lang('image')">
            </a>
        @endif

        @if ($credentials->linkedin->status == Status::ENABLE)
            <a href="{{ route('user.social.login', 'linkedin') }}">
                <img src="{{ asset($activeTemplateTrue . 'images/icons/linkedin.png') }}" alt="@lang('image')">
            </a>
        @endif
    </div>

    <div class="divider"><span>@lang('OR')</span></div>
@endif
