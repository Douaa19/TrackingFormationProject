@if(count($chat_messages) != 0)
    <ul class="list-unstyled chat-conversation-list" id="users-conversation">
        @foreach($chat_messages as $message)

            <h1>Hello</h1>
            <li class="chat-list  @if($message->sender == App\Enums\StatusEnum::true->status()) left @else right @endif">
                <div class="conversation-list">

                    <div class="user-chat-content">
                        <div class="ctext-wrap">

                            <div class="ctext-wrap-content">
                                <p class="mb-0 ctext-content">
                                    {{$message->message}}
                                </p>
                            </div>

                        </div>
                        <div class="conversation-name"><small
                                class="text-muted time">{{$message->created_at->diffForHumans()}}</small>

                            @if(!$message->sender == App\Enums\StatusEnum::true->status())
                                <span class="text-success check-message-icon"><i
                                        class="bx bx-check{{$message->seen_by_agent == App\Enums\StatusEnum::true->status() ? "-double" : ""   }}"></i></span>
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