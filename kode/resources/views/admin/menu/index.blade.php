@extends('admin.layouts.master')
@push('styles')
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
								{{translate('Menu')}}
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
								{{translate('Menu List')}}
							</h5>
						</div>
					</div>

					<div class="col-sm-auto">
						<div class="d-flex flex-wrap align-items-start gap-2">
							<button type="button" class="btn btn-success add-btn waves ripple-light"
								data-bs-toggle="modal" data-bs-target="#addMenu"><i
									class="ri-add-line align-bottom me-1"></i>
									{{translate('Add New Menu')}}
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

								<th scope="col">
									{{translate('Name')}}
								</th>
								<th scope="col">
									{{translate('URL')}}
								</th>

								<th scope="col">
									{{translate('Status')}}
								</th>
								<th scope="col">
									{{translate('Options')}}
								</th>
							</tr>
						</thead>
						<tbody>
							@forelse ($menus as $menu)
								<tr>
									<td class="fw-medium">
									   {{$loop->iteration}}
									</td>
									<td>
									    {{
											($menu->name)
										}}

									</td>
									<td>

										<a target="_blank" href="{{url($menu->url)}}">
											 {{limit_words(url(($menu->url)),25)}}
										</a>
							
									</td>

									<td >
										<div class="form-check  form-switch">
											<input id="status-{{$menu->id}}" type="checkbox" class="status-update form-check-input"
												data-column="status"
												data-route="{{ route('admin.menu.status.update') }}"
												data-model="Menu"
												data-status="{{ $menu->status == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status():App\Enums\StatusEnum::true->status()}}"
												data-id="{{$menu->id}}" {{$menu->status == App\Enums\StatusEnum::true->status() ? 'checked' : ''}} >
											<label class="form-check-label"  for="status-{{$menu->id}}"></label>
										</div>

									</td>
									<td>
										<div class="hstack gap-3">

											<a  href="javascript:void(0);" data-id="{{$menu->id}}" data-name="{{$menu->name}}"  data-url="{{$menu->url}}" data-serial="{{$menu->serial_id}}"  data-footer="{{$menu->show_in_footer}}" data-quick-link="{{$menu->show_in_quick_link}}"  data-header="{{$menu->show_in_header}}" class="updateMenu  fs-18 link-warning add-btn waves ripple-light"
												data-bs-toggle="modal" data-bs-target="#updateMenu"> <i class="ri-pencil-line"></i>
											</a>

                                            <a href="javascript:void(0);" data-href="{{route('admin.menu.destroy',$menu->id)}}" class="delete-item fs-18 link-danger">
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



<div class="modal fade" id="addMenu"  data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md">
		<div class="modal-content">
			<div class="modal-header p-3">
				<h5 class="modal-title" id="modalTitle">{{translate('Add Menu')}}
				</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal"
					aria-label="Close" ></button>
			</div>
			<form action="{{route('admin.menu.store')}}" method="post">
				@csrf
				<div class="modal-body">
					<div class="row g-3">
						<div class="col-xl-12">
							<div class="row">
								<div class="col-lg-12">

                                    <div class="mb-3">
										<label class="form-label" for="serial_id">
											{{translate('Serial Id')}}

											  <span class="text-danger">*</span>

										</label>


										<input type="number" name="serial_id" id="serial_id" class="form-control"  placeholder="{{translate("Enter Serial Id")}}"
											value="{{old("serial_id")}}" required>

									</div>


									<div class="mb-3">
										<label class="form-label" for="name">
											{{translate('Name')}}

											  <span class="text-danger">*</span>

										</label>


										<input type="text" name="name" id="name" class="form-control"  placeholder="{{translate("Enter Title")}}"
											value="{{old("name")}}" required>

									</div>

									<div class="mb-3">
										<label class="form-label" for="url">
											{{translate('Url')}}

											  <span class="text-danger">*</span>

										</label>
                                        <input type="text" name="url" id="url" class="form-control"  placeholder="{{translate("Enter Url")}}"
                                        value="{{url('/')}}" required>

									</div>

									<div class="d-flex menu-visibility">
										<div class="form-group form-check form-check-success me-3 ">
											<input  type="checkbox" class="form-check-input "
											 class="form-check-input" type="checkbox" value="1" name="show_in_header" id="show_in_header" >
											<label class="form-check-label" for="show_in_header">
												{{translate("Header")}}
											</label>
										</div>
										<div class="form-group form-check form-check-success  me-3 ">
											<input  type="checkbox" class="form-check-input "
											 class="form-check-input" type="checkbox" name="show_in_footer" value="1" id="show_in_footer" >
											<label class="form-check-label" for="show_in_footer">
												{{translate("Footer")}}
											</label>
										</div>

										<div class="form-group form-check form-check-success  ">
											<input  type="checkbox" class="form-check-input "
											 class="form-check-input" type="checkbox" name="show_in_quick_link" value="1" id="show_in_quick_link" >
											<label class="form-check-label" for="show_in_quick_link">
												{{translate("Quick Link")}}
											</label>
										</div>

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
								{{translate('Add')}}
							</button>
						</div>
					</div>

				</div>
			</form>
		</div>
	</div>
