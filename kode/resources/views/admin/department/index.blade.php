@extends('admin.layouts.master')
@push('styles')
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
@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box d-sm-flex align-items-center justify-content-between">
					<h4 class="mb-sm-0">{{$title}}</h4>
					<div class="page-title-right">
						<ol class="breadcrumb m-0">
							<li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{translate('Home')}}</a></li>
							<li class="breadcrumb-item active">{{translate('Products')}}</li>
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
							<h5 class="card-title mb-0">{{translate('Product List')}}</h5>
						</div>
					</div>
					<div class="col-sm-auto">
						<div class="d-flex flex-wrap align-items-start gap-2">
							<button type="button" 
									class="btn btn-success add-btn addDept waves ripple-light"
									data-bs-toggle="modal" 
									data-bs-target="#addnew">
									<i class="ri-add-line align-bottom me-1"></i>
									{{translate('Add New')}}
							</button>
						</div>
					</div>
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="datatable" class="w-100 table table-bordered dt-responsive nowrap table-striped align-middle">
						<thead class="text-muted table-light">
							<tr>
								<th scope="col">#</th>
								<th scope="col">{{translate('Name')}}</th>
								<th scope="col">{{translate('Type')}}</th>
								<th scope="col">{{translate('Status')}}</th>
								<th scope="col">{{translate('Options')}}</th>
							</tr>
						</thead>
						<tbody>
							@forelse ($departments as $department)
								<tr>
									<td class="fw-medium">
									   {{$loop->iteration}}
									</td>
									<td class="d-flex">
										<img src="{{getImageUrl(getFilePaths()['department']['path']."/". $department->image , getFilePaths()['department']['size']) }}" alt="{{ $department->image}}" class="avatar-xs rounded-3 me-2">
										<div>
											<h5 class="fs-13 mb-0">{{($department->name)}}</h5>
										</div>
									</td>
									<td>
										<div class="badge rounded-pill border {{ $department->envato_item_id ? "border-success text-success" : 'border-danger text-danger' }} border-success text-success" title>
											{{ $department->envato_item_id ? translate('Envato') : translate('System') }}
										</div>
									</td>
									<td>
										<div class="form-check form-switch">
											<input id="status-{{$department->id}}" type="checkbox" class="status-update form-check-input"
												data-column="status"
												data-route="{{ route('admin.department.status.update') }}"
												data-model="Department"
												data-status="{{ $department->status == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status():App\Enums\StatusEnum::true->status()}}"
												data-id="{{$department->id}}" {{$department->status == App\Enums\StatusEnum::true->status() ? 'checked' : ''}} >
											<label class="form-check-label" for="status-{{$department->id}}"></label>
										</div>
									</td>
									<td>
										<div class="hstack gap-3">
											<a 	href="javascript:void(0);" 
												data-envato-item-id = "{{!is_null($department->envato_item_id)}}"    
												data-id="{{$department->id}}" 
												data-name="{{$department->name}}" 
												data-description="{{$department->description}}" 
												class="updateDepartment fs-18 link-warning  waves ripple-light"> 
												<i class="ri-pencil-line"></i>
											</a>
                                            <a 	href="javascript:void(0);" 
												data-href="{{route('admin.department.destroy', $department->id)}}" 
												class="delete-item fs-18 link-danger">
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

	<div class="modal fade" id="addnew" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg scorllable-modal">
			<div class="modal-content">
				<div class="modal-header p-3">
					<h5 class="modal-title" id="modalTitle">{{translate('Add Product')}}</h5>
					<button type="button" 
							class="btn-close" 
							data-bs-dismiss="modal" 
							aria-label="Close">
					</button>
				</div>
				<form action="{{route('admin.department.store')}}" id="modalForm" method="post" enctype="multipart/form-data">
					@csrf
					<div class="modal-body">
						<div class="row g-3">
							<div class="col-xl-12">
								<div class="row">
									<input type="hidden" id="id" name="id">
									<div class="col-lg-12">
										<div class="mb-3">
											<div>
												<div class="form-label d-flex justify-content-between" for="isEnvato">
													<div>{{translate('Name')}}<span class="text-danger">*</span></div>
												</div>
												<div class="input-group">
													<input type="text" name="name" id="name" class="form-control"  placeholder="{{translate("Enter name")}}"
													value="{{old("name")}}" required>
													<span class="input-group-text" id="is_envato_product">
														<input class="form-check-input mt-0 me-2" id="envatoProduct" type="checkbox" name="is_envato_product" value="1">
														<label for="envatoProduct" class="mb-0">
															{{translate('Envato product')}}
														</label>
													</span>
												</div>
											</div>
										</div>
									</div>
									<div class="col-lg-12">
										<div class="mb-3">
											<label class="form-label" for="image">
												{{translate('Image')}}
												<span class="text-danger">
													({{getFilePaths()['department']['size']}})
												</span>
											</label>
											<input type="file" name="image" id="image" class="form-control">
										</div>
									</div>
									<div class="col-lg-12">
										<div class="mb-3">
											<label class="form-label" for="name">
												{{translate('Description')}}
												<span class="text-danger">*</span>
											</label>
											<textarea class="form-control" required placeholder="{{translate("Enter description")}}" name="description" id="description" cols="30" rows="8">{{old("description")}}</textarea>
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
									{{translate('Close')}}
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
@include('modal.delete_modal')

@endsection

@push('script-include')
	<script src="{{asset('assets/global/js/summernote.min.js')}}"></script>
	<script src="{{asset('assets/global/js/editor.init.js')}}"></script>
	<script src="{{asset('assets/global/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{asset('assets/global/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{asset('assets/global/js/dataTables.responsive.min.js') }}"></script>
@endpush

@push('script-push')
<script>
	(function($){
       	"use strict";
		document.addEventListener("DOMContentLoaded", function () {
            new DataTable("#datatable", {
                fixedHeader: !0
            })
        })


		var modal = $("#addnew");

		$(document).on('click','.updateDepartment',function(e){

			$('#modalForm').attr('action',"{{route('admin.department.update')}}")
			$('#id').val($(this).attr('data-id'))
			$('#name').val($(this).attr('data-name'))
			$('#description').html($(this).attr('data-description'))
			$('#modalTitle').html('Update Product')

			var envatoPayload = $(this).attr('data-envato-item-id');
			$('#envato_token').val('')
			$('#envatoProduct').prop("checked", false)
			if(envatoPayload){
				$('#is_envato_product').removeClass("d-none")
				$('#envato_token').val(envatoPayload)
				$('#envatoProduct').prop("checked", true)
				$('#envatoProduct').prop("disabled", true)
			} else {
				$('#is_envato_product').addClass("d-none")
			}



			modal.modal('show')
		})

		$(document).on('click','.addDept',function(e){

			$('#modalForm').attr('action',"{{route('admin.department.store')}}")
			$('#id').val('')
			$('#name').val('')
			
			$('#envato_token').val('')
			$('#is_envato_product').addClass("d-none")
			$('#modalTitle').html('Add Product')


			modal.modal('show')
		})
	})(jQuery);
</script>
@endpush


