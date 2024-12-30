@forelse($messages as $message)
    <div class="ticket-chat {{$message->admin ? "replay-form-admin" : ""}}">

        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 w-100">
            <div class="chat-meta">
                <span class="chat-meta-img">

                    @php
                        $name  = $message->admin  
                                    ?  $message->admin->name 
                                    :  translate('Me');


                    
                        $imgURL = $message->admin 
                                        ? getImageUrl(getFilePaths()['profile']['admin']['path']."/". @$message->admin->image)
                                        : asset('assets/images/default.jpg');

                        if(site_settings(key:'agent_name_privacy',default:0) == 1 && $message->admin){
                            $name   = site_settings("site_name");
                            $imgURL =  getImageUrl(getFilePaths()['site_logo']['path']."/".site_settings('site_favicon'));
                        }

             
                    @endphp

                      <img src="{{$imgURL}}" alt="profile.jpg">
                </span>

                <h6>
                    {{$name}}
                </h6>
            </div>

            <span class="d-flex align-items-center gap-1">
                <small class="fs-14">({{getTimeDifference($message->created_at)}})</small>

                @if(!$message->admin_id && site_settings(key:'message_seen_status',default:1) == 1)
                   <i class="text-success lh-1 fs-18 bi bi-check2{{$message->seen == App\Enums\StatusEnum::true->status() ?"-all":""}}"></i>
                @endif
            </span>
        </div>

        <div class="chat-message-body">
            <div class="chat-message-content">
                 @php echo $message->message @endphp
            </div>

            @php
                $files = $message->file 
                           ? json_decode($message->file,true) 
                           : [];
            @endphp

            @if(count($files) != 0)
                @foreach( $files  as $file)
                    <div class="file w-100 border-top pt-3 mt-3">
                        <form class="d-flex gap-2" action="{{route("user.ticket.download.file")}}" method="post">
                            @csrf
                            <input hidden type="text" name="name" value="{{$file}}">

                            <button class="d-inline-flex download-attach" type="submit">
                                <i class="bi bi-download"></i> <span>{{translate('File-').$loop->index+1..".".pathinfo($file, PATHINFO_EXTENSION)}}</span>
                            </button>

                        </form>
                    </div>
                @endforeach
            @endif

        </div>
    </div>
@empty

@endforelse