</div>


<div class="modal fade" id="updateMenu"  data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md">
		<div class="modal-content">
			<div class="modal-header p-3">
				<h5 class="modal-title" id="modalTitle">{{translate('Update Menu')}}
				</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal"
					aria-label="Close"></button>
			</div>
			<form action="{{route('admin.menu.update')}}" method="post">
				@csrf
				<div class="modal-body">
					<div class="row g-3">
						<div class="col-xl-12">
							<div class="row">
								<div class="col-lg-12">
                                    <div class="mb-3">
										<label class="form-label" for="serial">
											{{translate('Serial Id')}}

											  <span class="text-danger">*</span>

										</label>

										<input type="number" name="serial_id" id="serial" class="form-control"  placeholder="{{translate("Enter Serial Id")}}"
											value="" required>
									</div>

									<div class="mb-3">
										<label class="form-label" for="menuName">
											{{translate('Name')}}

											  <span class="text-danger">*</span>
										</label>
										<input type="hidden" id="id" name="id">

										<input type="text" name="name" id="menuName" class="form-control"  placeholder="{{translate("Enter Name")}}"
											value="" required>

									</div>

									<div class="mb-3">
										<label class="form-label" for="menuUrl">
											{{translate('Url')}}

											  <span class="text-danger">*</span>

										</label>

                                        <input type="text" name="url" id="menuUrl" class="form-control"  placeholder="{{translate("Enter Url")}}"
											value="" required>

									</div>


									<div class="d-flex menu-visibility">
										<div class="form-group form-check form-check-success me-3 ">
											<input  type="checkbox" class="form-check-input "
											 class="form-check-input" type="checkbox" value="1" id="headerVisibility" name="show_in_header" >
											<label class="form-check-label" for="headerVisibility">
												{{translate("Header")}}
											</label>
										</div>
										<div class="form-group form-check form-check-success me-3">
											<input  type="checkbox" class="form-check-input "
											 class="form-check-input" type="checkbox" value="1" id="footerVisibility" name="show_in_footer" >
											<label class="form-check-label" for="footerVisibility">
												{{translate("Footer")}}
											</label>
										</div>

										<div class="form-group form-check form-check-success  ">
											<input  type="checkbox" class="form-check-input "
											 class="form-check-input" type="checkbox" value="1" id="quickLinkVisibility" name="show_in_quick_link" >
											<label class="form-check-label" for="quickLinkVisibility">
												{{translate("Quick Link")}}
											</label>
										</div>

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
								id="update-btn">
								{{translate('Update')}}
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
	<script src="{{asset('assets/global/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{asset('assets/global/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{asset('assets/global/js/dataTables.responsive.min.js') }}"></script>
@endpush


@push('script-push')
<script>
	(function($){
       	"use strict";


		$(document).on('click','.updateMenu',function(e){
			
			 $('#menuUrl').val($(this).attr('data-url'))
			 $('#serial').val($(this).attr('data-serial'))
			 $('#id').val($(this).attr('data-id'))
			 $('#menuName').val($(this).attr('data-name'))
			 var headerVisibility  = $(this).attr('data-header')
			 var footerVisibility  = $(this).attr('data-footer')
			 var quickLinkVisibility  = $(this).attr('data-quick-link')
			 if(headerVisibility == 1){
				$("#headerVisibility").prop( "checked", true );
			 }
			 if(footerVisibility == 1){
				$("#footerVisibility").prop( "checked", true );

			 }
			 if(quickLinkVisibility == 1){
				$("#quickLinkVisibility").prop( "checked", true );

			 }
		})

		document.addEventListener("DOMContentLoaded", function () {
            new DataTable("#datatable", {
                fixedHeader: !0
            })
        })


	})(jQuery);
</script>
@endpush


