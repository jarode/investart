@extends($activeTemplate . 'layouts.auth')
@section('content')
    @php
        $policyPages = getContent('policy_pages.element', orderById: true);
    @endphp
    <div class="account-form__wrap">
        <div class="account-form__content">
            <div class="logo"><a href="{{ route('home') }}"><img src="{{ siteLogo() }}" alt="@lang('Logo')"></a></div>
            @include($activeTemplate . '.user.auth.social_login')
        </div>
        <form action="{{ route('user.register') }}" method="POST" class="account-content__form verify-gcaptcha">
            @csrf
            <div class="row">
                @if (session()->get('reference') != null)
                    <div class="col-12">
                        <div class="form-group">
                            <div class="form--floating form-floating">
                                <input type="text" name="refferdby" readonly value="{{ session()->get('reference') }}"
                                    class="form-control form--control checkUser" placeholder="@lang('Referred by')" required>
                                <label>@lang('Referred by')</label>
                                <small class="text--danger usernameExist"></small>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="col-sm-6">
                    <div class="form-group">
                        <div class="form--floating form-floating">
                            <input type="text" name="username" value="{{ old('username') }}" class="form-control form--control checkUser"
                                placeholder="@lang('Username')" required>
                            <label>@lang('Username')</label>
                            <small class="text--danger usernameExist"></small>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <div class="form--floating form-floating">
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="@lang('Email Address')" required
                                class="form-control form--control checkUser">
                            <label>@lang('Email Address')</label>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <select class="form--control bg-dark select-2 w-100" name="country" id="country">
                            @foreach ($countries as $key => $country)
                                <option data-mobile_code="{{ $country->dial_code }}" value="{{ $country->country }}" data-code="{{ $key }}"
                                    data-image="{{ getImage('assets/images/country/' . strtolower($key) . '.svg') }}">
                                    {{ __($country->country) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <div class="input--group">
                            <span class="input-group-text mobile-code"></span>
                            <div class="form--floating form-floating">
                                <input type="hidden" value="+93" name="mobile_code">
                                <input type="hidden" value="Afganistan" name="country_code">
                                <input type="number" class="form-control form--control" id="emailAddress" name="mobile" value="{{ old('mobile') }}"
                                    placeholder="@lang('Phone')" required>
                                <label>@lang('Phone')</label>
                            </div>
                        </div>
                        <small class="text--danger mobileExist"></small>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <div class="form--floating form-floating form--floating--password">
                            <input id="password" name="password" placeholder="@lang('Password')" type="password"
                                class="form-control @if ($general->secure_password) secure-password @endif form--control" required>
                            <label>@lang('Password')</label>
                            <a role="button" data-password-id="password"><i class="far fa-eye"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <div class="form--floating form-floating form--floating--password">
                            <input id="confirmPassword" name="password_confirmation" type="password" class="form-control form--control"
                                placeholder="@lang('Confirm Password')" required>
                            <label>@lang('Confirm Password')</label>
                            <a role="button" data-password-id="confirmPassword"><i class="far fa-eye"></i></a>
                        </div>
                    </div>
                </div>

                <x-captcha />

                @if ($general->agree)
                    <div class="mb-3 col-sm-12">
                        <div class="form--check">
                            <input class="form-check-input" name="agree" id="agree" type="checkbox">
                            <div class="form-check-label">
                                <label for="agree">@lang('I agree with')</label>
                                @foreach ($policyPages as $policy)
                                    <a href="{{ route('policy.pages', [slug($policy->data_values->title), $policy->id]) }}"
                                        target="_blank">{{ __($policy->data_values->title) }}</a>
                                    @if (!$loop->last)
                                        ,
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <div class="mb-3 col-sm-12">
                    <button type="submit" class="btn btn--base w-100">@lang('Register')</button>
                </div>
                <div class="mb-3 col-sm-12">
                    <div class="have-account text-left">
                        <p class="have-account__text">@lang('Already Have an Account')? <a href="{{ route('user.login') }}"
                                class="have-account__link text--base">@lang('Login Now')</a></p>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection
@push('style')
@endpush

@if ($general->secure_password)
    @push('script-lib')
        <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
    @endpush
@endif

@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/global/css/select2.min.css') }}">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/global/js/select2.min.js') }}"></script>
@endpush

@push('script')
    <script>
        "use strict";
        (function($) {
            @if ($mobileCode)
                $(`option[data-code={{ $mobileCode }}]`).attr('selected', '');
            @endif

            $('select[name=country]').on("change", function() {

                $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
                $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
                $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
            });
            $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
            $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
            $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));

            $('.checkUser').on('focusout', function(e) {
                var url = '{{ route('user.checkUser') }}';
                var value = $(this).val();
                var token = '{{ csrf_token() }}';
                if ($(this).attr('name') == 'mobile') {
                    var mobile = `${$('.mobile-code').text().substr(1)}${value}`;
                    var data = {
                        mobile: mobile,
                        _token: token
                    }
                }
                if ($(this).attr('name') == 'email') {
                    var data = {
                        email: value,
                        _token: token
                    }
                }
                if ($(this).attr('name') == 'username') {
                    var data = {
                        username: value,
                        _token: token
                    }
                }
                $.post(url, data, function(response) {
                    if (response.data != false && response.type == 'email') {
                        $('#existModalCenter').modal('show');
                    } else if (response.data != false) {
                        $(`.${response.type}Exist`).text(`${response.type} already exist`);
                    } else {
                        $(`.${response.type}Exist`).text('');
                    }
                });
            });

            function formatImage(imageOption) {
                if (!imageOption.id) {
                    if ($(imageOption.element).data("placeholder")) {
                        return $(imageOption.element).data("placeholder");
                    }
                    return imageOption.text;
                }
                var optionClass = $(imageOption.element).data("class");
                var $image = $('<img class="flag_image">').attr(
                    "src",
                    $(imageOption.element).data("image")
                );
                var $text = $("<span>").text(imageOption.text);
                return $("<span>").addClass(optionClass).append($image).append($text);
            }

            function formatPlaceholder(imageOption) {
                if (!imageOption.id) {
                    return $(imageOption.element).data("placeholder");
                }
                return imageOption.text;
            }

            function formatImageSelection(imageOption) {
                var $image = $('<img class="flag_image">').attr(
                    "src",
                    $(imageOption.element).data("image")
                );
                var $text = $("<span>").text(imageOption.text);

                return $("<span>").append($image).append($text);
            }
            $(".select-2").select2({
                templateResult: formatImage,
                templateSelection: formatImageSelection,
                containerCssClass: ":all:",
                placeholder: formatPlaceholder,
            });

        })(jQuery);
    </script>
@endpush
