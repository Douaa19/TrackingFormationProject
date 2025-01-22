@extends('user.layouts.master')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="h-100">
                <div class="row col-xl-12">
                    <div class="col-xl">
                        <div class="card">
                            <div class="card-header align-items-center d-flex gap-3">
                                <h3 class="card-title text-18 mb-0 flex-grow-1">
                                    {{ translate(
    $data['user']['training_type'] == 'engineering_training_(GIAC+CSF)'
    ? 'No Planned Training'
    : Str::title(str_replace('_', ' ', $data['user']['training_type'] ?? $data['user']['training_type']))
) }}
                                </h3>

                                <a href="{{route('user.dashboard')}}"
                                    class=" me-2 btn link-success btn-icon btn-sm reset-table res fs-18">
                                    <i class="ri-refresh-line align-bottom"></i>
                                </a>

                                {{-- <div class="flex-shrink-0">

                                    <div class="dropdown card-header-dropdown">
                                        <a class="text-reset dropdown-btn show" href="javascript:void(0)"
                                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            <span class="fw-semibold text-uppercase fs-12">{{translate("Sort by")}}:
                                            </span><span class="text-muted">
                                                {{ request()->filter? ucwords(str_replace("_"," ",request()->filter))
                                                :translate("All") }}
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
                                </div> --}}
                            </div><!-- end card header -->


                            <tbody>


                            </tbody>

                        </div> <!-- .card-->
                    </div>
                </div>
                <div class="row justify-content-around gap-0">
                    @php
                        $trainingType = $data['user']['training_type'];
                        $phases = $data['trainingsAndStatus'][$trainingType];
                        $currentStatus = $data['user']['status'];
                        $statusReached = false;
                        $isConfirmation = $currentStatus === 'confirmation';
                    @endphp

                    @foreach ($phases as $index => $phase)
                                        @php
                                            $cardClass = "bg-white";

                                            if (!$isConfirmation) {
                                                if ($phase == $currentStatus) {
                                                    $cardClass = 'bg-warning';
                                                    $statusReached = true;
                                                } elseif (!$statusReached) {
                                                    $cardClass = 'bg-success';
                                                }
                                            }

                                            // if ($phase == $currentStatus) {
                                            //     $cardClass = 'bg-warning';
                                            //     $statusReached = true;
                                            // } elseif (!$statusReached) {
                                            //     $cardClass = 'bg-success';
                                            // } else {
                                            //     $cardClass = 'bg-white';*
                                            // }
                                        @endphp
                                        <div class="col-xl-2 col-md-4 m-0 p-0">
                                            <div class="card card-animate {{ $cardClass }}">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-grow-1 overflow-hidden">
                                                            <p
                                                                class="text-uppercase fw-medium text-truncate mb-0 {{ $phase == $currentStatus ? 'text-white' : ($cardClass == 'bg-success' ? 'text-white' : 'text-muted') }}">
                                                                {{ translate(ucwords(str_replace('_', ' ', $phase))) }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                    @endforeach
                </div>
                <div class="row d-flex justify-content-center">
                    @if ($data['agent_user'])
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">
                                        {{translate('Agent Information')}}
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">
                                                    {{translate('Agent Name')}}
                                                </label>
                                                <p class="text-muted mb-0">{{$data['agent_user']['agent']['name']}}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">
                                                    {{translate('Agent Email')}}
                                                </label>
                                                <p class="text-muted mb-0">{{$data['agent_user']['agent']['email']}}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">
                                                    {{translate('Agent Phone')}}
                                                </label>
                                                <p class="text-muted mb-0">{{$data['agent_user']['agent']['phone']}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-xl-8">
                            <div class="col-xl-12">
                                <div class="card py-2">
                                    <div class="card-body text-center">
                                        <p class="fs-6 text-uppercase text-muted mb-0">
                                            {{ translate("You haven't been assigned to any agent at the moment! Please check again later.") }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script-push')
    <script>
        (function ($) {
            "use strict";

            //  ticket by category chart
            var chartDonutBasicColors = getChartColorsArray("ticket-by-category");

            var categoryLabel = @json(array_keys($data['ticket_by_category']));
            var categoryValues = @json(array_values($data['ticket_by_category']));

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
            var ticketLabel = @json(array_keys($data['ticket_by_year']));
            var counterVlues = @json(array_values($data['ticket_by_year']));
            var linechartBasicColors = getChartColorsArray("ticket-by-month"),
                linechartZoomColors =
                    (linechartBasicColors &&
                        ((options = {
                            series: [
                                { name: "Tickets", data: counterVlues },
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


            $(document).on('click', ".ticket-filter", function (e) {
                var day = $(this).attr('data-day')
                $('#filterValue').val(day)
                $('#filter-form').submit()
                e.preventDefault();
            })



        })(jQuery);
    </script>
@endpush
