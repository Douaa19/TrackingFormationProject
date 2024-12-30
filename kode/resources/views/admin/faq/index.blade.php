@extends('admin.layouts.master')
@push('styles')
  <link href="{{asset('assets/global/css/summnernote.css')}}" rel="stylesheet" type="text/css"/>
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
								{{translate('Faqs')}}
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
								{{translate('Faq List')}}
							</h5>
						</div>
					</div>

					<div class="col-sm-auto">
						<div class="d-flex flex-wrap align-items-start gap-2">
							<button type="button" class="btn btn-success add-btn waves ripple-light"
								data-bs-toggle="modal" data-bs-target="#addFaq"><i
									class="ri-add-line align-bottom me-1"></i>
									{{translate('Add New Faq')}}
							</button>
						
						</div>
					</div>

				</div>
			</div>
			<div class="card-body">
				<div>
					<table id="datatable" class="w-100 table table-bordered dt-responsive nowrap table-striped align-middle">
						<thead class="text-muted table-light">
							<tr>
								<th scope="col">#</th>

                                <th scope="col">
									{{translate('Category')}}
								</th>

								<th scope="col">
									{{translate('Question')}}
								</th>


								<th scope="col">
									{{translate('Answer')}}
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
							@forelse ($faqs as $faq)
								<tr>
									<td class="fw-medium">
									   {{$loop->iteration}}
									</td>

                                    <td class="fw-medium">
                                         <span class="badge bg-info">
                                            {{get_translation($faq->category->name)}}
                                         </span>
                                     </td>
									<td>

                                        {{limit_words(strip_tags($faq->question),20)}}

									</td>
									<td>
                                        {{limit_words(strip_tags($faq->answer),20)}}
									</td>

									<td >
										<div class="form-check  form-switch">
											<input id="status-{{$faq->id}}" type="checkbox" class="status-update form-check-input"
												data-column="status"
												data-route="{{ route('admin.faq.status.update') }}"
												data-model="Faq"
												data-status="{{ $faq->status == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status():App\Enums\StatusEnum::true->status()}}"
												data-id="{{$faq->id}}" {{$faq->status == App\Enums\StatusEnum::true->status() ? 'checked' : ''}} >
											<label class="form-check-label" for="status-{{$faq->id}}"></label>
										</div>
									</td>
									<td>
										<div class="hstack gap-3 ">

											<a href="{{route('admin.faq.edit',$faq->id)}}"  class=" fs-18 link-warning add-btn waves ripple-light"> <i class="ri-pencil-line"></i>
                                            </a>

                                            <a href="javascript:void(0);" data-href="{{route('admin.faq.destroy',$faq->id)}}" class="delete-item fs-18 link-danger">
                                            <i class="ri-delete-bin-line"></i></a>
										</div>
									</td>
								</tr>
							@empty  
							@endforelse
						</tbody>
					</table>
				</div>

			
			</div>
		</div>
	</div>



	<div class="modal fade" id="addFaq"  data-bs-keyboard="false" tabindex="-1"  aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
			<div class="modal-content">
				<div class="modal-header p-3">
					<h5 class="modal-title" id="modalTitle">{{translate('Add Faq')}}
					</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal"
						aria-label="Close" ></button>
				</div>
				<form action="{{route('admin.faq.store')}}" method="post">
					@csrf
					<div class="modal-body">
						<div class="row g-3">
							<div class="col-xl-12">
								<div class="row">
									<div class="col-lg-12">


										<div class="mb-3">
											<label class="form-label" for="category_id">
												{{translate('Category')}}

												<span class="text-danger">*</span>

											</label>


											<select name="category_id" class="form-select" id="category_id"  required>

												<option value="">
													{{translate('Select Category')}}
												</option>
												@foreach($categories as $category)

												<option {{old('category_id') == $category->id ? "selected" :""}} value="{{$category->id}}">

													{{get_translation($category->name)}}
													
												</option>
												
												@endforeach

											</select>

										</div>
										<div class="mb-3">
											<label class="form-label" for="question">
												{{translate('Question')}}

												<span class="text-danger">*</span>

											</label>

											<input type="text" name="question" id="question" class="form-control"  placeholder="{{translate("Enter Question")}}"value="{{old("question")}}" required>

										</div>

										<div class="mb-3">
											<label class="form-label" for="text-editor">
												{{translate('Answer')}}

												<span class="text-danger">*</span>

											</label>


											<div class="text-editor-area">
												<textarea placeholder="{{translate("Start typing...")}}" class="form-control summernote" name="answer" id="text-editor" cols="30" rows="10">{{old("answer")}}</textarea>
				
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




