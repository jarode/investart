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
                                    <h3 class="title">@lang('Profit')</h3>
                                    @if ($profits->count() > 0)
                                        <form class="form border-0" id="form" action="{{ route('user.profit.return.all.submit') }}" method="post">
                                            @csrf
                                            @foreach ($profits as $profit)
                                                <input type="hidden" name="return_id[]" class="return_ids" value="{{ $profit->id }}">
                                            @endforeach
                                            <button class="btn btn--base">@lang('Return All')</button>
                                        </form>
                                    @endif
                                </div>
                                <div class="card-body">
                                    <table class="table table-separated table--responsive--md">
                                        <thead>
                                            <tr>

                                                <th>@lang('Cases')</th>
                                                <th>@lang('Investor')</th>
                                                <th>@lang('Profit')</th>
                                                <th>@lang('Date')</th>
                                                <th>@lang('Status')</th>
                                                <th>@lang('Action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($profits as $profit)
                                                <tr>

                                                    <td>
                                                        <div>
                                                            {{ __(@$profit->invest->plan->title) }} <br>
                                                            <small> {{ __(@$profit->invest->case->title) }} </small>
                                                        </div>
                                                    </td>

                                                    <td>{{ $profit->invest->user->fullname }}</td>
                                                    <td>{{ showAmount($profit->profit_amount) . ' ' . __($general->cur_text) }}
                                                    </td>
                                                    <td>{{ showDateTime($profit->created_at, ' d M, Y') }}</td>
                                                    <td>
                                                        @if ($profit->status == Status::APPROVED)
                                                            <span class="badge badge--success">@lang('Approved')</span>
                                                        @else
                                                            <span class="badge badge--warning">@lang('Pending')</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-end">
                                                        @if ($profit->status == Status::PENDING)
                                                            <button class="btn btn-outline--base btn--sm confirmationBtn"
                                                                data-question="@lang('Are you sure you want to approve this profit')"
                                                                data-action="{{ route('user.profit.return.submit', $profit->id) }}">
                                                                <i class="las la-check"></i>
                                                                @lang('Approve')
                                                            </button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="100%" class="text-center">{{ __($emptyMessage) }}</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                @if ($profits->hasPages())
                                    <div class="card-footer">
                                        {{ paginateLinks($profits) }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-confirmation-modal isFrontend="true" />
@endsection
