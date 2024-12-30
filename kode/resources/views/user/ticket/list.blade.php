@php
  $user = auth_user('web');
@endphp


<table class="table table-nowrap align-middle mb-0">
    <thead class="table-light">
        <tr>
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

            <tr class="{{$ticket->messages_count > 0 || $ticket->status == App\Enums\TicketStatus::PENDING->value ? "unread" :""}}">

                <td>
                   
                     <div class="ticket-number">
                        <a  href="{{route('user.ticket.view',$ticket->ticket_number)}}">
                            #{{$ticket->ticket_number}}
                        </a>
                      
                     </div>


                     <small class="fs-10">
                        {{ getTimeDifference($ticket->created_at)}}
                     </small>
                </td>

                <td>
                    @php
                       $url = getImageUrl(getFilePaths()['profile']['user']['path'].'/'.$user->image,getFilePaths()['profile']['user']['size']);
                        if(filter_var($user->image, FILTER_VALIDATE_URL) !== false){
                            $url = $user->image;
                        }
                    @endphp
                    <div class="ticket-creator">
                        <span class="me-1">
                            <img src="{{   $url }}" class="w-30 h-30 rounded-circle" alt="{{@$user->image}}">
                        </span>

                        {{($ticket->name)}}
                    </div>
                </td>

                <td>

                    @php
                       $lastReply = @$ticket->messages->first();
                    @endphp

                    <div class="ticket-summary">
                        <p class="ticket-subject">@if($ticket->department)<span class="line-clamp-1 limit-text fs-10 badge badge-soft-dark rounded-pill me-1">
                            {{$ticket->department->name}}
                          </span>  @endif    {{$ticket->subject}}
                        </p>

                        <p class="last-reply mt-1">  {{ strip_tags($lastReply ?  $lastReply->message : $ticket->message)}}</p>
                    </div>

                </td>

                <td>
                    @if(count($ticket->agents) > 0)
                      <div class="avatar-group">
                            @foreach ($ticket->agents as $agent )
                                <div class="avatar-group-item material-shadow custom--tooltip">
                                    <span class="tooltip-text">
                                        {{@$agent->name}}
                                   </span>
                                    <img src="{{getImageUrl(getFilePaths()['profile']['admin']['path']."/". $agent->image) }}"  class="rounded-circle avatar-xxs">
                                </div>
                            @endforeach
                      </div>

                    @else
                        ({{translate('Unassigned')}})
                    @endif
                </td>

                <td>@php echo priority_status(@$ticket->linkedPriority->name ,@$ticket->linkedPriority->color_code ) @endphp</td>

                <td>@php echo ticket_status($ticket->ticketStatus->name,$ticket->ticketStatus->color_code) @endphp</td>

                <td>

                    <div class="hstack gap-3 ">

                        <a href="{{route('user.ticket.view',$ticket->ticket_number)}}"  class=" fs-18 link-success add-btn waves ripple-light"> <i class="ri-eye-line"></i>
                        </a>

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
