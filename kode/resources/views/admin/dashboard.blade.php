@extends('admin.layouts.master')
@section('content')
@php
    $agent_boolean = auth_user()->agent;

@endphp
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="h-100">
                @php
                    $currentYear = \Carbon\Carbon::now()->year;
                @endphp

                @php
                    $currentYear = \Carbon\Carbon::now()->year;
                @endphp

                @php
                    if ($agent_boolean == 1) {
                        $extra = "";
                    } else {
                        $extra = "";
                    }
                @endphp
                <div class="row mb-3 pb-1">
                    <div class="col-12">
                        <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                            <div class="flex-grow-1">
                                <h4 class="fs-16 mb-1">{{translate("Welcome")}} {{auth_user()->name}} {{$extra}} </h4>
                                <p class="text-muted mb-0">
                                    {{translate("Here's what's happening with your System")}}
                                </p>
                            </div>

                            <div class="mt-3 mt-lg-0">
                                <form action="javascript:void(0);">
                                    <div class="row g-3 align-items-center">
                                        <div class="col-auto">
                                            <p class="fs-14 badge badge-soft-secondary mb-0">
                                                @php
                                                    $cornRunAt = App\Models\Settings::where('key', 'last_cron_run')->first();
                                                    site_settings('last_cron_run');

                                                @endphp
                                                {{translate('Last cron run')}} :
                                                {{  $cornRunAt ? diff_for_humans($cornRunAt->value) : "N/A"}}
                                            </p>
                                        </div>

                                        <div class="col-auto">
                                            <div class="input-group">
                                                <div class="dropdown card-header-dropdown">

                                                    <a class="text-reset btn-primary dropdown-btn show"
                                                        href="javascript:void(0)" data-bs-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="true">
                                                        <span
                                                            class="fw-semibold text-uppercase fs-12">{{ translate('Sort by') }}:
                                                        </span><span class="text-muted">
                                                            {{ request()->filter ? ucwords(str_replace('_', ' ', request()->filter)) : translate('All') }}
                                                            <i class="mdi mdi-chevron-down ms-1"></i></span>
                                                    </a>


                                                    <ul class="dropdown-menu dropdown-menu-end "
                                                        data-popper-placement="top-end">
                                                        <li class="dropdown-item ticket-filter" data-day="all">
                                                            {{ translate('All') }}
                                                        </li>
                                                        <li class="dropdown-item ticket-filter" data-day="today">
                                                            {{ translate('Today') }}
                                                        </li>
                                                        <li class="dropdown-item ticket-filter" data-day="yesterday">
                                                            {{ translate('Yesterday') }}
                                                        </li>
                                                        <li class="dropdown-item ticket-filter" data-day="last_7_days">
                                                            {{ translate('Last 7 Days') }}
                                                        </li>
                                                        <li class="dropdown-item ticket-filter" data-day="last_30_days">
                                                            {{ translate('Last 30 Days') }}
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>



                                        </div>

                                        <div class="col-auto">
                                            <div class="d-flex align-items-center gap-3">
                                                <a href="{{ route('admin.dashboard') }}"
                                                    class="btn right-menu-btn btn-soft-warning btn-icon reset-table res">
                                                    <i class="ri-refresh-line align-bottom"></i>
                                                </a>
                                                <button type="button"
                                                    class="btn right-menu-btn btn-soft-info btn-icon layout-rightsidebar-btn waves ripple-light"><i
                                                        class="ri-pulse-line"></i></button>
                                            </div>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-start align-items-center gap-0 h-full">
                    <div class="col-xl-5">
                        <div class="card crm-widget">
                            <div class="card-body p-0">
                                <div class="row row-cols-lg-3 row-cols-sm-2 row-cols-1">
                                    <div class="col col-xl crm-widget-card">
                                        <div class="py-4 px-3">
                                            <div class="d-flex align-items-center mb-1">
                                                <div class="flex-shrink-0">
                                                    <i class="link-secondary ri-group-line display-6"></i>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h2 class="mb-0">
                                                        {{ translate('Formation directe (CSF)') }}
                                                    </h2>
                                                </div>
                                            </div>
                                            <h5 class="text-muted text-uppercase fs-5 mt-2">
                                                {{ translate('Total Clients') }} {{$data['direct_training_users']}}
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($agent_boolean !== 1)
                        <div class="col-xl-2 col-md-4">
                            <div class="card crm-widget">
                                <div class="card-body p-0">
                                    <div class="row row-cols-lg-3 row-cols-sm-2 row-cols-1">
                                        <div class="col col-xl crm-widget-card">
                                            <div class="py-4 px-3">
                                                <div class="d-flex align-items-center mb-1">
                                                    <div class="flex-shrink-0">
                                                        <i class="link-secondary ri-money-dollar-circle-line display-6"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h2 class="mb-0">
                                                            {{ translate('CAE') }}
                                                        </h2>
                                                    </div>
                                                </div>
                                                <h5 class="text-muted text-uppercase fs-5 mt-2">
                                                    {{$data['direct_training_total_revenue']}} DHS
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="col-xl-2 col-md-4">
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                            {{translate('Confirmation Phase')}}
                                        </p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-1">
                                    <div>
                                        <h2 class="fs-22 mb-4">
                                            {{ num_short($data['direct_training_users_phase_0']) }}
                                        </h2>
                                        <a href="{{route('admin.user.phase.list', ['training_type' => 'direct_training_(csf)', 'phase' => 'confirmation'])}}"
                                            class="text-decoration-underline">
                                            {{translate("View All")}}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row justify-content-around gap-0">
                    <div class="col-xl-2 col-md-4 m-0 p-0">
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">

                                            {{translate('Qualification Phase')}}

                                        </p>
                                    </div>
                                    {{-- <div class="flex-shrink-0">
                                        <h5 class="text-success fs-14 mb-0">
                                            <i class="ri-arrow-right-up-line fs-13 align-middle"></i>
                                            {{ num_short($data['total_tickets_increase']) }}%
                                        </h5>
                                    </div> --}}
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h2 class="fs-22 mb-4">
                                            {{ num_short($data['direct_training_users_phase_1']) }}
                                        </h2>

                                        <a href="{{route('admin.user.phase.list', ['training_type' => 'direct_training_(CSF)', 'phase' => 'Phase Qualification'])}}"
                                            class="text-decoration-underline">
                                            {{translate("View All")}}

                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-4 m-0 p-0">
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">

                                            {{translate('Administrative Preliminary Phase')}}

                                        </p>
                                    </div>
                                    {{-- <div class="flex-shrink-0">
                                        <h5 class="text-success fs-14 mb-0">
                                            <i class="ri-arrow-right-up-line fs-13 align-middle"></i>
                                            {{ num_short($data['total_tickets_increase']) }}%
                                        </h5>
                                    </div> --}}
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h2 class="fs-22 mb-4">
                                            {{ num_short($data['direct_training_users_phase_2']) }}
                                        </h2>

                                        <a href="{{route('admin.user.phase.list', ['training_type' => 'direct_training_(CSF)', 'phase' => 'Phase Administrative Pralable'])}}"
                                            class="text-decoration-underline">

                                            {{translate("View All")}}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-4 m-0 p-0">
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">

                                            {{translate('Validation Phase')}}

                                        </p>
                                    </div>
                                    {{-- <div class="flex-shrink-0">
                                        <h5 class="text-success fs-14 mb-0">
                                            <i class="ri-arrow-right-up-line fs-13 align-middle"></i>
                                            {{ num_short($data['total_tickets_increase']) }}%
                                        </h5>
                                    </div> --}}
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h2 class="fs-22 mb-4">
                                            {{ num_short($data['direct_training_users_phase_3']) }}
                                        </h2>

                                        <a href="{{route('admin.user.phase.list', ['training_type' => 'direct_training_(CSF)', 'phase' => 'Phase Validation'])}}"
                                            class="text-decoration-underline">

                                            {{translate("View All")}}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-4 m-0 p-0">
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">

                                            {{translate('Construction Phase')}}

                                        </p>
                                    </div>
                                    {{-- <div class="flex-shrink-0">
                                        <h5 class="text-success fs-14 mb-0">
                                            <i class="ri-arrow-right-up-line fs-13 align-middle"></i>
                                            {{ num_short($data['total_tickets_increase']) }}%
                                        </h5>
                                    </div> --}}
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h2 class="fs-22 mb-4">
                                            {{ num_short($data['direct_training_users_phase_4']) }}
                                        </h2>

                                        <a href="{{route('admin.user.phase.list', ['training_type' => 'direct_training_(CSF)', 'phase' => 'Phase Réalisation'])}}"
                                            class="text-decoration-underline">

                                            {{translate("View All")}}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-4 m-0 p-0">
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">

                                            {{translate('Repayment Phase')}}

                                        </p>
                                    </div>
                                    {{-- <div class="flex-shrink-0">
                                        <h5 class="text-success fs-14 mb-0">
                                            <i class="ri-arrow-right-up-line fs-13 align-middle"></i>
                                            {{ num_short($data['total_tickets_increase']) }}%
                                        </h5>
                                    </div> --}}
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h2 class="fs-22 mb-4">
                                            {{ num_short($data['direct_training_users_phase_5']) }}
                                        </h2>

                                        <a href="{{route('admin.user.phase.list', ['training_type' => 'direct_training_(CSF)', 'phase' => 'Phase Remboursement'])}}"
                                            class="text-decoration-underline">

                                            {{translate("View All")}}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-start align-items-center gap-0 h-full">
                    <div class="col-xl-5">
                        <div class="card crm-widget">
                            <div class="card-body p-0">
                                <div class="row row-cols-lg-3 row-cols-sm-2 row-cols-1">
                                    <div class="col col-xl crm-widget-card">
                                        <div class="py-4 px-3">
                                            <div class="d-flex align-items-center mb-1">
                                                <div class="flex-shrink-0">
                                                    <i class="link-secondary ri-group-line display-6"></i>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h2 class="mb-0">
                                                        {{ translate('Ingénierie + Formation') }}
                                                    </h2>
                                                </div>
                                            </div>
                                            <h5 class="text-muted text-uppercase fs-5 mt-2">
                                                {{ translate('Total Clients') }} {{$data['engineering_training_users']}}
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($agent_boolean !== 1)
                        <div class="col-xl-2 col-md-4">
                            <div class="card crm-widget">
                                <div class="card-body p-0">
                                    <div class="row row-cols-lg-3 row-cols-sm-2 row-cols-1">
                                        <div class="col col-xl crm-widget-card">
                                            <div class="py-4 px-3">
                                                <div class="d-flex align-items-center mb-1">
                                                    <div class="flex-shrink-0">
                                                        <i class="link-secondary ri-money-dollar-circle-line display-6"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h2 class="mb-0">
                                                            {{ translate('CAE') }}
                                                        </h2>
                                                    </div>
                                                </div>
                                                <h5 class="text-muted text-uppercase fs-5 mt-2">
                                                    {{$data['engineering_training_users_total_revenue']}} DHS
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="col-xl-2 col-md-4">
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                            {{translate('Confirmation Phase')}}
                                        </p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-1">
                                    <div>
                                        <h2 class="fs-22 mb-4">
                                            {{ num_short($data['engineering_training_users_phase_0']) }}
                                        </h2>
                                        <a href="{{route('admin.user.phase.list', ['training_type' => 'engineering_training_(GIAC+CSF)', 'phase' => 'confirmation'])}}"
                                            class="text-decoration-underline">
                                            {{translate("View All")}}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="row justify-content-around gap-0">
                    <div class="col-xl-2 col-md-4 m-0 p-0">
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">

                                            {{translate('Qualification Phase')}}

                                        </p>
                                    </div>
                                    {{-- <div class="flex-shrink-0">
                                        <h5 class="text-success fs-14 mb-0">
                                            <i class="ri-arrow-right-up-line fs-13 align-middle"></i>
                                            {{ num_short($data['total_tickets_increase']) }}%
                                        </h5>
                                    </div> --}}
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h2 class="fs-22 mb-4">
                                            {{ num_short($data['engineering_training_users_phase_1']) }}
                                        </h2>

                                        <a href="{{route('admin.user.phase.list', ['training_type' => 'engineering_training_(GIAC+CSF)', 'phase' => 'Phase Qualification'])}}"
                                            class="text-decoration-underline">

                                            {{translate("View All")}}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-4 m-0 p-0">
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">

                                            {{translate('Engineering Phase')}}

                                        </p>
                                    </div>
                                    {{-- <div class="flex-shrink-0">
                                        <h5 class="text-success fs-14 mb-0">
                                            <i class="ri-arrow-right-up-line fs-13 align-middle"></i>
                                            {{ num_short($data['total_tickets_increase']) }}%
                                        </h5>
                                    </div> --}}
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h2 class="fs-22 mb-4">
                                            {{ num_short($data['engineering_training_users_phase_2']) }}
                                        </h2>

                                        <a href="{{route('admin.user.phase.list', ['training_type' => 'engineering_training_(GIAC+CSF)', 'phase' => 'Phase Ingénierie (GIAC)'])}}"
                                            class="text-decoration-underline">

                                            {{translate("View All")}}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-4 m-0 p-0">
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">

                                            {{translate('Phase CSF')}}

                                        </p>
                                    </div>
                                    {{-- <div class="flex-shrink-0">
                                        <h5 class="text-success fs-14 mb-0">
                                            <i class="ri-arrow-right-up-line fs-13 align-middle"></i>
                                            {{ num_short($data['total_tickets_increase']) }}%
                                        </h5>
                                    </div> --}}
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h2 class="fs-22 mb-4">
                                            {{ num_short($data['engineering_training_users_phase_3']) }}
                                        </h2>

                                        <a href="{{route('admin.user.phase.list', ['training_type' => 'engineering_training_(GIAC+CSF)', 'phase' => 'Phase CSF'])}}"
                                            class="text-decoration-underline">

                                            {{translate("View All")}}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-4 m-0 p-0">
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">

                                            {{translate('Construction Phase')}}

                                        </p>
                                    </div>
                                    {{-- <div class="flex-shrink-0">
                                        <h5 class="text-success fs-14 mb-0">
                                            <i class="x-gmdi-support-agent"></i>
                                            {{ num_short($data['total_tickets_increase']) }}%
                                        </h5>
                                    </div> --}}
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h2 class="fs-22 mb-4">
                                            {{ num_short($data['engineering_training_users_phase_4']) }}
                                        </h2>

                                        <a href="{{route('admin.user.phase.list', ['training_type' => 'engineering_training_(GIAC+CSF)', 'phase' => 'Phase Réalisation'])}}"
                                            class="text-decoration-underline">

                                            {{translate("View All")}}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-4 m-0 p-0">
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">

                                            {{translate('Repayments Phase')}}

                                        </p>
                                    </div>
                                    {{-- <div class="flex-shrink-0">
                                        <h5 class="text-success fs-14 mb-0">
                                            <i class="ri-arrow-right-up-line fs-13 align-middle"></i>
                                            {{ num_short($data['total_tickets_increase']) }}%
                                        </h5>
                                    </div> --}}
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h2 class="fs-22 mb-4">
                                            {{ num_short($data['engineering_training_users_phase_5']) }}
                                        </h2>

                                        <a href="{{route('admin.user.phase.list', ['training_type' => 'engineering_training_(GIAC+CSF)', 'phase' => 'Phase Remboursement'])}}"
                                            class="text-decoration-underline">

                                            {{translate("View All")}}
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
@endsection

