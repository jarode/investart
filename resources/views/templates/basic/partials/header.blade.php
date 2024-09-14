<header class="header" id="header">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand logo" href="{{ route('home') }}">
                <img src="{{ siteLogo() }}" alt="@lang('logo')">
            </a>
            <button class="navbar-toggler header-button" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                <span id="hiddenNav"><i class="las la-bars"></i></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav nav-menu ms-auto align-items-lg-center">
                    <li class="nav-item {{ menuActive('home') }}">
                        <a class="nav-link" href="{{ route('home') }}">@lang('Home')</a>
                    </li>
                    <li class="nav-item {{ menuActive('investment') }}">
                        <a class="nav-link" href="{{ route('investment') }}">@lang('Investment')</a>
                    </li>
                    <li class="nav-item {{ menuActive('blog') }}">
                        <a class="nav-link" href="{{ route('blog') }}">@lang('Blog')</a>
                    </li>
                    <li class="nav-item {{ menuActive('contact') }}">
                        <a class="nav-link" href="{{ route('contact') }}">@lang('Contact')</a>
                    </li>

                    <li class="nav-item dropdown responsiveMenuButtons">
                        <div class="header__btns d-inline-flex d-lg-none">
                            @auth
                                <a class="btn btn--base" href="{{ route('user.home') }}">@lang('Dashboard')</a>
                            @else
                                <a class="btn btn--base" href="{{ route('user.register') }}">@lang('Join ')</a>
                            @endauth
                        </div>
                        @if (gs('multi_language'))
                            @php
                                $language = App\Models\Language::all();
                            @endphp
                            <select class="langSel form--control select">
                                @foreach ($language as $item)
                                    <option value="{{ $item->code }}" @if (session('lang') == $item->code) selected @endif>{{ __($item->name) }}
                                    </option>
                                @endforeach
                            </select>
                        @endif
                    </li>

                    @auth
                        <li class="nav-item d-lg-block d-none">
                            <div class="header__btns">
                                <a class="btn btn--base" href="{{ route('user.home') }}">@lang('Dashboard')</a>
                            </div>
                        </li>
                    @else
                        <li class="nav-item d-lg-block d-none">
                            <div class="header__btns">
                                <a class="btn btn--base" href="{{ route('user.register') }}">@lang('Join ')</a>
                            </div>
                        </li>
                    @endauth

                </ul>
            </div>
        </nav>
    </div>
</header>
