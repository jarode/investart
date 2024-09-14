@extends($activeTemplate . 'layouts.frontend')
@section('content')

    <section class="blog py-120">
        <div class="container">
            <div class="row gy-4 justify-content-center">
                @include($activeTemplate.'partials.blog',['blogs' => $blogs])
            </div>

            @if ($blogs->hasPages())
                {{ paginateLinks($blogs) }}
            @endif
        </div>
    </section>

    @if (@$sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif
@endsection
