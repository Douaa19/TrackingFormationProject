
<div class="container-fluid p-0">

    @php



        $ticketStatus   = App\Models\TicketStatus::active()->get();

        $priorityStatus = App\Models\Priority::active()->get();
        $agents = App\Models\Admin::active()
        ->where('id','!=',auth_user()->id)
        ->get();

        if(auth_user()->agent == App\Enums\StatusEnum::true->status()){
            $agents  =   $agents->filter(function ($agent) use ($ticket) {
                                return in_array((string)$ticket->category_id, (array)json_decode($agent->categories, true));
                            });
        }


        $default_notifications = admin_notification();
        if(auth_user()->agent  ==  App\Enums\StatusEnum::true->status()){
            $default_notifications = agent_notification();
        }
        $admin_notifications =  auth_user()->notification_settings ? json_decode(auth_user()->notification_settings,true) :$default_notifications;

        $emailNotification   = false;
        $smsNotification     = false;
        $slackNotification   = false;
        $browserNotification = false;

        if(@$admin_notifications['email']['user_reply_admin'] ==  App\Enums\StatusEnum::true->status() ||  @$admin_notifications['email']['user_reply_agent'] == App\Enums\StatusEnum::true->status() ||  @$admin_notifications['email']['agent_ticket_reply'] == App\Enums\StatusEnum::true->status() ){
            $emailNotification = true;
        }
        if(@$admin_notifications['sms']['user_reply_admin'] ==  App\Enums\StatusEnum::true->status() ||  @$admin_notifications['sms']['user_reply_agent'] == App\Enums\StatusEnum::true->status() ||  @$admin_notifications['sms']['agent_ticket_reply'] == App\Enums\StatusEnum::true->status() ){
            $smsNotification = true;
        }
        if(@$admin_notifications['slack']['user_reply_admin'] ==  App\Enums\StatusEnum::true->status() ||  @$admin_notifications['slack']['user_reply_agent'] == App\Enums\StatusEnum::true->status() || @$admin_notifications['slack']['agent_ticket_reply'] == App\Enums\StatusEnum::true->status()){
            $slackNotification = true;
        }
        if(@$admin_notifications['browser']['user_reply_admin'] ==  App\Enums\StatusEnum::true->status() ||  @$admin_notifications['browser']['user_reply_agent'] == App\Enums\StatusEnum::true->status() || @$admin_notifications['browser']['agent_ticket_reply'] == App\Enums\StatusEnum::true->status() ){
            $browserNotification = true;
        }

    @endphp

    <div class="row gy-4">
        <div class="col-xxl-3">
            <div class="border rounded sticky-div">
                <div class="ticket-details-item pt-3">
                    <h5>
                        {{translate("Ticket Details")}}
                    </h5>

                    <div class="ticket-details-body">
                        <ul class="list-group list-group-flush ticket-detail-list">
                            <li class="list-group-item">
                                <span>
                                    {{translate("Ticket")}}
                                    </span>
                                <small class="fs-12 badge rounded-pill bg-primary">      {{$ticket->ticket_number}}
                                </small>
                            </li>

                            <li class="list-group-item">
                                <span>{{translate("User Name")}} </span>
                                    <small> {{$ticket->name}}</small>
                            </li>

                            <li class="list-group-item">
                                <span>{{translate("User Email")}} </span>
                                <small>{{$ticket->email}}</small>
                            </li>

                            <li class="list-group-item">
                                <span> {{translate("Category")}}</span>
                                <small> {{@get_translation($ticket->category->name)}}</small>
                            </li>

                            @if(auth_user()->agent == App\Enums\StatusEnum::false->status())
                                <li class="list-group-item">
                                    <span>
                                            {{translate("Assigned To")}}
                                    </span>

                                    <small class="ms-2 {{count($ticket->agents) == 0 ?"text-danger" :"text-info"}}">
                                            @if(count($ticket->agents) > 0)

                                                <a href="{{route('admin.ticket.agent',$ticket->agents->first()?->id)}}">
                                                    {{$ticket->agents->first()?->id == auth_user()->id ? 'Me' : $ticket->agents->first()?->name }}
                                                </a>

                                            @else
                                                ({{translate('Unassigned')}})
                                            @endif
                                    </small>
                                </li>
                            @endif

                            @if(check_agent("update_tickets"))
                                <li class="list-group-item">
                                    <span>{{translate("Status")}}</span>

                                    <select class="form-select ticket-modal" id="ticket-status" >


                                        @foreach($ticketStatus as $status)


                                            <option data-id ="{{$ticket->id}}"  {{$status->id == $ticket->status ? 'selected' :""}} value="{{$status->id}}">
                                                {{
                                                    $status->name
                                                }}
                                            </option>

                                        @endforeach
                                    </select>
                                </li>
                            @endif


                            <li class="list-group-item">
                                <span>
                                    {{translate('Priority')}}
                                </span>
                                <small>
                                    @php
                                        echo priority_status(@$ticket->linkedPriority->name ,@$ticket->linkedPriority->color_code ,'12')
                                    @endphp
                                </small>
                            </li>

                            <li class="list-group-item">
                                <span>
                                    {{translate('Create Date')}}
                                </span>
                                <small>
                                    {{getTimeDifference($ticket->created_at)}}
                                </small>
                            </li>

                            <li class="list-group-item">
                                <span>
                                    {{translate('Last Activity')}}
                                </span>
                                <small>
                                    {{@getTimeDifference($ticket->messages->first()->created_at)}}
                                </small>
                            </li>
                        </ul>
                    </div>
                </div>

                @if(auth_user()->agent == App\Enums\StatusEnum::true->status() )
                    <div class="ticket-details-item">
                        <h5 >
                            {{translate("Short Notes")}}
                        </h5>

                        <div class="ticket-details-body">
                            @php
                                $agentTicket = $ticket->agents->first();
                            @endphp
                            {{  @$agentTicket->pivot->short_notes}}

                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-xxl-9">
            <div class="card card mb-0 shadow-none">
                <div class="card-header border-bottom-0 pt-0 px-0">
                    <h5 class="card-title">
                        {{translate('Message')}}
                    </h5>
                </div>

                <div class="card-body px-0 pt-0">
                    <div class="ticket-action-buttons">

                        <button class="reply-btn modal-ticket">
                            <i class="ri-reply-fill"></i>
                            {{translate("Reply")}}
                        </button>

                        <button  class="btn btn-info btn-sm add-note" data-ticket = "{{$ticket->id}}" >
                        <i class="ri-sticky-note-line"></i>
                            {{translate("Note")}}
                        </button>


                        @if($ticket->status !=  App\Enums\TicketStatus::CLOSED->value)
                            <button class="btn btn-success  btn-sm canned-reply">
                                    <i class="ri-mail-line"></i>
                                    {{translate("Predefined Response")}}
                            </button>
                        @endif

 


                        @if(check_agent("delete_tickets"))
                            <button type="button"  data-href="{{route('admin.ticket.delete',$ticket->id)}}" class="delete-item btn py-0 fs-16 text-body">
                                <i class="ri-delete-bin-6-line link-danger "></i>
                                {{translate("Delete")}}
                            </button>
                        @endif

                        @php

                            $mutedTicket = (array)auth_user()->muted_ticket;

                            $muted_class = 'ri-notification-4-line';
                            $muted       = App\Enums\StatusEnum::true->status();

                            if(in_array($ticket->id ,$mutedTicket)){
                                $flag = App\Enums\StatusEnum::true->status();
                                $muted = App\Enums\StatusEnum::false->status();
                                $muted_class = 'ri-notification-off-line';
                            }

                        @endphp

                        <a id="mute-user"  data-ticket = "{{$ticket->ticket_number}}"  href="javascript:void(0)"
                                class="mute-btn btn bg-{{$muted == App\Enums\StatusEnum::false->status()?'danger':"success" }} btn-icon">
                            <i class="mute-icon {{$muted_class}} icon-sm me-0 text-light"></i>
                        </a>


                        <button data-ticket = '{{$ticket->id}}' class="btn btn-success  btn-sm merge-ticket">
                            <i class="ri-git-merge-line"></i>
                                {{translate("Merge")}}
                        </button>


                        <a href="{{route('admin.ticket.view', $ticket->ticket_number)}}" class="btn btn-success  btn-sm ">
                            <i class="ri-file-list-line"></i>
                            {{translate("View")}}
                        </a>

                    </div>
                </div>

                <div class="card-body px-0 pt-0 reply-card d-none ">
                    @include('admin.ticket.partials.reply_card')
                </div>

                <div class="card-body pb-0 px-0">
                    <div class="ticket-wrapper rounded border">
                        <div class="d-none modal-message-loader" id="elmLoader">
                            <div class="spinner-border text-primary avatar-sm" role="status">
                                <span class="visually-hidden"></span>
                            </div>
                        </div>

                        <div class="all-reply-item" >

                        </div>

                        <div class="text-center pt-4 load-more-div d-none">
                            <button data-ticket="{{$ticket->id}}"  class="btn btn-md btn-success add-btn waves ripple-light load-more modal-message">
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






