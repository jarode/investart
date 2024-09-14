@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="dashboard position-relative">
        <div class="dashboard-body">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="card custom--card">
                            <div class="card-header">
                                <h5 class="card-title">@lang('Case Creator KYC Data')</h5>
                            </div>
                            <div class="card-body">
                                @if ($user->ckv_data)
                                    <ul class="list-group list-group-flush">
                                        @foreach ($user->ckv_data as $val)
                                            @continue(!$val->value)
                                            <li class="list-group-item d-flex justify-content-between align-items-center ps-0">
                                                {{ __($val->name) }}
                                                <span>
                                                    @if ($val->type == 'checkbox')
                                                        {{ implode(',', $val->value) }}
                                                    @elseif($val->type == 'file')
                                                        <a href="{{ route('user.attachment.download', encrypt(getFilePath('verify') . '/' . $val->value)) }}"
                                                            class="me-3"><i class="fa fa-file"></i> @lang('Attachment') </a>
                                                    @else
                                                        <p>{{ __($val->value) }}</p>
                                                    @endif
                                                </span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <h5 class="text-center">@lang('KYC data not found')</h5>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
