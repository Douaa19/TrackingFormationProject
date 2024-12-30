
@php
        $ticketStatus   = App\Models\TicketStatus::get();
@endphp

<div class="replay-container style-dash">
    <form class="ticketReply" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <input type="hidden" name="draft_message_id" id="draft_message_id">

            @if($ticket->status !=  App\Enums\TicketStatus::CLOSED->value)
                <input type="hidden" name="ticket_id" value="{{$ticket->id}}">
                <div class="col-12">
                    <div class="form-inner mb-0 text-editor-area">
                        <textarea class="form-control summernote" id="text-editor" name="message" rows="3" placeholder="{{translate("Message")}}">{{old("message")}}</textarea>
                        @if(site_settings("open_ai")  ==  App\Enums\StatusEnum::true->status())

                            <button type="button" class="ai-generator-btn mt-3 ai-modal-btn mb-3 " >
                                <span class="ai-icon btn-success waves ripple-light">
                                        <span class="spinner-border d-none" aria-hidden="true"></span>

                                        <i class="ri-robot-line"></i>
                                </span>

                                <span class="ai-text">
                                    {{translate('Generate With AI')}}
                                </span>
                            </button>

                         @endif
                    </div>
                </div>
            @else
                <div class="col-lg-12 text-center">
                        <p class="fs-18 text-danger">
                            {{translate('Ticket Closed')}}
                        </p>
                </div>
            @endif
        </div>

        @if($ticket->status !=  App\Enums\TicketStatus::CLOSED->value)
            <div class="row align-items-end g-2">
                <div class="col-md-7">
                    <div class="form-inner">
                        <label for="ticketFile" class="form-label">
                            {{translate('Upload File')}}
                            <span class="text-danger">
                                ({{translate("Maximum File Upload :")}} {{site_settings("max_file_upload")}})

                            </span>
                        </label>
                        <div class='file-input'>
                            <input multiple class="form-control" name="files[]" type="file" id="ticketFile" >
                        </div>
                    </div>
                </div>

                <div class="col-md-5 mt-3">
                    <div class="button-with-select">
                        @if(check_agent("update_tickets"))

                            <select id="ticket-reply-status" name="status" class="form-select d-inline rounded-0   btn-primary"  >
                                @foreach($ticketStatus as $status)
                                    <option {{$status->id == $ticket->status ? 'selected' :""}} value="{{$status->id}}">
                                        {{
                                            ucfirst(strtolower($status->name))
                                        }}
                                    </option>
                                @endforeach
                            </select>
                        @endif

                        <button type="submit"
                        class="btn btn-md btn-primary rounded-0 lh-1" aria-expanded="false">
                                <div class="reply-option">
                                <i class="ri-reply-fill me-1"></i>
                                {{translate("Reply")}}
                                </div>

                            <div class="spinner-border spinner-border-sm text-white reply-btn-spinner d-none" role="status">
                                <span class="visually-hidden"></span>
                            </div>

                        </button>
                        <div class="dropdown">

                            <button class="btn btn-sm btn-primary dropdown-toggle rounded-0 border-start-" role="button" data-bs-toggle="dropdown" aria-expanded="false">

                            </button>


                            <ul class="dropdown-menu">

                                @foreach (App\Enums\TicketReply::toArray() as $key => $value )
                                    <li class="dropdown-item">

                                        <label for="{{$key}}" class="cursor-pointer">
                                            {{translate('Send & ')}} {{
                                                ucfirst(strtolower(str_replace('_'," ",$key)))
                                                }}
                                        </label>

                                    <input hidden {{$loop->index == 0 ? "checked" :""}}   type="radio" name="redirect_to" value="{{$value}}" id="{{$key}}">
                                    </li>
                                @endforeach

                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        @endif
    </form>
</div>
