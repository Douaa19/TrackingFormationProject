@extends('user.layouts.master')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="h-100">
                    <div class="card crm-widget">
                        <div class="card-body p-0">
                            <div class="row row-cols-lg-3 row-cols-sm-2 row-cols-1">
                                <div class="col col-xl crm-widget-card">
                                    <div class="py-4 px-3">
                                        <h5 class="text-muted text-uppercase fs-13">{{translate('Total Tickets')}}</h5>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <i class="ri-message-2-line display-6 link-info"></i>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h2 class="mb-0">
                                                    {{   collect($data['ticket_status_counter'])->sum('total_ticket') }}
                                                </h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @foreach ($data['ticket_status_counter'] as $counter )

                                    <div class="col col-xl crm-widget-card">
                                        <div class="mt-3 mt-md-0 py-4 px-3">
                                            <h5 class="text-muted text-uppercase fs-13">{{translate('Total')}} {{$counter->name}} {{translate("Tickets")}}</h5>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    @php echo       $counter->icon @endphp
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h2 class="mb-0">
                                                        {{$counter->total_ticket}} 
                                                    </h2>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                @endforeach

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-8">
                            <div class="card">

                                 <form action="{{route('user.dashboard')}}" method="get" id="filter-form">

                                    <input type="hidden" name="filter" id="filterValue">

                                 </form>
                                <div class="card-header align-items-center d-flex gap-3 flex-wrap">
                                    <h4 class="card-title mb-0 flex-grow-1">
                                        {{translate('Latest Tickets')}}
                                    </h4>

                                    <a href="{{route('user.dashboard')}}" class=" me-2 btn link-success btn-icon btn-sm reset-table res fs-18">
                                        <i class="ri-refresh-line align-bottom"></i>
                                    </a>

                                    <div class="flex-shrink-0">

                                        <div class="dropdown card-header-dropdown">
                                            <a class="text-reset dropdown-btn show" href="javascript:void(0)" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                <span class="fw-semibold text-uppercase fs-12">{{translate("Sort by")}}:
                                                </span><span class="text-muted">
                                                      {{ request()->filter?  ucwords(str_replace("_"," ",request()->filter)) :translate("All")  }}
                                                    <i class="mdi mdi-chevron-down ms-1"></i></span>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end " data-popper-placement="top-end">
                                                <li class="dropdown-item ticket-filter" data-day="all">
                                                    {{translate("All")}}
                                                </li>
                                                <li class="dropdown-item ticket-filter" data-day="today">
                                                    {{translate("Today")}}
                                                </li>
                                                <li class="dropdown-item ticket-filter" data-day="yesterday">
                                                    {{translate("Yesterday")}}
                                                </li>
                                                <li class="dropdown-item ticket-filter" data-day="last_7_days">
                                                    {{translate("Last 7 Days")}}
                                                </li>
                                                <li class="dropdown-item ticket-filter" data-day="last_30_days">
                                                    {{translate("Last 30 Days")}}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div><!-- end card header -->

                                <div class="card-body">
                                        <div class="table-responsive pb-2">
                                            <table
                                                class="table table-border table-centered align-middle table-nowrap mb-0">
                                                <thead class="text-muted table-light">
                                                <tr>
                                                    <th scope="col">
                                                        {{translate("Ticket Id")}}
                                                    </th>
                                                    <th scope="col">
                                                        {{translate('Name')}}
                                                    </th>
                                                    <th scope="col">
                                                        {{translate("Email")}}
                                                    </th>
                                                    <th scope="col">
                                                        {{translate("Last Activity")}}
                                                    </th>
                                                    <th scope="col">
                                                        {{translate("Subject")}}
                                                    </th>
                                                    <th scope="col">
                                                        {{translate('Status')}}
                                                    </th>

                                                </tr>
                                                </thead>
                                                <tbody>

                                                @forelse($data['latest_ticket'] as $ticket)
                                                        <tr>
                                                            <td>
                                                                <a href="{{route('user.ticket.view',$ticket->ticket_number)}}"
                                                                    class="fw-medium link-primary">
                                                                    {{$ticket->ticket_number}}
                                                                </a>
                                                            </td>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="flex-shrink-0 me-2">

                                                                        @php
                                                                        $url = getImageUrl(getFilePaths()['profile']['user']['path'].'/'.@$user->image,getFilePaths()['profile']['user']['size']);
                                                                            if(filter_var(@$user->image, FILTER_VALIDATE_URL) !== false){
                                                                                $url = @$user->image;
                                                                            }
                                                                        @endphp
                                                                        <img src="{{ $url }}"
                                                                                alt="{{@$user->image}}"
                                                                                class="avatar-xs rounded-circle" />
                                                                    </div>
                                                                    <div class="flex-grow-1">
                                                                        {{limit_words($ticket->name,10)}}
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                {{$ticket->email}}
                                                            </td>
                                                            <td>
                                                                <span class="text-info">
                                                                    {{@getTimeDifference($ticket->messages()->latest()->first()->created_at)}}
                                                                </span>

                                                            </td>
                                                            <td>
                                                                {{limit_words($ticket->subject,15)}}
                                                            </td>

                                                            <td>
                                                                @php echo ticket_status($ticket->ticketStatus->name,$ticket->ticketStatus->color_code) @endphp 

                                                            </td>

                                                        </tr>
                                                        @empty
                                                            @include('admin.partials.not_found')
                                                        @endforelse


                                                </tbody>
                                            </table>
                                        </div>

                                </div>
                            </div> <!-- .card-->
                        </div>

                        <div class="col-xl-4">
                            <div class="card card-height-100">
                                <div class="card-header align-items-center d-flex gap-3 flex-wrap">
                                    <h4 class="card-title mb-0 flex-grow-1">
                                        {{translate('Ticket By Category')}}
                                    </h4>

                                </div><!-- end card header -->

                                <div class="card-body">

                                    @if(count($data['ticket_by_category']) != 0)
                                      <div id="ticket-by-category"
                                            data-colors='["--vz-primary", "--vz-success", "--vz-warning", "--vz-danger", "--vz-info"]'
                                            class="apex-charts" dir="ltr"></div>
                                    @else
                                       @include('admin.partials.not_found')
                                    @endif

                                </div>
                            </div>
                        </div>

                        <div class="col-xl-12">
                            <div class="card card-height-100">
                                <div class="card-header align-items-center d-flex gap-3 flex-wrap">
                                    <h4 class="card-title mb-0 flex-grow-1">
                                        {{translate('Ticket By Month')}}
                                    </h4>

                                </div><!-- end card header -->

                                <div class="card-body">
                                    <div id="ticket-by-month"
                                    data-colors='["--vz-primary"]'
                                            class="apex-charts" dir="ltr"></div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-push')
    <script>
        (function($){
            "use strict";

            //  ticket by category chart
            var chartDonutBasicColors = getChartColorsArray("ticket-by-category");

            var categoryLabel =  @json(array_keys($data['ticket_by_category']));
            var categoryValues =  @json(array_values($data['ticket_by_category']));

            if (chartDonutBasicColors) {
                var options = {
                    series: categoryValues,
                    labels: categoryLabel,
                    chart: {
                        height: 333,
                        type: "donut",
                    },
                    legend: {
                        position: "bottom",
                    },
                    stroke: {
                        show: false
                    },
                    dataLabels: {
                        dropShadow: {
                            enabled: false,
                        },
                    },
                    colors: chartDonutBasicColors,
                };

                var chart = new ApexCharts(
                    document.querySelector("#ticket-by-category"),
                    options
                );
                chart.render();
            }

            // ticket by months
            var ticketLabel =  @json(array_keys($data['ticket_by_year']));
            var counterVlues =  @json(array_values($data['ticket_by_year']));
            var linechartBasicColors = getChartColorsArray("ticket-by-month"),
            linechartZoomColors =
             (linechartBasicColors &&
            ((options = {
                series: [
                    { name: "Tickets", data: counterVlues  },
                ],
                chart: {
                    height: 350,
                    type: "line",
                    zoom: { enabled: !1 },
                    toolbar: { show: !1 },
                },
                markers: { size: 4 },
                dataLabels: { enabled: !1 },
                stroke: { curve: "straight" },
                colors: linechartBasicColors,
                title: {
                    text: `Tickets In ${new Date().getFullYear()}`,
                    align: "left",
                    style: { fontWeight: 500 },
                },
                xaxis: {
                    categories: ticketLabel,
                },
            }),
            (chart = new ApexCharts(
                document.querySelector("#ticket-by-month"),
                options
            )).render()))


            $(document).on('click',".ticket-filter",function(e){
                var day = $(this).attr('data-day')
                $('#filterValue').val(day)
                $('#filter-form').submit()
                e.preventDefault();
            })



        })(jQuery);
    </script>
@endpush
