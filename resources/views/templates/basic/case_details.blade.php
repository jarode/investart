@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="project-details py-120">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="project-details__thumb">
                        <img src="{{ getImage(getFilePath('investmentImage') . '/' . $investmentCase->image, getFileSize('investmentImage')) }}"
                            alt="@lang('image')">
                        @if ($investmentCase->video_url)
                            <div class="project-details__video">
                                <a class="video-btn banner-content__video" href="{{ $investmentCase->video_url }}">
                                    <img src="{{ asset($activeTemplateTrue . 'images/icons/play.png') }}" alt="Play">
                                </a>
                            </div>
                        @endif
                    </div>
                    <div class="project-details__content">
                        <h3 class="project-details__title">{{ __($investmentCase->title) }}</h3>
                        <div class="project-details__stats">
                            <div class="project-details__stats__txt">
                                <div class="project-details__stats__raised">
                                    <span>@lang('RAISED')</span>
                                    <h5>{{ $general->cur_sym . showAmount($investmentCase->reach_amount) }}</h5>
                                </div>
                                <div class="project-details__stats__goal">
                                    <span>@lang('GOAL')</span>
                                    <h5>{{ $general->cur_sym . showAmount($investmentCase->goal_amount) }}</h5>
                                </div>

                            </div>
                            <div class="custom--progress progress" role="progressbar" aria-valuenow="{{ $investmentCase->progress }}">
                                <div class="progress-bar" style="width: {{ $investmentCase->progress }}%"></div>
                            </div>
                        </div>

                        <nav>
                            <div class="custom--tab-2 nav nav-tabs" id="nav-tab" role="tablist">
                                <button class="nav-link active" id="nav-overview-tab" data-bs-toggle="tab" data-bs-target="#nav-overview" type="button"
                                    role="tab">
                                    @lang('Overview')
                                </button>
                                <button class="nav-link " id="nav-segment-tab" data-bs-toggle="tab" data-bs-target="#nav-segment" type="button"
                                    role="tab">
                                    @lang('Investment Plan')
                                </button>
                                <button class="nav-link" id="nav-comment-tab" data-bs-toggle="tab" data-bs-target="#nav-comment" type="button"
                                    role="tab">
                                    @lang('Comment')
                                </button>
                                <button class="nav-link" id="nav-review-tab" data-bs-toggle="tab" data-bs-target="#nav-review" type="button"
                                    role="tab">
                                    @lang('Review')
                                </button>
                                <button class="nav-link" id="nav-faq-tab" data-bs-toggle="tab" data-bs-target="#nav-faq" type="button" role="tab">
                                    @lang('Faq')
                                </button>
                                <button class="nav-link" id="nav-agreement-tab" data-bs-toggle="tab" data-bs-target="#nav-agreement" type="button"
                                    role="tab">
                                    @lang('Agreement')
                                </button>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-overview" role="tabpanel">
                                <div>
                                    @php echo $investmentCase->overview; @endphp
                                </div>
                                <div class="mt-4">
                                    <h4>@lang('Share Link')</h4>
                                    <ul class="social-list">
                                        <li class="social-list__item">
                                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(Request::url()) }}" target="_blank"
                                                class="social-list__link flex-center active"><i class="fab fa-facebook-f"></i>
                                            </a>
                                        </li>
                                        <li class="social-list__item">
                                            <a href="https://www.twitter.com/intent/tweet?url={{ urlencode(Request::url()) }}" target="_blank"
                                                class="social-list__link flex-center "> <i class="fab fa-twitter"></i>
                                            </a>
                                        </li>
                                        <li class="social-list__item">
                                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(Request::url()) }}" target="_blank"
                                                class="social-list__link flex-center"> <i class="fab fa-linkedin-in"></i>
                                            </a>
                                        </li>
                                        <li class="social-list__item">
                                            <a href="https://www.pinterest.com/pin/create/button/?url={{ urlencode(Request::url()) }}" target="_blank"
                                                class="social-list__link flex-center"> <i class="fab fa-instagram"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-comment" role="tabpanel">
                                <h3 class="project-details__subtitle"><span>@lang('Comments')</span></h3>
                                <form action="{{ route('user.comment.submit', $investmentCase->id) }}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <textarea class="form--control" name="comment"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn--base">@lang('Submit')</button>
                                </form>
                                <ul class="comment-list mt-4">
                                    @foreach ($investmentCase->comments as $comment)
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
                                    @endforeach
                                </ul>
                            </div>

                            <div class="tab-pane fade " id="nav-review" role="tabpanel">
                                <h3 class="project-details__subtitle"><span>@lang('Review')</span></h3>
                                <form action="{{ route('user.review.submit', $investmentCase->id) }}" method="post">
                                    @csrf
                                    <div class="rating_wrapper">
                                        <label for="" class="reveiw_form_label">@lang('Select Rating')</label>
                                        <div class="rating-group">
                                            <input class="rating__input" name="rating" id="rating3-none" value="0" type="radio">
                                            <label class="rating__label" for="rating3-1">
                                                <i class="rating__icon rating__icon--star fa fa-star"></i>
                                            </label>
                                            <input class="rating__input" name="rating" id="rating3-1" value="1" type="radio">
                                            <label class="rating__label" for="rating3-2">
                                                <i class="rating__icon rating__icon--star fa fa-star"></i>
                                            </label>
                                            <input class="rating__input" name="rating" id="rating3-2" value="2" type="radio">
                                            <label class="rating__label" for="rating3-3">
                                                <i class="rating__icon rating__icon--star fa fa-star"></i>
                                            </label>
                                            <input class="rating__input" name="rating" id="rating3-3" value="3" type="radio">
                                            <label class="rating__label" for="rating3-4">
                                                <i class="rating__icon rating__icon--star fa fa-star"></i>
                                            </label>
                                            <input class="rating__input" name="rating" id="rating3-4" value="4" type="radio">
                                            <label class="rating__label" for="rating3-5">
                                                <i class="rating__icon rating__icon--star fa fa-star"></i>
                                            </label>
                                            <input class="rating__input" name="rating" id="rating3-5" value="5" type="radio">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <textarea class="form--control" name="comment"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn--base">@lang('Submit')</button>
                                </form>
                                <ul class="review-list mt-5">
                                    @foreach ($investmentCase->reviews as $review)
                                        <li class="review-list__item">
                                            <div class="review-list__content">
                                                <div class="review-list__heading">
                                                    <div class="rating-list">
                                                        @php echo displayRating($review->rating); @endphp
                                                    </div>
                                                    <h5 class="review-list__name">
                                                        <a href="{{ route('investor', $review->user->username) }}">
                                                            {{ __($review->user->fullname) }}
                                                        </a>
                                                    </h5>
                                                    <span class="review-list__time">{{ diffForHumans($review->created_at) }}</span>
                                                </div>
                                                <p class="review-list__desc">{{ __($review->comment) }}</p>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="tab-pane fade " id="nav-faq" role="tabpanel">
                                <div class="custom--accordion-2 accordion" id="faqAccoriadiam">
                                    @foreach ($investmentCase->faq as $k => $item)
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#colspan{{ $k }}">
                                                    {{ __($item->question) }}
                                                </button>
                                            </h2>
                                            <div id="colspan{{ $k }}" class="accordion-collapse collapse {{ $k == 0 ? 'show' : '' }}"
                                                data-bs-parent="#faqAccoriadiam">
                                                <div class="accordion-body">
                                                    <p>{{ __($item->answer) }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="tab-pane fade " id="nav-segment" role="tabpanel">
                                <div class="project-details__types mt-5">
                                    <div class="row gy-4">
                                        @foreach ($investmentCase->activePlan as $plan)
                                            <div class="col-sm-6 col-xl-4">
                                                <div class="post-sidebar">
                                                    <h5 class="post-sidebar__title">{{ __($plan->title) }}</h5>
                                                    <div class="post-sidebar__body">
                                                        <ul class="text-list profile-info">
                                                            <li class="text-list__item">
                                                                @lang('Minimum Invest')
                                                                <span>{{ $general->cur_sym . showAmount($plan->minimum_invest) }}</span>
                                                            </li>
                                                            <li class="text-list__item">
                                                                @lang('Maximum Invest')
                                                                <span>{{ $general->cur_sym . showAmount($plan->maximum_invest) }}</span>
                                                            </li>
                                                            <li class="text-list__item">
                                                                @lang('Return Period')
                                                                <span>{{ $plan->schedule->title }}</span>
                                                            </li>
                                                            <li class="text-list__item">
                                                                @lang('Profit')
                                                                <span>
                                                                    @if ($plan->profit_type == Status::FIXED_TYPE)
                                                                        <span>{{ $general->cur_sym . showAmount($plan->profit_value) }}</span>
                                                                    @else
                                                                        <span>{{ showAmount($plan->profit_value, 2) . '%' }}</span>
                                                                    @endif
                                                                </span>
                                                            </li>
                                                            <li class="text-list__item">
                                                                @lang('Capital Back')
                                                                <span>
                                                                    @if ($plan->capital_back == Status::CAPITAL_BACK_YES)
                                                                        <span>@lang('YES')</span>
                                                                    @else
                                                                        <span>@lang('NO')</span>
                                                                    @endif
                                                                </span>
                                                            </li>
                                                            <li class="text-list__item">
                                                                @lang('Profit Returns')
                                                                <span>{{ $plan->return_times . ' ' . __('Times') }}</span>
                                                            </li>
                                                            <li class="text-list__item">
                                                                <a href="{{ route('user.case.segment.view', ['code' => $investmentCase->case_code, 'id' => $plan->id]) }}"
                                                                    class="btn btn--base w-100">@lang('Invest Now')
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="nav-agreement" role="tabpanel">
                                <h3 class="project-details__subtitle"><span>@lang('Agreement Paper')</span></h3>
                                <embed class="embeded-video-src"
                                    src="{{ asset(getFilePath('agreement_paper') . '/' . $investmentCase->agreement_paper) }}" type="application/pdf"
                                    width="100%" height="600px" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="post-sidebar-wrapper">
                        <div class="post-sidebar">
                            <h5 class="post-sidebar__title">@lang('Cases Info')</h5>
                            <div class="post-sidebar__body">
                                <ul class="text-list profile-info">
                                    <li class="text-list__item">@lang('Created By') <span>{{ __(@$investmentCase->user->full_name) }}</span></li>
                                    <li class="text-list__item">@lang('Created At')
                                        <span>{{ showDateTime(@$investmentCase->created_at, 'Y-m-d') }}</span>
                                    </li>
                                    <li class="text-list__item">
                                        @lang('Raised Amount')<span>{{ $general->cur_sym }}{{ showAmount($investmentCase->reach_amount) }}</span>
                                    </li>
                                    <li class="text-list__item">
                                        @lang('Goal Amount')<span>{{ $general->cur_sym }}{{ showAmount($investmentCase->goal_amount) }}</span>
                                    </li>
                                    <li class="text-list__item">
                                        <button type="button" class="btn btn--base w-100 investBtn">@lang('Invest Now')</button>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        @if ($latestCases->count() > 0)
                            <div class="post-sidebar">
                                <h5 class="post-sidebar__title">@lang('Recent Cases')</h5>
                                <div class="post-sidebar__body">
                                    <div class="case-list">
                                        @foreach ($latestCases as $latestCase)
                                            <div class="case-list__card">
                                                <a href="{{ route('investment.case.details', $latestCase->case_code) }}" class="case-list__card__img">
                                                    <img src="{{ getImage(getFilePath('investmentImage') . '/' . $latestCase->image, getFileSize('investmentImage')) }}"
                                                        alt="@lang('image')">
                                                </a>
                                                <div class="case-list__card__txt">
                                                    <a href="{{ route('investment.case.details', $latestCase->case_code) }}"
                                                        class="case-list__card__title">{{ __($latestCase->title) }}
                                                    </a>
                                                    <span class="case-list__card__owner">
                                                        @lang('By')
                                                        <a href="{{ route('investor', $latestCase->user->username) }}">
                                                            {{ __($latestCase->user->fullname) }}</a>
                                                    </span>
                                                    <div class="d-flex justify-content-between">
                                                        <div class="case-list__card__info">
                                                            <span>@lang('GOAL TO REACHED')</span>
                                                            <h6>{{ $general->cur_sym . showAmount($latestCase->reach_amount) }}
                                                            </h6>
                                                        </div>
                                                        <div class="case-list__card__info">
                                                            <span>@lang('PROFIT')</span>
                                                            <h6>{{ showAmount($latestCase->plans->max('profit_value')) . '%' }}
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style-lib')
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/magnific-popup.css') }}">
@endpush

@push('script-lib')
    <script src="{{ asset($activeTemplateTrue . '/js/magnific-popup.js') }}"></script>
@endpush

@push('script')
    <script>
        "use strict";
        (function($) {
            $(document).ready(function() {
                $('.banner-content__video').magnificPopup({
                    type: 'iframe'
                });
            });

            $(".investBtn").on('click', function(e) {
                let {
                    top
                } = document.getElementById("nav-segment").getBoundingClientRect();
                $('html').animate({
                    scrollTop: top < 800 ? 800 : top
                });
                $('#nav-segment-tab').click();
            });
        })(jQuery);
    </script>
@endpush

@push('style')
    <style>
        .embeded-video-src {
            width: 100%;
            height: 600px
        }
    </style>
@endpush
