@extends('admin.layouts.master')
@push('style-include')
   <link href="{{asset('assets/global/css/chat.css')}}" rel="stylesheet" type="text/css" />
@endpush
@section('content')
<div class="container-fluid">



    <div class="chat-wrapper d-lg-flex gap-2">
        <div class="chat-leftsidebar p-3 ">
                <div class="chat-room-list" data-simplebar>


                    @if($chats ->count() > 0)
                        <div class="d-flex align-items-center px-3 mb-3">
                            <div class="flex-grow-1">
                                <h4 class="mb-0 fs-11 text-uppercase">
                                {{translate('Direct Messages')}}
                                </h4>
                            </div>
                        </div>

                        <div class="chat-message-list mb-3">
                            <ul class="nav list-unstyled chat-list chat-user-list d-block" role="tablist">
                                @foreach($chats as $chat)

                                    <li class="nav-item " role="presentation">
                                        <a class="nav-link  user-chat-section" href="javascript:void(0)" >
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 chat-user-img online align-self-center me-2 ms-0">
                                                    <div class="avatar-xxs">
                                                        <img src="{{getImageUrl(getFilePaths()['profile']['user']['path']."/". @$chat->user->image) }}" class="rounded-circle img-fluid userprofile" alt="{{@$chat->user->image}}" />
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <p class="text-truncate mb-0">
                                                        {{@$chat->user->name}}
                                                    </p>
                                                </div>

                                                <div class="ms-auto unread-notifications- {{$unreadMessages > 0 ? "" :"d-none"  }} ">
                                                    <span class="badge badge-soft-dark rounded p-1 unread-message-counter-{{@$chat->user->id}}">

                                                    </span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                    @endif


                    @if($anonymousChats->count() > 0)

                        <div class="d-flex align-items-center px-3 mb-3">
                            <div class="flex-grow-1">
                                <h4 class="mb-0 fs-11 text-uppercase">
                                {{translate('Anonymous Messages')}}
                                </h4>
                            </div>
                        </div>


                        <div class="chat-message-list mb-3">
                            <ul class="nav list-unstyled chat-list chat-user-list d-block"  role="tablist">
                                @foreach($anonymousChats as $user)

                                    @php
                                        $unreadMessages = $user->unread(auth_user()->id);
                                    @endphp
                                    <li class="nav-item " role="presentation">
                                        <a class="nav-link {{$unreadMessages > 0 ? "unread-msg-user" :""  }} user-chat-section" data-id="{{$user->id}}" id="{{"anonymous-".$user->id}}" data-anonymous = "{{$user->id}}"  href="javascript:void(0)" >
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 chat-user-img online align-self-center me-2 ms-0">
                                                    <div class="avatar-xxs">

                                                        @php
                                                        $url = getImageUrl(getFilePaths()['profile']['user']['path'].'/'.$user->image,getFilePaths()['profile']['user']['size']);
                                                            if(filter_var($user->image, FILTER_VALIDATE_URL) !== false){
                                                                $url = $user->image;
                                                            }
                                                        @endphp
                                                        <img src="{{$url }}" class="rounded-circle img-fluid userprofile" alt="{{@$user->image}}" />
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <p class="text-truncate mb-0">
                                                        {{@$user->email}}
                                                    </p>
                                                </div>

                                                <div class="ms-auto unread-notifications-anonymous-{{@$user->id}} {{$unreadMessages > 0 ? "" :"d-none"  }} ">
                                                    <span class="badge badge-soft-dark rounded p-1 unread-message-counter-anonymous-{{@$user->id}}">

                                                    </span>
                                                </div>

                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                    @endif


                    @if($users->count() > 0)

                        <div class="d-flex align-items-center px-3 mb-3">
                            <div class="flex-grow-1">
                                <h4 class="mb-0 fs-11 text-uppercase">
                                {{translate('Contacts')}}
                                </h4>
                            </div>
                        </div>


                        <div class="chat-message-list">
                                <ul class="nav list-unstyled chat-list chat-user-list d-block"  role="tablist">

                                        @foreach($users  as $user )

                                            @php
                                                $unreadMessages = $user->unread(auth_user()->id);
                                            @endphp

                                            <li class="nav-item " role="presentation">
                                                <a class="nav-link {{$unreadMessages > 0 ? "unread-msg-user" :""  }}  user-chat-section"  data-id="{{$user->id}}" id="{{$user->id}}"  href="javascript:void(0)" >
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0 chat-user-img online align-self-center me-2 ms-0">

                                                            @php
                                                            $url = getImageUrl(getFilePaths()['profile']['user']['path'].'/'.$user->image,getFilePaths()['profile']['user']['size']);
                                                                if(filter_var($user->image, FILTER_VALIDATE_URL) !== false){
                                                                    $url = $user->image;
                                                                }
                                                            @endphp
                                                            <div class="avatar-xxs">
                                                                <img src="{{$url}}" class="rounded-circle img-fluid userprofile" alt="{{@$user->image}}" />
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1 overflow-hidden">
                                                            <p class="text-truncate mb-0">
                                                                {{@$user->name}}
                                                            </p>
                                                        </div>

                                                        <div class="ms-auto unread-notifications-{{@$user->id}} {{$unreadMessages > 0 ? "" :"d-none"  }} ">
                                                            <span class="badge badge-soft-dark rounded p-1 unread-message-counter-{{@$user->id}}">
                                                                @if($unreadMessages > 0)
                                                                {{$unreadMessages}}
                                                                @endif
                                                            </span>
                                                        </div>


                                                    </div>
                                                </a>
                                            </li>

                                        @endforeach

                                </ul>
                        </div>
                    @endif


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

                    <div class="chat-form d-none">
                        <div class="chat-input-section p-2 p-lg-3">
                            <form id="chatinput-form">
                                @csrf
                                <input class="form-control" type="hidden" id="chat-user-id" name="user_id">
                                <input  type="hidden" name="anonymous" id="anonymous">
                                <div class="row g-0 align-items-center">
                                    <div class="col">

                                        <div class="chat-input-feedback">
                                           {{translate("Please Enter a Message")}}
                                        </div>

                                        <input type="text"
                                            class="form-control chat-input bg-light border-light"
                                            id="chat-input"
                                            name ="message"
                                            placeholder=" {{translate('Type your message')}} ..."
                                            autocomplete="off" />

                                    </div>

                                    <div class="col-auto">
                                        <div class="chat-input-links ms-2">
                                            <div class="links-list-item">
                                                <button id='send-message' type="submit"
                                                    class="btn btn-success chat-send waves-effect waves-light">
                                                    <i class="ri-send-plane-2-fill align-bottom"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="blocked-message" >
                                 <p>
                                    {{translate('You Can not reply to this conversations')}}
                                 </p>
                            </div>
                        </div>

                        <div class="replyCard">
                            <div class="card mb-0">
                                <div class="card-body py-3">
                                    <div
                                        class="replymessage-block mb-0 d-flex align-items-start">
                                        <div class="flex-grow-1">
                                            <h5 class="conversation-name"></h5>
                                            <p class="mb-0"></p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <button type="button" id="close_toggle"
                                                class="btn btn-sm btn-link mt-n2 me-n3 fs-18">
                                                <i class="bx bx-x align-middle"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <audio id="message-notifications" src="{{asset('assets/global/audio/notifications.mp3')}}" preload="auto"></audio>

