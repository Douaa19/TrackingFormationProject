@extends('admin.layouts.master')
@push('styles')
 <link href="{{asset('assets/global/css/summnernote.css')}}" rel="stylesheet" type="text/css" />
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
								{{translate('Pages')}}
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
								{{translate('Page List')}}
							</h5>
						</div>
					</div>

					<div class="col-sm-auto">
						<div class="d-flex flex-wrap align-items-start gap-2">
								<button type="button" class="btn btn-success add-btn waves ripple-light"
									data-bs-toggle="modal" data-bs-target="#addPage"><i
										class="ri-add-line align-bottom me-1"></i>
										{{translate('Add New Page')}}
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
									{{translate('Title')}}
								</th>

								<th scope="col">
									{{translate('Description')}}
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
							@forelse ($pages as $page)
								<tr>
									<td class="fw-medium">
									   {{$loop->iteration}}
									</td>

                                    <td class="fw-medium">
                                        {{$page->title}}
                                    </td>

									<td>
                                        {{limit_words(strip_tags($page->description),20)}}
									</td>

									<td>
										<div class="form-check  form-switch">
											<input id="status-{{$page->id}}" type="checkbox" class="status-update form-check-input"
												data-column="status"
												data-route="{{ route('admin.page.status.update') }}"
												data-model="Page"
												data-status="{{ $page->status == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status():App\Enums\StatusEnum::true->status()}}"
												data-id="{{$page->id}}" {{$page->status == App\Enums\StatusEnum::true->status() ? 'checked' : ''}} >
											<label class="form-check-label" for="status-{{$page->id}}"></label>
										</div>
									</td>
									<td>
										<div class="hstack gap-3 ">

											<a href="{{route('admin.page.edit',$page->id)}}"  class="  fs-18 link-warning  waves ripple-light"> <i class="ri-pencil-line"></i>
                                            </a>

                                            <a href="javascript:void(0);" data-href="{{route('admin.page.destroy',$page->id)}}" class="delete-item fs-18 link-danger">
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


<div class="modal fade" id="addPage"  data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
		<div class="modal-content">
			<div class="modal-header p-3">
				<h5 class="modal-title" id="modalTitle">{{translate('Add Page')}}
				</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal"
					aria-label="Close" ></button>
			</div>
			<form action="{{route('admin.page.store')}}" method="post">
				@csrf
				<div class="modal-body">
					<div class="row g-3">
						<div class="col-xl-12">
							<div class="row">
								<div class="col-lg-12">
                                    <div class="mb-3">
										<label class="form-label" for="title">
											{{translate('Title')}}

											  <span class="text-danger">*</span>

										</label>

                                        <input id="title" placeholder="{{translate("Enter Title")}}... " class="form-control" type="text" name="title" value="{{old('title')}}" >

									</div>
									<div class="mb-3">
										<label class="form-label" for="text-editor">
											{{translate('Description')}}

											  <span class="text-danger">*</span>

										</label>

						


										<div class="text-editor-area">
											<textarea placeholder="{{translate("Type Here")}} ....." class="form-control summernote" name="description" id="text-editor" cols="30" rows="10">{{old("description")}}</textarea>

											@if(site_settings("open_ai")  ==  App\Enums\StatusEnum::true->status())

												<button type="button" class="ai-generator-btn mt-3 ai-modal-btn " >
													<span class="ai-icon btn-success waves ripple-light">
															<span class="spinner-border d-none" aria-hidden="true"></span>
					
															<i class="ri-robot-line"></i>
													</span>
					
													<span class="ai-text">
														{{translate('Generate With AI')}}
													</span>
												</button>
					
									      	@endif
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

	})(jQuery);
</script>
@endpush



