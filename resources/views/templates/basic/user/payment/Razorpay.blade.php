@extends($activeTemplate.'layouts.master')
@section('content')

<div class="dashboard position-relative">
    <div class="dashboard-body">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card custom--card">
                        <div class="card-header border-0 pb-0">
                            <h3 class="card-title mb-0">@lang('Razorpay')</h3>
                        </div>
                        <div class="card-body">
                            <ul class="list-group  list-group-flush">
                                <li class="list-group-item d-flex justify-content-between">
                                    @lang('You have to pay '):
                                    <strong>{{showAmount($deposit->final_amount)}} {{__($deposit->method_currency)}}</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    @lang('You will get '):
                                    <strong>{{showAmount($deposit->amount)}}  {{__($general->cur_text)}}</strong>
                                </li>
                            </ul>
                            <form action="{{$data->url}}" method="{{$data->method}}">
                                <input type="hidden" custom="{{$data->custom}}" name="hidden">
                                <script src="{{$data->checkout_js}}"
                                        @foreach($data->val as $key=>$value)
                                        data-{{$key}}="{{$value}}"
                                    @endforeach >
                                </script>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection


@push('script')
    <script>
        (function ($) {
            "use strict";

            $('input[type="submit"]').addClass("mt-4 btn btn-base w-100");
        })(jQuery);
    </script>
@endpush
