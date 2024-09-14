@extends($activeTemplate . 'layouts.auth')
@section('content')
    <div class="account-form__wrap">
        <div class="account-form__content mb-0 pb-3">
            <div class="logo"><a href="{{ route('home') }}"><img src="{{ siteLogo() }}" alt="@lang('Logo')"></a></div>
            <div class="alert bg--base">
                <h4 class="text-white mb-0">
                    @lang('Complete your profile')
                </h4>
                <p class="text-white">@lang('You need to complete your profile by providing below information.')</p>
            </div>
        </div>
        <form method="POST" action="{{ route('user.data.submit') }}">
            @csrf
            <div class="row g-3">
                <div class="col-sm-6">
                    <div class="form--floating form-floating">
                        <input type="text" name="firstname" required value="{{ old('firstname') }}" placeholder="@lang('First Name')"
                            class="form-control form--control">
                        <label>@lang('First Name')</label>
                </div>
                </div>
                <div class="col-sm-6">
                    <div class="form--floating form-floating">
                        <input type="text" name="lastname" required value="{{ old('lastname') }}" placeholder="@lang('Last Name')"
                            class="form-control form--control">
                        <label>@lang('Last Name')</label>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form--floating form-floating">
                        <input type="text" name="address" required value="{{ old('address') }}" placeholder="@lang('Address')"
                            class="form-control form--control">
                        <label>@lang('Address')</label>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form--floating form-floating">
                        <input type="text" name="state" required value="{{ old('state') }}" placeholder="@lang('State')"
                            class="form-control form--control">
                        <label>@lang('State')</label>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form--floating form-floating">
                        <input type="text" name="zip" required value="{{ old('zip') }}" placeholder="@lang('Zip')"
                            class="form-control form--control">
                        <label>@lang('Zip')</label>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form--floating form-floating">
                        <input type="text" name="city" required value="{{ old('city') }}" placeholder="@lang('City')"
                            class="form-control form--control">
                        <label>@lang('City')</label>
                    </div>
                </div>
                <div class="col-sm-12">
                    <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                </div>

            </div>
        </form>
    </div>
@endsection
