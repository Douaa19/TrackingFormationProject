@extends('frontend.layouts.master')
@push('styles')
 <link href="{{asset('assets/global/css/summnernote.css')}}" rel="stylesheet" type="text/css" />
@endpush
@section('content')
@include('frontend.section.breadcrumb')
<section class="pt-100 pb-100">
    @php

       $messages       =  $ticket->messages
                                 ->where('is_draft',App\Enums\StatusEnum::false->status());
       $latestMessage  =  $messages->first();
    @endphp
    <div class="container">
        <div class="container">
            <div class="row g-3 align-items-start">
                <div class="col-xxl-3 col-lg-4">

                    <div class="card border-0">
                        <div class="card-body">
                            @include('frontend.partials.operating_hour')
                        </div>
                    </div>
                
                    <div class="ticket-details sticky-div">
                        <h5 class="pb-3 border-bottom">
                            {{translate("Ticket Details")}}
                        </h5>

                        @if($ticket->solved_request == App\Models\SupportTicket::REQUESTED)
                        
                            <div class="ticket-request mb-2 mt-2">

                                <p>
                                    {{Translate("An agent has requested to mark this ticket as 'Solved.' Would you like to accept this request")}} ??
                                </p>

                                <div class="mt-3 d-flex align-items-center gap-3">
                                    <a href="{{route("ticket.solve.request",[
                                        "ticketId" => $ticket->id ,
                                        "status"   => '1'
                                    ])}}" class="i-badge success fs-14 px-3"> {{translate("Yes")}} <i class="bi bi-check-circle"></i> </a>
                                    <a href="{{route("ticket.solve.request",[
                                        "ticketId" => $ticket->id ,
                                        "status"   => "0"
                                    ])}}" class="i-badge danger fs-14 px-3"> {{translate("No")}}  <i class="bi bi-x-circle"></i> </a>
                                </div>
                            </div>
                        @endif

                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <span>{{translate("Ticket Id")}} </span> 
                                <small class="i-badge success">{{$ticket->ticket_number}}</small>
                            </li>

                            <li class="list-group-item"><span>{{translate("Name")}} </span> <small> {{$ticket->name }} </small></li>
                            <li class="list-group-item"><span>{{translate("Email")}} </span> <small>{{$ticket->email }}</small></li>

                            <li class="list-group-item">
                                <span>{{translate("Category")}}</span> 
                                <small>{{@get_translation($ticket->category->name) }}</small>
                            </li>

                            <li class="list-group-item">
                                <span>{{translate("Status")}}</span>

                                <small>
                                    @php echo ticket_status($ticket->ticketStatus->name,$ticket->ticketStatus->color_code) @endphp 

                                </small>
                            </li>

                            <li class="list-group-item">
                                <span>{{translate("Priority")}}</span>

                                <small> 
                                    @if($ticket->linkedPriority)
                                       @php echo priority_status(@$ticket->linkedPriority->name ,@$ticket->linkedPriority->color_code ,'12') @endphp
                                    @else
                                        {{translate('N/A')}}
                                    @endif
                                </small>
                            </li>

                            <li class="list-group-item">
                                <span>{{translate("Create Date")}}</span>
                                 <small>
                                    {{@getTimeDifference($ticket->created_at) }}
                                 </small>
                            </li>

                            <li class="list-group-item">
                                <span>{{translate("Last Activity")}} </span>
                                 <small>{{@getTimeDifference($latestMessage->created_at) }}</small>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-xxl-9 col-lg-8">
                    <div class="ticket-wrapper">

                        <div class="ticket-header d-flex align-items-center justify-content-between flex-wrap gap-3 pb-3 mb-4 border-bottom">
                            <div>
                                <h5 class="ticket-subject">
                                    {{translate("Subject")}}: <span class="text-muted">{{$ticket->subject}}</span>
                                </h5>
                            </div>

                         

                            <div class="d-flex align-items-center gap-3">

                                @if(site_settings(key:'user_ticket_close',default:0) == 1 && $ticket->status != App\Enums\TicketStatus::CLOSED->value)
                                    <a href="{{route('ticket.close',$ticket->id)}}" class="Btn danger-btn btn--sm  text-center btn-icon">
                                        <span>{{translate("Close")}}</span>
                                        <i class="bi bi-x-circle"></i>
                                    </a>
                                @endif
                                @if(site_settings(key:'user_ticket_open',default:0) == 1 && $ticket->status == App\Enums\TicketStatus::CLOSED->value)
                                    <a href="{{route('ticket.open',$ticket->id)}}" class="Btn danger-btn btn--sm  text-center btn-icon">
                                        <span>{{translate("Reopen")}}</span>
                                        <i class="bi bi-folder2-open"></i>
                                    </a>
                                @endif

                                <button class="Btn primary-btn btn--sm btn-icon-hover text-center reply-btn">
                                    <span>{{translate("Reply")}}</span>
                                    <i class="bi bi-reply-fill"></i>
                                </button>
                            </div>

                        </div>

                        <div class="reply-section d-none">
                            <div class="replay-container mb-5">
                                <form action="{{route('user.ticket.reply')}}"  method="post" enctype="multipart/form-data">
                                        @csrf
                                    <div class="row">
                                        @if($ticket->status !=  App\Enums\TicketStatus::CLOSED->value)
                                            <input type="hidden" name="ticket_id" value="{{$ticket->id}}">

                                            <div class="col-12">
                                                <div class="form-inner mb-0">
                                                    <label for="text-editor" class="form-label">
                                                        {{translate("Your Message")}} <span class="text-danger" >*</span>
                                                    </label>
                                                    <textarea class="form-control summernote " id="text-editor" name="message" rows="3" placeholder="{{translate("Message")}}">{{old("message")}}</textarea>
                                                </div>
                                            </div>

                                            @if(site_settings(key:'custom_file',default:1) == 1)
                                                <div class="col-md-12">
                                                    <div class="form-inner">
                                                        <label for="ticketFile" class="form-label">
                                                            {{translate("Upload File")}}
                                                            <span class="text-danger">
                                                                ({{translate("Maximum File Upload :")}} {{site_settings("max_file_upload")}})
                                                            </span>
                                                        </label>

                                                        <div class="upload-filed">
                                                            <input id="ticketFile" type='file' name="files[]" multiple  >

                                                            <label for="ticketFile">
                                                            <div class="d-flex flex-column align-items-center justify-content-center gap-2">
                                                                    <div class="d-flex align-items-center gap-3">
                                                                    <span class="upload-drop-file">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 128 128" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path fill="#f6f0ff" d="M99.091 84.317a22.6 22.6 0 1 0-4.709-44.708 31.448 31.448 0 0 0-60.764 0 22.6 22.6 0 1 0-4.71 44.708z" opacity="1" data-original="#f6f0ff" class=""></path><circle cx="64" cy="84.317" r="27.403" fill="#000" opacity="1" data-original="#000" class=""></circle><g fill="#f6f0ff"><path d="M59.053 80.798v12.926h9.894V80.798h7.705L64 68.146 51.348 80.798zM68.947 102.238h-9.894a1.75 1.75 0 0 1 0-3.5h9.894a1.75 1.75 0 0 1 0 3.5z" fill="#f6f0ff" opacity="1" data-original="#f6f0ff" class=""></path></g></g></svg>
                                                                    </span>
                                                                    <span class="upload-browse"> {{translate("Upload File Here")}} </span>
                                                                </div>
                                                                <span class='label' data-js-label></span>
                                                            </div>
                                                            </label>
                                                        </div>

                                                        <ul class="file-list"></ul>
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="col-lg-3 col-md-4 mt-3">
                                                <button type="submit" class="Btn secondary-btn btn--lg btn-icon-hover w-100 d-flex align-items-center justify-content-center" type="submit">
                                                    <span> {{translate("Reply")}}</span>
                                                    <i class="bi bi-arrow-right"></i>
                                                </button>
                                            </div>

                                        @else
                                            <div class="col-lg-12 text-center">
                                                <p class="fs-18 text-danger">
                                                    {{translate('Ticket Closed')}}
                                                </p>
                                            </div>
                                        @endif

                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="ticket-lists-wrapper">
                            <div class="ticket-lists">

                            </div>

                            <div class="text-center pt-4 load-more-div d-none">
                                <button class="Btn btn--md secondary-btn load-more">                           
                                    {{translate('Load More')}}                              
                                    <i class="bi bi-arrow-clockwise align-bottom"></i>
                                </button>
                            </div>

                            <div id="elmLoader" class="d-none">
                                <div class="spinner-border" role="status">
                                    <span class="visually-hidden"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

