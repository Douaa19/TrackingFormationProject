@extends('admin.layouts.master')
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
								{{translate('Article Categories')}}
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
								{{translate('Category List')}}
							</h5>
						</div>
					</div>

					<div class="col-sm-auto">
						<div class="d-flex flex-wrap align-items-start gap-2">
							<button type="button" class="btn btn-success add-btn waves ripple-light"
								data-bs-toggle="modal" data-bs-target="#addCategory"><i
									class="ri-add-line align-bottom me-1"></i>
									{{translate('Add New')}}
							</button>
					
						</div>
					</div>

				</div>
			</div>

			<form hidden id="bulkActionForm" action="{{route("admin.article.category.bulk")}}" method="post">
				@csrf
				 <input type="hidden" name="bulk_id" id="bulkid">
				 <input type="hidden" name="value" id="value">
				 <input type="hidden" name="type" id="type">
			</form>

			<div class="card-body border border-dashed border-end-0 border-start-0">

		
					<form action="{{route(Route::currentRouteName())}}" method="get"  class="flex-grow-1 ">

						<div class="row g-3">

							<div class="col-xxl-3 col-lg-3 order-lg-1 order-2 ">

								<div class="btn-group bulk-action d-none">
								
									<button type="submit" class="btn btn-danger w-100 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"> 
										<i class="ri-settings-4-line align-bottom">
										
									   </i>
										
									</button>

									<div class="dropdown-menu dropdownmenu-info">
								
											@foreach(App\Enums\StatusEnum::toArray() as $k => $v)
												
												<button type="button"  name="bulk_status" data-type ="status" value="{{$v}}" class="dropdown-item bulkActionBtn" > {{translate($k)}}</button>
												
											@endforeach

										
											<button type="button"  id="deleteModal" class="dropdown-item">
												{{translate("Delete")}}
											</button>
											
									
									</div>
								</div>

							</div>

					
							<div class="col-xxl-9 col-lg-9 d-flex justify-content-end gap-2 flex-sm-nowrap flex-wrap order-lg-2 order-1">

								<div class="search-box flex-lg-grow-0 flex-grow-1">
									<input type="text" name="name" value="{{request()->input("name")}}" class="form-control search" placeholder="{{translate("Search By Name")}}">
									<i class="ri-search-line search-icon"></i>
								</div>
								<div>
									<button type="submit" class="btn btn-primary w-100"> <i class="ri-equalizer-fill me-1 align-bottom"></i>
										{{translate("Filter")}}
									</button>
								</div>

								<div>
									<a href="{{route(Route::currentRouteName())}}" class="btn btn-danger w-100"> <i class="ri-refresh-line me-1 align-bottom"></i>
										{{translate("Reset")}}
									</a>
								</div>
							</div>

						</div>
						
					</form>


			</div>

			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-centered align-middle table-nowrap mb-0 text-center">
						<thead class="text-muted table-light">
							<tr>
								<th scope="col">
									<div class="form-check">
										<input class="form-check-input check-all" type="checkbox"
											id="checkAll" value="option">

											<label  class="ms-2 mb-0" for="checkAll">#</label>
											
									</div>
								</th>

								<th scope="col">
									{{translate('Name')}}
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
							@forelse ($categories as $category)
								<tr>
									<td class="fw-medium">
										<div class="form-check">
											<input class="form-check-input data-checkbox" type="checkbox"
											value="{{$category->id}}" id="{{$category->id}}" name="ids[]">
												<label  class="ms-2 mb-0" for="{{$category->id}}">{{$loop->iteration}}</label>
												
										</div>
									</td>
									<td>
									    {{
											($category->name)
										}}

									</td>

									<td >
										<div class="form-check text-center form-switch">
											<input id="status-{{$category->id}}" type="checkbox" class="status-update form-check-input"
												data-column="status"
												data-route="{{ route('admin.article.category.status.update') }}"

												data-status="{{ $category->status == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status():App\Enums\StatusEnum::true->status()}}"
												data-id="{{$category->id}}" {{$category->status == App\Enums\StatusEnum::true->status() ? 'checked' : ''}}>
											<label class="form-check-label" for="status-{{$category->id}}"></label>
										</div>

									</td>
									<td>
										<div class="hstack gap-3 justify-content-center">

											<button type="button" data-id="{{$category->id}}" data-serial="{{$category->serial_id}}" data-name="{{$category->name}}"   class="updateCategory btn fs-18 link-warning add-btn waves ripple-light"
												data-bs-toggle="modal" data-bs-target="#updateArticleCategory"> <i class="ri-pencil-line"></i>
											</button>

                                            <a href="javascript:void(0);" data-href="{{route('admin.article.category.destroy',$category->id)}}" class="delete-item fs-18 link-danger">
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

				<div class="pagination d-flex justify-content-end mt-3 ">
					<nav >
						
							{{$categories->links()}}
						
					</nav>
				</div>


			</div>
		</div>
	</div>



