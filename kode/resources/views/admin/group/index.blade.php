@extends('admin.layouts.master')
@push('style-include')
    <link rel="stylesheet" href="{{asset('assets/global/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{asset('assets/global/css/responsive.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{asset('assets/global/css/buttons.dataTables.min.css') }}">
@endpush
@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box d-sm-flex align-items-center justify-content-between">
					<h4 class="mb-sm-0">
                        {{translate($title)}}
					</h4>

					<div class="page-title-right">
						<ol class="breadcrumb m-0">
							<li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">
								{{translate('Home')}}
							</a></li>
							<li class="breadcrumb-item active">
								{{translate('Groups')}}
							</li>
						</ol>
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
								{{translate('Group List')}}
							</h5>
						</div>
					</div>

                    <div class="col-sm-auto">
                        <div class="d-flex flex-wrap align-items-start gap-2">
                            <a href="{{route('admin.group.create')}}" class="btn btn-success add-btn waves ripple-light"
                            ><i class="ri-add-line align-bottom me-1"></i>
                                    {{translate('Add New ')}}
                            </a>
                        </div>
                    </div>

				</div>
			</div>
			<div class="card-body ">
			    <table id="dataTable" class="w-100 table table-bordered dt-responsive nowrap table-striped align-middle" >
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>
                                {{translate('Name')}}
                            </th>

                            <th>
                                {{translate('Total Agents')}}
                            </th>

                            <th>
                                {{translate('Priority')}}
                            </th>

                            <th>
                                {{translate('Avg Response Time - Responsed Tickets')}}
                            </th>
                
                            <th>
                                {{translate('Status')}}
                            </th>


                            <th>
                                {{translate('Optinos')}}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($groups as $group)
                        
                            <tr>
                                <td>
                                    {{$loop->iteration}}
                                </td>
                                <td>
                             
                                    {{$group->name}}
                                    
                                </td>

                                <td>
                                      {{$group->agent_count}}
                                </td>

                                <td>
                                    @if($group->priority)
                                        @php echo priority_status(@$group->priority,@$group->color_code) @endphp
                                    @else
                                      {{translate('N/A')}}
                                    @endif
                                </td>
                      
                        
                                <td>

                                    @if($group->total_agent_responses > 0 && $group->avg_group_response_time > 0 )
                                        <span class="badge badge-gradient-success">
                                            <i class="ri-timer-fill badge-icon"></i> @if($group->total_agent_responses > 0){{convertHoursToDays($group->avg_group_response_time)}}@else {{translate("N/A")}} @endif -
                                            {{ $group->total_agent_responses}} <i class="ri-ticket-line badge-icon"></i>
                                        </span>
                                    @else
                                       {{translate("N/A")}}
                                    @endif
                                </td>

                            

                                <td>
                                    <div class="form-check form-switch">
                                        <input id="status-{{$group->id}}" type="checkbox" class="status-update form-check-input"
                                            data-column="status"
                                            data-route="{{ route('admin.group.status.update') }}"
                                            data-model="Group"
                                            data-status="{{  $group->status == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status():App\Enums\StatusEnum::true->status()}}"
                                            data-id="{{ $group->id}}" {{ $group->status == App\Enums\StatusEnum::true->status() ? 'checked' : ''}} >
                                        <label class="form-check-label" for="status-{{$group->id}}"></label>
                                    </div>
                                </td>

                              

                                <td>
                                    <div class="hstack gap-3">

                            
                                        <a href="{{route('admin.group.edit', $group->id)}}" class=" fs-18 link-warning"><i class="ri-pencil-fill"></i></a>

                                        <a href="javascript:void(0);" data-href="{{route('admin.group.destroy', $group->id)}}" class="delete-item fs-18 link-danger">
                                        <i class="ri-delete-bin-line"></i></a>
                                        
                                    </div>

                                </td>
                            </tr>
                            @empty

                              @include('admin.partials.not_found')

                         @endforelse
                    </tbody>
                </table>
			</div>

		</div>
	</div>

@include('modal.delete_modal')

@endsection

@push('script-include')
    <script src="{{asset('assets/global/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{asset('assets/global/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{asset('assets/global/js/dataTables.responsive.min.js') }}"></script>
@endpush

@push('script-push')
<script>
	(function($){
       	"use strict";
        document.addEventListener("DOMContentLoaded", function () {
            new DataTable("#dataTable", {
                fixedHeader: !0
            })
        })

	})(jQuery);
</script>
@endpush





