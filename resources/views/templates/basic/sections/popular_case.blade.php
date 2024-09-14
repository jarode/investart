@php
    $content = getContent('popular_case.content', true);
    $popularCase = \App\Models\InvestmentCase::take(6)
        ->validated()
        ->active()
        ->approved()
        ->with(['user', 'reviews', 'invests.user', 'plans'])
        ->latest('id')
        ->get();
@endphp


<section class="popular-case pt-120 pb-60">
    <div class="container">
        <div class="section-heading style-left">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-6 col-md-8">
                    <h2 class="section-heading__title">{{ __(@$content->data_values->heading) }}</h2>
                    <p class="section-heading__desc">{{ __(@$content->data_values->subheading) }}</p>
                </div>
                @if ($popularCase->count() > 3)
                    <div class="col-lg-2 col-md-4 d-md-block d-none">
                        <div class="section-heading__slider-btn">
                            <button class="case-card-prev"><i class="las la-angle-left"></i></button>
                            <button class="case-card-next"><i class="las la-angle-right"></i></button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="case-card-slider popular-case-card-slider">
            @forelse ($popularCase as $popular)
                @include($activeTemplate . 'invest_card', [
                    'data' => $popular,
                    'showExpiredDate' => false,
                ])
            @empty
                <div class="text-center p-5">{{ __($emptyMessage) }}</div>
            @endforelse
        </div>
    </div>
</section>

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

            'use strict'

            $('.popular-case-card-slider').slick({
                slidesToShow: 3,
                slidesToScroll: 1,
                autoplay: false,
                autoplaySpeed: 2000,
                speed: 1500,
                pauseOnHover: false,
                arrows: false,
                dots: false,
                responsive: [{
                        breakpoint: 1200,
                        settings: {
                            slidesToShow: 2.5,
                        },
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            slidesToShow: 2,
                        },
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 1.5,
                            dots: true,
                        },
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 1,
                            dots: true,
                        },
                    },
                ],
            });
        });
    </script>
@endpush
