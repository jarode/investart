@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="dashboard position-relative">
        <div class="dashboard-body">
            <div class="container">
                <div class="case-step">
                    @include($activeTemplate . 'user.case.step_header')
                    <form action="{{ route('user.case.submit.two', $case->id) }}" method="post">
                        @csrf
                        <div class="case-step-body">
                            <div class="row gy-4">
                                <div class="col-12 segment-row">
                                    @if ($case->plans->count() > 0)
                                        @foreach ($case->plans as $segment)
                                            <div class="row mb-4 single-segment">
                                                <input type="hidden" required name="plan[{{ $loop->iteration }}][id]" value="{{ $segment->id }}">
                                                @if ($loop->first)
                                                    <div class="col-12">
                                                        <div class="text-end">
                                                            <button class="btn btn--base btn--sm add-more-title" type="button">
                                                                <i class="fa fa-plus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form--label">@lang('Title')</label>
                                                        <input type="text" required name="plan[{{ $loop->iteration }}][title]" value="{{ $segment->title }}"
                                                            class="form-control form--control">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form--label">@lang('Minimum Invest')</label>
                                                        <div class="input-group">
                                                            <input type="number" step="any" required name="plan[{{ $loop->iteration }}][minimum_invest]"
                                                                class="form-control form--control" value="{{ getAmount($segment->minimum_invest) }}">
                                                            <span class="input-group-text bg--base">{{ __($general->cur_text) }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form--label">@lang('Maximum Invest')</label>
                                                        <div class="input-group">
                                                            <input type="number" step="any" required name="plan[{{ $loop->iteration }}][maximum_invest]"
                                                                class="form-control form--control" value="{{ getAmount($segment->maximum_invest) }}">
                                                            <span class="input-group-text bg--base">{{ __($general->cur_text) }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form--label">@lang('Profit Period')</label>
                                                        <select class="form-select form--control " required name="plan[{{ $loop->iteration }}][schedule_id]">
                                                            @foreach ($schedules as $schedule)
                                                                <option value="{{ $schedule->id }}" @selected($schedule->id == $segment->schedule_id)>
                                                                    {{ __($schedule->title) }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form--label">@lang('Profit Type')</label>
                                                        <select class="form-select form--control profit-type"
                                                            required name="plan[{{ $loop->iteration }}][profit_type]">
                                                            <option value="1" @selected($segment->profit_type == Status::ENABLE)>
                                                                @lang('Fixed')
                                                            </option>
                                                            <option value="0" @selected($segment->profit_type == Status::DISABLE)>
                                                                @lang('Percentage')
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form--label">@lang('Profit Value')</label>
                                                    <div class="input-group">
                                                        <input type="number" step="any" required name="plan[{{ $loop->iteration }}][profit_value]"
                                                            class="form-control form--control" value="{{ getAmount($segment->profit_value) }}">
                                                        <span class="input-group-text bg--base profit_symbol">%</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form--label">@lang('Capital Back')</label>
                                                        <select class="form-select form--control profit-type"
                                                            required name="plan[{{ $loop->iteration }}][capital_back]">
                                                            <option value="1" @selected($segment->capital_back == Status::ENABLE)>
                                                                @lang('Yes')
                                                            </option>
                                                            <option value="0" @selected($segment->capital_back == Status::DISABLE)>
                                                                @lang('No')
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form--label">@lang('Status')</label>
                                                        <select class="form-select form--control profit-type"
                                                            required name="plan[{{ $loop->iteration }}][status]">
                                                            <option value="1" @selected($segment->status == Status::ENABLE)>
                                                                @lang('Enable')
                                                            </option>
                                                            <option value="0" @selected($segment->status == Status::DISABLE)>
                                                                @lang('Disable')
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form--label">@lang('Return Times')</label>
                                                    <input type="number" required name="plan[{{ $loop->iteration }}][return_time]"
                                                        class="form-control form--control" value="{{ $segment->return_times }}">
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="row mb-4 single-segment">
                                            <div class="col-12">
                                                <div class="text-end">
                                                    <button type="button" class="btn btn--sm btn--danger remove-segment--btn">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    <button class="btn btn--base btn--sm add-more-title" type="button">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="form--label">@lang('Title')</label>
                                                    <input type="text" required name="plan[1][title]" class="form-control form--control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form--label">@lang('Minimum Invest')</label>
                                                    <div class="input-group">
                                                        <input type="number" step="any" required name="plan[1][minimum_invest]"
                                                            class="form-control form--control">
                                                        <span class="input-group-text bg--base">{{ __($general->cur_text) }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form--label">@lang('Maximum Invest')</label>
                                                    <div class="input-group">
                                                        <input type="number" step="any" required name="plan[1][maximum_invest]"
                                                            class="form-control form--control" value="">
                                                        <span class="input-group-text bg--base">{{ __($general->cur_text) }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form--label">@lang('Profit Period')</label>
                                                    <select class="form-select form--control " required name="plan[1][schedule_id]">
                                                        @foreach ($schedules as $schedule)
                                                            <option value="{{ $schedule->id }}">
                                                                {{ __($schedule->title) }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form--label">@lang('Profit Type')</label>
                                                    <select class="form-select form--control profit-type" required name="plan[1][profit_type]">
                                                        <option value="0">
                                                            @lang('Percentage')
                                                        </option>
                                                        <option value="1">
                                                            @lang('Fixed')
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form--label">@lang('Profit Value')</label>
                                                <div class="input-group">
                                                    <input type="number" step="any" required name="plan[1][profit_value]"
                                                        class="form-control form--control">
                                                    <span class="input-group-text profit_symbo bg--base">@lang('%')</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form--label">@lang('Capital Back')</label>
                                                    <select class="form-select form--control" required name="plan[1][capital_back]">
                                                        <option value="1">
                                                            @lang('Yes')
                                                        </option>
                                                        <option value="0">
                                                            @lang('No')
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form--label">@lang('Return Times')</label>
                                                <input type="number" required name="plan[1][return_time]" class="form-control form--control">
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form--label">@lang('Status')</label>
                                                    <select class="form-select form--control" required name="plan[1][status]">
                                                        <option value="1">
                                                            @lang('Enable')</option>
                                                        <option value="0">
                                                            @lang('Disable')</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="flex-align justify-content-between gap-3">
                                @if ($case->completed_step == 3)
                                    <div class="d-flex gap-2 flex-wrap">
                                        <a href="{{ route('user.case.step.one', $case->id) }}" class="btn step--btn">
                                            <span class="icon"><i class="las la-arrow-left"></i></span>
                                            @lang('Previous')
                                        </a>
                                        <button type="submit" class="btn step--btn bg--base">
                                            @lang('Save')
                                            <span class="icon"><i class="fas fa-paper-plane"></i></span>
                                        </button>
                                        <a href="{{ route('user.case.step.three', @$case->id) }}" class="btn step--btn bg--dark">
                                            @lang('Next')
                                            <span class="icon"><i class="las la-arrow-right"></i></span>
                                        </a>
                                    </div>
                                @else
                                    <div class="d-flex gap-2 flex-wrap">
                                        <a href="{{ route('user.case.step.one', $case->id) }}" class="btn step--btn">
                                            <span class="icon"><i class="las la-arrow-left"></i></span>
                                            @lang('Previous')
                                        </a>
                                        <button type="submit" class="btn step--btn bg--base">
                                            @lang('Next') <span class="icon"><i class="las la-arrow-right"></i></span>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(function() {
            'use strict'

            $('.add-more-title').on('click', function() {

                let count = Number($('.segment-row').find(".single-segment").length) + Number(1);
                let action = "{{ route('user.case.form', ':count') }}";

                $.ajax({
                    url: action.replace(":count", count),
                    type: "GET",
                    dataType: "html",
                    success: function(data) {
                        $('.segment-row').append(data);
                        $('html').animate({
                            scrollTop: $(document).height() - 1500
                        });
                    }
                })
            });

            $(document).on('change', '.profit-type', function() {
            console.log(2121);
                if ($(this).val() == 0) {
                    $(this).parent().parent().parent().find('.profit_symbol').text(' %')
                } else {
                    $(this).parent().parent().parent().find('.profit_symbol').text('{{ __($general->cur_text) }}')
                }
            });

            $(document).on('click', '.remove-segment--btn', function() {
                $(this).closest(".single-segment").remove();
            })
        });
    </script>
@endpush
