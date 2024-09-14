@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="dashboard position-relative">
        <div class="dashboard-body">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <form action="{{ route('user.case.segment.submit', ['code' => $investment->case_code, 'id' => $plan->id]) }}" method="post">
                            @csrf
                            <input type="hidden" name="currency">
                            <div class="card custom--card">
                                <div class="card-header">
                                    <h5 class="card-title">@lang('Invest Amount')</h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label class="form--label">@lang('Amount')</label>
                                        <div class="input-group">
                                            <input type="number" step="any" name="amount" class="form-control form--control"
                                                value="{{ old('amount') }}" autocomplete="off" required>
                                            <span class="input-group-text">{{ __($general->cur_text) }}</span>
                                        </div>
                                        <span class="mt-2">
                                            @lang('Available Balance')
                                            <span class="text--base">{{ showAmount(auth()->user()->balance) . ' ' . __($general->cur_text) }}</span>
                                        </span>
                                    </div>


                                    <div class="mt-3 preview-details">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item d-flex justify-content-between ps-0">
                                                <span>@lang('Minimum Invest')</span>
                                                <span class="min fw-bold">{{ showAmount($plan->minimum_invest) . ' ' . __($general->cur_text) }}</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between ps-0">
                                                <span>@lang('Maximum Invest')</span>
                                                <span class="min fw-bold">{{ showAmount($plan->maximum_invest) . ' ' . __($general->cur_text) }}</span>
                                            </li>

                                        </ul>
                                    </div>
                                    <button type="submit" class="btn btn--base w-100 mt-3">@lang('Submit')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
