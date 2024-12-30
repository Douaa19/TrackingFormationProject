@extends('admin.layouts.master')
@push('style-include')
   <link href="{{asset('assets/global/css/chat.css')}}" rel="stylesheet" type="text/css" />
@endpush
@section('content')
<div class="container-fluid">

    @php
        $pusher_settings  =  json_decode(site_settings('pusher_settings'),true);
    @endphp

    <div class="chat-wrapper d-lg-flex gap-2">
        <div class="chat-leftsidebar p-3 ">
                <div class="d-flex align-items-start">
                    <div class="flex-grow-1">
                        <h5 class="mb-3">
                          {{$agent->name}} ({{translate('Chat List')}})
                        </h5>
                    </div>
                </div>

                <div class="chat-room-list" data-simplebar>
                    <div class="d-flex align-items-center px-3 mb-3">
                        <div class="flex-grow-1">
                            <h4 class="mb-0 fs-11 text-uppercase">
                               {{translate('User list')}}
                            </h4>
                        </div>
                    </div>

                    <div class="chat-message-list">
                        <ul class="nav list-unstyled chat-list chat-user-list d-block gap-1"  role="tablist">

                            @foreach($users as $user)
                                @php
                                   $unreadMessages = $user->unread(auth_user()->id);
                                @endphp
                                <li class="nav-item " role="presentation">
                                    <a class="nav-link  user-chat-section" data-id="{{$user->id}}" id="{{$user->id}}" href="javascript:void(0)" >
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 chat-user-img online align-self-center me-2 ms-0">
                                                <div class="avatar-xxs">
                                                    @php
                                                    $url = getImageUrl(getFilePaths()['profile']['user']['path'].'/'.$user->image,getFilePaths()['profile']['user']['size']);
                                                        if(filter_var($user->image, FILTER_VALIDATE_URL) !== false){
                                                            $url = $user->image;
                                                        }
                                                    @endphp
                                                    <img src="{{$url}}" class="rounded-circle img-fluid userprofile" alt="{{$user->image}}" />
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-truncate mb-0">
                                                    {{$user->name}}
                                                </p>
                                            </div>

                                        </div>
                                    </a>
                                </li>
                            @endforeach


                        </ul>
                    </div>

                </div>
        </div>

        <div class="user-chat w-100 overflow-hidden">
            <div class="d-none" id="elmLoader">
                <div
                class="spinner-border text-primary avatar-sm"
                role="status">

                </div>
            </div>

            <div class="no-message">
                <div class="no-message-content">
                    <div class="no-message-img">
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 60 60" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M10 25.465h13a1 1 0 1 0 0-2H10a1 1 0 1 0 0 2zM36 29.465H10a1 1 0 1 0 0 2h26a1 1 0 1 0 0-2zM36 35.465H10a1 1 0 1 0 0 2h26a1 1 0 1 0 0-2z" fill="#000000" opacity="1" data-original="#000000" class=""></path><path d="m54.072 2.535-34.142-.07c-3.27 0-5.93 2.66-5.93 5.93v5.124l-8.07.017c-3.27 0-5.93 2.66-5.93 5.93v21.141c0 3.27 2.66 5.929 5.93 5.929H12v10a1 1 0 0 0 1.74.673l9.704-10.675 16.626-.068c3.27 0 5.93-2.66 5.93-5.929v-.113l5.26 5.786a1.002 1.002 0 0 0 1.74-.673v-10h1.07c3.27 0 5.93-2.66 5.93-5.929V8.465a5.937 5.937 0 0 0-5.928-5.93zM44 40.536a3.934 3.934 0 0 1-3.934 3.929l-17.07.07a1 1 0 0 0-.736.327L14 53.949v-8.414a1 1 0 0 0-1-1H5.93A3.934 3.934 0 0 1 2 40.606V19.465a3.935 3.935 0 0 1 3.932-3.93L15 15.516h.002l25.068-.052a3.934 3.934 0 0 1 3.93 3.93v21.142zm14-10.93a3.934 3.934 0 0 1-3.93 3.929H52a1 1 0 0 0-1 1v8.414l-5-5.5V19.395c0-3.27-2.66-5.93-5.932-5.93L16 13.514v-5.12a3.934 3.934 0 0 1 3.928-3.93l34.141.07h.002a3.934 3.934 0 0 1 3.93 3.93v21.142z" fill="#000000" opacity="1" data-original="#000000" class=""></path></g></svg>
                    </div>
                     <p class="pusher-error">{{translate('Start chating by select a user')}}</p>
                </div>
            </div>

            <div class="chat-content d-lg-flex">
                <div class="w-100 overflow-hidden position-relative">
                    <div class="position-relative" id="users-chat">
                        <div id="chat-head">
                        </div>

                        <div id="chat-message" class="message-container">
                            <div class="chat-conversation position-relative p-2 p-lg-3" id="chat-conversation">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
