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
                                    <th>@lang('Profit Amount')</th>
                                    <th>@lang('Date')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($profits as $profit)
                                    <tr>

                                        <td>
                                            <div class="user">
                                                <div class="thumb">
                                                    <img src="{{ getImage(getFilePath('investmentImage') . '/' . $profit->invest->case->image, getFileSize('investmentImage')) }}"
                                                        class="plugin_bg">
                                                </div>
                                                <span class="name">
                                                    {{ __($profit->invest->case->title) }} <br>
                                                    <span class="text--small">
                                                        {{ __($profit->invest->case->case_code) }}
                                                    </span>
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="fw-bold">{{ $profit->invest->user->fullname }}</span>
                                            <br>
                                            <span class="small">
                                                <a href="{{ route('admin.users.detail', $profit->invest->user->id) }}"><span>@</span>{{ $profit->invest->user->username }}</a>
                                            </span>
                                        </td>
                                        <td>
                                            {{ showAmount($profit->profit_amount) }} {{ __($general->cur_text) }}
                                        </td>
                                        <td>
                                            {{ showDateTime($profit->created_at, 'd M Y') }}
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
                @if ($profits->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($profits) }}
                    </div>
                @endif
            </div>
        </div>


    </div>
@endsection

@push('breadcrumb-plugins')
    <x-search-form placeholder="Search username" />
@endpush
