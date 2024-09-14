@extends($activeTemplate . 'layouts.frontend')
@section('content')
    @include($activeTemplate . 'investor.header')
    <div class="profile">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="profile__content">
                        @if (!$investor->about)
                            <div class="p-5 text-center bg-white rounded-2">
                                <img src="{{ asset('assets/images/empty.png') }}">
                                <p>@lang('This user has no about info.')</p>
                            </div>
                        @else
                            @php echo $investor->about; @endphp
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    @include($activeTemplate . 'investor.sidebar_data')
                </div>
            </div>
        </div>
    </div>
@endsection
