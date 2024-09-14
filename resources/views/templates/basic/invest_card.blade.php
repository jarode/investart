<div class="case-card">
    <a class="case-card__img" href="{{ route('investment.case.details', $data->case_code) }}">
        <img src="{{ getImage(getFilePath('investmentImage') . '/thumb_' . $data->image, getFileSize('investmentImage')) }}" alt="@lang('image')">
        @if (@$showExpiredDate)
            <span class="case-card__badge">{{ diffInDays($data->expired_date) }}
                @lang('DAY LEFT')</span>
        @endif
    </a>
    <div class="case-card__txt">
        <h3 class="case-card__title"><a href="{{ route('investment.case.details', $data->case_code) }}">{{ __($data->title) }}</a></h3>
        <span class="case-card__about">
            @lang('By') <a href="{{ route('investor', $data->user->username) }}">{{ __($data->user->fullname) }}

                @if ($data->user->verified_badge_active == Status::BADGE_ACTIVE)
                    <span class="verified"><i class="fas fa-check"></i></span>
                @endif
            </a>
            <span class="rating-list">
                @php echo displayRating($data->reviews->avg('rating')); @endphp
                <span class="rating-list__text">({{ $data->reviews->count() }})</span>
            </span>
        </span>
        <div class="case-card__info">
            <div class="case-card__info__txt">
                @lang('MIN. INVEST')
                <span>{{ showAmount($data->plans->min('minimum_invest')) . ' ' . __($general->cur_text) }}</span>
            </div>
            <div class="case-card__info__txt">
                @lang('MAX. INVEST')
                <span>{{ showAmount($data->plans->max('maximum_invest')) . ' ' . __($general->cur_text) }}</span>
            </div>
        </div>
    </div>
</div>
