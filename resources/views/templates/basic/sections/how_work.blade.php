@php
    $content = getContent('how_work.content', true);
    $elements = getContent('how_work.element', orderById: true);
@endphp

<div class="how-it-works py-120 bg-img" data-background-image="{{ sectionImage('how_work', @$content->data_values->background_image, '1920x920') }}">
    <div class="container">
        <div class="section-heading">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <h2 class="section-heading__title">{{ __(@$content->data_values->heading) }}</h2>
                    <p class="section-heading__desc">{{ __(@$content->data_values->subheading) }}</p>
                </div>
            </div>
        </div>
        <div class="row align-items-center justify-content-between g-4">
            <div class="col-xl-6 col-lg-7 ">
                <div class="how-it-works__grid">
                    @foreach ($elements as $k => $element)
                        <div class="how-it-works__card">
                            <div class="how-it-works__card__icon">
                                <img src="{{ sectionImage('how_work', $element->data_values->icon, '50x50') }}" alt="@lang('Icon')">
                            </div>
                            <div class="how-it-works__card__index">{{ $k + 1 }}</div>
                            <div class="how-it-works__card__txt">
                                <h3 class="how-it-works__card__title">{{ __($element->data_values->title) }}</h3>
                                <p class="how-it-works__card__desc">{{ __($element->data_values->details) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-block">
                <div class="how-it-works__thumb">
                    <img src="{{ sectionImage('how_work', @$content->data_values->image, '525x710') }}" alt="@lang('image')">
                </div>
            </div>
        </div>
    </div>
</div>
