@extends($activeTemplate . 'layouts.frontend')
@section('content')
    @include($activeTemplate . 'investor.header')
    <div class="profile">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="profile_content">
                        <div class="row justify-content-center gy-5">
                            @forelse ($cases as $case)
                                <div class="col-6">
                                    @include($activeTemplate . 'invest_card', ['data' => $case])
                                </div>
                            @empty
                                <div class="col-12">
                                    <div class="p-5 text-center bg-white rounded-2">
                                        <img src="{{ asset('assets/images/empty.png') }}">
                                        <p>@lang('No case found')</p>
                                    </div>
                                </div>
                            @endforelse
                            @if ($cases->hasPages())
                                <div class="col-12">
                                    {{ paginateLinks($cases) }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @include($activeTemplate . 'investor.sidebar_data')
                </div>
            </div>
        </div>
    </div>
@endsection
