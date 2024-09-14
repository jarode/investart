@php
    $content = getContent('latest_transaction.content', true);
    $deposits = \App\Models\Deposit::successful()->latest('id')->with('user')->take(10)->get();
    $withdrawals = \App\Models\Withdrawal::latest('id')->with('user')->approved()->take(10)->get();
@endphp

<section class="top-rated py-120">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-5">
                <div class="section-heading">
                    <h2 class="section-heading__title">{{ __($content->data_values->heading) }}</h2>
                    <p class="section-heading__desc">{{ __($content->data_values->subheading) }}</p>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-xl-9 col-lg-10">
                <nav>
                    <div class="custom--tab nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-deposit-tab" data-bs-toggle="tab" data-bs-target="#nav-deposit" type="button"
                            role="tab" aria-controls="nav-deposit" aria-selected="true">@lang('Deposit')</button>
                        <button class="nav-link" id="nav-withdraw-tab" data-bs-toggle="tab" data-bs-target="#nav-withdraw" type="button"
                            role="tab" aria-controls="nav-withdraw" aria-selected="false">@lang('Withdraw')</button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-deposit" role="tabpanel" aria-labelledby="nav-deposit-tab" tabindex="0">
                        <table class="table table--responsive--lg">
                            <thead>
                                <tr>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Amount')</th>
                                    <th>@lang('Date')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($deposits as $deposit)
                                    <tr>
                                        <td>{{ $deposit->user->fullname }}</td>
                                        <td>
                                            {{ showAmount($deposit->amount) . ' ' . __($general->cur_text) }}</td>
                                        <td class="text-end"> {{ showDateTime($deposit->created_at) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">@lang('No deposit found')</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="nav-withdraw" role="tabpanel" aria-labelledby="nav-withdraw-tab" tabindex="0">
                        <table class="table table--responsive--lg">
                            <thead>
                                <tr>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Amount')</th>
                                    <th>@lang('Date')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($withdrawals as $withdrawal)
                                    <tr>
                                        <td>{{ $withdrawal->user->fullname }}</td>
                                        <td>
                                            {{ showAmount($withdrawal->amount) . ' ' . __($general->cur_text) }}</td>
                                        <td class="text-end"> {{ showDateTime($withdrawal->created_at) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">@lang("No withdraw found")</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
