@php
    $socials = getContent('social_icon.element', orderById: true);
    $policyPages = getContent('policy_pages.element', orderById: true);
    $subscribe = getContent('subscribe.content', true);
    $footer = getContent('footer.content', true);
    $content = @getContent('contact_us.content', true)->data_values;
@endphp


<footer class="footer-area">
    <div class="py-120">
        <div class="container">
            <div class="row justify-content-between gy-4">
                <div class="col-lg-4 col-md-6">
                    <div class="footer-item">
                        <div class="footer-item__logo">
                            <a href="{{ route('home') }}"> <img src="{{ siteLogo() }}" alt="@lang('image')"></a>
                        </div>
                        <p class="footer-item__desc">
                            {{ __($footer->data_values->description) }}
                        </p>

                    </div>
                </div>
                <div class="col-lg-2 col-sm-6 col-xsm-6">
                    <div class="footer-item two">
                        <h5 class="footer-item__title">@lang('Quick Link')</h5>
                        <ul class="footer-menu">
                            <li class="footer-menu__item"><a href="{{ route('home') }}" class="footer-menu__link">@lang('Home')</a></li>
                            <li class="footer-menu__item"><a href="{{ route('blog') }}" class="footer-menu__link">@lang('Blog')</a></li>
                            <li class="footer-menu__item"><a href="{{ route('contact') }}" class="footer-menu__link">@lang('Contact')</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-sm-6 col-xsm-6">
                    <div class="footer-item">
                        <h5 class="footer-item__title">@lang('Policy Pages')</h5>
                        <ul class="footer-menu">
                            @foreach ($policyPages as $policy)
                                <li class="footer-menu__item"><a href="{{ route('policy.pages', [slug($policy->data_values->title), $policy->id]) }}"
                                        class="footer-menu__link">{{ __($policy->data_values->title) }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="footer-item">
                        <h5 class="footer-item__title">@lang('Get in Touch')</h5>
                        <ul class="footer-menu">
                            <li class="footer-menu__item">
                                <a href="tel:{{str_replace(" ","",@$content->mobile_number)}}" class="footer-menu__link">
                                    <i class="las la-phone"></i> {{ @$content->mobile_number }}
                                </a>
                            </li>
                            <li class="footer-menu__item">
                                <a href="mailto:{{ @$content->email_address }}" class="footer-menu__link">
                                    <i class="las la-envelope"></i> {{ @$content->email_address }}
                                </a>
                            </li>
                            <li class="footer-menu__item">
                                <a href="javascript:void(0)" class="footer-menu__link">
                                    <i class="las la-map-marker"></i> {{ @$content->address }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom-footer py-3">
        <div class="container">
            <div class="flex-align justify-content-between">
                <ul class="social-list">
                    @foreach ($socials as $social)
                        <li class="social-list__item">
                            <a href="{{ $social->data_values->url }}" target="_blank" class="social-list__link flex-center">
                                @php echo $social->data_values->social_icon; @endphp
                            </a>
                        </li>
                    @endforeach
                </ul>
                <div class="bottom-footer-text">
                    &copy; @php echo now()->year; @endphp
                    <a href="{{ route('home') }}" class="text--base">{{ $general->site_name }}</a>. @lang('All Rights Reserved')
                </div>
            </div>
        </div>
    </div>
</footer>
