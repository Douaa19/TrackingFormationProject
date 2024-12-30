@extends('frontend.layouts.master')

@push('styles')

    <style>

            .select2-container .select2-selection--multiple {
                min-height: calc(1.5em + 1rem + 2px);
                border: 1px solid #ddd !important;
                background-color: #fff !important;
            }

            .select2-container--default .select2-results>.select2-results__options {
                max-height: 200px !important;
                overflow-y: auto !important;
                z-index: 9999999 !important;
                position: relative !important;
                background: #fff !important;
                border: 1px solid #eee !important;
            }

            .select2.select2-container {
                width: 100% !important;
                border: 1px solid #ddd;
            }

            .select2-container--default .select2-search--dropdown .select2-search__field {
                outline: none;
                border: 1px solid #ddd !important;
                background-color: #FFF !important;
                color: var(--text-primary);
                border-radius: 0.25rem;
            }

            .select2-container--default .select2-search--dropdown {
                padding: 10px;
                background-color: #fff !important;
                border: 1px solid #eee !important;
            }


            .select2-container--open
                .select2-selection--single
                .select2-selection__arrow
                b {
                border-color: transparent transparent #222 transparent !important;
                border-width: 0 6px 6px 6px !important;
            }

    </style>

@endpush
  
@push('style-include')
 <link href="{{asset('assets/global/css/summnernote.css')}}" rel="stylesheet" type="text/css" />
 <link href="{{ asset('assets/global/css/select2.min.css') }}" rel="stylesheet" />
 <link href="{{ asset('assets/global/css/select2.css') }}" rel="stylesheet" />
@endpush

