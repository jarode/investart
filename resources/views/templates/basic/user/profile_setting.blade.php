@extends($activeTemplate . 'layouts.master')
@section('content')

    <div class="dashboard position-relative">
        <div class="dashboard-body">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-md-10">
                        <div class="card custom--card">
                            <div class="card-header d-flex flex-wrap justify-content-between">
                                <h3 class="card-title">@lang('Profile')</h3>
                                <div class="card-header-right card--right-wrapper">
                                    @if ($user->verified_badge_active == Status::BADGE_INACTIVE)
                                        <button type="button" class="btn profile-confirmatiion btn-outline--primary confirmationBtn"
                                            data-action="{{ route('user.enable.badge') }}" data-question="@lang('Are you sure to enable badge?')">
                                            <span class="icon"><i class="la la-eye"></i></span> @lang('Enable Badge')
                                        </button>
                                        @if ($user->badge_expired < now())
                                            <span class="enable-note"
                                                class="d-block">@lang('Enable badge every month reduce '){{ $general->cur_sym . showAmount($general->verified_badge_price) }}
                                                @lang('from your balance')</span>
                                        @endif
                                    @else
                                        <button type="button" class="btn profile-confirmatiion btn-outline--danger confirmationBtn"
                                            data-action="{{ route('user.disable.badge') }}" data-question="@lang('Are you sure to disable badge?')">
                                            <span class="icon"><i class="la la-eye"></i></span> @lang('Disable Badge')
                                        </button>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="profile__thumb">
                                        <div class="file-upload-profile">
                                            <label class="edit-pen" for="profile-image"><i class="las la-camera"></i></label>
                                            <input type="file" name="image" accept=".png, .jpg, .jpeg" class="form-control form--control"
                                                id="profile-image" hidden="">
                                        </div>
                                        <img src="{{ getImage(getFilePath('userProfile') . '/' . $user->image, getFileSize('userProfile')) }}"
                                            id="imagePreview" alt="@lang('img')">
                                    </div>
                                    <div class="text-center mb-4 mt-3">
                                        <small class="">
                                            @lang('Supported Files'): <b> @lang('.png, .jpg, .jpeg')</b> <br> @lang('& image will be resized into')
                                            <b>{{ getFileSize('userProfile') }}</b>@lang('px')
                                        </small>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <label class="form--label">@lang('First Name')</label>
                                            <input type="text" class="form-control form--control" name="firstname" value="{{ $user->firstname }}"
                                                required>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label class="form--label">@lang('Last Name')</label>
                                            <input type="text" class="form-control form--control" name="lastname" value="{{ $user->lastname }}"
                                                required>
                                        </div>
                                        <div class="form-group col-12">
                                            <label class="form--label">@lang('Position')</label>
                                            <input type="text" class="form-control form--control" name="position" value="{{ $user->position }}"
                                                required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <label class="form--label">@lang('E-mail Address')</label>
                                            <input class="form-control form--control" value="{{ $user->email }}" readonly>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label class="form--label">@lang('Mobile Number')</label>
                                            <input class="form-control form--control" value="{{ $user->mobile }}" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <label class="form--label">@lang('Address')</label>
                                            <input type="text" class="form-control form--control" name="address"
                                                value="{{ @$user->address->address }}">
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label class="form--label">@lang('State')</label>
                                            <input type="text" class="form-control form--control" name="state" value="{{ @$user->address->state }}">
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="form-group col-sm-4">
                                            <label class="form--label">@lang('Zip Code')</label>
                                            <input type="text" class="form-control form--control" name="zip" value="{{ @$user->address->zip }}">
                                        </div>

                                        <div class="form-group col-sm-4">
                                            <label class="form--label">@lang('City')</label>
                                            <input type="text" class="form-control form--control" name="city" value="{{ @$user->address->city }}">
                                        </div>

                                        <div class="form-group col-sm-4">
                                            <label class="form--label">@lang('Country')</label>
                                            <input class="form-control form--control" value="{{ @$user->address->country }}" disabled>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <label>@lang('About')</label>
                                            <textarea name="about" class="form-control form--control nicEdit">{{ $user->about }}</textarea>
                                        </div>
                                    </div>

                                    <div class="form-group mt-3">
                                        <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-confirmation-modal isFrontend="true" />
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
            $('#profile-image').on("change", function() {
                var file = this.files[0];

                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#imagePreview').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(file);
                }
            });
        })(jQuery);
    </script>
@endpush

