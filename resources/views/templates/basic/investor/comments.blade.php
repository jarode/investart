@extends($activeTemplate . 'layouts.frontend')
@section('content')
    @include($activeTemplate . 'investor.header')
    <div class="profile">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="profile__content">
                        <ul class="comment-list">
                            @forelse ($investor->comments as $comment)
                                <li class="comment-list__item d-flex flex-wrap">
                                    <div class="comment-list__thumb">
                                        <img src="{{ getImage(getFilePath('userProfile') . '/' . $comment->user->image, getFileSize('userProfile')) }}"
                                            class="fit-image" alt="@lang('image')">
                                    </div>
                                    <div class="comment-list__content">
                                        <h5 class="comment-list__name">{{ __($comment->user->fullname) }}</h5>
                                        <span class="comment-list__time">{{ diffForHumans($comment->created_at) }}</span>
                                        <p class="comment-list__desc">{{ __($comment->comment) }}</p>

                                    </div>
                                </li>
                            @empty
                                <li>
                                    <div class="p-5 text-center bg-white rounded-2">
                                        <img src="{{ asset('assets/images/empty.png') }}">
                                        <p>@lang('No comment found')</p>
                                    </div>
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4">
                    @include($activeTemplate . 'investor.sidebar_data')
                </div>
            </div>
        </div>
    </div>
@endsection
