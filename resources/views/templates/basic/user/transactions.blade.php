@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="dashboard position-relative">
        <div class="dashboard-body">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="row g-4">
                            <div class="col-xl-12">
                                <div class="custom--card card">
                                    <div class="card-body">
                                        <div class="toggle-item">
                                            <span class="toggle_item__btn"><i class="las la-bars"></i></span>
                                            <form class="transection-search" action="">
                                                <div class="transection-form-item">
                                                    <label class="form--label">@lang('Trx')</label>
                                                    <input type="text" name="search" value="{{ request()->search }}" class="form--control">
                                                </div>
                                                <div class="transection-form-item">
                                                    <label class="form--label">@lang('Type')</label>
                                                    <select name="trx_type" class="form--control form-select">
                                                        <option value="">@lang('All')</option>
                                                        <option value="+" @selected(request()->trx_type == '+')>@lang('Plus')
                                                        </option>
                                                        <option value="-" @selected(request()->trx_type == '-')>@lang('Minus')
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="transection-form-item">
                                                    <label class="form--label">@lang('Remark')</label>
                                                    <select class="form--control form-select" name="remark">
                                                        <option value="">@lang('Any')</option>
                                                        @foreach ($remarks as $remark)
                                                            <option value="{{ $remark->remark }}" @selected(request()->remark == $remark->remark)>
                                                                {{ __(keyToTitle($remark->remark)) }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="transection-form-item">
                                                    <button class="btn btn--base w-100 h-45"><i class="fas fa-filter"></i>
                                                        @lang('Filter')</button>
                                                </div>
                                            </form>
                                        </div>
                                        <table class="table table-separated table--responsive--md">
                                            <thead>
                                                <tr>
                                                    <th>@lang('Trx')</th>
                                                    <th>@lang('Transacted')</th>
                                                    <th>@lang('Amount')</th>
                                                    <th>@lang('Post Balance')</th>
                                                    <th>@lang('Detail')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($transactions as $trx)
                                                    <tr>
                                                        <td>
                                                            <strong>{{ $trx->trx }}</strong>
                                                        </td>

                                                        <td>
                                                            <div class="text-end text-lg-center">
                                                                {{ showDateTime($trx->created_at) }}<br>{{ diffForHumans($trx->created_at) }}
                                                            </div>
                                                        </td>

                                                        <td class="budget">
                                                            <span
                                                                class="fw-bold @if ($trx->trx_type == '+') text--success @else text--danger @endif">
                                                                {{ $trx->trx_type }} {{ showAmount($trx->amount) }}
                                                                {{ __($general->cur_text) }}
                                                            </span>
                                                        </td>
                                                        <td class="budget">
                                                            {{ showAmount($trx->post_balance) }}
                                                            {{ __($general->cur_text) }}
                                                        </td>
                                                        <td>{{ __($trx->details) }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td class="text-center" colspan="100%">
                                                            {{ __($emptyMessage) }}
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                    {{ paginateLinks($transactions) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
