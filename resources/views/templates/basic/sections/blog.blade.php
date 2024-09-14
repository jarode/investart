@php
    $blogContent = getContent('blog.content', true);
    $blogElement = getContent('blog.element', limit: 3);
    $totalBlog = getContent('blog.element')->count();
@endphp

<section class="blog py-120">
    <div class="container">
        <div class="section-wrapper section-heading {{ $totalBlog > 3 ? 'style-left d-flex flex-wrap gap-3 justify-content-between' : '' }} ">
            <div class="content">
                <h3 class="section-heading__title">{{ __(@$blogContent->data_values->heading) }}</h3>
                <p class="section-heading__desc">{{ __(@$blogContent->data_values->subheading) }}</p>
            </div>
            @if (@$totalBlog > 3)
                <div class="view-btn">
                    <a href="{{ route('blog') }}" class="btn btn--base">@lang('View More')</a>
                </div>
            @endif
        </div>
        <div class="row gy-4 justify-content-center">
            @include($activeTemplate . 'partials.blog', ['blogs' => $blogElement])
        </div>
    </div>
</section>
