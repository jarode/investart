@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="dashboard position-relative">
        <div class="dashboard-body">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card custom--card">
                            <div class="card-header">
                                <h5 class="card-title">@lang('Create Case')</h5>
                            </div>
                            <form action="" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group mb-3">
                                                <label>@lang('Video')</label>
                                                <input type="text" class="form-control form--control"
                                                    value="{{ old('video_url') }}" name="video_url">
                                                <small>@lang('Youtube video url')</small>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group mb-3">
                                                <label>@lang('Expired Date')</label>
                                                <input type="date" class="form-control form--control"
                                                    value="{{ old('expired_date') }}" name="expired_date">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group mb-3">
                                                <label>@lang('Thumbnail')</label>
                                                <input type="file" class="form-control form--control"
                                                    accept="image/jpeg, image/png, image/jpg" name="image">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group mb-3">
                                                <label>@lang('Agreement Paper')</label>
                                                <input type="file" class="form-control form--control" accept=".pdf"
                                                    name="agreement_paper">
                                            </div>
                                        </div>
                                    </div>

                                    <p>@lang('FAQ') </p>
                                    <button type="button" class="btn btn--primary faq-add">@lang('Add More')</button>
                                    <div class="row faq_row">
                                        <div class="col-md-12">
                                            <div class="form-group mb-3">
                                                <label>@lang('Question')</label>
                                                <input type="text" class="form-control form--control"
                                                    name="faq_question[]">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group mb-3">
                                                <label>@lang('Answer')</label>
                                                <textarea name="faq_answer[]" class="form-control form--control"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <button type="submit" class="btn btn--primary ">@lang('Submit')</button>
                                </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
