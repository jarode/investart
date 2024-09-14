@php
    $elements = getContent('counter.element', orderById: true);
@endphp

<div class="counter gradient-bg py-60">
    <div class="container">
        <div class="row g-4 justify-content-md-center">
            @foreach ($elements as $element)
                <div class="col-xl-3 col-md-5 col-sm-6 col-xsm-6">
                    <div class="counter__card">
                        <div class="counter__icon">
                            <img src="{{ sectionImage('counter', $element->data_values->image, '50x50') }}"
                                alt="@lang('Icon')">
                        </div>
                        <div class="counter__txt">
                            <span class="counter__number">
                                <span class="odometer"
                                    data-count="{{ $element->data_values->counter_digit }}">0</span>{{ $element->data_values->counter_symbol }}</span>
                            <span class="counter__name">{{ __($element->data_values->title) }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@push('style-lib')
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/odometer.css') }}">
@endpush

@push('script-lib')
    <script src="{{ asset($activeTemplateTrue . 'js/odometer.min.js') }}"></script>
@endpush

@push('script')
    <script>
        $(function() {
            'use strict'

            $(function() {
                $('.counter').each(function() {
                    $(this).isInViewport(function(status) {
                        if (status === 'entered') {
                            for (var i = 0; i < document.querySelectorAll('.odometer')
                                .length; i++) {
                                var el = document.querySelectorAll('.odometer')[i];
                                el.innerHTML = el.getAttribute('data-count');
                            }
                        }
                    });
                });
            });
        });
    </script>
@endpush
