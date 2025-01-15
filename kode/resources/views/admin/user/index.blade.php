@extends('admin.layouts.master')
@push('style-include')
    <link rel="stylesheet" href="{{asset('assets/global/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{asset('assets/global/css/responsive.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{asset('assets/global/css/buttons.dataTables.min.css') }}">
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

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@push('script-push')
<script>
    (function($){
        "use strict";

        // DataTable initialization
        document.addEventListener("DOMContentLoaded", function () {
            new DataTable("#user-table", {
                fixedHeader: !0
            });
        });

        // Password update modal
        var modal = $("#updatePassword");
        $(document).on('click','.update-password',function(e){
            $('#id').val($(this).attr('data-id'));
            modal.modal('show');
        });

        // Assign user modal
        $(document).on('click', '.assign-user', function(e) {
            e.preventDefault();
            var userId = $(this).data('user-id');
            $('.assign-user-id').val(userId);
            $('#assignUserModal').modal('show');
        });

    })(jQuery);
</script>
@endpush

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box d-sm-flex align-items-center justify-content-between">
					<h4 class="mb-sm-0">
						{{translate('Manage Users')}}
					</h4>

					<div class="page-title-right">
						<ol class="breadcrumb m-0">
							<li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">
								{{translate('Home')}}
							</a></li>
							<li class="breadcrumb-item active">
								{{translate('Users')}}
							</li>
						</ol>
					</div>
				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-header border-bottom-dashed ">
				<div class="row g-4 align-items-center">
					<div class="col-sm">
						<div>
							<h5 class="card-title mb-0">
								{{translate('User List')}}
							</h5>
						</div>
					</div>

                    <div class="col-sm-auto">
                        <div class="d-flex flex-wrap align-items-start gap-2">
                            <a href="{{route('admin.user.create')}}"  class="btn btn-success add-btn waves ripple-light"
                            ><i class="ri-add-line align-bottom me-1"></i>
                                    {{translate('Add New User')}}
                            </a>
                        </div>
                    </div>

				</div>
			</div>
			<div class="card-body">
			    <div class="table-responsive">
                    <table id="user-table" class="w-100 table table-bordered dt-responsive nowrap table-striped align-middle" >
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
                                    {{translate('Phone')}}
                                </th>
                                <th>
                                    {{translate('WhatsApp Number')}}
                                </th>
                                <th>
                                    {{translate('City')}}
                                </th>
                                <th>
                                    {{translate('CNSS')}}
                                </th>
                                <th>
                                    {{translate('Garage Name')}}
                                </th>
                                <th>
                                    {{translate('Garage Revenue')}}
                                </th>
                                <th>
                                    {{translate('Training Type')}}
                                </th>
                                <th>
                                    {{translate('Training')}}
                                </th>
                                <th>
                                    {{translate('Status')}}
                                </th>
                                <th>
                                    {{translate('Assign to')}}
                                 </th>
                                <th>
                                    {{translate('Options')}}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td>
                                        {{$loop->iteration}}
                                    </td>
                                    <td class="d-flex">
                                        @php
                                        $url = getImageUrl(getFilePaths()['profile']['user']['path'].'/'.$user->image,getFilePaths()['profile']['user']['size']);
                                            if(filter_var($user->image, FILTER_VALIDATE_URL) !== false){
                                                $url = $user->image;
                                            }
                                        @endphp
                                        <img src="{{ $url }}" alt="{{$user->image}}" class="avatar-xs rounded-3 me-2">
                                        <div>
                                            <h5 class="fs-13 mb-1">
                                                {{ $user->name}}
                                            </h5>
                                        </div>
                                    </td>
                                    <td>
                                        {{$user->email}}
                                    </td>
                                    <td>
                                        {{$user->phone ? $user->phone : "N/A"}}
                                    </td>
                                    <td>
                                        {{$user->whatsapp_number ? $user->whatsapp_number : "N/A"}}
                                    </td>
                                    <td>
                                        {{$user->city}}
                                    </td>
                                    <td>
                                        {{$user->cnss}}
                                    </td>
                                    <td>
                                        {{$user->garage_name}}
                                    </td>
                                    <td>
                                        {{$user->revenue ? $user->revenue : 0}}
                                    </td>
                                    <td>
                                        {{str_replace('_', ' ', $user->training_type) ?? translate($user->training_type)}}
                                    </td>
                                    <td>
                                        {{str_replace('_', ' ', $user->training) ?? translate($user->training)}}
                                    </td>
                                    <td>
                                        {{str_replace('_', ' ', $user->status) ?? translate($user->status)}}
                                    </td>
                                    {{-- Assign to --}}
                                    <td>
                                        <div class="avatar-group">
                                            @php
    // Check if $agentsUsers is set before using it
    $isAssigned = isset($agentsUsers) && $agentsUsers->contains(function ($agentUser) use ($user) {
        return $agentUser->user_id == $user->id;
    });