@section('content')
@include('frontend.section.breadcrumb')
<section class="pt-100 pb-100">
    <div class="container">

        @php
            $pusher_settings = json_decode(site_settings('pusher_settings'),true);
            $yes             = App\Enums\StatusEnum::true->status();
            $no              = App\Enums\StatusEnum::false->status();
        @endphp

          <div class="row gy-5">
    

            <div class="col-lg-8  {{session()->has("ticket_created") ? "mx-auto" : "ps-lg-4" }}">
                <form action="{{route('ticket.store')}}" class="card-effect ticket-form form" method="post"  enctype="multipart/form-data">
                    @if (!session()->has("ticket_created"))
                      <h3 class="mb-4">{{translate("Create Ticket Here")}}</h3>
                    @endif

                    @csrf
                        @if(session()->has("ticket_created"))
                            <div class="ticket-notification">
                                <div class="row gy-5 d-flex justify-content-center">
                                        <div class="col-sm-8 text-start">
                                                @php echo session()->get("ticket_created") @endphp
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="text-center">
                                                <img src="{{asset('/assets/images/frontend/ticket.gif')}}" alt="ticket.gif">
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        @else
                            @php
                                $custom_feild_counter = 0;
                                $custom_rules = [];

                                if(site_settings(key:'ticket_department',default:0) == 1){

                                    $newField = [
                                        "labels" => translate("Product"),
                                        "type" => "select",
                                        "width" => "COL_12",
                                        "required" => "1",
                                        "visibility" => "1",
                                        "placeholder" => translate("Select product"),
                                        "default" => "1",
                                        "multiple" => "0",
                                        "name" => "department_id"
                                    ];

                                    $ticket_fields = collect($ticket_fields);
                                    $index = ($ticket_fields)->search(function ($item, $key) {
                                        return $item['name'] === 'category';
                                    });

                                    if ($index !== false) {
                                        $ticket_fields->splice($index, 0, [$newField]);
                                    }
                                    $ticket_fields  =  ($ticket_fields->all());
                                }
                               @endphp

                            <div class="row">


                                @foreach($ticket_fields as $ticket_field)

                                    @php

                                        $width           = Arr::get(@$ticket_field,'width',App\Enums\FieldWidth::COL_12->value);

                                        $col             = str_replace('COL_','',  $width);

                                        $field_name      = Arr::get(@$ticket_field,'name','default');

                                        $user            = auth_user('web');

                                        $hidden          = $user &&  ($field_name == 'name' || $field_name == 'email') ? true : false;

                                        $visibility      = Arr::get($ticket_field , "visibility", null);

                                    @endphp
                                    @if(!$hidden &&  ($visibility ==  $yes || is_null($visibility)))
                                        <div class="col-md-{{$col}}">
                                            <div class="form-inner">
                                                <label for="{{$loop->index}}" class="form-label">
                                                    {{$ticket_field['labels']}} @if($ticket_field['required'] ==   $yes || $ticket_field['type'] == 'file')

                                                    @endif
                                                </label>
                                                <span class="{{ $ticket_field['required'] ==   $yes ? 'text-danger' : 'text-muted' }} fs-12">
                                                    {{ $ticket_field['required'] ==   $yes ? "*" : "" }}

                                                    @if($ticket_field['type'] == 'file')
                                                        ({{ $ticket_field['placeholder'] }} {{ site_settings("max_file_upload") }} {{ translate('files') }} )
                                                    @endif
                                                </span>


                                            @if($ticket_field['type'] == 'select' && $field_name ==  "department_id")

                                         
                                            <select @if(site_settings(key:'envato_verification',default:0) == 1) class="product-option" @endif id="{{$loop->index}}" {{$ticket_field['required'] == $yes ? "required" :""}}  name="ticket_data[{{ $field_name }}]" >
                                                <option value="">{{$ticket_field['placeholder']}}</option>
                                                @foreach($departments as $department)
                                                    <option @if(site_settings(key:'envato_verification',default:0) == 1) 
                                                            @if( ($department->latest_purchase &&      @$department->latest_purchase->purchase_code) || 
                                                            $purchaseCode)
                                                               data-purchase_code = '{{@$department->latest_purchase->purchase_code}}'
                                                            @endif
                                                            data-envato-item-id="{{ $department->envato_item_id }}" 
                                                            data-envatopayload="{{ $department->envato_payload && $department->envato_item_id ? 'envato_product' : null }}" 
                                                            @endif
                                                            {{ old('ticket_data.department_id') == $department->id || ($selectedItemId && $department->envato_item_id == $selectedItemId) ? 'selected' : "" }}
                                                            value="{{$department->id}}">
                                                        {{($department->name)}}
                                                    </option>
                                                @endforeach
                                            </select>
                                            
                                            @if(site_settings(key:'envato_verification',default:0) == 1)
                                    
                                                <div class="mt-2 d-none">
                                                    <input type="text" id="envato_purchase_key" name="ticket_data[envato_purchase_key]"  value="{{  old('ticket_data.envato_purchase_key') ?? $purchaseCode }}" placeholder="{{translate('Enter envato purchase key')}}">
                                                </div>
                                            @endif

                                            @elseif($ticket_field['type'] == 'select' && $field_name ==  "category")

                                                    <select id="{{$loop->index}}" {{$ticket_field['required'] ==   $yes ? "required" :""}}  name="ticket_data[{{ $field_name }}]" >
                                                        <option value="">{{$ticket_field['placeholder']}}</option>

                                                        @foreach($categories as $category)
                                                            <option
                                                            {{old('ticket_data.'.$field_name) == $category->id ? 'selected' :"" }}
                                                            value="{{$category->id}}">
                                                                {{get_translation($category->name)}}
                                                            </option>
                                                        @endforeach

                                                    </select>
                                            @elseif($ticket_field['type'] == 'select' && $field_name ==  "priority")

                                                    <select id="{{$loop->index}}" {{$ticket_field['required'] ==   $yes ? "required" :""}}  name="ticket_data[{{ $field_name }}]" >
                                                        <option value="">{{$ticket_field['placeholder']}}</option>

                                                        @foreach($priorites as $priority)
                                                            <option
                                                            {{old('ticket_data.'.$field_name) == $priority->id ? 'selected' :"" }}
                                                            value="{{$priority->id}}">
                                                                {{($priority->name)}}
                                                            </option>
                                                        @endforeach

                                                    </select>


                                            @elseif(in_array( $ticket_field['type'] ,['select','checkbox','radio']) &&  Arr::has($ticket_field,'option'))
                                        
                                                        @php

                                                          $inputType     =  $ticket_field['type'];
                                                          $inputname     =  "ticket_data[$field_name][]";

                                                          $isMultiple    =  Arr::get($ticket_field,'multiple' ,$no);

                                                          if($isMultiple == $no)  $inputname =   "ticket_data[$field_name]";

                                                
                                                        
                                                        @endphp

                                                       @if($inputType ==  'select')
                                                            <select id="{{ $loop->index }}"
                                                                {{ $ticket_field['required'] == $yes ? 'required' : '' }}
                                                                name="{{ $inputname }}" {{   $isMultiple == $yes ? "multiple" :"" }}  class="select2" >

                                                                <option disabled value="">{{ $ticket_field['placeholder'] }}</option>

                                                                @foreach ($ticket_field['option'] as $key => $option)
                                                                    <option value="{{ @$ticket_field['option_value'][$key] }}" >
                                                                        {{ $option }}
                                                                    </option>
                                                                @endforeach

                                                            </select>
                                                        @elseif($inputType ==  'checkbox')

                                                            <div id="{{ $loop->index }}"
                                                                {{ $ticket_field['required'] == $yes ? 'required' : '' }}>
        
                                                                @foreach ($ticket_field['option'] as $key => $option)
                                                                   @php 
                                                                      $id =  rand(10,2000);
                                                                   @endphp
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            value="{{ @$ticket_field['option_value'][$key] }}" id="{{ $id }}" name="ticket_data[{{$field_name}}][]">
        
                                                                        <label class="form-check-label" for="{{ $id }}">
                                                                            {{ $option }} 
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                            </div>

                                                        @else

                                                                <div id="{{ $loop->index }}"
                                                                    {{ $ticket_field['required'] == $yes ? 'required' : '' }}>
            
                                                                    @foreach ($ticket_field['option'] as $key => $option)
                                                                        @php 
                                                                           $id =  rand(2001,400000);
                                                                        @endphp
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="radio" name="ticket_data[{{ $field_name}}]" id="{{ $id }}" value="{{@$ticket_field['option_value'][$key]}}">
            
                                                                            <label class="form-check-label" for="{{$id}}" {{ old('ticket_data.' . $field_name) == $ticket_field['option_value'][$key] ? 'selected' : '' }}>
                                                                                {{ $option }}
                                                                            </label>
                                                                        </div>
                                                                    @endforeach
                                                                </div>


                                                        @endif

                                            @elseif($ticket_field['type'] == 'textarea')

                                                <textarea id="{{$loop->index}}" {{$ticket_field['required'] ==   $yes ? "required" :""}} class="summernote"  name="ticket_data[{{ $field_name }}]"id="text-editor" cols="30" rows="10" placeholder="{{$ticket_field['placeholder']}}">
                                                    {{old('ticket_data.'.$field_name)}}
                                                </textarea>

                                                @elseif($ticket_field['type'] == 'file')
                                                <div class="upload-filed">
                                                    <input id="{{$loop->index}}" {{$ticket_field['required'] ==   $yes ? "required" :""}} multiple  type="file" name="ticket_data[{{ $field_name }}][]">
                                                    <label for="{{$loop->index}}">
                                                        <div class="d-flex align-items-center gap-3">
                                                            <span class="upload-drop-file">
                                                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 128 128" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path fill="#f6f0ff" d="M99.091 84.317a22.6 22.6 0 1 0-4.709-44.708 31.448 31.448 0 0 0-60.764 0 22.6 22.6 0 1 0-4.71 44.708z" opacity="1" data-original="#f6f0ff" class=""></path><circle cx="64" cy="84.317" r="27.403" fill="#000" opacity="1" data-original="#000" class=""></circle><g fill="#f6f0ff"><path d="M59.053 80.798v12.926h9.894V80.798h7.705L64 68.146 51.348 80.798zM68.947 102.238h-9.894a1.75 1.75 0 0 1 0-3.5h9.894a1.75 1.75 0 0 1 0 3.5z" fill="#f6f0ff" opacity="1" data-original="#f6f0ff" class=""></path></g></g></svg>
                                                            </span>

                                                        </div>
                                                    </label>
                                                </div>

                                                <ul class="file-list"></ul>

                                                @else

                                                @php
                                                    $value = ($user && ($field_name == 'name')) ? $user->name : (($user && ($field_name == 'email')) ? $user->email : old('ticket_data.'.$field_name));

                                                @endphp

                                                <input {{ $hidden ? "hidden" :""}} id="{{$loop->index}}" {{$ticket_field['required'] == $yes ? "required" :""}} type="{{$ticket_field['type']}}" name="ticket_data[{{ $field_name }}]" value="{{$value}}"  placeholder="{{$ticket_field['placeholder']}}">

                                                <div class="live-search d-none">

                                                </div>
                                                @endif

                                            </div>
                                        </div>
                                    @endif

                                @endforeach

                                @if(site_settings('ticket_security') == $yes )
                                    <div class="col-12">
                                        <div class="row align-items-center">
                                            <div class="col-5">
                                                <div>
                                                    <a id='genarate-captcha' class="d-flex align-items-center">
                                                        <img class="captcha-default pe-2 pointer" src="{{ route('captcha.genarate',1) }}" id="default-captcha">
                                                        <i class="bi bi-arrow-clockwise fs-3 pointer lh-1"></i>

                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-7">
                                                <input type="text" class="form-control  p-2" required name="default_captcha_code" value="" placeholder="{{translate('Enter captcha value')}}" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                @endif


                            </div>

                            <div class="row">
                                <div class="col-md-4 mt-4">
                                    <button type="submit"
                                        class="Btn secondary-btn btn--lg btnwithicon btn-icon-hover text-center w-100"> <span>{{translate('Create')}}</span> <i class="bi bi-arrow-right"></i>
                                    </button>
                                </div>
                            </div>
                        @endif
                </form>
            </div>

            @if(!session()->has("ticket_created"))
                <div class="col-lg-4">
                    <div class="creat-ticket-info">
                        <div class="mb-4">
                            @include('frontend.partials.operating_hour')
                        </div>

                        @php echo site_settings("ticket_notes") @endphp
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>



