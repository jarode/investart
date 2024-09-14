@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Title')</th>
                                    <th>@lang('Hour')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Actions')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($schedules as $schedule)
                                    <tr>
                                        <td>{{ __($schedule->title) }}</td>
                                        <td>{{ __($schedule->hour) }}</td>
                                        <td>
                                            @php echo $schedule->statusBadge; @endphp
                                        </td>
                                        <td>

                                            <button class="btn btn-sm btn-outline--primary cuModalBtn"
                                                data-modal_title="@lang('Update Schedule')" data-resource="{{ $schedule }}">
                                                <i class="la la-pen"></i> @lang('Edit')
                                            </button>

                                            @if ($schedule->status == Status::DISABLE)
                                                <button type="button"
                                                    class="btn btn-sm btn-outline--success confirmationBtn"
                                                    data-action="{{ route('admin.schedule.status', $schedule->id) }}"
                                                    data-question="@lang('Are you sure to enable this schedule?')">
                                                    <i class="la la-eye"></i> @lang('Enable')
                                                </button>
                                            @else
                                                <button type="button"
                                                    class="btn btn-sm btn-outline--danger confirmationBtn"
                                                    data-action="{{ route('admin.schedule.status', $schedule->id) }}"
                                                    data-question="@lang('Are you sure to disable this schedule?')">
                                                    <i class="la la-eye-slash"></i> @lang('Disable')
                                                </button>
                                            @endif

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="cuModal" role="dialog" tabindex="-1">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.schedule.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Title')</label>
                            <input type="text" class="form-control" value="{{ old('title') }}" name="title" required>
                        </div>

                        <div class="form-group">
                            <label>@lang('Hour')</label>
                            <input type="number" class="form-control" value="{{ old('hour') }}" name="hour" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn--primary w-100 h-45" type="submit">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <x-confirmation-modal />
@endsection


@push('breadcrumb-plugins')
    <button type="button" class="btn btn-sm btn-outline--primary cuModalBtn" data-bs-toggle="modal"
        data-modal_title="@lang('Add Schedule')" data-bs-target="#cuModal"><i
            class="las la-plus"></i>@lang('Add New')</button>
@endpush


@push('script')
    <script src="{{ asset('assets/admin/js/cu-modal.js') }}"></script>
@endpush
