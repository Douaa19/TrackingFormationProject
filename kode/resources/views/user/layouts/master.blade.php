<!doctype html>
<html lang="{{app()->getLocale()}}" data-layout-default="vertical" data-sidebar-size="lg" data-topbar="light" data-sidebar="dark"
@if(request()->routeIs('user.ticket.list') || request()->routeIs('user.ticket.view')) class="layout-full-width" @endif>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @if(@site_settings("same_site_name") ==  App\Enums\StatusEnum::true->status())
              {{@site_settings("site_name")}}
            @else
              {{@site_settings("user_site_name")}}
        @endif - {{@translate($title)}}</title>
    <meta name="csrf-token" content="{{csrf_token()}}" />

    <link rel="shortcut icon" href="{{ getImageUrl(getFilePaths()['site_logo']['path']."/".site_settings('site_favicon')) }}" >
    <link href="{{asset('assets/global/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/global/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/global/css/root.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/global/css/style.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/global/css/operating-hour.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/backend/css/custom.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/global/css/toastr.css')}}" rel="stylesheet" type="text/css" />

    @include('admin.partials.theme')

    @stack('style-include')
    @stack('styles')

    <style>
        .line-clamp-1{
            overflow: hidden;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 1;
            text-overflow: ellipsis;
        }
        .limit-text{
            width: 25ch;
            display: inline-block !important;
        }
    </style>
</head>

<body>

    @php
       $pusher_settings      =  json_decode(site_settings('pusher_settings'),true);
       $notificatios_settings = auth_user('web')->notification_settings ? json_decode(auth_user('web')->notification_settings,true) : [];
       $browser_notificatios_for_chat = App\Enums\StatusEnum::false->status();
       $ticket_reply = App\Enums\StatusEnum::false->status();
       if(isset($notificatios_settings['browser']['new_chat'])){
          $browser_notificatios_for_chat =    $notificatios_settings['browser']['new_chat'];
       }
       if(isset($notificatios_settings['browser']['ticket_reply'])){
          $ticket_reply =    $notificatios_settings['browser']['ticket_reply'];
       }

    @endphp

    <div id="layout-container">
        @include('user.partials.topbar')
        @include('user.partials.sidebar')
        <div class="vertical-overlay"></div>
        <div class="main-container">
            <div class="page-content">
                @yield('content')
            </div>

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            {{ date('Y') }}  | {{site_settings('site_name')}}
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                              {{site_settings('copy_right_text')}}
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>


        <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
            <i class="ri-arrow-up-line"></i>
        </button>

    </div>

    <script src="{{asset('assets/global/js/jquery-3.7.1.min.js')}}"></script>
    <script src="{{asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
    <script src="{{asset('assets/libs/feather-icons/feather.min.js')}}"></script>
    <script src="{{asset('assets/global/js/pages/plugins/lord-icon-2.1.0.js')}}"></script>
    <script src="{{asset('assets/global/js/layout.js')}}"></script>
    <script src="{{asset('assets/global/js/toastify-js.js')}}"></script>
    <script src="{{asset('assets/libs/apexcharts/apexcharts.min.js')}}"></script>
    <script src="{{asset('assets/global/js/helper.js')}}"></script>
    <script src="{{asset('assets/global/js/app.js')}}"></script>
    <script src="{{asset('assets/global/js/pusher.min.js')}}"></script>
    <script src="{{asset('assets/global/js/push.js')}}"></script>

    @include('partials.notify')
    @stack('script-include')
    @stack('script-push')

    <script>

    "use strict";


        var pusher = new Pusher("{{$pusher_settings['app_key']}}", {
           cluster: "{{$pusher_settings['app_cluster']}}"
        });

        var channel = pusher.subscribe("{{$pusher_settings['chanel']}}");
        channel.bind("{{$pusher_settings['event']}}", function(data) {
            var icon = '{{ getImageUrl(getFilePaths()["site_logo"]["path"]."/".site_settings("site_favicon")) }}';
            var message = "Demo Message";
            var title = "{{translate('Hello '). auth_user('web')->name }}"
            var route = "{{route('user.dashboard')}}";
            if(data.notifications_data){

                message = data.notifications_data.data['messsage']
                if(data.notifications_data.data.hasOwnProperty('route')){
                    route =  data.notifications_data.data['route']
                }

                if(data.notifications_data.notification_for == '{{App\Enums\NotifyStatus::USER->value}}' && data.notifications_data.notify_id == "{{auth_user('web')->id}}"){
                    if( (data.notifications_data.for = "new_chat" &&  "{{$browser_notificatios_for_chat}}" == "{{App\Enums\StatusEnum::true->status()}}" ) || (data.notifications_data.for = "ticket_reply" && "{{$ticket_reply}}" == "{{App\Enums\StatusEnum::true->status()}}" )  ){
                        if(data.notifications_data.for =="new_chat"){
                            route = "{{route('user.chat.list')}}";
                        }

                        send_browser_notification(title,icon,message, route);
                    }
                }
            }

        });



        // read notification
        $(document).on('click','.read-notification',function(e){
            var href = $(this).attr('data-href')
            var id = $(this).attr('id')
            readNotification(href,id)
            e.preventDefault()
        })


        function readNotification(href,id){

            $.ajax({
                method:'post',
                url: "{{route('user.read.notification')}}",
                data:{
                    "_token":"{{csrf_token()}}",
                    'id':id
                },
                dataType: 'json'
                }).then(response =>{
                if(!response.status){
                    toastr(response.message,'danger')
                }
                else{
                    window.location.href = href
                }

            });
        }


        $(document).on('click', '.note-btn.dropdown-toggle', function (e) {

            var $clickedDropdown = $(this).next();
            $('.note-dropdown-menu.show').not($clickedDropdown).removeClass('show');
            $clickedDropdown.toggleClass('show');
            e.stopPropagation();

        });



        $(document).on('click', function(e) {
            if (!$(e.target).closest('.note-btn.dropdown-toggle').length) {
                $(".note-dropdown-menu").removeClass("show");
            }
        });


    </script>
</body>
</html>
