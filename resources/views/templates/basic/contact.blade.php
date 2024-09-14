@extends($activeTemplate . 'layouts.frontend')
@section('content')
    @php
        $content = @getContent('contact_us.content', true)->data_values;
    @endphp
    <div class="pt-120 pb-60">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="contact__info">
                        <div class="contact__info__card">
                            <div class="row gy-3 gy-md-4 justify-content-center">
                                <div class="col-lg-4 col-sm-6">
                                    <div class="contact__info__card__icon">
                                        <img src="{{ asset($activeTemplateTrue . 'images/icons/contact-icon-1.png') }}" alt="@lang('Icon')">
                                    </div>
                                    <h3 class="contact__info__card__title">@lang('Our Address')</h3>
                                    <p class="contact__info__card__desc">{{ __(@$content->address) }}</p>
                                </div>
                                <div class="col-lg-4 col-sm-6">
                                    <div class="contact__info__card__icon">
                                        <img src="{{ asset($activeTemplateTrue . 'images/icons/contact-icon-3.png') }}" alt="@lang('Icon')">
                                    </div>
                                    <h3 class="contact__info__card__title">@lang('Mobile')</h3>
                                    <a href="tel:{{ str_replace(' ', '', @$content->mobile_number) }}"
                                        class="contact__info__card__desc">{{ @$content->mobile_number }}
                                    </a>
                                </div>
                                <div class="col-lg-4 col-sm-6">
                                    <div class="contact__info__card__icon">
                                        <img src="{{ asset($activeTemplateTrue . 'images/icons/contact-icon-2.png') }}" alt="@lang('Icon')">
                                    </div>
                                    <h3 class="contact__info__card__title">@lang('Email')</h3>
                                    <a class="contact__info__card__desc" href="mailto:{{ @$content->email_address }}">{{ @$content->email_address }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pb-120 pt-60">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-7">
                    <div class="contact__form">
                        <div class="contact__form__card">
                            <div class="mb-4">
                                <h3 class="mb-0">{{ __(@$content->heading) }}</h3>
                                <p>{{ __(@$content->subheading) }}</p>
                            </div>
                            <form method="post" action="{{ route('contact.submit') }}" class="verify-gcaptcha">
                                @csrf
                                <div class="mb-3">
                                    <div class="form--floating form-floating">
                                        <input type="text" class="form--control form-control" name="name"
                                            value="{{ old('name', @$user->fullname) }}" @if ($user) readonly @endif required
                                            placeholder="@lang('Name')">
                                        <label>@lang('Name')</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form--floating form-floating">
                                        <input type="email" class="form--control form-control" name="email" value="{{ old('email', @$user->email) }}"
                                            @if ($user) readonly @endif required placeholder="@lang('Email')">
                                        <label>@lang('Email')</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form--floating form-floating">
                                        <input type="text" name="subject" required class="form--control form-control" placeholder="name@example.com">
                                        <label>@lang('Write about the subject here..')</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form--floating form-floating">
                                        <textarea class="form--control form-control" name="message" placeholder="@lang('Your Message')"></textarea>
                                        <label>@lang('Your Message')</label>
                                    </div>
                                </div>
                                <x-captcha />
                                <div class="mb-3">
                                    <button class="btn btn--base">@lang('Send Message')</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="contact-thumb d-none d-lg-block h-100">
                        <img src="{{ sectionImage('contact_us', @$content->image, '530x700') }}">
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (@$sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif
@endsection
