@php
    $ctaContent = @getContent('cta.content', true)->data_values;
@endphp
<section class="cta-section  pb-120">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="cta-wrapper">
                    <div class="row">
                        <div class="col-md-6 px-md-0 d-none d-md-block">
                            <div class="cta-thumb">
                                <img src="{{ sectionImage('cta', @$ctaContent->image, '600x440') }}" alt="cta-image">
                            </div>
                        </div>
                        <div class="col-md-6 px-md-0">
                            <div class="cta-content bg-img"
                                data-background-image="{{ sectionImage('cta', @$ctaContent->background_image, '700x500') }}">
                                <div class="cta-content__inner">
                                    <h2 class="cta-content__title text-white">{{ __(@$ctaContent->heading) }}</h2>
                                    <p class="cta-content__desc text-white">{{ __(@$ctaContent->subheading) }}</p>
                                    <a href="{{ __(@$ctaContent->button_url) }}" class="btn btn--base">{{ __(@$ctaContent->button_text) }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
