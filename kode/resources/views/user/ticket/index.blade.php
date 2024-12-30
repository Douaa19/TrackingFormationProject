@extends('user.layouts.master')
@push('styles')
   <link href="{{ asset('assets/global/css/ticket.css') }}" rel="stylesheet" type="text/css" />

   <style>

    .custom--tooltip{
        position: relative;
        display: inline-block;
        cursor: pointer;
        .tooltip-text{
            position: absolute;
            bottom: 25px;
            left: 50%;
            max-width: 150px;
            background: #111;
            white-space:wrap;
            padding: 10px;
            color: #ddd;
            transform: translateX(-50%);
            border-radius:10px;
            display:none;
            z-index:999 !important;
        }

        &:hover{
            .tooltip-text {
                display: block;
            }
        }
    }
</style>
@endpush

@section('content')
    <div class="container-fluid px-0">
        <div class="ticket-body-wrapper">
            <div class="row g-0">
                <div class="col-auto ticket-sidebar">
                    <div class="ticket-sidebar-sticky py-4">
                        <div class="px-xl-4 px-lg-3 px-4 ticket-sidebar-scroll" data-simplebar>
                            <div class="email-menu-sidebar">
                                <div>
                                    <h5 class="fs-12 text-uppercase tag-header">
                                        {{translate("Inbox")}}
                                    </h5>
                                    <div class="mail-list ticket-categories">
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>

                <div class="col ticket-content">
                    <form action="{{route('user.ticket.mark')}}" id="ticketForm" method="post" >
                        @csrf
                        <div class="card shadow-none rounded-none mb-0">
                            <div class="ticket-sidebar-sticky">
                                <div class="card-body border-bottom py-3 bg-white">
                                    <div class="row gx-0 gy-3 align-items-center">
                                        <div class="col-xl-2 col-md-3">
                                            <div class="d-flex align-items-center gap-2">
                                                <a href="{{route('user.dashboard')}}" class="btn btn-primary waves ripple-light d-flex align-items-center gap-2 lh-1">
                                                    <i class="ri-arrow-go-back-fill align-bottom fs-5"></i>
                                                    {{translate("Back")}}
                                                </a>

                                                <button type="button" class="btn  btn-soft-primary btn-icon btn-sm fs-16 d-xl-none" id="ticket-menu-btn">
                                                 <i class="ri-bar-chart-horizontal-fill align-bottom"></i>
                                                </button>

                                                <div class="dropdown">
                                                    <button class="btn btn-soft-info btn-icon btn-sm fs-16" type="button"
                                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                                        <i class="ri-file-ppt-2-line align-bottom"></i>
                                                    </button>
                                                    <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top"
                                                    title="Export"    class="dropdown-menu">

                                                        <a class="dropdown-item" href="{{route('user.ticket.export','pdf')}}">
                                                            {{Translate('Export As Pdf')}}
                                                        </a>

                                                        <a class="dropdown-item" href="{{route('user.ticket.export','csv')}}">
                                                            {{Translate('Export As Csv')}}
                                                        </a>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-10 col-md-9">
                                            <div class="d-flex gap-3 flex-wrap flex-sm-nowrap align-items-center gap-sm-1 email-topbar-link">

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

                                                <input type="text" class="form-control" id="searchInput" name="search" placeholder="{{translate('Ticket Number')}}" >

                                                <button type="button" class="filter btn btn-primary btn-md"> <i class="ri-search-line me-1 align-bottom"></i>

                                                <button type="button" class="btn btn-danger btn-md reset-table res">
                                                    <i class="ri-refresh-line align-bottom"></i>
                                                </button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body p-0">
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" >
                                        <div class="table-responsive ticket-table position-relative">

                                            <div class="d-none" id="elmLoader">
                                                <div class="spinner-border text-secondary border-3 avatar-sm" role="status">
                                                    <span class="visually-hidden"></span>
                                                </div>
                                            </div>

                                            <div class="message-list" id="ticket-list">

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style-include')
    <link href="{{ asset('assets/global/css/ticket.css') }}" rel="stylesheet" type="text/css" />
@endpush



@push('script-push')
    <script>
        (function($) {
            "use strict";

        var page = 1;
        var category_id = null;
        var status = null;
        var reset = false;
        var search = null;


        loadMoreData(page);

        $(document).on('keypress','#searchInput',function(e){

            var keycode = (event.keyCode ? event.keyCode : event.which);
            if(keycode == '13'){
                reset = true;
                search = $(this).val();
                loadMoreData(page,true);
                e.preventDefault();
            }
        });

        $(document).on('click','.filter',function(e){
            reset  = true;
            search = $('#searchInput').val();
            status = $('#status').val();
            loadMoreData(page,true);
        });



        $(document).on('click', '.pagination a', function(event){
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            loadMoreData(page)
        });

        $(document).on('click','.reset-table',function(e){

            $("#searchInput").val('')
            page = 1;
            reset = true;
            status = null;
            search  = null;
            category_id= null;
            loadMoreData(page );
            e.preventDefault()
        })

        //get ticket by category
        $(document).on('click','.ticket-category',function(e){

            category_id = $(this).attr('data-id')
            page = 1;

            loadMoreData(page)
            $('.ticket-categoires .active').removeClass('active');
            $(this).addClass('active')
            e.preventDefault()
        })


        // load more data after scroll
        function loadMoreData(page ,loadBtn = false ) {

            $.ajax({
                    url: "{{route('user.ticket.list')}}",
                    type: "get",
                    data:{
                        'page' : page,
                        'category_id' : category_id,
                        'status' : status,
                        'search' : search,
                    },
                    dataType:'json',
                    beforeSend: function () {
                        $('#elmLoader').removeClass('d-none');
                    },
                    success:(function (response) {
                        $('#elmLoader').addClass('d-none');
                        $(".ticket-categories").html(response.categories_html)

                        $('#ticket-list').html(response.ticket_html)

                     }),

                     error:(function (error) {
                        $('#elmLoader').addClass('d-none');



                        if(error && error.responseJSON){
                            for (let i in error.responseJSON.errors) {
                                toastr(error.responseJSON.errors[i][0],'danger')
                            }
                        }
                         $('#ticket-list').html(`
                            <div class="text-center text-danger mt-10">
                                "{{translate('Something Went Wrong!!')}}"
                            </div>
                        `)

                    })
                })
        }


        })(jQuery);
    </script>
@endpush