@if(site_settings('chat_module') == $yes )
    <section class="chat-section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-4">
                    <div class="chat-area">
                        <div class="chat-box" id="chat-box">
                            <div class="chat-header">
                                <div class="logo">
                                    <img src="{{ getImageUrl(getFilePaths()['site_logo']['path']."/".site_settings('frontend_logo')) }}" alt="{{site_settings('frontend_logo')}}" alt="image">
                                </div>
                            </div>

                            <div id="chat-message" class="d-none">
                            </div>

                            <div class="email-area d-none">
                                <div class="email-wrapper">
                                    <div class="form-inner">
                                        <div class="icon">
                                            <i class="bi bi-envelope"></i>
                                        </div>
                                        <input type="text" id="userEmail" placeholder="{{translate("Enter Email")}}">
                                    </div>
                                    <button id="set-cookie" type="submit">
                                         {{translate("Start")}}
                                    </button>
                                </div>
                            </div>

                            <div class="chat-form d-none">
                                <textarea id="sendMessage" name="message" placeholder="{{translate("Type & hit enter")}}"></textarea>
                            </div>
                        </div>

                        <a href="javascript:void(0)" id="send-btn" class="send-btn start-chat"><i class="bi bi-envelope"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif

@endsection

@push('script-include')
	<script src="{{asset('assets/global/js/summernote.min.js')}}"></script>
	<script src="{{asset('assets/global/js/editor.init.js')}}"></script>
    <script src="{{asset('assets/global/js/pusher.min.js')}}"></script>
    <script src="{{asset('assets/global/js/push.js')}}"></script>
    <script src="{{ asset('assets/global/js/select2.min.js') }}"></script>
