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
								{{translate('Agents')}}
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
								{{translate('Agent List')}}
							</h5>
						</div>
					</div>

                    <div class="col-sm-auto">
                        <div class="d-flex flex-wrap align-items-start gap-2">
                            <a href="{{route('admin.agent.create')}}" class="btn btn-success add-btn waves ripple-light"
                            ><i class="ri-add-line align-bottom me-1"></i>
                                    {{translate('Add New Agent')}}
                            </a>
                        </div>
                    </div>

				</div>
			</div>
			<div class="card-body ">
			    <table id="agent-table" class="w-100 table table-bordered dt-responsive nowrap table-striped align-middle" >
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>
                                {{translate('Name')}}
                            </th>

                            <th>
                                {{translate('Email')}}
                            </th>

                            <th>
                                {{translate('Avg Response Time - Responsed Tickets')}}
                            </th>
                
                            <th>
                                {{translate('Status')}}
                            </th>

                            <th>
                                {{translate('Best Agent')}}
                            </th>

                            <th>
                                {{translate('Options')}}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($agents as $agent)
                            @if(($agent->agent == 1 || $agent->agent == 2) && $agent->super_agent == 0)
                            <tr>
                                <td>
                                    {{$loop->iteration}}
                                </td>
                                <td class="d-flex">
                                    <img src="{{getImageUrl(getFilePaths()['profile']['admin']['path']."/". $agent->image) }}" alt="{{ $agent->image}}" class="avatar-xs rounded-3 me-2">
                                    <div>
                                        <h5 class="fs-13 mb-0">
                                            {{  $agent->super_agent}}
                                        </h5>
                                    </div>
                                </td>

                                <td>
                                    {{ $agent->email}}
                                </td>
                        
                                <td>
                                    @if($agent->response_count > 0)
                                        <span class="badge badge-gradient-success">
                                            <i class="ri-timer-fill badge-icon"></i> @if($agent->response_count > 0){{convertHoursToDays($agent->response->avg("response_time"))}}@else {{translate("N/A")}} @endif -
                                            {{ $agent->response_count}} <i class="ri-ticket-line badge-icon"></i>
                                        </span>
                                    @else
                                        {{translate("N/A")}}
                                    @endif
                                   
                                </td>

                            

                                <td>
                                    <div class="form-check form-switch">
                                        <input type="checkbox" id="for-{{$agent->id}}" class="status-update form-check-input"
                                            data-column="status"
                                            data-route="{{ route('admin.agent.status.update') }}"
                                            data-model="Admin"
                                            data-status="{{  $agent->status == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status():App\Enums\StatusEnum::true->status()}}"
                                            data-id="{{ $agent->id}}" {{ $agent->status == App\Enums\StatusEnum::true->status() ? 'checked' : ''}}
                                        >
                                        <label class="form-check-label" for="for-{{$agent->id}}"></label>
                                    </div>
                                </td>


                                <td>
                                    <div class="form-check form-switch">
                                        <input id="popular-for-{{$agent->id}}" type="checkbox" class="status-update form-check-input"
                                            data-column="best_agent"
                                            data-route="{{ route('admin.agent.popular.status.update') }}"
                                            data-model="Admin"
                                            data-status="{{  $agent->best_agent == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status():App\Enums\StatusEnum::true->status()}}"
                                            data-id="{{ $agent->id}}" {{ $agent->best_agent == App\Enums\StatusEnum::true->status() ? 'checked' : ''}}>
                                        <label class="form-check-label" for="popular-for-{{$agent->id}}"></label>
                                    </div>
                                </td>


                                <td>
                                    <div class="hstack gap-3">

                                        <a  href="{{route('admin.agent.login', $agent->id)}}" class=" fs-18 link-success"><i class="ri-login-box-line"></i></a>

                                        <a href="javascript:void(0);" data-id="{{$agent->id}}" class="update-password fs-18 link-danger">
                                            <i class="ri-key-2-line"></i></a>


                                        <a target="_blank" href="{{route('admin.agent.chat.list', $agent->id)}}" class=" fs-18 link-info"><i class="ri-chat-2-line"></i></a>

                                        <a href="{{route('admin.ticket.agent', $agent->id)}}" class=" fs-18 link-success"><i class="ri-send-plane-fill"></i></a>

                                        <a href="{{route('admin.agent.edit', $agent->id)}}" class=" fs-18 link-warning"><i class="ri-pencil-fill"></i></a>
                                        <a href="javascript:void(0);" data-href="{{route('admin.agent.destroy', $agent->id)}}" class="delete-item fs-18 link-danger">
                                        <i class="ri-delete-bin-line"></i></a>
                                        
                                    </div>

                                </td>
                            </tr>
                            @endif
                            @empty

                            @include('admin.partials.not_found')
                        @endforelse
                    </tbody>
                </table>
			</div>

		</div>
	</div>

@include('modal.delete_modal')

<div class="modal fade" id="updatePassword"  data-bs-keyboard="false" tabindex="-1"  aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg scorllable-modal">
		<div class="modal-content">
			<div class="modal-header p-3">
				<h5 class="modal-title" id="modalTitle">{{translate('Update password')}}
				</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal"
					aria-label="Close" ></button>
			</div>
			<form action="{{route('admin.agent.password.update')}}" id="modalForm" method="post" enctype="multipart/form-data">
				@csrf
				<div class="modal-body">
					<div class="row g-3">
						<div class="col-xl-12">
							<div class="row">
								<input type="hidden" id="id" name="id">
								<div class="col-lg-12 mb-3">
                                    <div>
                                        <label for="password" class="form-label">
                                            {{translate('Password')}} <span  class="text-danger">* ({{translate('Minimum 5 Character Required!!')}})</span>
                                        </label>
                                        <input required type="password" name="password" value="{{old('password')}}" class="form-control" placeholder="*************" id="password">
                                    </div>
								</div>
								<div class="col-lg-12">
                                    <div>
                                        <label for="confirmPassword" class="form-label">
                                            {{translate('Confirm Password')}} <span  class="text-danger"  >*</span>
                                        </label>
                                        <input required type="password" name="password_confirmation" value="{{old('confirm_password')}}" class="form-control" placeholder="*************" id="confirmPassword">
                                    </div>
								</div>



							</div>
						</div>
					</div>

					<div class="modal-footer px-0 pb-0 pt-3">
						<div class="hstack gap-2 justify-content-end">
							<button type="button"
								class="btn btn-danger waves ripple-light"
								data-bs-dismiss="modal">
								{{translate('Close
								')}}
							</button>
							<button type="submit"
								class="btn btn-success waves ripple-light"
								id="add-btn">
								{{translate('Submit')}}
							</button>
						</div>
					</div>

				</div>
			</form>
		</div>
	</div>
</div>


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
            new DataTable("#agent-table", {
                fixedHeader: !0
            })
        })

        var modal = $("#updatePassword");

        $(document).on('click','.update-password',function(e){

            $('#id').val($(this).attr('data-id'))
            modal.modal('show')
        })

	})(jQuery);
</script>
@endpush





