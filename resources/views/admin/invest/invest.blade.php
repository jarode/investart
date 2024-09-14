@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Case')</th>
                                    <th>@lang('Investor')</th>
                                    <th>@lang('Amount')</th>
                                    <th>@lang('Next Return')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($invests as $invest)
                                    <tr>
                                        <td>
                                            <div class="user">
                                                <div class="thumb">
                                                    <img src="{{ getImage(getFilePath('investmentImage') . '/' . $invest->case->image, getFileSize('investmentImage')) }}"
                                                        class="plugin_bg">
                                                </div>
                                                <span class="name">
                                                    {{ __($invest->case->title) }} <br>
                                                    <span class="text--small">
                                                        {{ __($invest->case->case_code) }}
                                                    </span>
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="fw-bold">{{ $invest->user->fullname }}</span>
                                            <br>
                                            <span class="small">
                                                <a
                                                    href="{{ route('admin.users.detail', $invest->user->id) }}"><span>@</span>{{ $invest->user->username }}</a>
                                            </span>
                                        </td>
                                        <td>
                                            {{ $general->cur_sym . showAmount($invest->invest_amount) }}
                                        </td>
                                        <td>{{ showDateTime($invest->next_return_date, 'd M Y') }}</td>
                                        <td>
                                            @php echo $invest->statusBadge @endphp
                                        </td>
                                        <td>
                                            <div class="button--group">
                                                <button class="btn btn--sm btn-outline--base detailBtn" data-info="{{ json_encode($invest) }}"
                                                    data-invest="{{ $general->cur_sym . showAmount($invest->invest_amount) }}"
                                                    data-profit="{{ $general->cur_sym . showAmount($invest->profit_amount) }}"
                                                    data-get-profit="{{ $general->cur_sym . showAmount($invest->profits_sum_profit_amount) }}"><i
                                                        class="las la-desktop"></i>@lang('Details')
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
                </div>
                @if ($invests->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($invests) }}
                    </div>
                @endif
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

@push('breadcrumb-plugins')
    <x-search-form placeholder="Search username" />
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            $('.detailBtn').on('click', function() {

                let modal     = $('#detailModal');
                let info      = $(this).data('info');
                let invest    = $(this).data('invest');
                let profit    = $(this).data('profit');
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
                                <span>@lang('Should be Payable')</span>
                                <span>${info.total_return_time}x${profit}${info.is_capital_back ? "+Captial" : ''}</span>
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