@endpush


@push('script-push')


<script>
   "use strict";

       $(document).on('click','#genarate-captcha',function(e){

            var url = "{{ route('captcha.genarate',[":randId"]) }}"
            url = (url.replace(':randId',Math.random()))
            document.getElementById('default-captcha').src = url;
            e.preventDefault()
        })


        var receiver_id = null;

        try {

            var pusher = new Pusher("{{$pusher_settings['app_key']}}", {

                cluster: "{{$pusher_settings['app_cluster']}}"

            });

            var channel = pusher.subscribe("{{$pusher_settings['chanel']}}");

            channel.bind("{{$pusher_settings['event']}}", function(data) {

                if(data){
                    var  oldCookie =  JSON.parse(getNewCookie("floating_chat"));
                    if($(".chat-box").hasClass('show-chatbox') &&   oldCookie.id ==  data.anonymous_id &&  !data.anonymous_sender){
                        get_message();
                    }
                }

            });
        } catch (error) {
            toastr("{{translate('Pusher configuration Error!!')}}",'danger')
        }


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        // clearCookie("floating_chat");

        $(document).on('click','.start-chat',function(e){
             $("i", this).toggleClass("bi-envelope bi-x-lg");

            var  oldCookie = getNewCookie("floating_chat");
            $(".chat-box").toggleClass("show-chatbox")

            if($(".chat-box").hasClass('show-chatbox')){

                if (oldCookie != "") {
                    get_message();
                    $('.email-area').addClass('d-none');
                    $('.chat-form').removeClass('d-none');
                    $('#chat-message').removeClass('d-none');


                } else {

                    $('.email-area').removeClass('d-none');
                    $('.chat-form').addClass('d-none');

                }
            }
        });




        function setNewCookie(name, value, days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            var expiration = "expires=" + date.toUTCString();
            document.cookie = name + "=" + value + ";" + expiration + ";path=/";

        }

        function getNewCookie(name) {
            var cookieName = name + "=";
            var cookieArray = document.cookie.split(';');

            for (var i = 0; i < cookieArray.length; i++) {
                var cookie = cookieArray[i];
                while (cookie.charAt(0) == ' ') {
                    cookie = cookie.substring(1);
                }
                if (cookie.indexOf(cookieName) == 0) {
                    return cookie.substring(cookieName.length, cookie.length);
                }
            }
            return "";
        }


        function clearCookie(cookieName) {
            var pastDate = new Date(0);
            var expiredCookie = cookieName + "=;expires=" + pastDate.toUTCString() + ";path=/";
            document.cookie = expiredCookie;

        }



    /** ajax event startt  */

    $(document).on('click','#set-cookie',function(e){

        var email = $('#userEmail').val();
        $.ajax({
            type: 'POST',
            url:"{{ route('set.cookie') }}",
            data: {
                "_token": '{{ csrf_token() }}',
                email: email,
            },
            success: function(data) {

                $('.email-area').addClass('d-none');
                $('.chat-form').removeClass('d-none');
                $('#chat-message').removeClass('d-none');
                setNewCookie('floating_chat', JSON.stringify(data), 30);
                get_message();

                if(data.old){
                    if(data.receiver_id){
                        receiver_id = data.receiver_id ;
                    }
                }

            },

            error: function (error) {

                if(error && error.responseJSON){
                    if(error.responseJSON.errors){
                        for (let i in error.responseJSON.errors) {
                            toastr(error.responseJSON.errors[i][0],'danger')
                        }
                    }
                    else{
                        if((error.responseJSON.message)){
                            toastr("{{translate('Something went wrong !!')}}",'danger')
                        }
                        else{
                            toastr("{{translate('Something went wrong !!')}}",'danger')
                        }
                    }
                }
                else{
                    toastr("{{translate('Something went wrong !!')}}",'danger')
                }

            }
        });

    });



    @if(site_settings(key:'envato_verification',default:0) == 1)
       fillPurchaseKey();
    @endif





    @if(site_settings(key:'envato_verification',default:0) == 1)
        $(document).on('change', '.product-option', function() {

            var selectedOption = $(this).find('option:selected');
            var envatoPayload = selectedOption.data('envatopayload');
            var purchaseKey = selectedOption.data('envatopayload');
            
            if (envatoPayload) {

                   $(this).next('div').removeClass('d-none');
        
                var purchaseCode = selectedOption.data('purchase_code');
                if(purchaseCode){
                    $('#envato_purchase_key').val(purchaseCode)

                    @if(auth_user("web"))

                       $('#envato_purchase_key').attr('hidden',true)

                    @endif
                }

            } else {
               
                  $(this).next('div').addClass('d-none');
                
            }
        });

        function fillPurchaseKey(){


            var selector = $('.product-option');
            var selectedOption = $(selector).find('option:selected');
            var envatoPayload = selectedOption.data('envatopayload');
            var purchaseKey = selectedOption.data('envatopayload');
            
            if (envatoPayload) {
         
                   $(this).next('div').removeClass('d-none');
        

                var purchaseCode = selectedOption.data('purchase_code');
                if(purchaseCode){
                    $('#envato_purchase_key').val(purchaseCode)

                    @if(auth_user("web"))

                      $('#envato_purchase_key').attr('hidden',true)

                    @endif
                }

            } else {
   
                  $(this).next('div').addClass('d-none');
      
            }

        }

    @endif





    $(document).on('keyup', '#sendMessage', function(e) {

        var message = $(this).val();

        if (e.keyCode == 13 && message != '') {

            $(this).val('');

            $.ajax({
                type: "post",

                url:"{{ route('send.message') }}",
                data: {
                    "_token": '{{ csrf_token() }}',
                    message: message,
                    receiver_id: receiver_id,
                },
                cache: false,

                success: function(data) {
                    if(data.status){
                        get_message();
                    }else{
                        toastr(data.message,'danger')
                        if(data.block){

                            $("#chat-message").html(
                                `
                                 <div class =" text-center text-danger anonymous-block"> ${data.message} </div>
                                `
                            )

                            $('.email-area').removeClass('d-none');
                            $('.chat-form').addClass('d-none');
                        }
                        else{


                            $("#chat-message").addClass('d-none')
                            clearCookie("floating_chat");
                            $('.email-area').removeClass('d-none');
                            $('.chat-form').addClass('d-none');

                        }

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
          

            })
        }
    });


    function get_message(user) {

        $.ajax({

            type: "get",
            url:"{{ route('get.message') }}",

            cache: false,

            success: function(data) {

                if(data.status != false){

                    $("#chat-message").removeClass('d-none')
                    $('.email-area').addClass('d-none');
                    $('.chat-form').removeClass('d-none');

                    $("#chat-message").html(data.html)

                    scroll_bottom()

                }
                else{

                    toastr(data.message,'danger')
                    if(data.block){

                        $("#chat-message").html(
                            `
                            <div class =" text-center text-danger anonymous-block"> ${data.message} </div>
                            `
                        )

                        $('.email-area').removeClass('d-none');
                        $('.chat-form').addClass('d-none');
                    }
                    else{

                        $("#chat-message").addClass('d-none')
                        clearCookie("floating_chat");
                        $('.email-area').removeClass('d-none');
                        $('.chat-form').addClass('d-none');

                    }

                }


            },
            error: function (error) {

                if(error && error.responseJSON){
                    if(error.responseJSON.errors){
                        for (let i in error.responseJSON.errors) {
                            toastr(error.responseJSON.errors[i][0],'danger')
                        }
                    }
                    else{
                        if((error.responseJSON.message)){
                            toastr("{{translate('Something went wrong !!')}}",'danger')
                        }
                        else{
                            toastr("{{translate('Something went wrong !!')}}",'danger')
                        }
                    }
                }
                else{
                    toastr("{{translate('Something went wrong !!')}}",'danger')
                }

            }
        });
    }


    // scroll bottom to chat list when new message appear
    function scroll_bottom() {

        $('.chat-body').animate({
            scrollTop: $('.chat-body').get(0).scrollHeight
        }, 1);
    }


    $('.select2').select2({

    });


</script>
@endpush










