@php
    $content = getContent('testimonial.content', true);
    $elements = getContent('testimonial.element');
@endphp

<section class="testimonials py-120 section-bg-2">
    <div class="container">
        <div class="section-heading">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <h2 class="section-heading__title">{{ __(@$content->data_values->heading) }}</h2>
                    <p class="section-heading__desc">{{ __(@$content->data_values->subheading) }}</p>
                </div>
            </div>
        </div>
        <div class="testimonial-slider">
            @foreach ($elements as $element)
                <div class="testimonails-card">
                    <div class="testimonial-item">
                        <p class="testimonial-item__desc">{{ __($element->data_values->description) }}</p>
                        <div class="testimonial-item__content">
                            <div class="testimonial-item__info">
                                <div class="testimonial-item__thumb">
                                    <img src="{{ sectionImage('testimonial', $element->data_values->image, '55x55') }}"
                                        alt="@lang('image')">
                                </div>
                                <div class="testimonial-item__details">
                                    <h5 class="testimonial-item__name">{{ __($element->data_values->name) }}</h5>
                                    <span class="testimonial-item__location">@lang('From')
                                        {{ __($element->data_values->address) }}</span>
                                </div>
                                <div class="testimonial-item__vector">
                                    <img src="{{ asset($activeTemplateTrue . 'images/icons/testimonial-vector.png') }}"
                                        alt="@lang('img')">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
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

            $('.testimonial-slider').slick({
                slidesToShow: 3,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 2000,
                speed: 1500,
                dots: false,
                pauseOnHover: false,
                arrows: false,
                responsive: [{
                        breakpoint: 1200,
                        settings: {
                            arrows: false,
                            slidesToShow: 2,
                        },
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            arrows: false,
                            slidesToShow: 1,
                        },
                    },
                ],
            });
        });
    </script>
@endpush
