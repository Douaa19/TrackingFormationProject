@extends('admin.layouts.master')

@push('styles')


<style>

    .mh-300{
        min-height: 300px ;
    }

</style>

@endpush
@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">
                        {{ translate($title) }}
                    </h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">
                                    {{ translate('Home') }}
                                </a></li>
                            <li class="breadcrumb-item active">
                                {{ translate('Visitors') }}
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
     
           
        <div class="card ">
            <div class="card-header border-0 align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">
                    {{ translate('Visitors') }}
                </h4>
            </div>

            
            <div class="card-body position-relative">

                <div class="row mb-3">
                    <div class="col-xl-4 offset-xl-8">
                        <div class="form-group">
                            <label for="select2-year" class="form-label">
                                {{translate("Select year")}}
                            </label>
          

                            <select class="select2" id="select2-year" name="visitorByYear" 
                                data-current-year= "{{ date('Y') }}">
                                <option> </option>
                                @for ($i = 0; $i <= 23; $i++)
                                    <option value="{{ date('Y') - $i }}"> {{ date('Y') - $i }}
                                    </option>
                                @endfor
        
                            </select>
                        </div>
        
                    </div>
                </div>

                <div class="visitors-chart">

                </div>

                <div class="mh-300 d-flex align-items-center justify-content-center h-100 d-none"  id="chart-loader">
                
                        <div class="spinner-border text-primary avatar-sm" role="status">
                            <span class="visually-hidden"></span>
                        </div>
                   
                </div>
              

            </div>
        
        </div>
         
     
        <div class="card">
            <div class="card-header border-bottom-dashed">
                <div class="row g-4 align-items-center">
                    <div class="col-sm">
                        <div>
                            <h5 class="card-title mb-0">
                                {{ translate('Ip List') }}
                            </h5>
                        </div>
                    </div>

                    <div class="col-sm-auto">
                        <div class="d-flex flex-wrap align-items-start gap-2">
                            <button type="button" class="btn btn-success add-btn waves ripple-light" data-bs-toggle="modal"
                                data-bs-target="#addIp"><i class="ri-add-line align-bottom me-1"></i>
                                {{ translate('Add New') }}
                            </button>
                        </div>
                    </div>

                </div>
            </div>



            <div class="card-body border border-dashed border-end-0 border-start-0">


                <form action="{{ route(Route::currentRouteName()) }}" method="get" class="flex-grow-1 ">

                    <div class="row g-3">


                        <div
                            class="col-xxl-12 col-lg-12 d-flex justify-content-end gap-2 flex-sm-nowrap flex-wrap order-lg-2 order-1">

                            <div class="search-box flex-lg-grow-0 flex-grow-1">
                                <input type="text" name="ip_address" value="{{ request()->input('ip_address') }}"
                                    class="form-control search" placeholder="{{ translate('Filter by ip') }}">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary w-100"> <i
                                        class="ri-equalizer-fill me-1 align-bottom"></i>
                                    {{ translate('Filter') }}
                                </button>
                            </div>

                            <div>
                                <a href="{{ route(Route::currentRouteName()) }}" class="btn btn-danger w-100"> <i
                                        class="ri-refresh-line me-1 align-bottom"></i>
                                    {{ translate('Reset') }}
                                </a>
                            </div>
                        </div>

                    </div>

                </form>

            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-centered align-middle table-nowrap mb-0">
                        <thead class="text-muted table-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">
                                    {{ translate('Ip') }}
                                </th>

                                <th scope="col">
                                    {{ translate('Blocked') }}
                                </th>

                                <th scope="col">
                                    {{ translate('Last Visited') }}
                                </th>
                                <th scope="col">
                                    {{ translate('Options') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($ip_lists as $ip)
                                <tr>
                                    <td class="fw-medium">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>

                                        @php
                                            $flagCode = $ip->agent_info->code ?? 'DEFAULT';
                                            $flagPath = 'assets/images/global/flags/' . $flagCode . '.png';
                                        @endphp

                                        <img
                                            src="{{ asset(\Illuminate\Support\Facades\File::exists($flagPath) ? $flagPath : 'assets/images/global/flags/DEFAULT.png') }}">

                                        <span>{{ $ip->ip_address }}</span>
                                    </td>

                                    <td>
                                        <div class="form-check form-switch">
                                            <input id="status-{{ $ip->id }}" type="checkbox"
                                                class="status-update form-check-input" data-column="is_blocked"
                                                data-route="{{ route('admin.security.ip.update.status') }}"
                                                data-model="Visitor"
                                                data-status="{{ $ip->is_blocked == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status() }}"
                                                data-id="{{ $ip->id }}"
                                                {{ $ip->is_blocked == App\Enums\StatusEnum::true->status() ? 'checked' : '' }}>
                                            <label class="form-check-label" for="status-{{ $ip->id }}"></label>
                                        </div>

                                    </td>

                                    <td>
                                        {{ diff_for_humans($ip->updated_at) }}
                                    </td>

                                    <td>
                                        <div class="hstack gap-3">
                                            <a href="javascript:void(0);"
                                                data-href="{{ route('admin.security.ip.destroy', $ip->id) }}"
                                                class="delete-item fs-18 link-danger">
                                                <i class="ri-delete-bin-line"></i></a>

                                            <a href="javascript:void(0)" data-agent ="{{ collect($ip->agent_info) }}"
                                                id="showInfo" class=" fs-18 link-success">
                                                <i class="ri-eye-line"></i>
                                            </a>

                                        </div>
                                    </td>
                                </tr>
                            @empty

                                @include('admin.partials.not_found')
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="pagination d-flex justify-content-end mt-3 ">
                    <nav>
                        {{ $ip_lists->links() }}
                    </nav>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="addIp" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header p-3">
                    <h5 class="modal-title" id="modalTitle">{{ translate('Add Ip') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.security.ip.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="ip_address" class="form-label">
                                    {{ translate('Ip Address') }} <span class="text-danger"> *</span>
                                </label>

                                <input type="text" name="ip_address" id="ip_address" class="form-control"
                                    placeholder="{{ translate('Enter ip') }}" value="{{ old('ip_address') }}" required>

                            </div>
                        </div>
                        <div class="modal-footer px-0 pb-0 pt-3">
                            <div class="hstack gap-2 justify-content-end">
                                <button type="button" class="btn btn-danger waves ripple-light" data-bs-dismiss="modal">
                                    {{ translate('Close') }}
                                </button>
                                <button type="submit" class="btn btn-success waves ripple-light" id="add-btn">
                                    {{ translate('Add') }}
                                </button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="agentInfo" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header p-3">
                    <h5 class="modal-title" id="modalTitle">{{ translate('Visistor Agent Info') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <ul class="list-group agent-info-list">

                            </ul>

                        </div>
                    </div>
                    <div class="modal-footer px-0 pb-0 pt-3">
                        <div class="hstack gap-2 justify-content-end">
                            <button type="button" class="btn btn-danger waves ripple-light" data-bs-dismiss="modal">
                                {{ translate('Close') }}
                            </button>

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    @include('modal.delete_modal')
@endsection



@push('script-push')
    <script>
 



        (function($) {

            "use strict";

			$(".select2").select2({
              placeholder: $('[data-current-year]').attr('data-current-year')

            });


            $(document).on('click', '#showInfo', function(e) {


                var agents = $(this).attr('data-agent');
                var agents = JSON.parse(agents);



                var list = "";

                for (let i in agents) {

                    if (agents[i] != '') {

                        var formattedKey = i.replace(/_/g, ' ').replace(/^\w/, c => c.toUpperCase());

                        list += `<li class="list-group-item d-flex justify-content-between align-items-center">
								${formattedKey} : <span class="badge bg-success">${agents[i]}</span>
							    </li>`;

                    }

                }


                $('.agent-info-list').html(list)

                $('#agentInfo').modal('show');


                e.preventDefault()
            })


			



			//Fetch current year visitors
            fetchDataForYear(new Date().getFullYear());

 

			// Get visitor by  selected year
			$(document).on("change",'[name="visitorByYear"]',function(e){
                fetchDataForYear(($(this).val()));
                e.preventDefault()
			})


            var options = {
                series: [{
                    name: "{{translate('Visitors')}}",
                    data: []
                }],
                chart: {
                height: 350,
                type: 'line',
                zoom: {
                    enabled: false
                }
                },
                dataLabels: {
                enabled: false
                },
                stroke: {
                curve: 'straight'
                },
               
                grid: {
                row: {
                    colors: ['#f3f3f3', 'transparent'], 
                    opacity: 0.5
                },
                },
                xaxis: {
                   categories: [],
                }
                };

                var chart = new ApexCharts(  document.querySelector(".visitors-chart"), options);
                chart.render();

           

      
            //fetch data by year
            function fetchDataForYear(selectedYear) {

                $.ajax({

                    url: "{{ route('admin.security.ip.chart') }}",
                    method: 'GET',
                    data: {
                        year: selectedYear
                    },
                    success: function(response) {

                        chart.updateOptions({
                        xaxis: {
                            categories: response.categories
                            }
                        });

                        chart.updateSeries([{
                            name: 'Visitor',
                            data:  response.seriesData
                        }])
                    },
                    error: function(xhr, status, error) {

                    }
                });
            }

      

		


        })(jQuery);
    </script>
@endpush
