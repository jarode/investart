@php
    $socials = getContent('social_icon.element', orderById: true);
    $banners = getContent('banner.element', orderById: true);
    $clients = getContent('client.element', orderById: true);
@endphp

<section class="banner-section">
    <div class="banner-section__slider">
        @foreach ($banners as $banner)
            <div class="banner-section__slide bg-img"
                data-background-image="{{ sectionImage('banner', @$banner->data_values->background_image, '1900x900') }}">
                <div class="container container-lg">
                    <div class="row justify-content-end">
                        <div class="col-xxl-9 col-xl-10 col-lg-9">
                            <div class="banner-content">
                                <span class="banner-content__vector">
                                    <img src="{{ asset($activeTemplateTrue . 'images/icons/banner-vector.png') }}" alt="vector">
                                </span>
                                <p class="banner-content__desc">{{ __(@$banner->data_values->description) }}</p>
                                <h1 class="banner-content__title" data-s-break="-2">{{ __(@$banner->data_values->title) }}</h1>
                                <div class="banner-cta position-relative">
                                    <a href="{{ $banner->data_values->btn_url }}" class="banner-content__button">
                                        <span class="icon"><i class="fas fa-arrow-right"></i></span>
                                        <span class="circle-txt">{{ $banner->data_values->btn_name }} </span>
                                    </a>
                                </div>
                                <div class="banner-content__social">
                                    @foreach ($socials as $social)
                                        <a target="_blank" href="{{ $social->data_values->url }}">{{ __($social->data_values->title) }}</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>

<div class="client gradient-bg">
    <div class="container">
        <div class="client__slider">
            @foreach ($clients as $client)
                <div class="client__slide">
                    <img src="{{ sectionImage('client', @$client->data_values->image, '100x25') }}" alt="@lang('image')">
                </div>
            @endforeach
        </div>
    </div>
</div>

@push('style-lib')
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/jquery.bxslider.min.css') }}">
@endpush

@push('script-lib')
    <script src="{{ asset($activeTemplateTrue . 'js/jquery.bxslider.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/circletype.min.js') }}"></script>
@endpush

@if (!app()->offsetExists('slick_script'))
    @push('style-lib')
        <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/slick.css') }}">
    @endpush

    @push('script-lib')
        <script src="{{ asset($activeTemplateTrue . 'js/slick.min.js') }}"></script>
    @endpush
    @php app()->offsetSet('slick_script',true) @endphp
@endif

@push('script')
    <script>
        $(function() {
            'use strict';

            $('.client__slider').bxSlider({
                minSlides: 6,
                maxSlides: 6,
                slideWidth: $(window).outerWidth() / 6,
                slideMargin: 30,
                ticker: true,
                speed: 9000,
                responsive: true
            });

            $('.banner-section__slider').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplay: true,
                fade: true,
                autoplaySpeed: 2000,
                speed: 1500,
                pauseOnHover: false,
                arrows: false,
                dots: true,
                adaptiveHeight: true,
                customPaging: function(slider, i) {
                    var index = ('0' + (i + 1)).slice(-2);
                    return '<button>' + index + '</button>';
                }
            });

            let elements = document.querySelectorAll('[data-s-break]');
            Array.from(elements).forEach(element => {
                let html = element.innerHTML;
                if (typeof html != 'string') {
                    return false;
                }
                let breakLength = parseInt(element.getAttribute('data-s-break'));
                html = html.split(" ");
                var colorText = [];
                if (breakLength < 0) {
                    colorText = html.slice(breakLength);
                } else {
                    colorText = html.slice(0, breakLength);
                }
                let solidText = [];
                html.filter(ele => {
                    if (!colorText.includes(ele)) {
                        solidText.push(ele);
                    }
                });
                var color = element.getAttribute('s-color') || "styled-title";
                colorText = `<span class="${color}">${colorText.toString().replaceAll(',', ' ')}</span>`;
                solidText = solidText.toString().replaceAll(',', ' ');
                breakLength < 0 ? element.innerHTML = `${solidText} ${colorText}` : element.innerHTML = `${colorText} ${solidText}`
            });
        });
    </script>
@endpush
