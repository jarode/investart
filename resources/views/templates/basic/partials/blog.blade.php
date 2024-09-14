@foreach ($blogs as $blog)
    <div class="col-lg-4 col-sm-6">
        <div class="blog-item">
            <a href="{{ route('blog.details', ['slug' => slug(@$blog->data_values->title), 'id' => @$blog->id]) }}" class="blog-item__thumb">
                <img src="{{ sectionImage('blog', 'thumb_' . @$blog->data_values->image, '485x270') }}" alt="@lang('img')">
            </a>
            <div class="blog-item__content">
                <ul class="text-list flex-align gap-3">
                    <li class="text-list__item fs-16">{{ showDateTime(@$blog->created_at, 'M d, Y') }}</li>
                </ul>
                <h5 class="blog-item__title">
                    <a href="{{ route('blog.details', ['slug' => slug(@$blog->data_values->title), 'id' => @$blog->id]) }}"
                        class="blog-item__title-link border-effect">{{ __(strLimit(@$blog->data_values->title, 90)) }}
                    </a>
                </h5>

                <p class="blog-item__desc">
                    {{ strLimit(strip_tags(@$blog->data_values->description_nic), 200) }}</p>
                <a href="{{ route('blog.details', ['slug' => slug(@$blog->data_values->title), 'id' => @$blog->id]) }}"
                    class="btn--simple">@lang('Read More') <span class="btn--simple__icon"><i class="fas fa-arrow-right"></i></span></a>
            </div>
        </div>
    </div>
@endforeach
