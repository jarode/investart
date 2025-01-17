@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="dashboard position-relative">
        <div class="dashboard-body">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card custom--card">
                            <div class="card-header border-0 pb-0">
                                <h3 class="card-title mb-0">{{ __($pageTitle) }}</h3>
                            </div>
                            <div class="card-body  ">
                                <form action="{{ route('user.deposit.manual.update') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p class="text-center mt-2">@lang('You have requested') <b class="text--success">{{ showAmount($data['amount']) }}
                                                    {{ __($general->cur_text) }}</b> , @lang('Please pay')
                                                <b class="text--success">{{ showAmount($data['final_amount']) . ' ' . $data['method_currency'] }}
                                                </b> @lang('for successful payment')
                                            </p>
                                            <h4 class="mb-4">@lang('Please follow the instruction below')</h4>
                                            <p class="my-4">@php echo  $data->gateway->description @endphp</p>
                                        </div>
                                        <x-viser-form identifier="id" identifierValue="{{ $gateway->form_id }}" />
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn--base w-100">@lang('Pay Now')</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
