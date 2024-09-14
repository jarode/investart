<div class="case-step-header">
    <ul class="case-step-list">
        <li class="case-step-item {{ menuActive(['user.case.step.one', 'user.case.step.two', 'user.case.step.three', 'user.case.step.four']) }}">
            <a href="{{ route('user.case.step.one', @$case->id) }}" class="case-step-link">
                <span class="case-step-link">
                    <span class="count">@lang('1')</span>
                    <span class="text">@lang('Overview')</span>
                </span>
            </a>
        </li>
        <li class="case-step-item {{ menuActive(['user.case.step.two', 'user.case.step.three', 'user.case.step.four']) }}">
            <a href="@if(@$case) {{ route('user.case.step.two', @$case->id) }} @else javascript:void(0) @endif" class="case-step-link disabled">
                <span class="case-step-link">
                    <span class="count">@lang('2')</span>
                    <span class="text">@lang('Investment Plan')</span>
                </span>
            </a>
        </li>
        <li class="case-step-item {{ menuActive(['user.case.step.three', 'user.case.step.four']) }}">
            <a href="@if(@$case) {{ route('user.case.step.three', @$case->id) }} @else javascript:void(0)  @endif" class="case-step-link">
                <span class="case-step-link">
                    <span class="count">@lang('3')</span>
                    <span class="text">@lang('FAQ')</span>
                </span>
            </a>
        </li>
        <li class="case-step-item {{ menuActive(['user.case.step.four']) }}">
            <span class="case-step-link">
                <span class="count">@lang('4')</span>
                <span class="text">@lang('Complete')</span>
            </span>
        </li>
    </ul>
</div>
