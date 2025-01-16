@extends('admin.layouts.master')

@push('styles')
    <link rel="stylesheet" href="{{asset('assets/global/css/flatpickr.min.css')}}">

    <link href="{{ asset('assets/global/css/ticket.css') }}" rel="stylesheet" type="text/css" />

    <style>
        .custom--tooltip {
            position: relative;
            display: inline-block;
            cursor: pointer;

            .tooltip-text {
                position: absolute;
                bottom: 25px;
                left: 50%;
                max-width: 150px;
                background: #111;
                white-space: wrap;
                padding: 10px;
                color: #ddd;
                transform: translateX(-50%);
                border-radius: 10px;
                display: none;
                z-index: 999 !important;
            }

            &:hover {
                .tooltip-text {
                    display: block;
                }
            }
        }
    </style>
@endpush

@section('content')
<div class="container-fluid px-0">
    @php
        $agents = App\models\Admin::active()->get();
        $priorityStatus = App\Models\Priority::active()->get();
    @endphp

    <div class="ticket-body-wrapper">
        <div class="row g-0">
            <div class="col-auto ticket-sidebar">
                <div class="ticket-sidebar-sticky py-4">
                    <div class="px-xl-4 px-lg-3 px-4 ticket-sidebar-scroll" data-simplebar>
                        <div class="ticket-department">


                        </div>

                        <div class="email-menu-sidebar">
                            <div>
                                <h5 class="fs-12 text-uppercase tag-header">
                                    {{translate("Inbox")}}
                                </h5>
                                <div class="mail-list ticket-categories">

                                </div>
                            </div>


                            @if(auth_user()->agent == App\Enums\StatusEnum::false->status())
                                <div>
                                    <h5 class="fs-12 text-uppercase mt-3 tag-header">
                                        {{translate("Tags")}}
                                    </h5>

                                    <div class="mail-list tag-list mt-1">

                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col ticket-content">

                <div class="card shadow-none rounded-none mb-0">
                    <div class="ticket-sidebar-sticky">
                        <div class="card-body position-relative border-bottom py-3 bg-white">
                            <div class="row gx-0 gy-3 align-items-center">
                                <div class="col-xl-2 col-md-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <a href="{{route('admin.dashboard')}}"
                                            class="btn btn-primary waves ripple-light d-flex align-items-center gap-2 lh-1">
                                            <i class="ri-arrow-go-back-fill align-bottom fs-5"></i>
                                            {{translate("Back")}}
                                        </a>

                                        <button type="button"
                                            class="btn btn-soft-secondary btn-icon btn-sm fs-16 d-xl-none"
                                            id="ticket-menu-btn">
                                            <i class="ri-bar-chart-horizontal-fill align-bottom"></i>
                                        </button>

                                        <div class="dropdown">
                                            <button class="btn btn-soft-info btn-icon btn-sm fs-16" type="button"
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="ri-file-ppt-2-line align-bottom"></i>
                                            </button>

                                            <div data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                data-bs-placement="top" title="{{translate("Export")}}"
                                                class="dropdown-menu">

                                                <a class="dropdown-item" href="{{route('admin.ticket.export', 'pdf')}}">
                                                    {{Translate('Export As Pdf')}}
                                                </a>

                                                <a class="dropdown-item" href="{{route('admin.ticket.export', 'csv')}}">
                                                    {{Translate('Export As Csv')}}
                                                </a>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-10 col-md-9">
                                    <div
                                        class="d-flex gap-3 flex-wrap flex-sm-nowrap align-items-center gap-sm-1 email-topbar-link">

                                        @php

                                            $priorites = App\Models\Priority::active()->get();

                                        @endphp


                                        <select class="form-select" name="status" id="status">

                                            <option value="">
                                                {{
    translate('Select status')
                                                        }}
                                            </option>

                                            @foreach($ticketStatus as $status)
                                                <option value="{{$status->id}}">
                                                    {{$status->name}}

                                                </option>
                                            @endforeach

                                        </select>


                                        <select class="form-select" name="priority" id="priority">

                                            <option value="">
                                                {{
    translate('Select Priority')
                                                        }}
                                            </option>

                                            @foreach($priorites as $priority)
                                                <option value="{{$priority->id}}">
                                                    {{$priority->name}}
                                                </option>
                                            @endforeach

                                        </select>

                                        <input type="text" class="form-control" id="searchDate" name="date_range"
                                            placeholder="{{translate('Search By Date')}}">

                                        <input type="text" class="form-control" id="searchInput" name="search"
                                            placeholder="{{translate('Search By Name, or Ticket Number')}}">


                                        <button type="button" class="filter btn btn-primary btn-md"> <i
                                                class="ri-search-line me-1 align-bottom"></i>

                                        </button>

                                        <a href="{{route("admin.ticket.list")}}" class="btn btn-danger btn-md res">
                                            <i class="ri-refresh-line align-bottom"></i>
                                        </a>

                                    </div>
                                </div>

                                <div id="ticketAction" class="col-auto ticketAction mt-1 d-none">
                                    <form action="{{route('admin.ticket.mark')}}" id="ticketbulkForm" method="post">


                                        @csrf


                                        <input type="hidden" name="bulk_id" value="" id="bulkTicketId">


                                        <div class="d-flex  align-items-center gap-2">

                                            @if(check_agent("update_tickets"))
                                                <div class="dropdown">
                                                    <button class="btn btn-soft-warning btn-icon btn-sm fs-16" type="button"
                                                        data-bs-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <i class="ri-more-2-fill align-bottom"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end">

                                                        @foreach(App\Models\TicketStatus::active()->get() as $status)

                                                            @if($status->id == App\Enums\TicketStatus::SOLVED->value && auth_user()->agent == App\Enums\StatusEnum::true->status())

                                                                @continue

                                                            @endif

                                                            <button value="{{$status->id }}" name="status"
                                                                class="dropdown-item">
                                                                {{translate('Mark as ') . Str::ucfirst(strtolower($status->name)) }}
                                                            </button>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif

                                            @if(check_agent("delete_tickets"))
                                                <div data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                    data-bs-placement="top" title="Delete">
                                                    <button type="button" name='btn' value='delete'
                                                        class="mark-delete btn btn-soft-danger delete-ticket btn-icon btn-sm fs-16">
                                                        <i class="ri-delete-bin-5-fill align-bottom"></i>
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="tab-content">
                            <div class="tab-pane fade show active">

                                <div class="table-responsive ticket-table position-relative">
                                    <div id="ticket-list">

                                    </div>

                                    <div class="d-none" id="elmLoader">
                                        <div class="spinner-border text-primary avatar-sm" role="status">
                                            <span class="visually-hidden"></span>
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

