@extends('user.layouts.master')
@push('styles')
 <link href="{{asset('assets/global/css/summnernote.css')}}" rel="stylesheet" type="text/css" />
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
							<li class="breadcrumb-item"><a href="{{route('user.dashboard')}}">
								{{translate('Home')}}
							</a></li>
							<li class="breadcrumb-item active">
								{{translate('Canned Reply')}}
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
								{{translate('Canned List')}}
							</h5>
						</div>
					</div>

					<div class="col-sm-auto">
						<div class="d-flex flex-wrap align-items-start gap-2">
							<button type="button" class="btn btn-success add-btn  addCan waves ripple-light"
								data-bs-toggle="modal" data-bs-target="#addCanned"><i
									class="ri-add-line align-bottom me-1"></i>
									{{translate('Add New Reply')}}
							</button>
						</div>
					</div>

				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-centered align-middle table-nowrap mb-0 text-center">
						<thead class="text-muted table-light">
							<tr>
								<th scope="col">#</th>

								<th scope="col">
									{{translate('Title')}}
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
							@forelse ($cannedReply as $reply)
								<tr>
									<td class="fw-medium">
									   {{$loop->iteration}}
									</td>
									<td>
									    {{
											($reply->title)
										}}

									</td>

									<td >
										<div class="form-check text-center form-switch">
											<input id="status-{{$reply->id}}" type="checkbox" class="status-update form-check-input"
												data-column="status"
												data-route="{{ route('user.canned.reply.status.update') }}"
												data-model="CannedReply"
												data-status="{{ $reply->status == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status():App\Enums\StatusEnum::true->status()}}"
												data-id="{{$reply->id}}" {{$reply->status == App\Enums\StatusEnum::true->status() ? 'checked' : ''}} >
											<label class="form-check-label" for="status-{{$reply->id}}"></label>
										</div>

									</td>
									<td>
										<div class="hstack gap-3 justify-content-center">

											<button type="button" data-id="{{$reply->id}}" data-title="{{$reply->title}}"  data-body="{{$reply->body}}" class="updateReply btn fs-18 link-warning add-btn waves ripple-light"> <i class="ri-pencil-line"></i>
											</button>

                                            <a href="javascript:void(0);" data-href="{{route('user.canned.reply.destroy',$reply->id)}}" class="delete-item fs-18 link-danger">
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
		
							{{$cannedReply->appends(request()->all())->links()}}
					
					</nav>
				</div>


			</div>
		</div>
	</div>



<div class="modal fade" id="addCanned"  data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg scorllable-modal">
		<div class="modal-content">
			<div class="modal-header p-3">
				<h5 class="modal-title" id="modalTitle">{{translate('Add Reply')}}
				</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal"
					aria-label="Close" ></button>
			</div>
			<form action="{{route('user.canned.reply.store')}}" method="post" id="modalForm">
				@csrf
				<div class="modal-body">
					<div class="row g-3">
						<div class="col-xl-12">
							<div class="row">
								<input type="hidden" id="id" name="id">
								<div class="col-lg-12">
									<div class="mb-3">
										<label class="form-label" for="title">
											{{translate('Title')}}

											  <span class="text-danger"> *</span>

										</label>


										<input type="text" name="title" id="title" class="form-control"  placeholder="{{translate("Enter Title")}}"
											value="{{old("title")}}" required>

									</div>

									<div class="mb-3">
										<label class="form-label" for="body">
											{{translate('Body')}}

											  <span class="text-danger"> *</span>

										</label>

										<textarea placeholder="{{translate('Type Here')}} ....." class="form-control summernote" name="body" id="body" cols="30" rows="10">{{old("body")}}</textarea>

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


@include('modal.delete_modal')

@endsection

@push('script-include')
	<script src="{{asset('assets/global/js/summernote.min.js')}}"></script>
	<script src="{{asset('assets/global/js/editor.init.js')}}"></script>
@endpush


@push('script-push')
<script>
	(function($){
       	"use strict";

		var modal = $("#addCanned");

		$(document).on('click','.updateReply',function(e){

			$('#modalForm').attr('action',"{{route('user.canned.reply.update')}}")
			$('#id').val($(this).attr('data-id'))
			$('#title').val($(this).attr('data-title'))
			$('#modalTitle').html('Update Reply')
			var html  = $(this).attr('data-body')

			$('.summernote').summernote('destroy');
			$('.summernote').html(html);
			$('.summernote').summernote({
                    height: 300,
                    placeholder: '{{translate("Start typing...")}}',
                    toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['insert', ['picture', 'link', 'video']],
					['view', ['codeview']],
                    ],
                    callbacks: {
                        onInit: function() {

                        }
                    }
                });
			modal.modal('show')
		})

		$(document).on('click','.addCan',function(e){
			
			$('#modalForm').attr('action',"{{route('user.canned.reply.store')}}")
			$('#id').val('')
			$('#title').val('')
			$('#modalTitle').html('Add Reply')

			$('.summernote').summernote('destroy');
			$('.summernote').html('');
			$('.summernote').summernote({
                    height: 300,
                    placeholder: '{{translate("Start typing...")}}',
                    toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['insert', ['picture', 'link', 'video']],
					['view', ['codeview']],
                    ],
                    callbacks: {
                        onInit: function() {

                        }
                    }
                });

			modal.modal('show')
		})


	})(jQuery);
</script>
@endpush


