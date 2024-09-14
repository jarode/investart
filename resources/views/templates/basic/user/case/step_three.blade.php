@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="dashboard position-relative">
        <div class="dashboard-body">
            <div class="container">
                <div class="case-step">
                    @include($activeTemplate . 'user.case.step_header')
                    <form action="{{ route('user.case.submit.three', $case->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="case-step-body">
                            @if ($case->faq)
                                <div class="row gy-4">
                                    @foreach ($case->faq as $k => $faq)
                                        <div class="col-sm-6 col-lg-4">
                                            <div class="faq-form-item">
                                                <div class="form-group">
                                                    <label class="form--label">@lang('Question')</label>
                                                    <input type="text" class="form--control" required value="{{ $faq->question }}" name="question[]">
                                                </div>

                                                <div class="form-group">
                                                    <label class="form--label">@lang('Answer')</label>
                                                    <textarea name="answer[]" class="form--control" required>{{ $faq->answer }}</textarea>
                                                </div>
                                                <button type="button" class="btn step-delete-btn btn--base w-100">@lang('Remove')</button>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="col-sm-6 col-lg-4 faq-add-item">
                                        <button class="add-more-faq" type="button">
                                            <span class="icon"><i class="las la-plus-circle"></i></span>
                                            <span class="text">@lang('Add More')</span>
                                        </button>
                                    </div>
                                </div>
                            @else
                                <div class="row gy-4">
                                    <div class="col-sm-6 col-lg-4">
                                        <div class="faq-form-item">
                                            <div class="form-group">
                                                <label class="form--label">@lang('Question')</label>
                                                <input type="text" class="form--control" required name="question[]">
                                            </div>
                                            <div class="form-group">
                                                <label class="form--label">@lang('Answer')</label>
                                                <textarea name="answer[]" class="form--control" required></textarea>
                                            </div>

                                            <button type="button" class="btn step-delete-btn btn--base w-100">@lang('Remove')</button>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-lg-4 faq-add-item">
                                        <button class="add-more-faq" type="button">
                                            <span class="icon"><i class="las la-plus-circle"></i></span>
                                            <span class="text">@lang('Add More')</span>
                                        </button>
                                    </div>
                                </div>
                            @endif
                            <div class="flex-align  gap-3  mt-4">
                                <a href="{{ route('user.case.step.two', $case->id) }}" class="btn step--btn">
                                    <span class="icon"><i class="las la-arrow-left"></i></span>
                                    @lang('Previous')
                                </a>
                                <button type="submit" class="btn step--btn bg--base">
                                    <span class="icon"><i class="fas fa-paper-plane"></i></span>
                                    @lang('Save')
                                </button>
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

            $('.add-more-faq').on('click', function() {

                let html = `
                <div class="col-sm-6 col-lg-4">
                    <div class="faq-form-item">
                        <div class="form-group">
                            <label class="form--label">@lang('Question')</label>
                            <input type="text" class="form--control" required name="question[]">
                        </div>
                        <div class="form-group">
                            <label class="form--label">@lang('Answer')</label>
                            <textarea name="answer[]" class="form--control" required></textarea>
                        </div>
                        <button type="button" class="btn step-delete-btn btn--base w-100">@lang('Remove')</button>
                    </div>
                </div>
                `;

                $(".faq-add-item:last").before(html);
            });

            $(document).on('click', '.step-delete-btn', function() {

                if ($('.faq-form-item').length > 1) {
                    $(this).parent().parent().remove();
                } else {
                    notify('error', 'A minimum of one FAQ needed ');
                    return false;
                }
            });
        });
    </script>
@endpush
