@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="dashboard position-relative">
        <div class="dashboard-body">
            <div class="container">
                @php
                    $kyc = getContent('kyc_content.content', true);
                @endphp
                <div class="row gy-3 gy-md-5">
                    @if ($user->kv == Status::KYC_UNVERIFIED)
                        <div class="col-12">
                            <div class="card custom--card">
                                <div class="card-body p-0">
                                    <h3 class="mb-2 text--danger">@lang('KYC Verification')</h3>
                                    <p>
                                        {{ __(@$kyc->data_values->unverified_content) }}
                                        <a href="{{ route('user.kyc.form') }}" class="text--danger fw-bold fs-14">@lang('Verify Now')</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if ($user->kv == Status::KYC_PENDING)
                        <div class="col-12">
                            <div class="card custom--card">
                                <div class="card-body p-0">
                                    <h3 class="mb-2 text--warning">@lang('KYC Verification Pending')</h3>
                                    <p>
                                        {{ __(@$kyc->data_values->pending_content) }}
                                        <a href="{{ route('user.kyc.data') }}" class="text--warning fw-bold fs-14">@lang('My KYC Data')</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="col-12">
                        <div class="row g-lg-4 g-3 justify-content-center dashboard-widget-wrapper">
                            <div class="col-xl-4 col-lg-4 col-sm-6">
                                <div class="dashboard-widget flex-align">
                                    <div class="dashboard-widget__content">
                                        <span class="dashboard-widget__text">@lang('Balance')</span>
                                        <h4 class="dashboard-widget__number">
                                            {{ $general->cur_sym . showAmount($user->balance) }}</h4>
                                    </div>
                                    <div class="dashboard-widget__icon flex-center">
                                        <img src="{{ asset($activeTemplateTrue . 'images/icons/dashboard-icon-1.png') }}" alt="@lang('Icon')">
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-4 col-sm-6">
                                <div class="dashboard-widget flex-align">
                                    <div class="dashboard-widget__content">
                                        <span class="dashboard-widget__text">@lang('Deposit')</span>
                                        <h4 class="dashboard-widget__number">
                                            {{ $general->cur_sym . showAmount($deposit) }}</h4>
                                    </div>
                                    <div class="dashboard-widget__icon flex-center">
                                        <img src="{{ asset($activeTemplateTrue . 'images/icons/dashboard-icon-4.png') }}" alt="@lang('Icon')">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-sm-6">
                                <div class="dashboard-widget flex-align">
                                    <div class="dashboard-widget__content">
                                        <span class="dashboard-widget__text">@lang('Withdraw')</span>
                                        <h4 class="dashboard-widget__number">
                                            {{ $general->cur_sym . showAmount($withdraw) }}</h4>
                                    </div>
                                    <div class="dashboard-widget__icon flex-center">
                                        <img src="{{ asset($activeTemplateTrue . 'images/icons/dashboard-icon-4.png') }}" alt="@lang('Icon')">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-sm-6">
                                <div class="dashboard-widget flex-align">
                                    <div class="dashboard-widget__content">
                                        <span class="dashboard-widget__text">@lang('Cases')</span>
                                        <h4 class="dashboard-widget__number">{{ $user->cases->count() }}</h4>
                                    </div>
                                    <div class="dashboard-widget__icon flex-center">
                                        <img src="{{ asset($activeTemplateTrue . 'images/icons/dashboard-icon-2.png') }}" alt="@lang('Icon')">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-sm-6">
                                <div class="dashboard-widget flex-align">
                                    <div class="dashboard-widget__content">
                                        <span class="dashboard-widget__text">@lang('Total Invest')</span>
                                        <h4 class="dashboard-widget__number">
                                            {{ $general->cur_sym . showAmount($user->invest->sum('invest_amount')) }}
                                        </h4>
                                    </div>
                                    <div class="dashboard-widget__icon flex-center">
                                        <img src="{{ asset($activeTemplateTrue . 'images/icons/dashboard-icon-3.png') }}" alt="@lang('Icon')">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-sm-6">
                                <div class="dashboard-widget flex-align">
                                    <div class="dashboard-widget__content">
                                        <span class="dashboard-widget__text">@lang('Total Profit')</span>
                                        <h4 class="dashboard-widget__number">
                                            {{ $general->cur_sym . showAmount($user->profit->sum('profit_amount')) }}
                                        </h4>
                                    </div>
                                    <div class="dashboard-widget__icon flex-center">
                                        <img src="{{ asset($activeTemplateTrue . 'images/icons/dashboard-icon-5.png') }}" alt="@lang('Icon')">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-12">
                        <div class="row g-4">
                            <div class="{{ $recentCases->count() > 0 ? 'col-xl-8 col-sm-12' : 'col-xl-12' }}">
                                <div class="custom--card">
                                    <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
                                        <h3 class="title">@lang('Pending Return Back')</h3>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-separated table--responsive--md">
                                            <thead>
                                                <tr>
                                                    <th>@lang('Cases')</th>
                                                    <th>@lang('User')</th>
                                                    <th>@lang('Profit')</th>
                                                    <th>@lang('Date')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($pendingReturn as $pending)
                                                    <tr>
                                                        <td>{{ $pending->invest->case->title }}</td>
                                                        <td>{{ $pending->invest->user->fullname }}</td>
                                                        <td>{{ showAmount($pending->profit_amount) . ' ' . __($general->cur_text) }}
                                                        </td>
                                                        <td>{{ showDateTime($pending->created_at, ' d M, Y') }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="100%" class="text-center">{{ __($emptyMessage) }}
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            @if ($recentCases->count() > 0)
                                <div class="col-xl-4">
                                    <div class="post-sidebar dashboard-card">
                                        <h5 class="post-sidebar__title">@lang('Recent Cases')</h5>
                                        <div class="post-sidebar__body">
                                            <div class="case-list">
                                                @foreach ($recentCases as $case)
                                                    <div class="case-list__card">
                                                        <div class="case-list__card__img">
                                                            <a href="{{ route('investment.case.details', $case->case_code) }}"><img
                                                                    src="{{ getImage(getFilePath('investmentImage') . '/' . $case->image, getFileSize('investmentImage')) }}"
                                                                    alt="@lang('image')"></a>
                                                        </div>
                                                        <div class="case-list__card__txt">
                                                            <a href="{{ route('investment.case.details', $case->case_code) }}"
                                                                class="case-list__card__title">{{ __($case->title) }}</a>
                                                            <span class="case-list__card__owner">@lang('By') <a
                                                                    href="{{ route('investor', $case->user->username) }}">{{ __($case->user->fullname) }}</a></span>
                                                            <div class="d-flex justify-content-between">
                                                                <div class="case-list__card__info">
                                                                    <span>@lang('GOAL TO REACHED')</span>
                                                                    <h6>{{ $general->cur_sym . showAmount($case->reach_amount) }}
                                                                    </h6>
                                                                </div>
                                                                <div class="case-list__card__info">
                                                                    <span>@lang('PROFIT')</span>
                                                                    <h6>{{ showAmount($case->plans->max('profit_value')) . ' %' }}
                                                                    </h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection
