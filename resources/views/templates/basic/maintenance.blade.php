@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="maintenance-page">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <h1 class="text-center text--danger">@lang('THIS SITE IS UNDER MAINTENANCE')</h1>
                    <p class="text-center mx-auto mb-4">
                        @php echo $maintenance->data_values->description @endphp
                    </p>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('style')
    <style>
        .maintenance-page{
            min-height: 100vh;
            padding-block: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }
        .maintenance-page h2{
            margin-bottom: 0;
        }

    </style>
@endpush

@push('script')
    <script>
        "use strict";
        (function ($) {
            $("header,footer, .header-top, .breadcrumb").remove();
        })(jQuery);
    </script>
@endpush

