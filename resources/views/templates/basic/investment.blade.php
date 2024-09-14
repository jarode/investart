@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="project py-120">
        <div class="container">
            <div class="row g-4 justify-content-center">
                @foreach ($cases as $case)
                    <div class="col-lg-4 col-sm-6">
                        @include($activeTemplate . 'invest_card', ['data' => $case])
                    </div>
                @endforeach

                @if ($cases->hasPages())
                    <div class="col-12">
                        <div class="mt-4">
                            {{ paginateLinks($cases) }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @if (@$sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif
@endsection
