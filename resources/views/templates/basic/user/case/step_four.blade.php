@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="dashboard position-relative">
        <div class="dashboard-body">
            <div class="container">
                <div class="case-step">
                    @include($activeTemplate . 'user.case.step_header')
                    <div class="case-step-body">
                        <div class="case-step-done-icon">
                            <i class="fa fa-check"></i>
                        </div>
                        <h3 class="case-step-done-title">
                            @lang('Case Submited Successful')
                        </h3>
                        <p class="case-step-done-desc">
                            @lang('Your case successfully submited.')
                        </p>
                        <div class="d-flex gap-2 flex-wrap justify-content-center mt-4">
                            <a href="{{ route('user.case.history') }}" class="btn step--btn">
                                <span class="icon"><i class="fa fa-list"></i></span>
                                @lang('Case History')
                            </a>
                            <a class="btn step--btn bg--base" href="{{ route('user.case.step.one') }}">
                                <span class="icon"><i class="fa fa-plus"></i></span>
                                @lang('New Case')
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
