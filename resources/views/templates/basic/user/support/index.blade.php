@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="dashboard position-relative">
        <div class="dashboard-body">
            <div class="container">
                <div class="row justify-content-center gy-4">
                    <div class="col-md-12">
                        <div class="text-end">
                            <a href="{{ route('ticket.open') }}" class="btn btn--sm btn--base">
                                <i class="las la-plus"></i> @lang('New Ticket')
                            </a>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card custom--card">
                            
                            <div class="card-body p-0">
                                <table class="table table-separated table--responsive--lg">
                                    <thead>
                                        <tr>
                                            <th>@lang('Subject')</th>
                                            <th>@lang('Status')</th>
                                            <th>@lang('Priority')</th>
                                            <th>@lang('Last Reply')</th>
                                            <th>@lang('Action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($supports as $support)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('ticket.view', $support->ticket) }}" class="fw-bold">
                                                        [@lang('Ticket')#{{ $support->ticket }}] {{ __($support->subject) }}
                                                    </a>
                                                </td>
                                                <td>
                                                    @php echo $support->statusBadge; @endphp
                                                </td>
                                                <td>
                                                    @if ($support->priority == Status::PRIORITY_LOW)
                                                        <span class="custom--badge badge badge--dark">@lang('Low')</span>
                                                    @elseif($support->priority == Status::PRIORITY_MEDIUM)
                                                        <span class="bcustom--badge adge  badge--warning">@lang('Medium')</span>
                                                    @elseif($support->priority == Status::PRIORITY_HIGH)
                                                        <span class="custom--badge badge badge--danger">@lang('High')</span>
                                                    @endif
                                                </td>
                                                <td>{{ diffForHumans($support->last_reply) }} </td>
                                                <td class="text-end">
                                                    <a href="{{ route('ticket.view', $support->ticket) }}" class="btn btn-outline--base btn--sm">
                                                        <i class="las la-eye"></i> @lang('View')
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="100%" class="text-center">{{ __($emptyMessage) }}</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {{ paginateLinks($supports) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
