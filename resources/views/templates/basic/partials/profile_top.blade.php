<div class="profile-top">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-5">
                <div class="profile-top__user">
                    <div class="profile-top__user__img">
                        <img src="{{ getImage(getFilePath('userProfile') . '/' . $user->image, getFileSize('userProfile')) }}" alt="@lang('image')">
                        @if ($user->verified_badge_active == Status::BADGE_ACTIVE)
                            <span class="verified"><i class="fas fa-check"></i></span>
                        @endif
                    </div>

                    <div class="profile-top__user__txt">
                        <h6 class="profile-top__user__name">{{ __($user->fullname) }}</h6>
                        <span class="profile-top__user__bio">{{ __($user->position) }}</span>
                        <span class="profile-top__user__rating">
                            <span class="rating-list">
                                @php echo displayRating($user->reviews->avg('rating')); @endphp
                            </span>
                            <span class="profile-top__user__rating__badge">{{ $user->reviews->avg('rating') ?? 0 }}</span>
                            <span class="profile-top__user__rating__text">({{ $user->reviews->count() }} @lang('Reviews'))</span>
                        </span>
                        <span class="profile-top__user__info">
                            <span class="profile-top__user__location">
                                <img src="{{ getImage('assets/images/country/' . strtolower(substr(@$user->address->country ?? null, 0, 2)) . '.svg') }}"
                                    alt="Canada">
                                {{ @$user->address->country }}
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
                            <span class="profile-top__stats__number">{{ $user->cases->count() }}</span>
                            <span class="profile-top__stats__name">@lang('Total Cases')</span>
                        </div>
                    </div>
                    <div class="profile-top__stats__card">
                        <div class="profile-top__stats__icon">
                            <img src="{{ asset($activeTemplateTrue . 'images/icons/stats-icon-2.png') }}" alt="@lang('Icon')">
                        </div>
                        <div class="profile-top__stats__txt">
                            <span class="profile-top__stats__number">{{ $user->successfulInvest->count() }}</span>
                            <span class="profile-top__stats__name">@lang('Successful Cases')</span>
                        </div>
                    </div>
                    <div class="profile-top__stats__card">
                        <div class="profile-top__stats__icon">
                            <img src="{{ asset($activeTemplateTrue . 'images/icons/stats-icon-3.png') }}" alt="@lang('Icon')">
                        </div>
                        <div class="profile-top__stats__txt">
                            <span class="profile-top__stats__number">{{ $user->reviews->count() }}</span>
                            <span class="profile-top__stats__name">@lang('Total Review')</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 position-relative">

                <div class="overflow-auto">
                    <ul class="profile-top__menu">
                        <li><a href="{{ route('user.home') }}" class="profile-top__menu__link">@lang('Dashboard')</a></li>
                        <li>
                            <a href="{{ route('user.case.history') }}" class="profile-top__menu__link {{ menuActive('user.case.*') }}">
                                @lang('Manage Case')
                            </a>
                        </li>
                        <li><a href="{{ route('user.invest.list') }}" class="profile-top__menu__link">@lang('My Invest')</a></li>
                        <li><a href="{{ route('user.profit.return') }}" class="profile-top__menu__link">@lang('Profit')</a></li>
                        <li><a href="{{ route('user.deposit.history') }}"
                                class="profile-top__menu__link {{ menuActive(['user.deposit.index', 'user.deposit.confirm']) }}">@lang('Deposit')</a>
                        </li>
                        <li><a href="{{ route('user.withdraw.history') }}" class="profile-top__menu__link">@lang('Withdraw')</a></li>
                        <li><a href="{{ route('user.transactions') }}" class="profile-top__menu__link">@lang('Transaction')</a></li>
                        <li><a href="{{ route('user.referrals') }}" class="profile-top__menu__link">@lang('Referrals')</a></li>
                        <li><a href="{{ route('ticket.index') }}" class="profile-top__menu__link">@lang('Support')</a></li>
                        <li>
                            <a href="javascript:void(0)" class="profile-has-menu profile-top__menu__link">@lang('Setting') <span
                                    class="profile-has-menu-icon"><i class="fas fa-chevron-down"></i></span>
                            </a>
                            <div class="extra-nav">
                                <ul>
                                    <li>
                                        <a href="{{ route('user.change.password') }}">@lang('Change Password')</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('user.profile.setting') }}">@lang('Profile Setting')</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('user.twofactor') }}">@lang('2FA Security')</a>
                                    </li>
                                    <li>
                                </ul>
                            </div>
                        </li>
                        <li><a href="{{ route('user.logout') }}" class="profile-top__menu__link">@lang('Logout')</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