@endsection

@push('script-include')
	<script src="{{asset('assets/global/js/summernote.min.js')}}"></script>
	<script src="{{asset('assets/global/js/editor.init.js')}}"></script>
@endpush


@push('script-push')


<script>
   "use strict";

   $(document).keydown(function(event) {

        if (event.key.toUpperCase() === 'R'
           && !event.ctrlKey
           && !event.altKey
           && !event.shiftKey
           && !event.metaKey
           &  !isTypingInInputField(event)) {
            enable_reply_option();
        }
    });

    $(document).on('click','.reply-btn',function(e){
        enable_reply_option()
    })

    function isTypingInInputField(event) {
        var targetTagName = event.target.tagName.toLowerCase();
        return (targetTagName === 'input' || targetTagName === 'textarea' || targetTagName === 'div');
    }

    function enable_reply_option (){
        $('.reply-section').toggleClass("d-none");

    }


    var      page = 1;

    loadMoreMessages(page)
    $(document).on('click','.load-more',function(e){
        page++;
        loadMoreMessages(page,true);
        e.preventDefault()
    })

    function  loadMoreMessages(page){

        $.ajax({
                url: "{{route('ticket.messages')}}",
                type: "get",
                data:{
                    'page' : page,
                    'id'   : '{{$ticket->id}}',

                },
                dataType:'json',
                beforeSend: function () {
                    $('#elmLoader').removeClass('d-none');
                },
                success:(function (response) {

                    $('#elmLoader').addClass('d-none');
                    if(response.status){
                        $('.ticket-lists').append(response.messages_html)
                        if(response.next_page){
                            $('.load-more-div').removeClass('d-none')
                        }else{
                            $('.load-more-div').addClass('d-none')
                        }
                    }
                    else{
                        $('.ticket-lists').html(`
                            <div class="text-center text-danger mt-10">
                                ${response.message}
                            </div>
                    `)
                    }

                }),

                error:(function (response) {
                    $('#elmLoader').addClass('d-none');

                    $('.ticket-lists').html(`
                        <div class="text-center text-danger mt-10">
                            {{translate('Something went wrong !! Please Try agian')}}
                        </div>
                    `)

                })
            })
    }

</script>
@endpush


