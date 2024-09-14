<div class="profile-top">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-5">
                <div class="profile-top__user">
                    <div class="profile-top__user__img">
                        <img src="{{ getImage(getFilePath('userProfile') . '/' . $investor->image, getFileSize('userProfile')) }}"
                            alt="@lang('image')">
                        @if ($investor->verified_badge_active == Status::BADGE_ACTIVE)
                            <span class="verified"><i class="fas fa-check"></i></span>
                        @endif
                    </div>

                    <div class="profile-top__user__txt">
                        <h6 class="profile-top__user__name">{{ __($investor->fullname) }}</h6>
                        <span class="profile-top__user__bio">{{ __($investor->position) }}</span>
                        <span class="profile-top__user__rating">
                            <span class="rating-list">
                                @php echo displayRating($investor->reviews->avg('rating')); @endphp
                            </span>
                            <span class="profile-top__user__rating__badge">{{ $investor->reviews->avg('rating') ?? 0 }}</span>
                            <span class="profile-top__user__rating__text">({{ $investor->reviews->count() }})
                                @lang("Reviews")
                            </span>
                        </span>
                        <span class="profile-top__user__info">
                            <span class="profile-top__user__location">
                                <img src="{{ getImage('assets/images/country/' . strtolower(substr($investor->address->country ?? null, 0, 2)) . '.svg') }}"
                                    alt="Canada">{{ @$user->address->country }}
                            </span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 d-flex flex-column align-items-lg-end align-items-start">
                <div class="profile-top__stats">
                    <div class="profile-top__stats__card">
                        <div class="profile-top__stats__icon">
                            <img src="{{ asset($activeTemplateTrue . 'images/icons/stats-icon-1.png') }}" alt="@lang('Icon')">
                        </div>
                        <div class="profile-top__stats__txt">
                            <span class="profile-top__stats__number">{{ $investor->cases->count() }}</span>
                            <span class="profile-top__stats__name">@lang('Total Cases')</span>
                        </div>
                    </div>
                    <div class="profile-top__stats__card">
                        <div class="profile-top__stats__icon">
                            <img src="{{ asset($activeTemplateTrue . 'images/icons/stats-icon-2.png') }}" alt="@lang('Icon')">
                        </div>
                        <div class="profile-top__stats__txt">
                            <span class="profile-top__stats__number">{{ $investor->successfulInvest->count() }}</span>
                            <span class="profile-top__stats__name">@lang('Total Invest')</span>
                        </div>
                    </div>
                    <div class="profile-top__stats__card">
                        <div class="profile-top__stats__icon">
                            <img src="{{ asset($activeTemplateTrue . 'images/icons/stats-icon-3.png') }}" alt="@lang('Icon')">
                        </div>
                        <div class="profile-top__stats__txt">
                            <span class="profile-top__stats__number">{{ $investor->reviews->count() }}</span>
                            <span class="profile-top__stats__name">@lang('Total Review')</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="overflow-auto">
                    <ul class="profile-top__menu">
                        <li><a href="{{ route('investor', $investor->username) }}" class="profile-top__menu__link">@lang('About')</a></li>
                        <li><a href="{{ route('cases', $investor->username) }}" class="profile-top__menu__link">@lang('Cases')</a></li>
                        <li><a href="{{ route('comments', $investor->username) }}"
                                class="profile-top__menu__link">@lang('Comment')({{ $investor->comments->count() }})</a></li>
                        <li><a href="{{ route('reviews', $investor->username) }}"
                                class="profile-top__menu__link">@lang('Review')({{ $investor->reviews->count() }})</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
