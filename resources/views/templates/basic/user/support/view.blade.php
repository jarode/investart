@extends($activeTemplate . 'layouts.' . $layout)

@section('content')
    <div class="dashboard position-relative">
        <div class="dashboard-body">
            <div class="container">
                <div class="row justify-content-center gy-4">
                    
                    <div class="col-md-12">
                        <div class="card custom--card">
                            <div class="flex-align justify-content-between gap-3 card-header">
                                <h3 >
                                    @php echo $myTicket->statusBadge; @endphp
                                    [@lang('Ticket')#{{ $myTicket->ticket }}] {{ $myTicket->subject }}
                                </h3>
                                <div class="d-flex gap-2 flex-wrap">
                                    @if ($myTicket->status != Status::TICKET_CLOSE && $myTicket->user)
                                        <button class="btn btn--sm btn-dark close-button confirmationBtn" type="button" data-question="@lang('Are you sure to close this ticket?')"
                                            data-action="{{ route('ticket.close', $myTicket->id) }}"><i class="fa fa-times-circle"></i> @lang('Closed')
                                        </button>
                                    @endif
                                    @auth
                                        <a href="{{ route('ticket.index') }}" class="btn btn--sm btn--base"> <i class="fa fa-list"></i> @lang('Ticket List')</a>
                                    @endauth
                                </div>
                            </div>
                            <div class="card-body">
                                <form method="post" action="{{ route('ticket.reply', $myTicket->id) }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row justify-content-between">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <textarea name="message" class="form-control form--control" rows="4">{{ old('message') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <a href="javascript:void(0)" class="btn btn--base btn--sm addFile"><i class="fa fa-plus"></i>
                                            @lang('Add New')</a>
                                    </div>
                                    <div class="form-group">
                                        <label class="form--label">@lang('Attachments')</label> <small class="text--danger">@lang('Max 5 files can be uploaded').
                                            @lang('Maximum upload size is')
                                            {{ ini_get('upload_max_filesize') }}</small>
                                        <input type="file" name="attachments[]" class="form-control form--control" />
                                        <div id="fileUploadsContainer"></div>
                                        <p class="my-2 ticket-attachments-message text-muted">
                                            @lang('Allowed File Extensions'): .@lang('jpg'), .@lang('jpeg'), .@lang('png'),
                                            .@lang('pdf'), .@lang('doc'), .@lang('docx')
                                        </p>
                                    </div>
                                    <button type="submit" class="btn btn--base w-100"> <i class="fa fa-reply"></i>
                                        @lang('Reply')</button>
                                </form>
                            </div>
                        </div>

                        <div class="card mt-4 custom--card">
                            <div class="card-body">
                                @foreach ($messages as $message)
                                    @if ($message->admin_id == 0)
                                        <div class="row">
                                            <div class="col-lg-10">
                                                <div class="support-ticket">
                                                    <div class="flex-align gap-3 mb-2">
                                                        <h4 class="support-ticket-name">{{ $message->ticket->name }}</h4>
                                                        <p class="support-ticket-date"> @lang('Posted on')
                                                            {{ showDateTime($message->created_at) }}</p>
                                                    </div>
                                                    <p class="support-ticket-message">{{ __($message->message) }}</p>
                                                    @if ($message->attachments->count() > 0)
                                                        <div class="support-ticket-file mt-2">
                                                            @foreach ($message->attachments as $k => $image)
                                                                <a href="{{ route('ticket.download', encrypt($image->id)) }}" class="me-3"> <span
                                                                        class="icon"><i class="la la-file-download"></i></span>
                                                                    @lang('Attachment')
                                                                    {{ ++$k }}
                                                                </a>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="row justify-content-end">
                                            <div class="col-lg-10">
                                                <div class="support-ticket">
                                                    <div class="flex-align gap-3 mb-2">
                                                        <h class="support-ticket-name">{{ $message->admin->name }} <span
                                                                class="staff">@lang('Staff')</span></h>
                                                        <p class="support-ticket-date"> @lang('Posted on')
                                                            {{ showDateTime($message->created_at) }}</p>
                                                    </div>
                                                    <p class="support-ticket-message">{{ __($message->message) }}</p>
                                                    @if ($message->attachments->count() > 0)
                                                        <div class="support-ticket-file mt-2">
                                                            @foreach ($message->attachments as $k => $image)
                                                                <a href="{{ route('ticket.download', encrypt($image->id)) }}" class="me-3"> <span
                                                                        class="icon"><i class="la la-file-download"></i></span>
                                                                    @lang('Attachment')
                                                                    {{ ++$k }}
                                                                </a>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-confirmation-modal isFrontend="true" />
@endsection
@push('style')
    <style>
        .input-group-text:focus {
            box-shadow: none !important;
        }
    </style>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            var fileAdded = 0;
            $('.addFile').on('click', function() {
                if (fileAdded >= 4) {
                    notify('error', 'You\'ve added maximum number of file');
                    return false;
                }
                fileAdded++;
                $("#fileUploadsContainer").append(`
                    <div class="input-group my-3">
                        <input type="file" name="attachments[]" class="form-control form--control" required />
                        <button type="submit" class="input-group-text btn--danger remove-btn border-0 text-white"><i class="las la-times"></i></button>
                    </div>
                `)
            });
            $(document).on('click', '.remove-btn', function() {
                fileAdded--;
                $(this).closest('.input-group').remove();
            });
        })(jQuery);
    </script>
@endpush
