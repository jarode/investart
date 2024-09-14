@extends($activeTemplate . 'layouts.frontend')
@section('content')
    @php
        $ban = @getContent('ban.content', true)->data_values;
    @endphp

    <div class="dashboard">
        <div class="dashboard-body">
            <div class="text-center flex-column justify-content-center">
                <div class="container">
                    <div class="ban-content">
                        <div class="ban-content__thumb">
                            <img src="{{ getImage('assets/images/frontend/ban/' . @$ban->image, '110x110') }}" alt="@lang('image')"
                                class="img-fluid mx-auto mb-4">
                        </div>
                        <h1 class="text--danger"> {{ __(@$ban->title) }}</h1>
                        <h4 class="ban-content__title mb-1">{{ __(@$ban->heading) }}</h4>
                        <p class="text-center mx-auto mb-4">{{ __(@$ban->subheading) }}</p>
                        <a href="{{ route('home') }}" class="btn btn--md btn--base">
                            <i class="las la-globe"></i> @lang('Home')
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .ban-content {
            max-width: 650px;
            width: 100%;
            margin: 0 auto;
        }

        .dashboard-body {
            min-height: 100vh;
            padding-block: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }
    </style>
@endpush

@push('script')
    <script>
        "use strict";
        (function($) {
            $("header,footer, .header-top, .breadcrumb").remove();
        })(jQuery);
    </script>
@endpush
