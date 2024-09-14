@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="dashboard position-relative">
        <div class="dashboard-body">
            <div class="container">
                <div class="col-12">
                    <div class="row gy-3 gy-md-5">
                        @php
                            $kyc  = getContent('ckyc_content.content', true);
                            $user = auth()->user();
                        @endphp

                        @if ($user->ckv == Status::KYC_UNVERIFIED)
                            <div class="col-12">
                                <div class="card custom--card">
                                    <div class="card-body p-0">
                                        <h3 class="mb-2 text--danger">@lang('Case Creator KYC Verification')</h3>
                                        <p>
                                            {{ __(@$kyc->data_values->unverified_content) }}
                                            <a href="{{ route('user.case.creator.kyc.form') }}" class="text--danger fw-bold fs-14">@lang('Verify Now')</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if ($user->ckv == Status::KYC_PENDING)
                            <div class="col-12">
                                <div class="card custom--card">
                                    <div class="card-body p-0">
                                        <h3 class="mb-2 text--warning">@lang('Case Creator KYC Verification Pending')</h3>
                                        <p>
                                            {{ __(@$kyc->data_values->pending_content) }}
                                            <a href="{{ route('user.case.creator.kyc.data') }}" class="text--warning fw-bold fs-14">@lang('My KYC Data')</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="col-xl-12">
                            <div class="card custom--card">
                                <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
                                    <h3 class="mb-0 mb-md-3">@lang('Case History')</h3>
                                    <a href="{{ route('user.case.step.one') }}" class="btn btn--base btn--sm"><i class="fas fa-plus"></i>
                                        @lang('New Case')
                                    </a>
                                </div>
                                <div class="card-body">
                                    <table class="table table-separated table--responsive--lg">
                                        <thead>
                                            <tr>
                                                <th>@lang('Cases')</th>
                                                <th>@lang('Goal Amount')</th>
                                                <th>@lang('Date')</th>
                                                <th>@lang('Status')</th>
                                                <th>@lang('Action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($cases as $case)
                                                <tr>
                                                    <td>{{ __($case->title) }}</td>
                                                    <td>
                                                        <div class="custom--progress progress" role="progressbar" aria-label="Basic example"
                                                            aria-valuenow="{{ $case->progress }}" aria-valuemin="0" aria-valuemax="100">
                                                            <div class="progress-bar" style="width: {{ $case->progress }}%">
                                                            </div>
                                                        </div>
                                                        {{ showAmount($case->goal_amount) . ' ' . __($general->cur_text) }}
                                                    </td>
                                                    <td>{{ showDateTime($case->created_at, 'd M Y') }}</td>
                                                    <td>
                                                        @php echo $case->statusBadge ; @endphp
                                                    </td>
                                                    <td class="data-action">
                                                        <div class="action--btn-wrapper actionButtons">
                                                            <span class="actionButtons__btn"><i class="fas fa-ellipsis-h"></i></span>
                                                            <ul class="actionButtons__list">

                                                                @if ($case->status != Status::CASE_DRAFT)
                                                                    @if ($case->status == Status::DISABLE)
                                                                        <li class="confirmationBtn list-btn"
                                                                            data-action="{{ route('user.case.status', $case->id) }}"
                                                                            data-question="@lang('Are you sure to enable this case?')">
                                                                            <i class="la la-toggle-on"></i> @lang('Enable')
                                                                        </li>
                                                                    @else
                                                                        <li class="confirmationBtn list-btn"
                                                                            data-action="{{ route('user.case.status', $case->id) }}"
                                                                            data-question="@lang('Are you sure to disable this case?')">
                                                                            <i class="la la-toggle-off"></i> @lang('Disable')
                                                                        </li>
                                                                    @endif
                                                                @endif

                                                                <li>
                                                                    <a href="{{ route('user.case.log', $case->id) }}"
                                                                        class="btn btn--sm btn-outline--warning">
                                                                        <i class="las la-file-alt"></i> @lang('Invest Log')
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="{{ route('user.case.step.one', $case->id) }}"
                                                                        class="btn btn--sm btn-outline--warning">
                                                                        <i class="las la-edit"></i> @lang('Edit')
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="{{ route('investment.case.details', $case->case_code) }}"
                                                                        class="btn btn--sm btn-outline--info">
                                                                        <i class="las la-eye"></i> @lang('View')
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">{{ __($emptyMessage) }}
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                {{ paginateLinks($cases) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-confirmation-modal isFrontend="true" />
@endsection
