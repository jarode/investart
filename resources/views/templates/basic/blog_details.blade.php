@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="blog-detials py-120">
        <div class="container">
            <div class="row gy-4 justify-content-center">
                <div class="col-xl-9 col-lg-8">
                    <div class="blog-details">
                        <div class="blog-details__thumb">
                            <img src="{{ sectionImage('blog', @$blog->data_values->image, '970x450') }}" class="fit-image" alt="@lang('img')">
                        </div>
                        <div class="blog-details__content">
                            <span class="blog-item__date mb-2">
                                <span class="blog-item__date-icon"><i
                                        class="las la-clock"></i></span>{{ showDateTime(@$blog->created_at, 'M d, Y') }}</span>
                            <h3 class="blog-details__title">{{ __(@$blog->data_values->title) }}</h3>
                            <div>
                                @php echo @$blog->data_values->description_nic; @endphp
                            </div>

                            <div class="blog-details__share mt-4">
                                <h4>@lang('Share This')</h4>
                                <ul class="social-list">
                                    <li class="social-list__item">
                                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(Request::url()) }}" target="_blank"
                                            class="social-list__link flex-center"><i class="fab fa-facebook-f"></i>
                                        </a>
                                    </li>
                                    <li class="social-list__item">
                                        <a href="https://www.twitter.com/intent/tweet?url={{ urlencode(Request::url()) }}" target="_blank"
                                            class="social-list__link flex-center active"> <i class="fab fa-twitter"></i>
                                        </a>
                                    </li>
                                    <li class="social-list__item">
                                        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(Request::url()) }}" target="_blank"
                                            class="social-list__link flex-center"> <i class="fab fa-linkedin-in"></i>
                                        </a>
                                    </li>
                                    <li class="social-list__item">
                                        <a href="https://www.pinterest.com/pin/create/button/?url={{ urlencode(Request::url()) }}" target="_blank"
                                            class="social-list__link flex-center"> <i class="fab fa-pinterest"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4">
                    <div class="blog-sidebar-wrapper">
                        <div class="blog-sidebar">
                            <h3 class="blog-sidebar__title">@lang('Latest Blog')</h3>
                            @foreach ($blogElement as $item)
                                <div class="latest-blog">
                                    <div class="latest-blog__thumb">
                                        <a href="{{ route('blog.details', ['slug' => slug(@$item->data_values->title), 'id' => @$item->id]) }}">
                                            <img src="{{ sectionImage('blog', 'thumb_' . @$item->data_values->image, '485x270') }}" class="fit-image"
                                                alt="@lang('img')">
                                        </a>
                                    </div>
                                    <div class="latest-blog__content">
                                        <h5 class="latest-blog__title">
                                            <a href="{{ route('blog.details', ['slug' => slug(@$item->data_values->title), 'id' => @$item->id]) }}">
                                                {{ __(@$item->data_values->title) }}
                                            </a>
                                        </h5>
                                        <span class="latest-blog__date fs-13">{{ showDateTime(@$item->created_at, 'M d, Y') }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('fbComment')
    @php echo loadExtension('fb-comment') @endphp
@endpush
