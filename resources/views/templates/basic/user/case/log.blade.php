@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="dashboard position-relative">
        <div class="dashboard-body">
            <div class="container">
                <div class="col-12">
                    <div class="row g-4">
                        <div class="col-xl-12">
                            <div class="custom--card">
                                <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
                                    <h3 class=" mb-0 mb-md-3">@lang('Case Investment Log')</h3>
                                    <a href="{{ route('user.case.history') }}" class="btn btn--base btn--sm"><i class="fas fa-list"></i>
                                        @lang('All Case')
                                    </a>
                                </div>
                                <div class="card-body">
                                    <table class="table table-separated table--responsive--md">
                                        <thead>
                                            <tr>
                                                <th>@lang('Case')</th>
                                                <th>@lang('Invest Amount')</th>
                                                <th>@lang('Return')</th>
                                                <th>@lang('Received')</th>
                                                <th>@lang('Next Return')</th>
                                                <th>@lang('Action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($invests as $invest)
                                                <tr>
                                                    <td>
                                                        <div>
                                                            {{ __(@$invest->plan->title) }} <br>
                                                            <small> {{ __($invest->case->title) }} </small>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        {{ $general->cur_sym . showAmount($invest->profit_amount) }}
                                                    </td>
                                                    <td>
                                                        {{ $general->cur_sym . showAmount($invest->profit_amount) }} @lang('every')
                                                        {{ @$invest->plan->schedule->title }}
                                                        @lang('for') {{ $invest->total_return_time }} {{ @$invest->plan->schedule->title }}
                                                        @if ($invest->is_capital_back)
                                                            + @lang('Capital')
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ $invest->total_return }}x{{ $general->cur_sym . showAmount($invest->profit_amount) }}
                                                        ={{ $general->cur_sym . showAmount($invest->profit_amount * $invest->total_return) }}
                                                    </td>
                                                    <td>{{ showDateTime($invest->next_return_date, 'd M Y') }}</td>
                                                    <td>
                                                        <div class="button--group">
                                                            <button class="btn btn--sm btn-outline--base detailBtn"
                                                                data-info="{{ json_encode($invest) }}"
                                                                data-invest="{{ $general->cur_sym . showAmount($invest->invest_amount) }}"
                                                                data-profit="{{ $general->cur_sym . showAmount($invest->profit_amount) }}"
                                                                data-get-profit="{{ $general->cur_sym . showAmount($invest->profits_sum_profit_amount) }}"><i
                                                                    class="la la-eye"></i> @lang('View')
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center">{{ __($emptyMessage) }}</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                @if ($invests->hasPages())
                                    <div class="card-footer">
                                        {{ paginateLinks($invests) }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="detailModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Details')</h5>
                    <span type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </span>
                </div>
                <div class="modal-body pt-0">
                    <ul class="list-group userData mb-2 list-group-flush">
                    </ul>
                    <div class="feedback"></div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('script')
    <script>
        (function($) {
            "use strict";
            $('.detailBtn').on('click', function() {

                let modal = $('#detailModal');
                let info = $(this).data('info');
                let invest = $(this).data('invest');
                let profit = $(this).data('profit');
                let getProfit = $(this).data('getProfit');

                let html = `
                            <li class="list-group-item d-flex justify-content-between align-items-center ps-0">
                                <span>@lang('Case')</span>
                                <span>${info.case.title}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center ps-0">
                                <span>@lang('Plan')</span>
                                <span>${info.plan.title}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center ps-0">
                                <span>@lang('Invest Amount')</span>
                                <span>${invest}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center ps-0">
                                <span>@lang('Total Payable')</span>
                                <span>${info.total_return_time} @lang('times')</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center ps-0">
                                <span>@lang('Total Paid')</span>
                                <span>${info.total_return} @lang('times')</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center ps-0">
                                <span>@lang('Should Payable')</span>
                                <span>${profit}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center ps-0">
                                <span>@lang('Total Paid Amount')</span>
                                <span>${getProfit}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center ps-0">
                                <span>@lang('Next Return Date')</span>
                                <span>${info.next_return_date}</span>
                            </li>`;

                modal.find('.userData').html(html);
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
