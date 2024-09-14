@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="dashboard position-relative">
        <div class="dashboard-body">
            <div class="container">
                <div class="case-step">
                    @include($activeTemplate . 'user.case.step_header')
                    <form action="{{ route('user.case.submit.one', @$case->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="case-step-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form--label">@lang('Title')</label>
                                        <input type="text" class="form-control form--control" name="title" required
                                            value="{{ old('title', @$case->title) }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form--label">@lang('Goal Amount')</label>
                                        <div class="input-group">
                                            <input type="number" step="any" name="goal_amount" class="form-control form--control" required
                                                value="{{ old('goal_amount', @$case->goal_amount ? getAmount(@$case->goal_amount) : '') }}">
                                            <span class="input-group-text bg--base">{{ __($general->cur_text) }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form--label">@lang('Video URL')</label>
                                        <input type="url" class="form-control form--control" value="{{ old('video_url', @$case->video_url) }}"
                                            name="video_url">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form--label">@lang('Expired Date')</label>
                                        <input type="date" class="form-control form--control" value="{{ old('expired_date', @$case->expired_date) }}"
                                            name="expired_date" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form--label">@lang('Thumbnail')</label>
                                        <input type="file" class="form-control form--control" accept="image/png, image/jpg, image/jpeg" name="image"
                                            @required(!@$case)>
                                        <small>
                                            <span>@lang('Supported Files')</span>
                                            <b>@lang('.png'), @lang('.jpg'), @lang('.jpeg')</b>
                                            @lang('Image will be resized into') <b>{{ getFileSize('investmentImage') }}</b>@lang('px')</b>
                                        </small>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form--label">@lang('Agreement Paper')</label>
                                        <input type="file" class="form-control form--control" accept=".pdf" name="agreement_paper" @required(!@$case)>
                                        <small>
                                            <span>@lang('Supported Files')</span>
                                            <b>@lang('.pdf')</b>
                                        </small>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form--label">@lang('Overview')</label>
                                        <textarea name="overview" class="form--control nicEdit">{{ old('overview', @$case->overview) }}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    @if (@$case)
                                        <div class="d-flex gap-2">
                                            <button type="submit" class="btn step--btn bg--base">
                                                @lang('Save')
                                                <span class="icon"><i class="fas fa-paper-plane"></i></span>
                                            </button>
                                            <a href="{{ route('user.case.step.two', @$case->id) }}" class="btn step--btn bg--dark">
                                                @lang('Next')
                                                <span class="icon"><i class="las la-arrow-right"></i></span>
                                            </a>
                                        </div>
                                    @else
                                        <button type="submit" class="btn step--btn bg--base">
                                            @lang('Next')
                                            <span class="icon"><i class="las la-arrow-right"></i></span>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('assets/global/js/nicEdit.js') }}"></script>
    <script>
        "use strict";
        bkLib.onDomLoaded(function() {
            $(".nicEdit").each(function(index) {
                $(this).attr("id", "nicEditor" + index);
                new nicEditor({
                    fullPanel: true
                }).panelInstance('nicEditor' + index, {
                    hasPanel: true
                });
            });
        });
        (function($) {
            $(document).on('mouseover ', '.nicEdit-main,.nicEdit-panelContain', function() {
                $('.nicEdit-main').focus();
            });
        })(jQuery);
    </script>
@endpush