@endphp

@if ($isAssigned)
    @foreach ($agentsUsers as $agentUser)
        @if ($agentUser->user_id == $user->id)
            <div class="avatar-group-item material-shadow" data-bs-toggle="tooltip" data-bs-placement="top">
                <a href="javascript:void(0)" class="assign-user custom--tooltip">
                    <span class="tooltip-text">
                        {{ $agentUser->agent->name ?? 'Unknown Agent' }}
                    </span>
                    <img src="{{ getImageUrl(getFilePaths()['profile']['admin']['path'] . '/' . $agentUser->agent->image) }}"
                         alt="{{ $agentUser->id_agent }}"
                         class="rounded-circle avatar-xxs"
                    >
                </a>
            </div>
        @endif
    @endforeach
@else
    <div class="avatar-group-item material-shadow" data-bs-toggle="tooltip" data-bs-placement="top">
        <a href="javascript:void(0);" class="assign-user custom--tooltip" data-user-id="{{ $user->id }}">
            <span class="tooltip-text">
                {{ translate("Assign") }}
            </span>
            <div class="avatar-xxs">
                <span class="avatar-title rounded-circle bg-info text-white">
                    +
                </span>
            </div>
        </a>
    </div>
@endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="hstack gap-3">
                                            <a target="_blank" href="{{route('admin.user.login', $user->id)}}" class=" fs-18 link-success"><i class="ri-login-box-line"></i></a>
                                            <a href="javascript:void(0);" data-id="{{$user->id}}" class="update-password fs-18 link-danger">
                                                <i class="ri-key-2-line"></i>
                                            </a>
                                            <a href="{{route('admin.user.edit',$user->id)}}" class=" fs-18 link-warning"><i class="ri-pencil-fill"></i></a>
                                            <a href="javascript:void(0);" data-href="{{route('admin.user.delete',$user->id)}}" class="delete-item fs-18 link-danger">
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
			<form action="{{route('admin.user.password.update')}}" id="modalForm" method="post" enctype="multipart/form-data">
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

<!-- Assign User Modal -->
<div class="modal fade modal-custom-bg" id="assignUserModal" tabindex="-1" aria-labelledby="assignUserModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.user.assign_agent') }}" method="post">
                @csrf
                <div class="modal-header p-3">
                    <h5 class="modal-title">{{ translate('Assign User to Agent') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input class="assign-user-id" hidden type="text" name="user_id" value="{{ $user->id ?? '' }}">
                    <div class="mb-3">
                        <label class="form-label" for="assign-agent">
                            {{ translate('Assign to') }}
                            <span class="text-danger"> *</span>
                        </label>
                        <select name="agent_id" id="assign-agent" required class="form-select">
                            @forelse($agents as $agent)
                                <option value="{{ $agent->id }}">
                                    {{ $agent->name }}
                                </option>
                            @empty
                                <option disabled>{{ translate('No agents available') }}</option>
                            @endforelse
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ translate('Close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ translate('Assign') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('script-include')
    {{-- <script src="{{asset('assets/global/js/jquery.dataTables.min.js') }}"></script> --}}
    <script src="{{asset('assets/global/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{asset('assets/global/js/dataTables.responsive.min.js') }}"></script>
@endpush

{{-- @push('script-push')
<script>
	(function($){
       	"use strict";
        document.addEventListener("DOMContentLoaded", function () {
            new DataTable("#user-table", {
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
@endpush --}}