@push('script-include')
  <script src="{{asset('assets/global/js/pusher.min.js')}}"></script>
@endpush

@push('script-push')

  <script>

    var userId = 0;
    var loader = true;

    //user chat click event
    $(document).on('click','.user-chat-section',function(e){

        userId = $(this).attr('data-id');
        $('.nav-item .chat-active').removeClass('chat-active');
        $('.no-message').addClass('d-none')
        $(this).removeClass('unread-msg-user');
        get_user_chat(userId ,loader)
        $(this).addClass('chat-active')
    })

    //get user chat method
    function get_user_chat(userId ,preLoder){

        $.ajax({
            method:"POST",
            url:"{{ route('admin.agent.chat') }}",
            beforeSend: function() {
                if(preLoder){
                    $("#elmLoader").removeClass('d-none');
                }
            },
            data:{
                "_token":"{{csrf_token()}}",
                'user_id':userId,
                'agent_id':"{{$agent->id}}"
            },
            dataType:'json'
        }).then(response=>{

            if(preLoder){
                $("#elmLoader").addClass('d-none');
            }
            if(response.status){
                $('#chat-head').html(response.chat_header_html)
                $('#chat-conversation').html(response.chat_html)

                scroll_bottom();
            }
            else{
                $('.no-message').removeClass('d-none')
                toastr(response.message,'danger')
            }

        })

    }

    //delete a message event
    $(document).on('click','.delete-message',function(e){

        var user = $(this).attr('data-user-id');
        var message_id = $(this).attr('data-message-id');
        delete_message(user,message_id)
    })

    //delete message method
    function delete_message(user , message_id){

        $.ajax({
            method: 'POST',
            url:"{{ route('admin.agent.delete.message') }}",
            data: {
                "_token":"{{csrf_token()}}",
                'user_id' :user,
                'message_id' :message_id,
                'agent_id' :"{{$agent->id}}",
            },
            dataType:'json',
            success: function (response) {
                if(response.status){
                loader = false;
                    $(`#${response.user_id}`).click()
                    toastr(response.message,'success')
                }
                else{
                    toastr(response.message,'danger')
                }

            },
            error: function (response) {
                toastr('{{translate("Validation Error")}}','danger')
            },
        })
    }

    // scroll bottom to chat list when new message appear
    function scroll_bottom() {

        $('.chat-conversation').animate({
            scrollTop: $('.chat-conversation').get(0).scrollHeight
        }, 1);
    }

    //block a user event user
    $(document).on('click',"#block-user",function(e){

        var form = $('#block-form')[0];
        var data =  new FormData(form)
        block_user(data)
        e.preventDefault()
    })

    //block e user method start
    function block_user(data){

        $.ajax({
            method: 'POST',
            url:"{{ route('admin.agent.block.user')}}",
            data: data,
            processData: false,
            contentType: false,
            async: false,
            success: function (response) {
                var response = JSON.parse(response)
                var status ='danger';
                loader = false;
                $(`#${response.user_id}`).click()
                if(response.status){

                    status ='success';

                }
                toastr(response.message,status)
            },
            error: function (response) {
                toastr('{{translate("Validation Error")}}','danger')
            },
        });
    }


  </script>
@endpush
