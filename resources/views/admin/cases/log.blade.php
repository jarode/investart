@extends('admin.layouts.app')
@section('panel')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Case')</th>
                                    <th>@lang('User')</th>
                                    <th>@lang('Reach Amount') | @lang('Goal Amount')</th>
                                    <th>@lang('Progress')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($cases as $case)
                                    <tr>
                                        <td>
                                            <div class="user">
                                                <div class="thumb">
                                                    <img src="{{ getImage(getFilePath('investmentImage') . '/' . $case->image, getFileSize('investmentImage')) }}"
                                                        class="plugin_bg">
                                                </div>
                                                <span class="name">
                                                    {{ __($case->title) }} <br>
                                                    <span class="text--small">
                                                        {{ __($case->case_code) }}
                                                    </span>
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="fw-bold">{{ $case->user->fullname }}</span>
                                            <br>
                                            <span class="small">
                                                <a href="{{ route('admin.users.detail', $case->user->id) }}"><span>@</span>{{ $case->user->username }}</a>
                                            </span>
                                        </td>
                                        <td>
                                            <div>
                                                {{ $general->cur_sym }}{{ showAmount($case->reach_amount) }} <br>
                                                {{ $general->cur_sym }}{{ showAmount($case->goal_amount) }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" style="width: {{ $case->progress }}%"></div>
                                            </div>

                                        </td>
                                        <td>
                                            @php
                                                echo $case->statusBadge;
                                            @endphp
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.cases.details', $case->id) }}" class="btn btn-sm btn-outline--primary ms-1">
                                                <i class="la la-desktop"></i> @lang('Details')
                                            </a>

                                            <a href="{{ route('admin.invest.list') }}?search={{ $case->case_code }}"
                                                class="btn btn-sm btn-outline--dark ms-1 @if($case->status != Status::APPROVED) disabled  @endif" @disabled($case->status != Status::APPROVED)>
                                                <i class="las la-list"></i> @lang('Invest Logs')
                                            </a>

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($cases->hasPages())
                    <div class="card-footer py-4">
                        @php echo paginateLinks($cases) @endphp
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection


@push('breadcrumb-plugins')
    <x-search-form dateSearch='yes' />
@endpush
