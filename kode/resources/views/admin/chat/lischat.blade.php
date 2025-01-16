@extends('admin.layouts.master')
@push('style-include')
    <link href="{{asset('assets/global/css/chat.css')}}" rel="stylesheet" type="text/css" />
@endpush
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">
                    {{ translate('Manage Participants') }}
                </h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="">{{ translate('Home') }}</a></li>
                        <li class="breadcrumb-item active">{{ translate('Participants') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-header border-bottom-dashed">
            <div class="row g-4 align-items-center">
                <div class="col-sm">
                    <h5 class="card-title mb-0">{{ translate('Participant List') }}</h5>
                </div>

                <div class="col-sm-auto">
                    <div class="d-flex flex-wrap align-items-start gap-2">

                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="participant-table"
                    class="w-100 table table-bordered dt-responsive nowrap table-striped align-middle">
                    <thead>
                        <tr>
                            <th></th>

                            <th>{{ translate('User') }}</th>
                            <th>{{ translate('Options') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($participants as $participant)
                                                <tr>
                                                    <td>
                                                        @php
                                                            // Assuming you have the user object with image
                                                            $user = \App\Models\User::find($participant->user_id);
                                                            $imageUrl = $user->image ? asset('storage/' . $user->image) : 'http://localhost/TrackingFormationProject/default/image/150x150';
                                                        @endphp
                                                                <img src="{{ $imageUrl }}" alt="{{ $user->name }}"
                                                            class="avatar-xs rounded-circle me-2">
                                                    </td>

                                                    <td class="d-flex align-items-center">
                                                        @php
                                                            // Assuming you have the user object with image
                                                            $user = \App\Models\User::find($participant->user_id);
                                                            $imageUrl = $user->image ? asset('storage/' . $user->image) : "http://localhost/TrackingFormationProject/default/image/150x150.png";
                                                        @endphp

                                                        <span>{{ $user->name }}</span>
                                                    </td>
                                                    <td>
                                                        @foreach ($participant->ticket_numbers as $ticket)
                                                            <a href="{{ url('admin/tickets/' . $ticket) }}" class="btn btn-info btn-sm">
                                                                <i class="ri-chat-1-line"></i> {{ translate('Chat') }} - {{ $ticket }}
                                                            </a>
                                                        @endforeach
                                                    </td>
                                                </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection




@push('script-push')



@endpush
