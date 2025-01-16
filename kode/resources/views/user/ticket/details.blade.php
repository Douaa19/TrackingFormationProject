@extends('user.layouts.master')
@push('styles')
 <link href="{{asset('assets/global/css/summnernote.css')}}" rel="stylesheet" type="text/css" />
@endpush
@section('content')
    <div class="container-fluid px-0">
        <div class="ticket-body-wrapper">
            <div class="row g-0">
                <div class="col-auto ticket-sidebar">
                    <div class="ticket-sidebar-sticky py-4 ">
                        <div class="ticket-detail-scroll" data-simplebar>
                            <div class="ticket-details-item">
                                <div class="mb-4">

                                </div>
                                <h5>
                                    {{ translate('Agent Details') }}
                                </h5>


                                <div class="ticket-details-body">
                                    <ul class="list-group list-group-flush ticket-detail-list">
                                        <li class="list-group-item">

                                        <li class="list-group-item">
                                            <span class="fw-bold">{{translate("User Name")}} </span>
                                             <small> {{$admin[0]->name}} </small>
                                        </li>

                                        <li class="list-group-item">
                                            <span class="fw-bold">{{translate("Email")}} </span>
                                            <small> {{$admin[0]->email}} </small>
                                        </li>
                                        <li class="list-group-item">
                                            <span class="fw-bold">{{translate("Phone Number")}} </span>
                                            <small> {{$admin[0]->phone}} </small>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col ticket-content">
                    <div class="card mb-0 shadow-none">
                        <div class="card-body pb-0 ticket-header">
                            <div class="row g-4 align-items-center">
                                <div class="col-xl-9 order-xl-1 order-2">
                                    <div class="row align-items-center">
                                        <div class="col-md-auto">
                                            <div>

                                                @php
                                                    $url = getImageUrl(getFilePaths()['profile']['user']['path'].'/'.auth_user('web')->image,getFilePaths()['profile']['user']['size']);
                                                    if(filter_var(auth_user('web')->image, FILTER_VALIDATE_URL) !== false){
                                                        $url = auth_user('web')->image;
                                                    }
                                                @endphp

                                                <img src="{{$url}}"
                                                    alt="user-profile" class="avatar-md rounded-circle"/>

                                            </div>
                                        </div>

                                        <div class="col-md">
                                            <h4 class="fw-semibold" id="ticket-title">
                                            {{$admin[0]->name}}
                                        </h4>

                                            <div class="hstack gap-2 flex-wrap">
                                                <div class="text-muted"><i class="ri-bug-line align-bottom me-1"></i><span
                                                        id="ticket-client">
                                                        {{ @get_translation($ticket->category->name) }}
                                                    </span></div>
                                                <div class="vr"></div>
                                                <div class="text-muted">{{ translate('Create Date') }} : <span
                                                        class="fw-medium " id="create-date">
                                                        {{ getDateTime($ticket->created_at) }}
                                                    </span></div>
                                                <div class="vr"></div>


                                                @php echo ticket_status($ticket->ticketStatus->name,$ticket->ticketStatus->color_code) @endphp


                                                @if($ticket->linkedPriority)
                                                    @php echo priority_status(@$ticket->linkedPriority->name ,@$ticket->linkedPriority->color_code,12 ) @endphp
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-3 order-xl-2 order-1">
                                    <div class="d-flex justify-content-xl-end justify-content-between w-100">
                                        <button class="btn btn-soft-secondary btn-icon btn-sm fs-16 d-xl-none" id="ticket-menu-btn">
                                                <i class="ri-bar-chart-horizontal-fill align-bottom"></i>
                                        </button>

                                        <a href="{{route('user.ticket.list')}}" class="btn btn-primary waves ripple-light d-flex align-items-center gap-2 lh-1">
                                            <i class="ri-arrow-go-back-fill align-bottom fs-5"></i>
                                            {{translate("Back")}}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body py-3 ticket-sidebar-sticky bg-white border-bottom">
                            <div class="ticket-action-buttons">

                                <button class="reply-btn">
                                    <i class="ri-reply-fill"></i>
                                    {{translate("Reply")}}
                                </button>

                                @if($ticket->envato_payload && site_settings(key:'envato_verification',default:0) == 1  )
                                    <button class="envato-verification-btn">
                                        <i class="ri-shield-check-line"></i>
                                        {{translate("Envato verificaton")}}
                                    </button>
                                @endif

                                @if($ticket->status !=  App\Enums\TicketStatus::CLOSED->value)
                                    <button class="btn btn-success  btn-sm"
                                        data-bs-toggle="modal" data-bs-target="#cannedReply">
                                            <i class="ri-mail-line"></i>
                                            {{translate("Predefined Response")}}
                                    </button>
                                @endif
                                 @if(site_settings(key:'user_ticket_delete',default:0) ==  1)
                                    <button type="button"  data-href="{{route('user.ticket.delete',$ticket->id)}}" class="delete-item btn py-0 fs-16 text-body">
                                        <i class="ri-delete-bin-6-line link-danger "></i>
                                        {{translate("Delete")}}
                                    </button>
                                 @endif

                                 @if(site_settings(key:'user_ticket_close',default:0) == 1 && $ticket->status != App\Enums\TicketStatus::CLOSED->value)
                                    <a href="{{route('ticket.close',$ticket->id)}}" class="btn py-0 fs-16 text-body">
                                        <span>{{translate("Close")}}</span>
                                        <i class="ri-close-circle-line link-danger"></i>
                                    </a>
                                 @endif

                                 @if(site_settings(key:'user_ticket_open',default:0) == 1 && $ticket->status == App\Enums\TicketStatus::CLOSED->value)
                                    <a href="{{route('ticket.open',$ticket->id)}}" class="btn py-0 fs-16 text-body">
                                        <span>{{translate("Reopen")}}</span>
                                        <i class="ri-folder-open-line link-success"></i>

                                    </a>
                                 @endif

                            </div>

                            @if($ticket->solved_request == App\Models\SupportTicket::REQUESTED)

                                <div class="ticket-request d-flex flex-wrap justify-content-start align-items-center gap-3 mt-4">
                                    <div class="mb-0 alert alert-info fs-16 ">
                                        {{Translate("An agent has requested to mark this ticket as 'Solved.' Would you like to accept this request")}} ??
                                    </div>

                                    <div>

                                        <a href="{{route("ticket.solve.request",[
                                            "ticketId" => $ticket->id ,
                                            "status"   => '1'
                                        ])}}" class="btn btn-success btn-lg me-2 add-btn waves ripple-light fs-15"
                                        ><i class="ri-checkbox-circle-line align-bottom  "></i>
                                            {{translate("Yes")}}
                                        </a>
                                        <a href="{{route("ticket.solve.request",[
                                            "ticketId" => $ticket->id ,
                                            "status"   => "0"
                                        ])}}" class="btn btn-danger btn-lg add-btn waves ripple-light fs-15"
                                        ><i class="ri-close-circle-line align-bottom "></i>
                                            {{translate("No")}}
                                        </a>


                                    </div>
                                </div>
                            @endif
                        </div>



                        <div class="card-body border-bottom envato--card d-none">

                            @php
                                $payload =  $ticket->envato_payload;
                                $item    =  @$payload->item;

                            @endphp

                            <div class="container-fluid p-4 border mb-4 ">

                                <h4 class="border-bottom mb-4 pb-3">
                                    {{translate("Envato verification")}}
                                </h4>

                                @if($payload && $item)
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="card mt-n4 mx-n4">
                                                <div class="bg-warning-subtle">
                                                    <div class="card-body pb-0 px-4">
                                                        <div class="row mb-3">
                                                            <div class="col-md">
                                                                <div class="row align-items-center g-3">
                                                                    <div class="col-md-auto">
                                                                        <div class="avatar-md">
                                                                            <div class="avatar-title bg-white rounded-circle">
                                                                                <img src="{{$item->previews->icon_preview->icon_url}}" alt="Project icon" class="avatar-xs">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md">
                                                                        <div>
                                                                            <h4 class="fw-bold"> {{  $item->name }}</h4>
                                                                            <div class="hstack gap-3 flex-wrap">
                                                                                <div><i class="ri-building-line align-bottom me-1"></i>
                                                                                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="{{translate('Author')}}" target="_blank" href="{{$item->author_url}}">
                                                                                        {{ $item->author_username  }}
                                                                                        iiuyiuyiu iuiguiug
                                                                                    </a>
                                                                                </div>
                                                                                <div class="vr"></div>
                                                                                <div>{{ translate('Last update') }} : <span class="fw-medium"> {{ get_date_time($item->updated_at)  }}</span></div>
                                                                                <div class="vr"></div>
                                                                                <div>
                                                                                    <a target="_blank" href="{{$item->url }}" class=" btn btn-sm btn-success fs-16 ">
                                                                                        {{ translate('View item') }}
                                                                                    </a>
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

                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="tab-content text-muted">
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <div class="card">
                                                            <div class="card-body text-center">
                                                                <ul class="list-group">
                                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                        {{ translate("Buyer") }}    <span class="badge bg-success"> {{$payload->buyer }} </span>
                                                                    </li>
                                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                        {{ translate("Total purchase") }}    <span class="badge bg-success"> {{$payload->purchase_count }} </span>
                                                                    </li>
                                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                        {{ translate("Amount") }}    <span class="badge bg-success"> {{$payload->amount}}$ </span>
                                                                    </li>
                                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                        {{ translate("Support amount") }}    <span class="badge bg-success"> {{$payload->support_amount}}$ </span>
                                                                    </li>
                                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                        {{ translate("Sold at") }}    <span class="badge bg-success"> {{ get_date_time($payload->sold_at) }}</span>
                                                                    </li>
                                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                        {{ translate("Purchase key") }}    <span class="badge bg-info"> {{$payload->purchase_key}}</span>
                                                                    </li>
                                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                        {{ translate("License") }}    <span class="badge bg-success"> {{$payload->license }} </span>
                                                                    </li>

                                                                    <li class="list-group-item d-flex justify-content-between align-items-center">

                                                                        {{ translate("Support type") }}    @if($ticket->is_support_expired == 1)
                                                                                                                <span class="badge bg-danger"> {{ translate('Expired')  }}
                                                                                                                </span>
                                                                                                            @else
                                                                                                                <span class="badge bg-secondary"> {{ translate('Valid')  }}
                                                                                                                </span>
                                                                                                            @endif
                                                                    </li>

                                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                        @php

                                                                                if($payload->supported_until){
                                                                                    $supported_until   = \Carbon\Carbon::parse($payload->supported_until);
                                                                                    $expiredDate       = $supported_until->format('l, F j, Y \a\t g:i A');
                                                                                }

                                                                        @endphp
                                                                        {{ translate("Support until") }}    @if($payload->supported_until)
                                                                                                            <span class="badge bg-success"> {{$expiredDate}} </span>
                                                                                                            @else
                                                                                                            <span>  N/A </span>
                                                                                                            @endif
                                                                    </li>


                                                                </ul>


                                                            </div>


                                                        </div>
                                                    </div>


                                                </div>



                                            </div>
                                        </div>

                                    </div>

                                @endif

                            </div>

                        </div>

                        <div class="card-body border-bottom reply-card d-none">
                            <div class="replay-container style-dash">
                                <form action="{{ route('user.ticket.reply') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">

                                        @if ($ticket->status != App\Enums\TicketStatus::CLOSED->value)
                                            <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">

                                            <div class="col-12">
                                                <div class="form-inner">

                                                    <textarea class="form-control summernote " id="text-editor" name="message" rows="3"
                                                        placeholder="{{ translate('Message') }}">{{ old('message') }}</textarea>

                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-inner">
                                                    <label for="ticketFile" class="form-label">
                                                        {{ translate('Upload File') }}
                                                        <span class="text-danger">

                                                            ({{ translate('Maximum File Upload :') }}
                                                            {{ site_settings('max_file_upload') }})

                                                        </span>
                                                    </label>

                                                    <input multiple class="form-control" name="files[]" type="file"
                                                        id="ticketFile">

                                                </div>
                                            </div>

                                            <div class="col-xl-2 col-md-4 mt-3">
                                                <button type="submit" class="btn btn-md btn-primary w-100">
                                                    {{ translate('Reply') }}
                                                    <i class="bi bi-arrow-right"></i>
                                                </button>
                                            </div>
                                        @else
                                            <div class="col-lg-12 text-center">
                                                <p class="fs-18 text-danger">
                                                    {{ translate('Ticket Closed') }}
                                                </p>
                                            </div>
                                        @endif

                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="card-body p-0">
                            <div class="ticket-wrapper">
                                <div class="d-none message-preloader" id="elmLoader">
                                    <div class="spinner-border text-secondary border-3 avatar-sm" role="status">
                                        <span class="visually-hidden"></span>
                                    </div>
                                </div>

                                <div class="ticket-lists-wrapper" data-simplebar>
                                    <div class="all-reply-item">

                                    </div>

                                    <div class="text-center py-4 load-more-div d-none">
                                        <button class="btn btn-md btn-success add-btn waves ripple-light load-more">
                                            <i class="ri-refresh-line align-bottom me-1"></i>
                                            {{translate('Load More')}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('modal.delete_modal')
        <div class="modal fade" id="cannedReply"  data-bs-keyboard="false" tabindex="-1"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header p-3">
                        <h5 class="modal-title" id="modalTitle">{{ translate('Canned Reply') }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            ></button>
                    </div>

                    @php
                        $cannedReplay = App\Models\CannedReply::active()
                                                ->where('user_id', auth_user('web')->id)
                                                ->get();
                    @endphp

                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-xl-12">
                                <div class="row">
                                    <div class="col-lg-12">

                                        <div class="mb-3">
                                            <label class="form-label" for="cannedReplyBody">
                                                {{ translate('Reply List') }}

                                            </label>

                                            <select name="reply" class="form-select" id="cannedReplyBody" required>

                                                <option value="">
                                                    {{ translate('Select Template') }}
                                                </option>
                                                @foreach ($cannedReplay as $reply)
                                                    <option value="{{ $reply->body }}">
                                                        {{ $reply->title }}
                                                    </option>
                                                @endforeach

                                            </select>

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
@endsection

@push('style-include')
    <link href="{{ asset('assets/global/css/ticket.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/global/css/viewbox/viewbox.css')}}" rel="stylesheet" type="text/css" />
@endpush

@push('script-include')
	<script src="{{asset('assets/global/js/summernote.min.js')}}"></script>
	<script src="{{asset('assets/global/js/editor.init.js')}}"></script>
    <script src="{{asset('assets/global/js/viewbox/jquery.viewbox.min.js')}}"></script>
@endpush

@push('script-push')
    <script>
        (function($) {


            "use strict";


            $(document).on('click','.envato-verification-btn',function(e){

                var isModal = false;

                if($(this).hasClass('modal-ticket')){
                    isModal = true;
                }
                expand_envato_card(isModal)
            })


            function expand_envato_card(modal = false){
                var selector  = modal ? $('#ticketModal').find('.envato--card') :  $('.envato--card')
                selector.toggleClass('d-none')
            }




            $('.file-v-preview').viewbox();
            $(document).keydown(function(event) {
                if (event.key.toUpperCase() === 'R'
                && !event.ctrlKey
                && !event.altKey
                && !event.shiftKey
                && !event.metaKey
                && !isTypingInInputField(event)) {

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
                $('.envato--card').addClass('d-none')
                $('.reply-card').toggleClass('d-none')
            }

            $(document).on('change', '#cannedReplyBody', function(e) {

                var html = $(this).val()
                $('.summernote').summernote('destroy');
                $('.summernote').html(html);
                $('.summernote').summernote({
                    height: 300,
                    placeholder: '{{translate("Start typing...")}}',
                    toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['insert', ['picture', 'link', 'video']],
                    ['view', ['codeview']],
                    ],
                    callbacks: {
                        onInit: function() {

                        }
                    }
                });
                $('.reply-card').removeClass('d-none')
                $('#cannedReply').modal('hide')
                e.preventDefault()
            })

            var      page = 1;

            loadMoreMessages(page)
            $(document).on('click','.load-more',function(e){
                page++;
                loadMoreMessages(page,true);
                e.preventDefault()
            })

            function  loadMoreMessages(page){

                $.ajax({
                        url: "{{route('user.ticket.messages')}}",
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
                                $('.all-reply-item').append(response.messages_html)
                                if(response.next_page){
                                    $('.load-more-div').removeClass('d-none')
                                }else{
                                    $('.load-more-div').addClass('d-none')
                                }
                            }
                            else{
                                $('.all-reply-item').html(`
                                    <div class="text-center text-danger mt-10">
                                        ${response.message}
                                    </div>
                            `)
                            }

                            $('.image-v-preview').viewbox();

                        }),

                        error:(function (response) {
                            $('#elmLoader').addClass('d-none');

                            $('.all-reply-item').html(`
                                <div class="text-center text-danger mt-10">
                                    {{translate('Something went wrong !! Please Try agian')}}
                                </div>
                            `)

                        })
                    })
            }

        })(jQuery);
    </script>
@endpush