<!-- delete modal -->
<div class="modal fade zoomIn" id="mark-delete-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header delete-modal-header ">

            </div>
            <div class="modal-body">
                <div class="mt-2 text-center">
                    <lord-icon src="{{asset('assets/global/json/gsqxdxog.json')}}" trigger="loop"
                        colors="primary:#f7b84b,secondary:#f06548" class="loader-icon"></lord-icon>
                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                        <h4>
                            {{translate('Are you sure ?')}}
                        </h4>
                        <p class="text-muted mx-4 mb-0">
                            {{translate('Are you sure you want to
                                remove this record ?')}}
                        </p>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">
                        {{translate('Close')}}

                    </button>
                    <button type="button" class="btn w-sm btn-danger " id="markDeleteItem">
                        {{translate('Yes, Delete It!')}}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- response time modal -->
<div class="modal fade" id="responseTimeModal" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md">
        <div class="modal-content">
            <div class="modal-header p-3">
                <h5 class="modal-title" id="modalTitle">{{translate('Respone & Resolve Time')}}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-xl-12">
                        <div class="row">
                            <div class="col-lg-12">

                                <div class="mb-3 fs-15" id="prioritySection">


                                </div>


                                <div class="fs-15" id="responseTime">



                                </div>


                            </div>

                        </div>
                    </div>
                </div>


            </div>

        </div>
    </div>
</div>

@include('modal.delete_modal')

<div class="modal fade modal-custom-bg" id="assignModal" tabindex="-1" aria-labelledby="assignModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{route('admin.ticket.mark')}}" method="post">
                @csrf
                <div class="modal-header p-3">
                    <h5 class="modal-title">{{translate('Assign Ticket With Sort Notes')}}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input class="assign-ticket" hidden type="text" name="ticket_id[1]" value="">
                    <div class="mb-3">
                        <label class="form-label" for="assign">
                            {{translate('Assign to')}}
                            <span class="text-danger"> *</span>
                        </label>
                        <select name="assign[]" id="assign" multiple required class="form-select">
                            @if(auth_user()->agent == App\Enums\StatusEnum::false->status() && auth_user()->super_agent != 1)
                                <option value="{{auth_user()->id}}">
                                    {{translate('Me')}}
                                </option>
                            @endif
                            @forelse($agents as $agent)
                                <option value="{{$agent->id}}">
                                    {{ auth_user()->id == $agent->id ? 'me' : $agent->name}}
                                </option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="message-text" class="col-form-label">{{translate("Message")}}:</label>
                        <textarea class="form-control" name="short_note" id="message-text"
                            placeholder="{{translate("Write Short Note Here")}} ...... "></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        {{translate("Close")}}
                    </button>
                    <button type="submit" class="btn btn-primary assignedToBtn">
                        {{translate('Submit')}}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection


@push('script-include')
    <script src="{{asset('assets/global/js/flatpickr.js')}}"></script>
@endpush



@push('script-push')
    <script>
        (function ($) {
            "use strict";


            $("#searchDate").flatpickr({
                mode: "range"
            });


            $(document).on('submit', '#ticketbulkForm', function (e) {
                const checkedIds = $('.ticket-check-box:checked').map(function () {
                    return $(this).val();
                }).get();

                $('#bulkTicketId').val(JSON.stringify(checkedIds));

            });


            $("#assign").select2({
                dropdownParent: $("#assignModal"),
            });

            $(document).on('click', '.assign-ticket', function (e) {
                var modal = $("#assignModal");

                var ticketId = $(this).data('ticket-id');
                var agentIds = $(this).data('agents');

                modal.find('input.assign-ticket').val(ticketId);

                modal.find('#assign').val(null).trigger('change');

                if (Array.isArray(agentIds)) {
                    $('#assign').val(agentIds).trigger('change');
                }


                modal.modal('show')
                e.preventDefault()
            })




            $(document).on('click', '.response-modal', function (e) {

                var modal = $("#responseTimeModal");

                var priority = JSON.parse($(this).attr('data-priority'))
                var responseAt = JSON.parse($(this).attr('data-response'))
                var resolvedAt = JSON.parse($(this).attr('data-resolved'))
                var colorCode = priority.color_code
                var priorityName = priority.name

                var span = `<span class="  badge rounded-pill" style="background: ${colorCode}" >
                               ${priorityName}
                           </span>`;

                var response = `<div class='mb-2' >
                                                Response In: ${priority.response_time.in} ${priority.response_time.format}

                                                 <span class=" ${responseAt.status ? "text-success" : "text-danger"}  ms-2"> (<i class="ri-${responseAt.status ? "checkbox" : "close"}-circle-line ${responseAt.status ? "link-success" : "link-danger"}  badge-icon"></i> ${responseAt.message}) </span>

                                            </div>
                                            <div>
                                                Resolve In: ${priority.resolve_time.in} ${priority.resolve_time.format}
                                                <span class="${resolvedAt.status ? "text-success" : "text-danger"} ms-2"> (<i class="ri-${resolvedAt.status ? "checkbox" : "close"}-circle-line ${resolvedAt.status ? "link-success" : "link-danger"} badge-icon"></i> ${resolvedAt.message}) </span>
                                            </div>`

                $('#responseTime').html(response)


                $("#prioritySection").html(
                    `<span class > Priority </span> : ${span}`
                )

                modal.modal('show')
                e.preventDefault()
            })


            var page = 1;
            var category_id = null;
            var status = null;
            var department_id = null;

            @if(request()->routeIs("admin.ticket.pending"))
                status = "{{App\Enums\TicketStatus::PENDING->value}}";
            @elseif(request()->routeIs("admin.ticket.solved"))
                status = "{{App\Enums\TicketStatus::SOLVED->value}}";
            @elseif(request()->routeIs("admin.ticket.closed"))
                status = "{{App\Enums\TicketStatus::CLOSED->value}}";
            @endif

            @if(request()->routeIs("admin.ticket.category"))
                category_id = "{{request()->route('categoryId')}}"
            @endif


            var tag = null;
            var priority = null;
            var reset = false;
            var search = null;
            var date_range = null;
            var agent_id = "{{request()->route('id')}}";
            $(document).ready(function () {

                loadMoreData(page);
            });



            $(document).on('click', '.filter', function (e) {
                reset = true;
                search = $('#searchInput').val();
                date_range = $('#searchDate').val();
                priority = $('#priority').val();
                status = $('#status').val();
                loadMoreData(page, true);
            });

            //get data by tag
            $(document).on('click', '.ticket-tag', function (e) {

                page = 1;
                reset = true;
                status = null;
                date_range = null
                priority = null
                search = null;
                tag = $(this).attr('data-tag')
                loadMoreData(page, true);
            })



            $(document).on('click', '.pagination a', function (event) {
                event.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                loadMoreData(page)
            });



            //reset ticket view
            $(document).on('click', '.reset-table', function (e) {

                $("#searchInput").val('')
                $("#searchDate").val('')
                page = 1;
                reset = true;
                status = null;
                search = null;
                date_range = null
                priority = null
                tag = null;
                category_id = null;
                department_id = null;
                loadMoreData(page);
                e.preventDefault()
            })

            //get ticket by category
            $(document).on('click', '.ticket-category', function (e) {

                category_id = $(this).attr('data-id')
                page = 1;
                reset = true;

                tag = null;
                loadMoreData(page)
                $('.ticket-categoires .active').removeClass('active');
                $(this).addClass('active')
                e.preventDefault()
            })


            //get ticket by department
            $(document).on('click', '.ticket-by-department', function (e) {

                page = 1;

                reset = true;
                category_id = null;
                status = null;
                search = null;
                date_range = null
                priority = null
                tag = null;
                department_id = $(this).attr('data-id')

                loadMoreData(page, true)
                e.preventDefault()

            });

            //get ticket by status
            $(document).on('click', '.status-filter-btn', function (e) {
                page = 1;
                reset = true;
                status = $(this).attr('data-status')
                loadMoreData(page, true)
                e.preventDefault()

            });

            // load more data after scroll
            function loadMoreData(page, loadBtn = false) {

                var url = "{{route('admin.ticket.list')}}" + '?page=' + page
                $.ajax({
                    url: url,
                    type: "get",
                    data: {
                        'category_id': category_id,
                        'status': status,
                        'tag': tag,
                        'search': search,
                        'date_range': date_range,
                        'agent_id': agent_id,
                        'priority': priority,
                        'department_id': department_id,
                    },
                    dataType: 'json',
                    beforeSend: function () {
                        $('#elmLoader').removeClass('d-none');
                    },
                    success: (function (response) {

                        $('#elmLoader').addClass('d-none');

                        $(".ticket-categories").html(response.categories_html)
                        $(".tag-list").html(response.tag_html)
                        $(".ticket-department").html(response.department_html)
                        $('#ticket-list').html(response.ticket_html)
                        $(`#checkall`).prop('checked', false);

                    }),

                    error: (function (response) {
                        $('#elmLoader').addClass('d-none');

                        $('#ticket-list').html(`
                                        <div class="text-center text-danger mt-10">
                                            ${response.statusText}
                                        </div>
                                    `)

                        toastr(response.statusText, 'danger');

                    })
                })
            }

            // check all checkbox
            $(document).on('click', '#checkall', function (e) {

                if ($(this).is(':checked')) {
                    $('#ticketAction').removeClass('d-none')
                    $(`.ticket-checked`).prop('checked', true);
                }
                else {
                    $('#ticketAction').addClass('d-none')
                    $(`.ticket-checked`).prop('checked', false);
                }
            });

            //single checkbox event

            $(document).on('click', '.ticket-checked', function (e) {

                if ($(this).is(':checked')) {
                    $('#ticketAction').removeClass('d-none')
                }
                else {
                    if ($(`.ticket-checked:checked`).length == 0) {
                        $('#ticketAction').addClass('d-none')
                    }
                }
                checkebox_event(".ticket-checked", '#checkall');

            });

            //mark delete evenet
            $(document).on('click', ".mark-delete", function (e) {
                $('#mark-delete-modal').modal('show')
            });

            //cofirm delete
            $(document).on('click', "#markDeleteItem", function (e) {
                e.preventDefault()
                $('#ticketbulkForm').submit()

            });


            //delete event start
            $(document).on('click', ".delete-item", function (e) {
                e.preventDefault();

                var href = $(this).attr('data-href');
                var modal = $("#delete-modal");
                if ($('#ticketModal').hasClass('show')) {
                    modal.css("z-index", "999999");
                    $('.modal-backdrop').css("z-index", '9999');
                }
                $("#delete-href").attr("href", href);
                modal.modal("show");

            })

        })(jQuery);
    </script>
@endpush
