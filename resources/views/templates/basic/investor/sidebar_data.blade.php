<div class="post-sidebar-wrapper">
    <div class="post-sidebar">
        <h5 class="post-sidebar__title">@lang('Profile Info')</h5>
        <div class="post-sidebar__body">
            <ul class="text-list profile-info">
                <li class="text-list__item">@lang('Name') <span>{{ __($investor->fullname) }}</span></li>
                <li class="text-list__item">@lang('City') <span>{{ __(@$investor->address->city) }}</span></li>
                <li class="text-list__item">@lang('Country') <span>{{ __(@$investor->address->country) }}</span></li>
                <li class="text-list__item">@lang('Join At') <span>{{ showDateTime($investor->created_at) }}</span></li>
            </ul>
        </div>
    </div>
    <div class="post-sidebar">
        <h5 class="post-sidebar__title">@lang('Profile link')</h5>
        <div class="post-sidebar__body">
            <label class="form--label">@lang('Link')</label>
            <div class="input--group">
                <input type="email" class="form--control link-to-copy" value="{{ route('investor', $investor->username) }}">
                <button class="btn btn--base copy-link"><i class="far fa-copy"></i></button>
            </div>
        </div>
    </div>
</div>
