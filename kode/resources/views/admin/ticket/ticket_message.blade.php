@foreach($messages as $message)

    @php
        $files = $message->file ? json_decode($message->file, true) : [];
    @endphp

    <div class="reply-item @if(!$message->admin_id) replay-form-user @endif @if($message->is_note == 1) alert mb-0 alert-warning @endif"
        id="messageCard-{{$message->id}}">
        <div class="item-header">
            <div class="d-flex align-items-center justify-content-between flex-wrap w-100 gap-1">
                <div class="author-area">
                    <span>
                        @if($message->admin)
                            <img class="avatar-xs rounded-circle"
                                src="{{getImageUrl(getFilePaths()['profile']['admin']['path'] . "/" . $message->admin->image) }}"
                                alt="{{$message->admin->image}}">
                        @else
                            <img class="avatar-xs rounded-circle"
                                src="{{getImageUrl(getFilePaths()['profile']['user']['path'] . "/" . @$ticket->user->image) }}"
                                alt="{{@$ticket->user->image}}">
                        @endif
                    </span>
                    <div class="author-info">
                        <h6>
                            @if($message->admin)
                                {{$message->admin->name }}
                                @if($message->is_note == 1)
                                    <span class="text-muted">
                                        ({{translate("Left a note")}})
                                    </span>
                                @endif
                            @else
                                {{ @$ticket->user->name}}
                            @endif

                        </h6>

                        @if($message->admin && $message->is_draft == App\Enums\StatusEnum::false->status())
                            <p>{{translate("Replied To")}}
                                <a href="mailto:{{@$ticket->email}}">
                                    {{@$ticket->email}}
                                </a>
                            </p>
                        @endif

                        @if($message->is_draft == App\Enums\StatusEnum::true->status())
                            <div class="d-flex align-items-center gap-2 mt-1">
                                <p>
                                    {{translate("Draft Message")}}
                                </p>
                                <button data-message="{{$message->message}}" data-id="{{$message->id}}" type="button"
                                    class="btn btn-sm btn-success add-btn edit-draft">
                                    {{translate('Edit')}}
                                </button>

                                <button id="add-ticket-option"
                                    data-href="{{route('admin.ticket.delete.message', $message->id)}}" type="button"
                                    class="btn btn-sm btn-danger add-btn delete-item">
                                    {{translate('Delete')}}
                                </button>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="text-lg-end text-center d-flex align-items-center justify-content-end gap-2 ">
                    <div class="reply-time">
                        <span> ({{getTimeDifference($message->created_at)}})</span>
                    </div>

                    @if($message->admin && $message->is_note == 0 && $message->is_draft == App\Enums\StatusEnum::false->status())
                        <i
                            class=" fs-16 link-success ri-check-{{$message->seen == App\Enums\StatusEnum::true->status() ? "double-" : ""}}fill"></i>
                    @endif
                    @if(check_agent("delete_tickets"))
                            <div class="dropdown">
                                <button class="btn btn-ghost-secondary btn-icon btn-sm fs-16" type="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="ri-more-2-fill align-bottom"></i>
                                </button>

                                @if(check_agent("delete_tickets"))
                                            <div class="dropdown-menu">
                                                <button type="button" data-href="{{route('admin.ticket.delete.message', $message->id)}}"
                                                    class="dropdown-item delete-item">
                                                    {{translate('Delete')}}
                                                </button>
                                                <button data-id="{{$message->id}}" data-message="{{$message->message}}" type="button"
                                                    class="dropdown-item edit-message">
                                                    {{translate('Edit')}}
                                                </button>
                                                @php
                                                    $originalMessage = $message->original_message ?? $message->message;
                                                @endphp

                                                <button data-message="{{$originalMessage}}" type="button" class="dropdown-item   show-message">
                                                    {{translate('Show Original')}}
                                                </button>
                                            </div>
                                @endif

                            </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="item-body">
            <div>
                @php echo $message->message @endphp
            </div>

            @if(count($files) != 0)
                <div class="attachment-group">
                    @foreach($files as $file)

                        @php
                            $fileURL = getImageUrl(getFilePaths()['ticket']['path'] . "/" . $file);
                            $isImage = isImageUrl($fileURL);
                        @endphp

                        <a href="{{getImageUrl(getFilePaths()['ticket']['path'] . "/" . $file)}}"
                            class="download-attach {{$isImage ? 'image-v-preview' : '' }} ">
                            <i class="ri-download-2-line"></i>
                            <span>{{translate('File-') . $loop->index + 1. . "." . pathinfo($file, PATHINFO_EXTENSION)}}</span>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>


@endforeach


@if($messages->count() == 0)

    <div class="reply-item">
        <div class="item-body">
            @include('admin.partials.not_found')
        </div>
    </div>

@endif