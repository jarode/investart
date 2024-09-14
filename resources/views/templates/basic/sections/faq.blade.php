@php
    $content  = getContent('faq.content', true);
    $elements = getContent('faq.element');
@endphp

<section class="faq py-120 bg--dark">
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-lg-6 d-none d-lg-block">
                <div class="faq__thumb">
                    <img src="{{ sectionImage('faq', @$content->data_values->image, '450x520') }}" alt="@lang('image')">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="faq__content">
                    <h2 class="faq__content__title">{{ __(@$content->data_values->heading) }}</h2>
                    <div class="custom--accordion accordion" id="accordionExample">
                        @foreach ($elements as $k => $element)
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collaps{{ $k }}" aria-expanded="{{ $k == 0 ? 'true' : 'false' }}"
                                        aria-controls="collaps{{ $k }}">
                                        {{ __($element->data_values->question) }}
                                    </button>
                                </h2>
                                <div id="collaps{{ $k }}" class="accordion-collapse collapse {{ $k == 0 ? 'show' : '' }}"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p class="text-white">{{ __($element->data_values->answer) }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
