    <!doctype html>
    <html lang="{{ config('app.locale') }}" itemscope itemtype="http://schema.org/WebPage">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title> {{ $general->siteName(__($pageTitle)) }}</title>
        @include('partials.seo')

        <link href="{{ asset('assets/global/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/global/css/all.min.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('assets/global/css/line-awesome.min.css') }}">

        <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/custom.css') }}">

        @stack('style-lib')
        @stack('style')

        <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/main.css') }}">
        <link rel="stylesheet"
            href="{{ asset($activeTemplateTrue . 'css/color.php') }}?color={{ $general->base_color }}&secondColor={{ $general->secondary_color }}">

    </head>

    <body>
        @stack('fbComment')
        <div class="preloader">
            <div class="loader-p"></div>
        </div>

        <div class="body-overlay"></div>

        <div class="sidebar-overlay"></div>
        <a class="scroll-top"><i class="fas fa-angle-double-up"></i></a>

        @include($activeTemplate . 'partials.header')
        <main>
            @if (!request()->routeIs('home'))
                @include($activeTemplate . 'partials.breadcrumb')
            @endif
            @yield('content')
        </main>
        @php
            $cookie = App\Models\Frontend::where('data_keys', 'cookie.data')->first();
        @endphp
        @if ($cookie->data_values->status == Status::ENABLE && !\Cookie::get('gdpr_cookie'))
            <div class="cookies-card text-center hide">
                <div class="cookies-card__icon">
                    <i class="las la-cookie-bite"></i>
                </div>
                <p class="mt-4 cookies-card__content">{{ $cookie->data_values->short_desc }} <a href="{{ route('cookie.policy') }}"
                        target="_blank">@lang('learn more')</a></p>
                <div class="cookies-card__btn mt-4">
                    <a href="javascript:void(0)" class="btn btn--base w-100 policy">@lang('Allow')</a>
                </div>
            </div>
        @endif

        @include($activeTemplate . 'partials.footer')

        <script src="{{ asset('assets/global/js/jquery-3.7.1.min.js') }}"></script>
        <script src="{{ asset('assets/global/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset($activeTemplateTrue . 'js/viewport.jquery.js') }}"></script>
        <script src="{{ asset($activeTemplateTrue . 'js/main.js') }}"></script>

        @stack('script-lib')
        @include('partials.plugins')
        @include('partials.notify')
        @stack('script')

        <script>
            (function($) {
                "use strict";
                $(".langSel").on("change", function() {
                    window.location.href = "{{ route('home') }}/change/" + $(this).val();
                });
                $('.policy').on('click', function() {
                    $.get('{{ route('cookie.accept') }}', function(response) {
                        $('.cookies-card').addClass('d-none');
                    });
                });

                setTimeout(function() {
                    $('.cookies-card').removeClass('hide')
                }, 2000);

                var inputElements = $('[type=text],select,textarea');
                $.each(inputElements, function(index, element) {
                    element = $(element);
                    element.closest('.form-group').find('label').attr('for', element.attr('name'));
                    element.attr('id', element.attr('name'))
                });

                $.each($('input, select, textarea'), function(i, element) {
                    var elementType = $(element);
                    if (elementType.attr('type') != 'checkbox') {
                        if (element.hasAttribute('required')) {
                            $(element).closest('.form-group').find('label').addClass('required');
                        }
                    }
                });

                Array.from(document.querySelectorAll('.table')).forEach(table => {
                    let heading = table.querySelectorAll('thead tr th');
                    Array.from(table.querySelectorAll('tbody tr')).forEach((row) => {
                        Array.from(row.querySelectorAll('td')).forEach((colum, i) => {
                            colum.setAttribute('data-label', heading[i].innerText)
                        });
                    });
                });

                $('.footer-subscribe__form').on('submit', function(e) {
                    e.preventDefault();
                    var data = $(this).serialize();

                    $.ajax({
                        type: "POST",
                        url: "{{ route('subscribe') }}",
                        data: data,
                        success: function(response) {
                            if (response.status == 'success') {
                                notify('success', response.message);
                                $('.footer-subscribe__form').find('input[name=email]').val('');
                            } else {
                                notify('error', response.message);
                            }
                        }
                    });
                });
            })(jQuery);
        </script>
    </body>

    </html>
