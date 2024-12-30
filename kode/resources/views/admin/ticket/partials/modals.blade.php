@include('modal.delete_modal')

<div class="modal fade modal-custom-bg" id="assignModal" tabindex="-1" aria-labelledby="assignModal" aria-hidden="true">

    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{route('admin.ticket.mark')}}" method="post" >
                @csrf
                <div class="modal-header p-3">
                    <h5 class="modal-title" >{{translate('Assign Ticket With Sort Notes')}}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close" ></button>
                </div>

                <div class="modal-body">
                    <input class="assign-ticket" hidden type="text" name="ticket_id[1]"  value="{{$ticket->id}}">

                    <div class="mb-3">

                        @php
                            $agentIds = @$ticket->agents?->pluck("id")->toArray() ?? [];
                        @endphp

                        
                        <label class="form-label" for="assign">
                            {{translate('Assign to')}}

                              <span class="text-danger"> *</span>
                        </label>

             
                        <select name="assign[]" id="assign" multiple required class="form-select">
                                @if(auth_user()->agent == App\Enums\StatusEnum::false->status() && auth_user()->super_agent != 1 )
                                        <option {{ in_array(auth_user()->id ,$agentIds) ? 'selected' :"" }} value="{{auth_user()->id}}">
                                            {{translate('Me')}}
                                        </option>
                                @endif
                                @forelse($agents as $agent)

                                    <option {{ in_array($agent->id ,$agentIds) ? 'selected' :"" }} value="{{$agent->id}}">
                                        {{$agent->name}}
                                    </option>
                        
                                @empty
                        
                                @endforelse

                        </select>

                     
                    </div>

                    <div class="mb-3">
                        <label for="message-text" class="col-form-label">{{translate("Message")}}:</label>
                        <textarea class="form-control" name="short_note" id="message-text" placeholder="{{translate("Write Short Note Here")}} ...... "></textarea>
                    </div>

                    @if(auth_user()->agent == App\Enums\StatusEnum::false->status() )
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">{{translate("Priority")}}:</label>
                                <select name="priority_id" class="form-select"  >
                                    @foreach($priorityStatus as $priority)
                                        <option {{$priority->id == $ticket->priority_id ? 'selected' :""}} value="{{$priority->id}}">
                                            {{
                                                $priority->name
                                            }}
                                        </option>
                                    @endforeach
                                </select>
                        </div>
                    @endif
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        {{translate("Close")}}
                    </button>
                    <button type="submit"  class="btn btn-primary assignedToBtn">
                        {{translate('Submit')}}
                    </button>
                </div>
           </form>
        </div>
    </div>
</div>

<div class="modal fade modal-custom-bg" id="cannedReply"  data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header p-3">
                <h5 class="modal-title" id="modalTitle">{{translate('Canned Reply')}}
                </h5>
                <button type="button" class="btn-close canned-reply-close" data-bs-dismiss="modal"
                    aria-label="Close" ></button>
            </div>

            @php
                $cannedReplay =  App\Models\CannedReply::active() 
                                     ->lazyById(100,'id')
                                     ->filter(function($reply){
                                        return $reply->admin_id == auth_user()->id || in_array(auth_user()->id ,@$reply->share_with ?? []);
                                     })->all();
            @endphp

            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-xl-12">
                        <div class="row">
                            <div class="col-lg-12">


                                <div class="mb-3">
                                    <label class="form-label" for="cannedReplyBody">
                                        {{translate('Reply List')}}

                                    </label>

                                    <select name="reply" class="form-select" id="cannedReplyBody" required>

                                        <option value="">
                                            {{translate('Select Template')}}
                                        </option>

                                        @foreach($cannedReplay  as $reply)
                                            <option value="{{$reply->body}}">
                                                {{$reply->title}}
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

