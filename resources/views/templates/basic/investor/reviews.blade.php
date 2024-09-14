@extends($activeTemplate . 'layouts.frontend')
@section('content')
    @include($activeTemplate . 'investor.header')
    <div class="profile">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="profile__content">
                        <ul class="review-list">
                            @forelse ($investor->reviews as $review)
                                <li class="review-list__item">
                                    <div class="review-list__content">
                                        <div class="review-list__heading">
                                            <div class="rating-list">
                                                @php echo displayRating($review->rating); @endphp
                                            </div>
                                            <h5 class="review-list__name"><a
                                                    href="{{ route('investor', $review->user->username) }}">{{ __($review->user->fullname) }}</a></h5>
                                            <span class="review-list__time">{{ diffForHumans($review->created_at) }}</span>
                                        </div>
                                        <p class="review-list__desc">{{ __($review->comment) }}</p>
                                    </div>
                                </li>
                                @empty
                                    <li>
                                        <div class="p-5 text-center bg-white rounded-2">
                                            <img src="{{ asset('assets/images/empty.png') }}">
                                            <p>@lang('No review found')</p>
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
