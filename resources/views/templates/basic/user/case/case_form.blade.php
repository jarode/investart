<div class="row mb-4 single-segment">
    <div class="col-12">
        <div class="text-end">
            <button type="button" class="btn btn--sm btn--base remove-segment--btn">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label class="form--label">@lang('Title')</label>
            <input type="text" name="plan[{{ $count }}][title]" class="form-control form--control" required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="form--label">@lang('Minimum Invest')</label>
            <div class="input-group">
                <input type="number" step="any" name="plan[{{ $count }}][minimum_invest]" class="form-control form--control" required>
                <span class="input-group-text bg--base">{{ __($general->cur_text) }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="form--label">@lang('Maximum Invest')</label>
            <div class="input-group">
                <input type="number" step="any" name="plan[{{ $count }}][maximum_invest]" class="form-control form--control" required>
                <span class="input-group-text bg--base">{{ __($general->cur_text) }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="form--label">@lang('Scheudle')</label>
            <select class="form-select form--control " name="plan[{{ $count }}][schedule_id]" required>
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
            <select required class="form-select form--control profit-type" name="plan[{{ $count }}][profit_type]">
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
            <input  required type="number" step="any" name="plan[{{ $count }}][profit_value]" class="form-control form--control">
            <span class="input-group-text profit_symbol bg--base">%</span>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="form--label">@lang('Capital Back')</label>
            <select required class="form-select form--control" name="plan[{{ $count }}][capital_back]">
                <option value="1">
                    @lang('Yes')</option>
                <option value="0">
                    @lang('No')</option>
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <label class="form--label">@lang('Return Times')</label>
        <input required type="number" name="plan[{{ $count }}][return_time]" class="form-control form--control">
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="form--label">@lang('Status')</label>
            <select class="form-select form--control" name="plan[{{ $count }}][status]">
                <option value="1">
                    @lang('Enable')</option>
                <option value="0">
                    @lang('Disable')</option>
            </select>
        </div>
    </div>

</div>