</div>

@endsection

@push('script-push')


  <script>
   	"use strict";
    var userId = 0;
    var anonymous = 0;

    var loader = true;

      try {

        var pusher = new Pusher("{{$pusher_settings['app_key']}}", {
            cluster: "{{$pusher_settings['app_cluster']}}"
        });

        var channel = pusher.subscribe("{{$pusher_settings['chanel']}}");

        channel.bind("{{$pusher_settings['event']}}", function(data) {

            if(data.receiver == "{{auth_user()->id}}"  && data.message_for == "admin" ){
                if(data.play_audio_for_chat){
                    $('#message-notifications').get(0).play();
                }
            }
            if(data.user_seen && data.admin_seen_id == "{{auth_user()->id}}"){
                loader = false;
                if(data.user_seen_by == userId){
                    $(`#${data.user_seen_by}`).click()
                }
            }

            if((data.user_id && data.user_id ==  userId) || (data.anonymous_id &&  data.anonymous_id ==  anonymous))
            {

                loader = false;
                if(data.anonymous_id){
                    anonymous  = data.anonymous_id
                    $(`#anonymous-${data.anonymous_id}`).click();
                }
                else{

                    $(`#${data.user_id}`).click();

                }
            }
            else{


                if(data.counter){

                    var prefix = "-"
                    var countedId = data.user_id;
                    if(data.anonymous_id){
                        prefix = "-anonymous-";
                        countedId     = data.anonymous_id;
                    }

                    $(`.unread-notifications${prefix}${countedId}`).removeClass('d-none')

                    var pending_message =  parseInt($(`.unread-message-counter${prefix}${countedId}`).html());

                    $(`#${countedId}`).addClass('unread-msg-user')

                    if(data.anonymous_id  || (data.receiver == "{{auth_user()->id}}" && data.user_id)){
                        if(pending_message){
                          $(`.unread-message-counter${prefix}${countedId}`).html(pending_message+1);
                        }
                        else{
                            $(`.unread-message-counter${prefix}${countedId}`).html(1);
                        }
                    }

                }
            }

        });
        } catch (error) {

            $('.pusher-error').addClass('text-danger')

            $('.pusher-error').html("{{translate('Please set up your Pusher configuration first!')}}")

           toastr("{{translate('Please set up your Pusher configuration first!')}}",'danger')
        }


    //user chat click event
    $(document).on('click','.user-chat-section',function(e){

        userId = $(this).attr('data-id');

        anonymous = $(this).attr('data-anonymous');

        if(anonymous){
            userId = null;
        }

        $('.nav-item .chat-active').removeClass('chat-active');

        $('.no-message').addClass('d-none')

        $(this).removeClass('unread-msg-user');

        get_user_chat(userId ,loader,anonymous)

        $(this).addClass('chat-active')
    })

    //get user chat method
    function get_user_chat(userId ,preLoder ,anonymous){

        $.ajax({

            method:"POST",
            url:"{{ route('admin.chat.user') }}",

            beforeSend: function() {
                if(preLoder){
                    $("#elmLoader").removeClass('d-none');
                }
            },
            data:{
                "_token":"{{csrf_token()}}",

                'user_id':userId,

                "anonymous" : anonymous
            },
            dataType:'json'
        }).then(response=>{

            if(preLoder){
                $("#elmLoader").addClass('d-none');
            }
            if(response.status){

                var prefix = "-"
                if(anonymous){
                    prefix = "-anonymous-"
                }

                $('#chat-head').html(response.chat_header_html)

                $('#chat-conversation').html(response.chat_html)

                $('.chat-form').removeClass('d-none');

                $('#chat-user-id').val(response.user_id)


                $("#anonymous").val(response.anonymous)


                $(`.unread-notifications${prefix}${response.user_id}`).addClass('d-none')

                $(`.unread-message-counter${prefix}${response.user_id}`).html('');

                if(response.is_blocked){
                    $('.blocked-message').removeClass('d-none');
                    $('.chat-input').addClass('d-none')
                    $('#send-message').addClass('d-none')


                }else{
                    $('.blocked-message').addClass('d-none');
                    $('#send-message').removeClass('d-none')
                    $('.chat-input').removeClass('d-none')
                }

                scroll_bottom();
            }
            else {
                $('.no-message').removeClass('d-none')

            }

        }).catch(error => {

        })

    }

    //send message to agent
    $(document).on('click','#send-message',function(e){

        e.preventDefault()
        var submitButton = $(e.originalEvent.submitter);
        var data =  $('#chatinput-form').serialize();

        var $btnHtml ='<i class="ri-send-plane-2-fill align-bottom"></i>';

        $.ajax({
            method: 'POST',

            url:"{{ route('admin.chat.send.message') }}",
            beforeSend: function() {
                    $('#send-message').html(`<div class="ms-1 spinner-border spinner-border-sm text-white note-btn-spinner " role="status">
                            <span class="visually-hidden"></span>
                        </div>`);
                },
            data: data,
            dataType:'json',
            success: function (response) {
                $('#send-message').html($btnHtml);
                scroll_bottom()
                $('#chat-conversation').html(response.chat_html)
                $('.chat-input').val('');

                if(!response.status){
                    toastr(response.message,'danger')
                }
            },
            error: function (error){
                    if(error && error.responseJSON){
                        if(error.responseJSON.errors){
                            for (let i in error.responseJSON.errors) {
                                toastr(error.responseJSON.errors[i][0],'danger')
                            }
                        }
                        else{
                            if((error.responseJSON.message)){
                                toastr(error.responseJSON.message,'danger')
                            }
                            else{
                                toastr( error.responseJSON.error,'danger')
                            }
                        }
                    }
                    else{
                        toastr(error.message,'danger')
                    }
                },

            complete: function() {
              $('#send-message').html($btnHtml);

            },
        })

    });

    //send message  method


    //delete a message event
    $(document).on('click','.delete-message',function(e){

        var user = $(this).attr('data-user-id');
        var anonymousId = $(this).attr('data-anonymous');

        var message_id = $(this).attr('data-message-id');
        delete_message(user,message_id,anonymousId)
    })

    //delete message method
    function delete_message(user , message_id , anonymousId){

        $.ajax({
            method: 'POST',
            url:"{{ route('admin.chat.delete.message') }}",
            data: {
                "_token":"{{csrf_token()}}",
                'user_id' :user,
                'anonymous_id' :anonymousId,
                'message_id' :message_id,
            },
            dataType:'json',
            success: function (response) {
                if(response.status){
                    $('#chat-conversation').html(response.chat_html)
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


        $.ajax({
            method: 'POST',

            url:"{{ route('admin.chat.block.user')}}",
            data:  $('#block-form').serialize(),
            dataType:"json",
            success: function (response) {

                var status ='danger';
                if(response.status){
                    status ='success';

                    $('.blocked-message').addClass('d-none');
                    $('.chat-input').removeClass('d-none')

                    $('#send-message').removeClass('d-none')

                }else{

                    $('.blocked-message').removeClass('d-none');
                    $('.chat-input').addClass('d-none')

                    $('#send-message').addClass('d-none')

                }
                toastr(response.message,status)
            },
            error: function (response) {
                toastr('{{translate("Validation Error")}}','danger')
            },
        });

        e.preventDefault()
    })


    //mute user event start
    $(document).on('click',"#mute-user",function(e){
        var form = $('#mute-form')[0];
        var data =  new FormData(form)
        mute_user(data)
        e.preventDefault()
    })

    //mute user method start
    function mute_user(data){

        $.ajax({
            method: 'POST',
            url:"{{ route('admin.chat.mute.user')}}",
            data: data,
            processData: false,
            contentType: false,
            async: false,
            success: function (response) {
                var response = JSON.parse(response)
                var status ='danger';
                $('#chat-head').html(response.chat_header_html)
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

    $(document).on('click','#assignBtn',function(e){

        var id         = $(this).val()
        var anonymous  = $(this).attr('data-anonymous')

        $('#agentId').val(id)
        $('#chatId').val(anonymous)
        $('#assignForm').submit();

    })

  </script>
@endpush
