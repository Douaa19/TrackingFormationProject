<!doctype html>
<html lang="{{app()->getLocale()}}" data-layout-default="vertical" data-sidebar-size="lg" data-topbar="light" data-sidebar="dark"
@if(request()->routeIs('admin.ticket.list') || request()->routeIs('admin.ticket.view')) class="layout-full-width" @endif>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{@site_settings("site_name")}} - {{@translate($title)}}</title>
    <meta name="csrf-token" content="{{csrf_token()}}"/>

    <link rel="shortcut icon" href="{{ getImageUrl(getFilePaths()['site_logo']['path']."/".site_settings('site_favicon')) }}" >
    <link href="{{asset('assets/global/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/global/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/global/css/root.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/global/css/style.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/backend/css/custom.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/global/css/toastr.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{asset('assets/global/css/bootstrap-icons.min.css') }}">
    <link href="{{asset('assets/global/css/select2.min.css')}}" rel="stylesheet"/>
    <link href="{{asset('assets/global/css/select2.css')}}" rel="stylesheet" />


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
        $pusher_settings          =  json_decode(site_settings('pusher_settings'),true);
        $notificatios_settings    = auth_user()->notification_settings ? json_decode(auth_user()->notification_settings,true) : [];
        $browser_notificatios_new_ticket = App\Enums\StatusEnum::false->status();
        $browser_notificatios_new_chat = App\Enums\StatusEnum::false->status();
        $admin_assign_ticket = App\Enums\StatusEnum::false->status();
        $agent_assign_ticket = App\Enums\StatusEnum::false->status();
        $agent_ticket_reply = App\Enums\StatusEnum::false->status();
        $user_reply_admin = App\Enums\StatusEnum::false->status();
        $user_reply_agent = App\Enums\StatusEnum::false->status();


        if(isset($notificatios_settings['browser']['new_chat'])){
           $browser_notificatios_new_chat = $notificatios_settings['browser']['new_chat'];
        }
        if(isset($notificatios_settings['browser']['new_ticket'])){
           $browser_notificatios_new_ticket = $notificatios_settings['browser']['new_ticket'];
        }
        if(isset($notificatios_settings['browser']['admin_assign_ticket'])){
           $admin_assign_ticket = $notificatios_settings['browser']['admin_assign_ticket'];
        }
        if(isset($notificatios_settings['browser']['agent_assign_ticket'])){
           $agent_assign_ticket = $notificatios_settings['browser']['agent_assign_ticket'];
        }
        if(isset($notificatios_settings['browser']['agent_ticket_reply'])){
           $agent_ticket_reply = $notificatios_settings['browser']['agent_ticket_reply'];
        }
        if(isset($notificatios_settings['browser']['user_reply_admin'])){
           $user_reply_admin = $notificatios_settings['browser']['user_reply_admin'];
        }
        if(isset($notificatios_settings['browser']['user_reply_agent'])){
           $user_reply_agent = $notificatios_settings['browser']['user_reply_agent'];
        }

   @endphp

    <div id="layout-container">
        @include('admin.partials.topbar')
        @include('admin.partials.sidebar')
        <div class="vertical-overlay"></div>

        <div class="main-container">
            <div class="page-content">
                @yield('content')
            </div>

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            {{ translate('App Version') }}  | {{site_settings(key : "app_version",default :1.0)}}
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                              {{site_settings('copy_right_text')}}
                            </div>
                        </div>
                    </div>
                </div>
            </footer>

            @include('admin.partials.ai_modal')
        </div>

        <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
            <i class="ri-arrow-up-line"></i>
        </button>

        <audio id="ticket-audio" src="{{asset('assets/global/audio/notifications.mp3')}}" preload="auto"></audio>

        <div class="loader-wrapper update-loader d-none">

            <div class="loader">

              <div class="mask"></div>
              <div class="mask2"></div>

            </div>
            <div class="warning-text">
                {{translate("Do not close window while proecessing")}}
                 <span class="dots-container  ms-2">
                        <span class="dot"></span>
                        <span class="dot"></span>
                        <span class="dot"></span>
                 </span>

            </div>
        </div>

    </div>

    <script src="{{asset('assets/global/js/jquery-3.7.1.min.js')}}"></script>
    <script src="{{asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
    <script src="{{asset('assets/libs/feather-icons/feather.min.js')}}"></script>
    <script src="{{asset('assets/global/js/pages/plugins/lord-icon-2.1.0.js')}}"></script>
    <script src="{{asset('assets/global/js/layout.js')}}"></script>
    <script src="{{asset('assets/libs/apexcharts/apexcharts.min.js')}}"></script>
    <script src="{{asset('assets/global/js/toastify-js.js')}}"></script>
    <script src="{{asset('assets/global/js/helper.js')}}"></script>
    <script src="{{asset('assets/global/js/app.js')}}"></script>
    <script src="{{asset('assets/global/js/pusher.min.js')}}"></script>
    <script src="{{asset('assets/global/js/push.js')}}"></script>
    <script src="{{asset('assets/global/js/select2.min.js')}}"></script>


    <script>
        "use strict";

        var pusher = new Pusher("{{$pusher_settings['app_key']}}", {
           cluster: "{{$pusher_settings['app_cluster']}}"
        });

        var channel = pusher.subscribe("{{$pusher_settings['chanel']}}");

        channel.bind("{{$pusher_settings['event']}}", function(data) {


            if(data){
                var icon = '{{ getImageUrl(getFilePaths()["site_logo"]["path"]."/".site_settings("site_favicon")) }}';
                var message = "Demo Message";
                var route = "{{route('admin.dashboard')}}";
                var title = "{{translate('Hello '). auth_user()->name }}"
                if(data.notifications_data){

                    message = data.notifications_data.data['messsage'];
                    route = data.notifications_data.data['route']

                    if((data.notifications_data.notification_for == '{{App\Enums\NotifyStatus::SUPER_ADMIN->value}}' || data.notifications_data.notification_for == '{{App\Enums\NotifyStatus::AGENT->value}}' ) && data.notifications_data.notify_id == "{{auth_user()->id}}"){
                        if ((data.notifications_data.for == "new_ticket" && "{{$browser_notificatios_new_ticket}}" == "{{App\Enums\StatusEnum::true->status()}}") || (data.notifications_data.for == "new_chat" && "{{$browser_notificatios_new_chat}}" == "{{App\Enums\StatusEnum::true->status()}}")
                        || (data.notifications_data.for == "admin_assign_ticket" && "{{$admin_assign_ticket}}" == "{{App\Enums\StatusEnum::true->status()}}") || (data.notifications_data.for == "agent_assign_ticket" && "{{$agent_assign_ticket}}" == "{{App\Enums\StatusEnum::true->status()}}")||(data.notifications_data.for == "agent_ticket_reply" && "{{$agent_ticket_reply}}" == "{{App\Enums\StatusEnum::true->status()}}")
                        ||
                        (data.notifications_data.for == "user_reply_admin" && "{{$user_reply_admin}}" == "{{App\Enums\StatusEnum::true->status()}}") ||
                        (data.notifications_data.for == "user_reply_agent" && "{{$user_reply_agent}}" == "{{App\Enums\StatusEnum::true->status()}}")
                        ) {
                          
                            send_browser_notification(title, icon, message, route);
                        }

                        if(data.notifications_data.play_audio){
                            $('#ticket-audio').get(0).play();
                        }
                    }
                }

            }

        });


            //file upload preview
        $(document).on('change', '.img-preview', function (e) {
         
            var file = e.target.files[0];
            var size = ($(this).attr('data-size')).split("x");
            $(this).closest('div').find('.image-preview-section').html(
                `<img alt='${file.type}' class="mt-2 rounded  d-block"
                    style="width:${size[0]}px;height:${size[1]}px;"
                    src='${URL.createObjectURL(file)}'>`
            );
            e.preventDefault();
        })
        


        $(document).on('click','.read-notification',function(e){

            var href = $(this).attr('data-href')
            var id = $(this).attr('id')
            readNotification(href,id)
            e.preventDefault()
        })

        function readNotification(href,id){

            $.ajax({
                method:'post',

                url: "{{route('admin.read.notification')}}",
                data:{

                    "_token": "{{ csrf_token()}}",
                    'id':id
                },
                dataType: 'json'
                }).then(response =>{
                if(!response.status){
                    toastr(response.message,'danger')
                }
                else{
                    window.location.href = href
                }}).fail((jqXHR, textStatus, errorThrown) => {
                    toastr(jqXHR.statusText, 'danger');
                });
        }

        $(document).on('click', '.status-update', function (e) {

            const id = $(this).attr('data-id')
            const key = $(this).attr('data-key')
            var column = ($(this).attr('data-column'))
            var route = ($(this).attr('data-route'))
            var modelName = ($(this).attr('data-model'))
            var status = ($(this).attr('data-status'))
            const data = {

                'id': id,
                'model': modelName,
                'column': column,
                'status': status,
                'key': key,
            }
            updateStatus(route, data)
        })

        function updateStatus(route, data) {

            var responseStatus;
            $.ajax({
                method: 'POST',
                url: route,
                data: {
                    "_token" :"{{csrf_token()}}",
                    data
                },
                dataType: 'json',
                success: function (response) {

                    if (response) {
                        var status =  'danger'
                        if(response.status)
                        {
                            status =  'success'
                        }
                        toastr(response.message,status)
                        if(response.reload){
                            location.reload()
                        }

                    } else {
                        toastr("{{translate('This Function is Not Avaialbe For Website Demo Mode')}}",'danger')
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
                }
            })
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



		$(document).on('submit', '.settingsForm', function(e) {
            e.preventDefault();

            var data = new FormData(this);

            var route = $(this).attr('data-route');
            var submitButton = e.originalEvent ? $(e.originalEvent.submitter) : null;

            var submitButtonExists = submitButton && submitButton.length > 0;

            $.ajax({
                method: 'post',
                url: route,
                dataType: 'json',
                cache: false,
                processData: false,
                contentType: false,
                data: data,
                beforeSend: function() {
                    if (submitButtonExists) {
                        submitButton.find(".note-btn-spinner").remove();
                        submitButton.append(`<div class="ms-1 spinner-border spinner-border-sm text-white note-btn-spinner" role="status">
                            <span class="visually-hidden"></span>
                        </div>`);
                    }

                    if ($('#add-ticket-field').hasClass('show')) {
                        $('#cardloader').removeClass('d-none');
                    }
                },
                success: function(response) {
                    if ($('#add-ticket-field').hasClass('show')) {
                        $('#add-ticket-field').modal('hide');
                    }

                    if (response.cards_html) {
                        $('#ticketAddform').trigger("reset");
                        $('#ticketInputCards').html(response.cards_html);
                    }

                    if (response.errors) {
                        $.each(response.errors, function(key, value) {
                            toastr(value, 'danger');
                        });
                    }

                    if (response.message) {
                        var className = response.status ? 'success' : 'danger';
                        toastr(response.message, className);
                    }
                },
                error: function(error) {
                    if (error && error.responseJSON) {
                        if (error.responseJSON.errors) {
                            for (let i in error.responseJSON.errors) {
                                toastr(error.responseJSON.errors[i][0], 'danger');
                            }
                        } else {
                            toastr(error.responseJSON.message || error.responseJSON.error, 'danger');
                        }
                    } else {
                        toastr(error.message, 'danger');
                    }
                },
                complete: function() {
                    if (submitButtonExists) {
                        submitButton.find(".note-btn-spinner").remove();
                    }
                    $('#cardloader').addClass('d-none');
                },
            });
        });



        var aiTexarea = '';
        var textEditor = '';

        $(".ai-lang").select2({
			placeholder:"{{translate('Select Country')}}",
			dropdownParent: $("#aiModal"),
		})


        $(document).on('submit','#AiForm',function(e){

            var formData = $(this).serialize();
            var modal =  $('#aiModal');
            $.ajax({
                url: "{{route('ai.content')}}",
                type: "post",
                data:formData,
                dataType:'json',
                beforeSend: function() {

                    modal.find('.ai-content-generate').addClass("d-none")
                    modal.find('.insert-result').addClass("d-none")
                    modal.find('.ai-modal-footer').addClass("d-none")
                    modal.find('.ai-content-loader').removeClass("d-none")

                },
                success:(function (response) {

                    if(response.status){
                        modal.find('.ai-result').val(response.message)
                        modal.find('.result-section').removeClass("d-none")
                        modal.find('.ai-modal-footer').removeClass("d-none")
                        modal.find('.insert-result').removeClass("d-none")
                    }
                    else{
                        modal.find('.ai-content-generate').removeClass("d-none")
                        toastr(response.message,'danger')
                    }

                }),
                error:(function (error) {
                    modal.find('.ai-content-generate').removeClass("d-none")
                    if(error && error.responseJSON){
                        if(error.responseJSON.message){
                            toastr(error.responseJSON.message,'danger')
                        }
                        else{
                            for (let i in error.responseJSON.errors) {
                                toastr(error.responseJSON.errors[i][0],'danger')
                            }
                        }

                    }
                    else{
                        toastr("{{translate('This Function is Not Avaialbe For Website Demo Mode')}}",'danger')
                    }
                }),
                complete: function() {

                    modal.find('.ai-content-loader').addClass("d-none")

                },
            })

            e.preventDefault()
        })


        @if(site_settings("open_ai") == App\Enums\StatusEnum::true->status())
            $('textarea.form-control').on('input', function() {

                if(!$(this).hasClass("ai-prompt-input")){
                    var words = $(this).val().trim().split(/\s+/).length;

                    if ($(this).next('.ai-generator-btn').length === 0) {
                        if (words >= 2) {
                            $(this).after(`
                                        <button type="button" class="ai-generator-btn mt-3 ai-modal-btn" >
                                            <span class="ai-icon btn-success waves ripple-light">
                                                    <span class="spinner-border d-none" aria-hidden="true"></span>

                                                    <i class="ri-robot-line"></i>
                                            </span>

                                            <span class="ai-text">
                                                {{translate('Generate With AI')}}
                                            </span>
                                        </button>
                        `);
                        }
                    } else {
                        if (words < 2) {
                            $(this).next('.ai-generator-btn').remove();
                        }
                    }
                }
            });
        @endif

        function removeTags(str) {
            if ((str === null) || (str === ''))
                return false;
            else
                str = str.toString();
                str = str.replace(/^[\s\n]+/, '');
                str = str.replace(/(<([^>]+)>|&nbsp;|)/ig, '');

                return str.trim();
        }


        $(document).on("input", '.custom-prompt-option', function (e) {
            var modal = $('#aiModal');
            var oldPrompt = modal.find('.custom-prompt').attr('data-value');
            var prompt = modal.find('.custom-prompt').val();
            var inputText = $(this).val().trim();

            if (prompt && inputText) {
                var lines = prompt.split('\n');
                var basePrompt = lines[0];
                var updatedPrompt = basePrompt + '\n' + inputText;
                modal.find('.custom-prompt').val(updatedPrompt);
            } else if (inputText) {
                modal.find('.custom-prompt').val(inputText);
            }
        });


        $(document).on("click",'.ai-modal-btn',function(e){

            var modal =  $('#aiModal');
            modal.find('.custom-prompt-option').val('')
            modal.find('.custom-prompt').val('')

            modal.find(".translate-section").addClass('d-none');
            modal.find(".ai-options").addClass('d-none');
            modal.find(".default-section").removeClass('d-none');

            aiTexarea  =   $(this).prev('textarea');
            textEditor = '';

            var textareaValue =  $(this).prev('textarea').val()

            if($(this).closest('.text-editor-area').length > 0){
                textEditor =  $(this).closest('.text-editor-area').find('.summernote');
                var textareaValue = $(this).closest('.text-editor-area').find('.summernote').summernote('code');
                textareaValue =  removeTags(textareaValue);
            }


            if(textareaValue && textareaValue != "" &&  textareaValue != " "){
                modal.find('.custom-prompt').val((textareaValue))
                modal.find('.custom-prompt').attr('data-value',(textareaValue))
            }

            modal.find('.insert-result').addClass("d-none")
            modal.find('.ai-content-generate').removeClass("d-none")
            modal.find('.ai-modal-footer').removeClass("d-none")
            modal.find('.ai-content-loader').addClass("d-none")
            modal.find('.result-section').addClass("d-none")
            modal.find(".ai-lang").select2({
                placeholder:"{{translate('Select Language')}}",
                dropdownParent: $("#aiModal"),
	     	})

             $('#language').val('').trigger('change');

            modal.modal('show');


        })


        const aiMdoal =document.querySelector("#aiModal")
        if (aiMdoal) {
            const moreOption        = aiMdoal.querySelector("#more-option");
            const translateOption   = aiMdoal.querySelector("#translate-option");
            const aiOptions         = aiMdoal.querySelector(".ai-options");
            const translateSection  = aiMdoal.querySelector(".translate-section");
            const btnClose          = aiMdoal.querySelector(".btn-close");

            moreOption.addEventListener("click",()=>{
                moreOption.parentElement.classList.add("d-none");
                aiOptions.classList.remove("d-none")
            })
            translateOption.addEventListener("click",()=>{
                translateOption.parentElement.classList.add("d-none");
                translateSection.classList.remove("d-none")
            })

            btnClose.addEventListener("click",()=>{
                moreOption.parentElement.classList.remove("d-none");
                aiOptions.classList.add("d-none")
                translateOption.parentElement.classList.remove("d-none");
                translateSection.classList.add("d-none")
            })

            const optionCloser = document.querySelectorAll(".ai-option-closer");
            optionCloser.forEach((e) => {
                e.addEventListener("click",()=>{
                        moreOption.parentElement.classList.remove("d-none");
                        aiOptions.classList.add("d-none")
                        translateOption.parentElement.classList.remove("d-none");
                        translateSection.classList.add("d-none")
               })
            })
        }




        $(document).on('click','.copy-content',function(e){

            var modal =  $('#aiModal');

            var textarea =  modal.find('.ai-result');
            textarea.select();
            document.execCommand('copy');
            window.getSelection().removeAllRanges();
            toastr("{{translate('Text copied to clipboard!')}}", 'success');

        });

        $(document).on('click','.download-text',function(e){
            var modal =  $('#aiModal');

            var content =  modal.find('.ai-result').val();

            var blob = new Blob([content], { type: 'text/html' });
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = 'downloaded_content.html';

            document.body.appendChild(link);
            link.click();

            document.body.removeChild(link);

        });


        $(document).on('click','.option-btn',function(e){


            var key = $(this).attr('name');
            var value = $(this).attr('value');
            var modal =  $('#aiModal');
            modal.find('.ai-content-option').attr('name',key)
            modal.find('.ai-content-option').val(value)


        });

        $(document).on('click','.insert-result',function(e){

            var modal  =  $('#aiModal');
            var result = modal.find('.ai-result').val()
            if(textEditor != ''){
                textEditor.summernote('code',result);
            }else{
                aiTexarea.val(result)
            }

        });


        $(document).on('change','.ai-lang',function(e){

            if(!$(this).val() =='' || !$(this).val() ==' '){
                $('#AiForm').submit()

            }
            e.preventDefault();
        });






    </script>

    @include('partials.notify')
    @stack('script-include')
    @stack('script-push')
</body>
</html>
