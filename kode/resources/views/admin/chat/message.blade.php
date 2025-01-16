@if(count($chat_messages) != 0)
<ul class="list-unstyled chat-conversation-list"
id="users-conversation">
    @foreach($chat_messages as $message)
        <li class="chat-list {{$message->sender == App\Enums\StatusEnum::false->status() ? "left" :'right'}}" >
            <div class="conversation-list">
                <div class="user-chat-content">
                    <div class="ctext-wrap">
                        <div class="ctext-wrap-content">
                            <p class="mb-0 ctext-content">
                                {{$message->message}}
                            </p>
                        </div>
                        <h1>Helllo</h1>
                        <div
                            class="dropdown align-self-start message-box-drop">
                            <a class="dropdown-toggle" href="javascript:void(0)"
                                role="button"
                                data-bs-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false"> <i
                                    class="ri-more-2-fill"></i>
                            </a>
                            <div class="dropdown-menu">
                                <button  @if($anonymous) data-anonymous = '{{$message->floating_id}}' @endif  data-message-id ='{{$message->id}}' data-user-id ='{{$message->user_id}}' class="btn delete-message  dropdown-item delete-item"><i
                                    class="ri-delete-bin-5-line text-danger  me-2 text-muted align-bottom"></i>
                                    {{translate('Delete')}}
                            </button>
                            </div>
                        </div>
                    </div>

                    <div class="conversation-name"><small
                            class="text-muted time">{{$message->created_at->diffForHumans()}}</small>
                            @if(!$message->sender == App\Enums\StatusEnum::false->status())
                            <span
                            class="text-success check-message-icon"><i
                                class="bx bx-check{{$message->seen == App\Enums\StatusEnum::true->status() ? "-double" :""   }}"></i></span>
                            @endif
                    </div>
                </div>
            </div>
        </li>
    @endforeach
</ul>
@else
    <div class="empty-message">
        {{translate('No Message Found')}}
    </div>
@endif


