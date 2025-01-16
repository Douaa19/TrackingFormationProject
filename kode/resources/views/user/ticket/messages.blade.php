@foreach($messages as $message)
    @php
        $files = $message->file ? json_decode($message->file, true) : [];
    @endphp

    <div class="reply-item">
        <div class="item-header">
            <div class="d-flex align-items-center justify-content-between flex-wrap w-100 gap-1">
                <div class="author-area">
                    <span>
                        @php
                            $name = $message->admin
                                ? $message->admin->name
                                : translate('Me');



                            $imgURL = $message->admin
                                ? getImageUrl(getFilePaths()['profile']['admin']['path'] . "/" . @$message->admin->image)
                                : asset('assets/images/default.jpg');

                            if (site_settings(key: 'agent_name_privacy', default: 0) == 1 && $message->admin) {
                                $name = site_settings("site_name");
                                $imgURL = getImageUrl(getFilePaths()['site_logo']['path'] . "/" . site_settings('site_favicon'));
                            }
                        @endphp
                        @if($message->admin)

                            <img class="avatar-xs rounded-circle" src="{{ $imgURL }}" alt="{{$message->admin->image}}">
                        @else
                            <img class="avatar-xs rounded-circle"
                                src="{{getImageUrl(getFilePaths()['profile']['user']['path'] . "/" . @$ticket->user->image) }}"
                                alt="{{$ticket->user->image}}">
                        @endif
                    </span>

                    <div class="author-info">
                        <h6>
                            {{   $name  }}
                        </h6>
                        @if($message->admin)

                            <p>{{translate("Replied To")}}
                                <a href="mailto:{{$ticket->email}}">
                                    {{auth_user('web')->name}}
                                </a>
                            </p>

                        @endif
                    </div>
                </div>

                <div class="text-lg-end text-center d-flex align-items-center justify-content-end gap-2">
                    <div class="reply-time">
                        <span> ({{getTimeDifference($message->created_at)}})</span>
                    </div>

                    @if(!$message->admin && site_settings(key: 'message_seen_status', default: 1) == 1)
                        <i
                            class=" fs-16 link-success ri-check-{{$message->seen == App\Enums\StatusEnum::true->status() ? "double-" : ""}}fill"></i>
                    @endif

                </div>
            </div>
        </div>

        <div class="item-body">
            @php echo $message->message @endphp
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