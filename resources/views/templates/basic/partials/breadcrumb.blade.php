@php
    $breadcrumb = getContent('breadcrumb.content', true);
@endphp
<section class="breadcrumb bg-img" data-background-image="{{ sectionImage('breadcrumb', @$breadcrumb->data_values->background_image, '1950x650') }}">
    <div class="container">
        <div class="breadcrumb__wrapper text-center">
            <h2 class="breadcrumb__title">{{ __($pageTitle) }}</h2>
        </div>
    </div>
</section>
