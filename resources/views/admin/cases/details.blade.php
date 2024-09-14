@extends('admin.layouts.app')
@section('panel')
    <div class="row justify-content-center gy-3">
        <div class="col-sm-6">
            <div class="card b-radius--10 overflow-hidden box--shadow1">
                <div class="card-header py-3 bg--primary">
                    <h5 class="fw-bold text-white"> {{ __(@$case->title) }}</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item ps-0 d-flex justify-content-between align-items-center flex-wrap">
                            <span> @lang('Created Date') </span>
                            <span class="fw-bold">{{ showDateTime($case->created_at) }}</span>
                        </li>
                        <li class="list-group-item ps-0 d-flex justify-content-between align-items-center flex-wrap">
                            <span> @lang('Case Code') </span>
                            <span class="fw-bold">{{ $case->case_code }}</span>
                        </li>
                        <li class="list-group-item ps-0 d-flex justify-content-between align-items-center flex-wrap">
                            <span> @lang('Username') </span>
                            <span class="fw-bold">
                                <a href="{{ route('admin.users.detail', $case->user_id) }}">{{ @$case->user->username }}</a>
                            </span>
                        </li>
                        <li class="list-group-item ps-0 d-flex justify-content-between align-items-center flex-wrap">
                            <span> @lang('Goal to Reach') </span>
                            <span class="fw-bold">{{ showAmount($case->goal_amount) }}
                                {{ __($general->cur_text) }}</span>
                        </li>
                        <li class="list-group-item ps-0 d-flex justify-content-between align-items-center flex-wrap">
                            <span> @lang('Goal to Reached') </span>
                            <span class="fw-bold">{{ showAmount($case->reach_amount) }}
                                {{ __($general->cur_text) }}</span>
                        </li>
                        <li class="list-group-item ps-0 d-flex justify-content-between align-items-center flex-wrap">
                            <span> @lang('Expire Date') </span>
                            <span class="fw-bold">{{ showDateTime($case->expired_date, 'd M Y') }}</span>
                        </li>
                        <li class="list-group-item ps-0 d-flex justify-content-between align-items-center flex-wrap">
                            <span> @lang('Agreement Paper') </span>
                            <span class="fw-bold"><a href="{{ route('admin.cases.download', $case->id) }}"><span> @lang('Download')</a></span> </span>
                        </li>
                        @if ($case->reject_note)
                            <li class="list-group-item ps-0 d-flex justify-content-between align-items-center flex-wrap">
                                <span> @lang('Reject Note') </span>
                                <span class="fw-bold">{{ __($case->reject_note) }}</span>
                            </li>
                        @endif

                    </ul>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <th>@lang('Title')</th>
                                <th>@lang('Min Invest')</th>
                                <th>@lang('Max Invest')</th>
                                <th>@lang('Profit')</th>
                            </thead>
                            <tbody>
                                @forelse ($case->plans as $plan)
                                    <tr>
                                        <td>{{ __($plan->title) }}</td>
                                        <td>{{ showAmount($plan->minimum_invest) . ' ' . __($general->cur_text) }}</td>
                                        <td>{{ showAmount($plan->maximum_invest) . ' ' . __($general->cur_text) }}</td>
                                        <td>{{ showAmount($plan->profit_value) . ' ' . ($plan->profit_type == Status::FIXED_TYPE ? __($general->cur_text) : '%') }}
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
                </div>
            </div>
        </div>
    </div>

    <div id="rejectModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Reject Case Confirmation')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.cases.reject') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <p>@lang('Are you sure to reject this case?') </p>
                        <div class="form-group">
                            <label class="mt-2">@lang('Reason for Rejection')</label>
                            <textarea name="note" maxlength="255" class="form-control" rows="5" required>{{ old('message') }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary w-100 h-45">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-confirmation-modal />
@endsection

@push('breadcrumb-plugins')
    @if ($case->is_approved == Status::CASE_PENDING && $case->status ==  Status::CASE_PENDING)
        <button class="btn btn-outline--success btn-sm ms-1 confirmationBtn" data-action="{{ route('admin.cases.approve', $case->id) }}"
            data-question="@lang('Are you sure to approve this Case?')"><i class="las la-check-double"></i>
            @lang('Approve')
        </button>

        <button class="btn btn-outline--danger btn-sm ms-1 rejectBtn" data-id="{{ $case->id }}" data-info="" data-amount="" data-username=""><i
                class="las la-ban"></i> @lang('Reject')
        </button>
    @endif
    <x-back route="{{ route('admin.cases.list') }}" />
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";

            $('.rejectBtn').on('click', function() {
                var modal = $('#rejectModal');
                modal.find('input[name=id]').val($(this).data('id'));
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
