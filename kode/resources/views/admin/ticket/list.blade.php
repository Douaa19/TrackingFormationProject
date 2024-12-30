@php
       $default =   App\Models\TicketStatus::default()->first();
@endphp

 <table class="table table-nowrap align-middle mb-0">
    <thead class="table-light">
        <tr>
            <th scope="col" class="all-checker">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="checkall">
                    <label class="form-check-label" for="checkall"></label>
                </div>
            </th>

            <th scope="col">
                {{translate("Ticket ID")}}
            </th>
            <th scope="col">
                {{translate("User")}}
            </th>
            <th scope="col" class="subject-width">
                {{translate("Subject")}} - {{ translate("Last reply") }}
            </th>
            <th scope="col">
                {{translate('Source')}}
             </th>
            <th scope="col">
               {{translate('Assign to')}}
            </th>

            <th scope="col">
                 {{translate("Priority")}}
            </th>
            <th scope="col">
                {{translate("Status")}}
            </th>
            <th scope="col">
                {{translate('Action')}}
            </th>
        </tr>
    </thead>

    <tbody>

        @forelse ($tickets as $ticket)


            <tr class="{{ $ticket->status == @$default->id ? "unread" :""}}">
                <td>
                    <div class="form-check">
                        <input
                        class="form-check-input ticket-checked ticket-check-box " type="checkbox" name="ticket_id[{{$loop->index}}]"  value="{{$ticket->id}}"
                        id="{{$loop->index."-checkbox"}}"> <label class="form-check-label"
                        for="{{$loop->index."-checkbox"}}"></label>
                    </div>
                </td>

                <td>
                    @php

                        $olderMessage  = $ticket->oldMessages->whereNotNull('admin_id')?->first();
                        $resolvedAt    = $ticket->solved_at;
                        $responsedIn   =  [
                            "status"    => false,
                            "message"   => translate("No Response Yet"),
                        ];
                        $resolvedIn   =  [
                            "status"    => false,
                            "message"   => translate("Not Resolved Yet"),
                        ];

                        if(@$olderMessage){
                            $responseTime    = $olderMessage->created_at;
                            $responsedIn     = ticket_response_format(@$ticket->linkedPriority->response_time, $ticket->created_at, $olderMessage->created_at);

                        }

                        if($resolvedAt){
                            $resolvedIn     = ticket_response_format(@$ticket->linkedPriority->resolve_time, $ticket->created_at, $resolvedAt ,true);
                        }


                    @endphp


                     <div class="ticket-number">
                        <a  href="{{route('admin.ticket.view',$ticket->ticket_number)}}">
                            #{{$ticket->ticket_number}}
                        </a>
                        <span class="teaser @if($responsedIn['status']  && $resolvedIn['status'])) link-success @else link-danger  @endif pointer fs-18 badge-icon">
                            <i data-response = "{{json_encode($responsedIn)}}"  data-resolved = "{{json_encode($resolvedIn)}}"    data-priority = "{{$ticket->linkedPriority}}"  class="ri-timer-2-line badge-icon  response-modal"></i>

                        </span>
                     </div>

                     <small class="fs-10">
                        {{ getTimeDifference($ticket->user_last_reply)}}
                     </small>
                </td>

                <td>
                 
                        @php
                            $url = getImageUrl(getFilePaths()['profile']['user']['path'].'/'.@$ticket->user->image);
                            if(filter_var(@$ticket->user->image, FILTER_VALIDATE_URL) !== false){
                                $url = @$ticket->user->image;
                            }
                        @endphp
                        <div class="ticket-creator">
                            <span class="me-1">
                                <img src="{{   $url }}" class="w-30 h-30 rounded-circle" alt="{{@$user->image}}">
                            </span>
    
                            {{($ticket->name ?? 'N/A')}}
                        </div>
                    
                </td>

                <td>

                    @php
                       $lastReply   = @$ticket->messages->first();
                       $lastMessage = @$lastReply->message;

                        if (strpos($lastMessage, '<img') !== false && strip_tags($lastMessage) === '') {
                            $lastMessage = "Replied with images only";
                        } 
        
                       $lastMessage = strip_tags($lastMessage);

  
                    @endphp

                    <div class="ticket-summary">
                        <a target="_blank" href="{{route('admin.ticket.view',$ticket->ticket_number)}}" class="ticket-subject">@if($ticket->department)<span class="line-clamp-1 limit-text fs-10 badge badge-soft-dark rounded-pill me-1">
                            {{$ticket->department->name}}
                          </span>  @endif    {{$ticket->subject ?? "N/A"}}
                        </a>

                        <a target="_blank" href="{{route('admin.ticket.view',$ticket->ticket_number)}}" class="last-reply mt-1">  {{  $lastMessage ? $lastMessage : 'N/A' }}</a>
                    </div>

                </td>

                <td>
                    @php
                       $source = $ticket->mail_id ? 'Email' :'System';
                       $badgeClass = $ticket->mail_id ? 'border-primary text-primary' : 'border-success text-success' ;

                    @endphp

                    <span class="badge rounded-pill border {{ $badgeClass }}">
                         {{  $source  }}
                    </span>

         
                </td>

                <td>

                        <div class="avatar-group">

                            @foreach ($ticket->agents as $agent )
                                
                                <div class="avatar-group-item material-shadow">

                                    @if(auth_user('admin')->agent == 0)
                                        <a href="{{route('admin.ticket.agent',$agent?->id)}}" class="d-inline-block custom--tooltip"    >
                                            <span class="tooltip-text">
                                                {{@$agent->name}}
                                           </span>
                                            <img src="{{getImageUrl(getFilePaths()['profile']['admin']['path']."/". $agent->image) }}"  class="rounded-circle avatar-xxs">
                                        </a>
                                    @else
                                        <a href="javascript:void(0)" class="d-inline-block custom--tooltip" >
                                            <span class="tooltip-text">
                                                {{@$agent->name}}
                                           </span>
                                            <img src="{{getImageUrl(getFilePaths()['profile']['admin']['path']."/". $agent->image) }}"  class="rounded-circle avatar-xxs">
                                        </a>
                                    @endif
                                </div>
                            @endforeach

                            @php
                               $agentIds = json_encode($ticket->agents->pluck('id')->toArray());
                            @endphp


                        @if(check_agent('assign_tickets'))
                            <div class="avatar-group-item material-shadow" data-bs-toggle="tooltip" data-bs-placement="top" >
                                <a href="javascript: void(0);" class="assign-ticket custom--tooltip" data-ticket-id='{{$ticket->id}}' data-agents="{{$agentIds}}">

                                    <span class="tooltip-text">
                                        {{ translate("Assign") }}
                                    </span>

                                    <div class="avatar-xxs">
                                        
                                        <span class="avatar-title rounded-circle bg-info text-white">
                                           +
                                        </span>
                                    </div>
                                </a>
                            </div>
                        @endif
                     
                        </div>

                </td>


                <td>@php echo priority_status(@$ticket->linkedPriority->name ,@$ticket->linkedPriority->color_code ) @endphp</td>

                <td>@php echo ticket_status($ticket->ticketStatus->name,$ticket->ticketStatus->color_code) @endphp</td>

                <td>

                    <div class="hstack gap-3 ">

                        <a target="_blank" href="{{route('admin.ticket.view',$ticket->ticket_number)}}"  class=" fs-18 link-success add-btn waves ripple-light"> <i class="ri-eye-line"></i>
                        </a>


                        @if(check_agent("delete_tickets"))
                            <a  target="_blank"  href="{{ route('admin.ticket.edit', $ticket->id) }}" class=" fs-18 link-warning"><i
                                class="ri-pencil-fill"></i></a>
                        @endif


                        @if(check_agent("delete_tickets"))
                           <a href="javascript:void(0);" data-href="{{route('admin.ticket.delete',$ticket->id)}}" class="delete-item fs-18 link-danger">
                            <i class="ri-delete-bin-line"></i></a>
                        @endif


                    </div>

                </td>
            </tr>

        @empty
           @include('admin.partials.not_found')
        @endforelse


    </tbody>
</table>

<div class="pagination d-flex justify-content-end mt-4 px-3 ">
     {{$tickets->links()}}
</div>


