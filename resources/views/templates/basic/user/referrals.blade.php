@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="dashboard position-relative">
        <div class="dashboard-body">
            <div class="container">
                <div class="card custom--card">
                    <div class="card-body">
                        @if (auth()->user()->referrer)
                            <h4 class="mb-2">@lang('You are referred by') {{ auth()->user()->referrer->fullname }}</h4>
                        @endif
                        <div class="col-md-12 mb-4">
                            <label class="form--label fw-bold">@lang('Referral Link')</label>
                            <div class="input-group">
                                <input type="text" name="text" class="form-control form--control referralURL"
                                    value="{{ route('home') }}?reference={{ auth()->user()->username }}" readonly>
                                <span class="input-group-text btn btn-base copytext copyBoard" id="copyBoard"> <i
                                        class="far fa-copy"></i> </span>
                            </div>
                        </div>

                        @if ($user->allReferrals->count() > 0 && $maxLevel > 0)
                            <div class="treeview-container">
                                <ul class="treeview">
                                    <li class="items-expanded"> {{ $user->fullname }} ( {{ $user->username }} )
                                        @include($activeTemplate . 'partials.under_tree', [
                                            'user' => $user,
                                            'layer' => 0,
                                            'isFirst' => true,
                                        ])
                                    </li>
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style-lib')
    <link href="{{ asset('assets/global/css/jquery.treeView.css') }}" rel="stylesheet">
@endpush

@push('script')
    <script src="{{ asset('assets/global/js/jquery.treeView.js') }}"></script>
    <script>
        (function($) {
            "use strict"
            $('.treeview').treeView();
            $('.copyBoard').on("click",function() {
                var copyText = document.getElementsByClassName("referralURL");
                copyText = copyText[0];
                copyText.select();
                copyText.setSelectionRange(0, 99999);

                /*For mobile devices*/
                document.execCommand("copy");
                copyText.blur();
                this.classList.add('copied');
                setTimeout(() => this.classList.remove('copied'), 1500);
            });
        })(jQuery);
    </script>
@endpush