@push('script-push')
    <script>
        (function ($) {
            "use strict";

            var categoryChart = getChartColorsArray("ticket-by-category");
            var userChart = getChartColorsArray("ticket-by-user");

            var categoryLabel = @json(array_keys($data['ticket_by_category']));
            var categoryValues = @json(array_values($data['ticket_by_category']));


            var userLabel = @json(array_keys($data['ticket_by_user']));
            var userValues = @json(array_values($data['ticket_by_user']));

            if (categoryChart) {

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
                    colors: categoryChart,
                };

                var chart = new ApexCharts(
                    document.querySelector("#ticket-by-category"),
                    options
                );
                chart.render();


            }

            if (userChart) {
                var options = {
                    series: userValues,
                    labels: userLabel,
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
                    colors: userChart,
                };

                var chart = new ApexCharts(
                    document.querySelector("#ticket-by-user"),
                    options
                );
                chart.render();
            }


            var linechartBasicColors = getChartColorsArray("ticket-by-month");

            var graphLabel = @json(($data['ticket_mix_graph']['label']));
            var tickets = @json(array_values($data['ticket_mix_graph']['tickets']));
            var openedTickets = @json(array_values($data['ticket_mix_graph']['open']));
            var closedTickets = @json(array_values($data['ticket_mix_graph']['closed']));

            var options = {
                series: [{
                    name: "{{translate('Opened Tickets')}}",
                    type: "area",
                    data: openedTickets,
                },
                {
                    name: "{{translate('Tickets')}}",
                    type: "bar",
                    data: tickets,
                },
                {
                    name: "{{translate('Closed Tickets')}}",
                    type: "line",
                    data: closedTickets,
                },
                ],
                chart: {
                    height: 300,
                    type: "line",
                    toolbar: {
                        show: false,
                    },
                },
                stroke: {
                    curve: "straight",
                    dashArray: [0, 0, 8],
                    width: [2, 0, 2.2],
                },
                fill: {
                    opacity: [0.1, 0.9, 1],
                },
                markers: {
                    size: [0, 0, 0],
                    strokeWidth: 2,
                    hover: {
                        size: 4,
                    },
                },
                xaxis: {
                    categories: graphLabel,
                    axisTicks: {
                        show: false,
                    },
                    axisBorder: {
                        show: false,
                    },
                },
                grid: {
                    show: true,
                    xaxis: {
                        lines: {
                            show: true,
                        },
                    },
                    yaxis: {
                        lines: {
                            show: false,
                        },
                    },
                    padding: {
                        top: 0,
                        right: -2,
                        bottom: 15,
                        left: 10,
                    },
                },
                legend: {
                    show: true,
                    horizontalAlign: "center",
                    offsetX: 0,
                    offsetY: -5,
                    markers: {
                        width: 9,
                        height: 9,
                        radius: 6,
                    },
                    itemMargin: {
                        horizontal: 10,
                        vertical: 0,
                    },
                },
                plotOptions: {
                    bar: {
                        columnWidth: "10%",
                        barHeight: "70%",
                    },
                },
                colors: linechartBasicColors,
                tooltip: {
                    shared: true,
                    y: [{
                        formatter: function (y) {
                            if (typeof y !== "undefined") {
                                return y.toFixed(0);
                            }
                            return y;
                        },
                    },
                    {
                        formatter: function (y) {
                            if (typeof y !== "undefined") {
                                return y.toFixed(0);
                            }
                            return y;
                        },
                    },
                    {
                        formatter: function (y) {
                            if (typeof y !== "undefined") {
                                return y.toFixed(0);
                            }
                            return y;
                        },
                    },
                    ],
                },
            };
            var chart = new ApexCharts(
                document.querySelector("#ticket-by-month"),
                options
            );
            chart.render();


            $(document).on('click', ".ticket-filter", function (e) {
                var day = $(this).attr('data-day')
                $('#filterValue').val(day)
                $('#filter-form').submit()
                e.preventDefault();
            })
        })(jQuery);
    </script>
@endpush