<div class="modal fade modal-custom-bg" id="addNote"  data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header p-3">
                <h5 class="modal-title" id="modalTitle">{{translate('Add Note')}}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close" ></button>
            </div>
            <form id="noteform" method="post">
                @csrf

                 <input type="hidden" id="ticketId" name="id" value="">

                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-xl-12">
                            <div class="row">
                                <div class="col-lg-12">


                                    <div class="mb-3">

                                        <label class="form-label" for="note">
                                            {{translate('Note')}} <span class="text-danger">*</span>
                                        </label>

                                    <textarea class="summernote" name="note" id="note" cols="30" rows="10">{{old("note")}}</textarea>

                                    </div>


                                </div>

                            </div>
                        </div>
                    </div>


                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        {{translate("Close")}}
                    </button>
                    <button type="submit" name="assign" class="btn btn-primary ticket-note-btn">
                        {{translate('Submit')}}
                        <div class="ms-1 spinner-border spinner-border-sm text-white note-btn-spinner d-none " role="status">
                            <span class="visually-hidden"></span>
                        </div>
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>


<div class="modal fade modal-custom-bg" id="updateMessage"  data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <form  class="ticket-update" >
                @csrf
                <div class="modal-header p-3">
                    <h5 class="modal-title" id="modalTitle">{{translate('Update Message')}}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close" ></button>
                </div>


                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-xl-12">
                            <div class="row">
                                <div class="col-lg-12">

                                    <input type="text" name="id" hidden  id="messageId">

                                    <div class="mb-3">

                                        <textarea class="form-control update-message"  name="message" rows="3" placeholder="{{translate("Message")}}"></textarea>

                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>


                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        {{translate("Close")}}
                    </button>
                    <button type="submit" name="assign" class="btn btn-primary submit-btn">
                        {{translate('Submit')}}
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<div class="modal fade modal-custom-bg" id="showMessage"  data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">

                <div class="modal-header p-3">
                    <h5 class="modal-title" id="modalTitle">{{translate('Original Message')}}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close" ></button>
                </div>


                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-xl-12">
                            <div class="row">
                                <div class="col-lg-12" id="originalMesssage">



                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        {{translate("Close")}}
                    </button>

                </div>

        </div>
    </div>
</div>


<div class="modal fade" id="ticketModal"  data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content">

            <div class="modal-header p-3">
                <h5 class="modal-title" id="modalTitle">{{translate('Ticket')}}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close" ></button>
            </div>

            <div class="modal-body modal-ticket-body position-relative">

                <div class="d-none modal-loader message-preloader text-center">
                    <div class="spinner-border text-primary avatar-sm" role="status">
                        <span class="visually-hidden"></span>
                    </div>
                </div>

                <div class="ticket-html">

                </div>


            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                    {{translate("Close")}}
                </button>

            </div>

        </div>
    </div>
</div>


<div class="modal fade zoomIn merge-modal" id="merge-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header merge-modal-header">

            </div>
            <div class="modal-body">
                <form action="{{route('admin.ticket.merge')}}" method="post">
                    @csrf
                     <input type="hidden" name="parent_ticket_id" value="{{$ticket->id}}">
                     <input id="childTicket" hidden type="text" name="ticket_id" value="">
                    <div class="mt-2 text-center">

                        <lord-icon
                                src="{{asset('assets/global/json/vyahiuge.json')}}"
                            trigger="loop"  colors="primary:#f7b84b,secondary:#f06548"   class="loader-icon">

                        </lord-icon>

                         <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                            <h4>
                              {{translate('Merged tickets can not be unmerged.')}}
                            </h4>
                            <p class="text-muted mx-4 mb-0">
                                {{translate('Are you sure you want merge this ticket with the original one behind the pop-ups?Merged tickets can not be unmerged.')}}
                            </p>
                        </div>
                    </div>
                    <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                        <button type="button" class="btn w-sm btn-light"
                            data-bs-dismiss="modal">
                            {{translate('Close')}}

                        </button>
                        <button type="submit"  class="btn w-sm btn-danger">
                            {{translate('Yes, Merge It!')}}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



@php
$lastReply  = $ticket->messages()
                ->whereNull('admin_id')
                ->latest()
                ->first();

@endphp


