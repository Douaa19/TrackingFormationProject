@extends('admin.layouts.master')
@push('styles')
    <link href="{{asset('assets/global/css/summnernote.css')}}" rel="stylesheet" type="text/css" />
@endpush
@section('content')
<div class="container-fluid px-0">

    @php

        $ticketStatus = App\Models\TicketStatus::active()->get();


        $priorityStatus = App\Models\Priority::active()->get();
        $agents = App\Models\Admin::active()
            ->where('id', '!=', auth_user()->id)
            ->get();

        if (auth_user()->agent == App\Enums\StatusEnum::true->status()) {
            $agents = $agents->filter(function ($agent) use ($ticket) {
                return in_array((string) $ticket->category_id, (array) json_decode($agent->categories, true));
            });
        }


        $default_notifications = admin_notification();
        if (auth_user()->agent == App\Enums\StatusEnum::true->status()) {
            $default_notifications = agent_notification();
        }
        $admin_notifications = auth_user()->notification_settings ? json_decode(auth_user()->notification_settings, true) : $default_notifications;

        $emailNotification = false;
        $smsNotification = false;
        $slackNotification = false;
        $browserNotification = false;

        if (@$admin_notifications['email']['user_reply_admin'] == App\Enums\StatusEnum::true->status() || @$admin_notifications['email']['user_reply_agent'] == App\Enums\StatusEnum::true->status() || @$admin_notifications['email']['agent_ticket_reply'] == App\Enums\StatusEnum::true->status()) {
            $emailNotification = true;
        }
        if (@$admin_notifications['sms']['user_reply_admin'] == App\Enums\StatusEnum::true->status() || @$admin_notifications['sms']['user_reply_agent'] == App\Enums\StatusEnum::true->status() || @$admin_notifications['sms']['agent_ticket_reply'] == App\Enums\StatusEnum::true->status()) {
            $smsNotification = true;
        }
        if (@$admin_notifications['slack']['user_reply_admin'] == App\Enums\StatusEnum::true->status() || @$admin_notifications['slack']['user_reply_agent'] == App\Enums\StatusEnum::true->status() || @$admin_notifications['slack']['agent_ticket_reply'] == App\Enums\StatusEnum::true->status()) {
            $slackNotification = true;
        }
        if (@$admin_notifications['browser']['user_reply_admin'] == App\Enums\StatusEnum::true->status() || @$admin_notifications['browser']['user_reply_agent'] == App\Enums\StatusEnum::true->status() || @$admin_notifications['browser']['agent_ticket_reply'] == App\Enums\StatusEnum::true->status()) {
            $browserNotification = true;
        }

    @endphp

    <div class="ticket-body-wrapper">
        <div class="row g-0">
            <div class="col-auto ticket-sidebar">
                <div class="ticket-sidebar-sticky py-4">
                    <div class="ticket-detail-scroll" data-simplebar>

                        <div class="ticket-details-item mb-0">
                            <h5>
                                {{translate("Client Details")}}
                            </h5>

                            <div class="ticket-details-body">
                                <ul class="list-group list-group-flush ticket-detail-list">

                                    <li class="list-group-item">
                                    </li>

                                    <li class="list-group-item">
                                        <span class="fw-bold">{{translate("User Name")}} </span>
                                        <small> {{$ticket->user->name}}</small>
                                    </li>

                                    <li class="list-group-item">
                                        <span class="fw-bold">{{translate("User Email")}} </span>
                                        <small>{{$ticket->user->email}}</small>
                                    </li>

                                    <li class="list-group-item">
                                        <span class="fw-bold">{{translate("Phone Number")}} </span>
                                        <small>{{$ticket->user->phone}}</small>
                                    </li>

                                    <li class="list-group-item">
                                        <span class="fw-bold">{{translate("WhatsApp Number")}} </span>
                                        <small>{{$ticket->user->whatsapp_number}}</small>
                                    </li>

                                    <li class="list-group-item">
                                        <span class="fw-bold">{{translate("City")}} </span>
                                        <small>{{$ticket->user->city}}</small>
                                    </li>

                                    <li class="list-group-item">
                                        <span class="fw-bold">{{translate("CNSS")}} </span>
                                        <small>{{$ticket->user->cnss}}</small>
                                    </li>

                                    <li class="list-group-item">
                                        <span class="fw-bold">{{translate("Company Name")}} </span>
                                        <small>{{$ticket->user->garage_name}}</small>
                                    </li>

                                    <li class="list-group-item">
                                        <span class="fw-bold">{{translate("Revenue")}} </span>
                                        <small>{{$ticket->user->revenue ? '' : 0}}</small>
                                    </li>

                                    <li class="list-group-item">
                                        <span class="fw-bold">{{translate("Training Type")}} </span>
                                        <small>{{ translate(ucwords(str_replace('_', ' ', $ticket->user->training_type))) }}</small>
                                    </li>

                                    <li class="list-group-item">
                                        <span class="fw-bold">{{translate("Training Topic")}} </span>
                                        <small>{{ translate(ucwords(str_replace('_', ' ', $ticket->user->training))) }}</small>
                                    </li>

                                    <li class="list-group-item">
                                        <span class="fw-bold">{{translate("Status")}} </span>
                                        <small>{{ translate(ucwords(str_replace('_', ' ', $ticket->user->status))) }}</small>
                                    </li>

                                    {{-- @if(check_agent("update_tickets"))
                                    <li class="list-group-item">
                                        <span>{{translate("Status")}}</span>

                                        <select class="form-select" id="ticket-status">
                                            @foreach($ticketStatus as $status)


                                            <option {{$status->id == $ticket->status ? 'selected' :""}}
                                                value="{{$status->id}}">
                                                {{
                                                $status->name
                                                }}
                                            </option>


                                            @endforeach
                                        </select>
                                    </li>
                                    @endif --}}
                                </ul>
                            </div>
                        </div>

                        {{-- @if(auth_user()->agent == App\Enums\StatusEnum::true->status() )
                        <div class="ticket-details-item mt-3 mb-0 pb-0">
                            <h5>
                                {{translate("Short Notes")}}
                            </h5>

                            <div class="ticket-details-body">
                                @php
                                $agentTicket = $ticket->agents->first();
                                @endphp
                                {{ @$agentTicket->pivot->short_notes}}
                            </div>
                        </div>
                        @endif --}}
                    </div>
                </div>
            </div>

            <div class="col ticket-content">
                <div class="card shadow-none mb-0">
                    <div class="card-body pb-0">
                        <div class="row g-3 align-items-center">
                            <div class="col-xl-9 order-xl-1 order-2">
                                <div class="ticket-header">
                                    @include('admin.ticket.partials.ticket_header')
                                </div>
                            </div>

                            <div class="col-xl-3 order-xl-2 order-1">
                                <div class="d-flex justify-content-xl-end justify-content-between w-100">
                                    <button class="btn btn-soft-secondary btn-icon btn-sm fs-16 d-xl-none"
                                        id="ticket-menu-btn">
                                        <i class="ri-bar-chart-horizontal-fill align-bottom"></i>
                                    </button>

                                    <a href="{{route('admin.ticket.list')}}"
                                        class="btn btn-primary waves ripple-light d-flex align-items-center gap-2 lh-1">
                                        <i class="ri-arrow-go-back-fill align-bottom fs-5"></i>
                                        {{translate("Back")}}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body py-3 ticket-sidebar-sticky bg-white border-bottom">
                        <div class="ticket-action-buttons">
                            <button class="reply-btn">
                                <i class="ri-reply-line"></i>
                                {{translate("Reply")}}
                            </button>


                            @if($ticket->envato_payload || site_settings(key: 'envato_verification', default: 0) == 1)
                                <button class="envato-verification-btn">
                                    <i class="ri-shield-check-line"></i>
                                    {{translate("Envato verificaton")}}
                                </button>
                            @endif

                            <button class="btn btn-info btn-sm add-note" data-ticket="{{$ticket->id}}">
                                <i class="ri-sticky-note-line"></i>
                                {{translate("Note")}}
                            </button>




                            @if($ticket->status != App\Enums\TicketStatus::CLOSED->value)
                                <button class="btn btn-success  btn-sm canned-reply">
                                    <i class="ri-mail-line"></i>
                                    {{translate("Predefined Response")}}
                                </button>
                            @endif

                            @if(check_agent('assign_tickets'))
                                <button type="button" class="btn py-0 fs-16 text-body assign-btn">
                                    <i class="ri-user-add-line"></i>
                                    {{translate("Assign")}}
                                </button>

                            @endif

                            @if(check_agent("delete_tickets"))
                                <button type="button" data-href="{{route('admin.ticket.delete', $ticket->id)}}"
                                    class="delete-item btn py-0 fs-16 text-body">
                                    <i class="ri-delete-bin-6-line link-danger "></i>
                                    {{translate("Delete")}}
                                </button>
                            @endif

                            @php

                                $mutedTicket = (array) auth_user()->muted_ticket;

                                $muted_class = 'ri-notification-4-line';
                                $muted = App\Enums\StatusEnum::true->status();

                                if (in_array($ticket->id, $mutedTicket)) {

                                    $flag = App\Enums\StatusEnum::true->status();
                                    $muted = App\Enums\StatusEnum::false->status();
                                    $muted_class = 'ri-notification-off-line';
                                }

                            @endphp

                            <a id="mute-user" data-ticket="{{$ticket->ticket_number}}" href="javascript:void(0)"
                                class="mute-btn btn bg-{{$muted == App\Enums\StatusEnum::false->status() ? 'danger' : "success" }} btn-icon">
                                <i class="mute-icon {{$muted_class}} me-0 text-light"></i>
                            </a>

                        </div>

                        @if($ticket->solved_request == App\Models\SupportTicket::REQUESTED && auth_user()->agent == App\Enums\StatusEnum::false->status())

                                                <div
                                                    class="ticket-request d-flex  flex-wrap justify-content-start align-items-center gap-3 mt-4">
                                                    <div class="mb-0 alert alert-info fs-16  ">
                                                        {{$ticket->admin ? $ticket->admin->name : TRANSLATE("An Agent") }}
                                                        {{Translate("has requested to mark this ticket as 'Solved.' Would you like to accept this request")}}
                                                        ??
                                                    </div>

                                                    <div>

                                                        <a href="{{route("ticket.solve.request", [
                                "ticketId" => $ticket->id,
                                "status" => '1'
                            ])}}" class="btn btn-success btn-lg me-2 add-btn waves ripple-light fs-15"><i
                                                                class="ri-checkbox-circle-line align-bottom  "></i>
                                                            {{translate("Yes")}}
                                                        </a>
                                                        <a href="{{route("ticket.solve.request", [
                                "ticketId" => $ticket->id,
                                "status" => "0"
                            ])}}" class="btn btn-danger btn-lg add-btn waves ripple-light fs-15"><i
                                                                class="ri-close-circle-line align-bottom "></i>
                                                            {{translate("No")}}
                                                        </a>


                                                    </div>
                                                </div>
                        @endif
                    </div>


                    <div class="card-body border-bottom envato--card d-none">
                        @include('admin.ticket.partials.envato_card')
                    </div>

                    <div class="card-body border-bottom reply-card d-none">
                        @include('admin.ticket.partials.reply_card')
                    </div>

                    <div class="card-body p-0">
                        <div class="ticket-wrapper">
                            <div class="d-none message-preloader" id="elmLoader">
                                <div class="spinner-border text-primary avatar-sm" role="status">
                                    <span class="visually-hidden"></span>
                                </div>
                            </div>

                            <div class="ticket-lists-wrapper">
                                <div class="all-reply-item">

                                </div>

                                <div class="text-center pt-3 pb-4 load-more-div d-none">
                                    <button class="btn btn-md btn-success add-btn waves ripple-light load-more">
                                        <i class="ri-refresh-line align-bottom me-1"></i>
                                        {{translate('Load More')}}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="{{route('admin.ticket.status.update')}}" id="statusUpdate" method="post">
        @csrf
        <input name="key" id="key" type="hidden">
        <input name="status" id="status" type="hidden">
        <input name="id" id="ticket-id" type="hidden">
    </form>


    @include('admin.ticket.partials.modals')

</div>
@endsection

@push('style-include')
    <link href="{{ asset('assets/global/css/ticket.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/global/css/viewbox/viewbox.css')}}" rel="stylesheet" type="text/css" />

@endpush

@push('script-include')
    <script src="{{asset('assets/global/js/summernote.min.js')}}"></script>
    <script src="{{asset('assets/global/js/editor.init.js')}}"></script>
    <script src="{{asset('assets/global/js/viewbox/jquery.viewbox.min.js')}}"></script>


@endpush

@push('script-push')



    @include('admin.ticket.partials.script')


    <script>

        $('.image-v-preview').viewbox();
        $('.file-v-preview').viewbox();

        $("#assign").select2({
            dropdownParent: $("#assignModal"),
        });




    </script>




@endpush