<div class="modal fade" id="addCategory"  data-bs-keyboard="false" tabindex="-1"  aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md">
		<div class="modal-content">
			<div class="modal-header p-3">
				<h5 class="modal-title" >{{translate('Add Category')}}
				</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal"
					aria-label="Close" ></button>
			</div>
			<form action="{{route('admin.article.category.store')}}" method="post">
				@csrf
				<div class="modal-body">
					<div class="row g-3">
						<div class="col-xl-12">
							<div class="row">
								<div class="col-lg-12">
									<div class="mb-3">
										<label class="form-label" for="name">
											{{translate('Name')}}

											  <span class="text-danger"> *</span>

										</label>


										<input type="text" name="name" id="name" class="form-control"  placeholder="{{translate("Enter Name")}}"
											value="{{old("name")}}" required>

									</div>
									<div class="mb-3">
										<label class="form-label" for="serial_id">
											{{translate('Serial Id')}}

											  <span class="text-danger"> *</span>

										</label>


										<input type="text" name="serial_id" id="serial_id" class="form-control"  placeholder="{{translate("Enter Serial Id")}}"
											value="{{old("serial_id") ? old("serial_id") :$serial_id }}" required>

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


<div class="modal fade" id="updateArticleCategory"  data-bs-keyboard="false" tabindex="-1"  aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md">
		<div class="modal-content">
			<div class="modal-header p-3">
				<h5 class="modal-title" id="modalTitle">{{translate('Update Category')}}
				</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal"
					aria-label="Close" ></button>
			</div>
			<form action="{{route('admin.article.category.update')}}" method="post">
				@csrf
				<div class="modal-body">
					<div class="row g-3">
						<div class="col-xl-12">
							<div class="row">
								<div class="col-lg-12">
									<div class="mb-3">
										<label class="form-label" for="categoryName">
											{{translate('Name')}}
											  <span class="text-danger"> *</span>
										</label>

										<input type="hidden" id="id" name="id">

										<input type="text" name="name" id="categoryName" class="form-control"  placeholder="{{translate("Enter Name")}}"
											value="" required>
									</div>

									<div class="mb-3">
										<label class="form-label" for="categorySerial">
											{{translate('Serial Id')}}
											  <span class="text-danger"> *</span>
										</label>
										<input type="number" name="serial_id" id="categorySerial" class="form-control"  placeholder="{{translate("Enter Serail Id")}}"
											value="" required>
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

@include('modal.bulk_delete_modal')




@endsection


@push('script-push')
<script>
	(function($){
       	"use strict";


		$(document).on('click','.updateCategory',function(e){

			 $('#id').val($(this).attr('data-id'))
			 $('#categorySerial').val($(this).attr('data-serial'))
			 $('#categoryName').val($(this).attr('data-name'))
		})


	})(jQuery);
</script>
@endpush


