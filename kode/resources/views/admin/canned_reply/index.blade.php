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
						{{$title}}
					</h4>

					<div class="page-title-right">
						<ol class="breadcrumb m-0">
							<li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">
								{{translate('Home')}}
							</a></li>
							<li class="breadcrumb-item active">
								{{translate('Predefined Response')}}
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
								{{translate('Response List')}}
							</h5>
						</div>
					</div>

					<div class="col-sm-auto">
						<div class="d-flex flex-wrap align-items-start gap-2">

						
							<button type="button" class="btn btn-success add-btn addCan waves ripple-light"
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
					<table id="datatable" class="w-100 table table-bordered dt-responsive nowrap table-striped align-middle">
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
									{{translate('Share with')}}
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
										<div class="form-check  form-switch">
											<input id="status-{{$reply->id}}" type="checkbox" class="status-update form-check-input"
												data-column="status"
												data-route="{{ route('admin.canned.reply.status.update') }}"
												data-model="CannedReply"
												data-status="{{ $reply->status == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status():App\Enums\StatusEnum::true->status()}}"
												data-id="{{$reply->id}}" {{$reply->status == App\Enums\StatusEnum::true->status() ? 'checked' : ''}} >
											<label class="form-check-label" for="status-{{$reply->id}}"></label>
										</div>

									</td>
									

									<td>
										
										<div class="avatar-group">

											@php
												$shareWith    =  ($reply->share_with ?? []);
												$sharedAdmins =  $admins->whereIn('id',$shareWith);
											@endphp


											@foreach ($sharedAdmins as $admin )
												<div class="avatar-group-item material-shadow">
													<a href="javascript:void(0)" class="d-inline-block" data-bs-toggle="tooltip" data-bs-placement="top" title="{{$admin->name}}" >
														<img src="{{getImageUrl(getFilePaths()['profile']['admin']['path']."/". $admin->image) }}"  class="rounded-circle avatar-xxs">
													</a>
												</div>
											@endforeach
				
							
				
											<div class="avatar-group-item material-shadow" data-bs-toggle="tooltip" data-bs-placement="top" title="{{translate('Share')}}">
												<a href="javascript:void(0);" class="share-canned" data-canned-id='{{$reply->id}}' data-share="{{json_encode($shareWith)}}">
													<div class="avatar-xxs">
														<span class="avatar-title rounded-circle bg-info text-white">
														   +
														</span>
													</div>
												</a>
											</div>
									 
										</div>
									</td>
									<td>
										<div class="hstack gap-3 ">

											<a href="javascript:void(0);" data-id="{{$reply->id}}" data-title="{{$reply->title}}"  data-body="{{$reply->body}}" class="updateReply  fs-18 link-warning  waves ripple-light"> <i class="ri-pencil-line"></i>
											</a>

                                            <a href="javascript:void(0);" data-href="{{route('admin.canned.reply.destroy',$reply->id)}}" class="delete-item fs-18 link-danger">
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


<div class="modal fade" id="addCanned"  data-bs-keyboard="false" tabindex="-1"  aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg scorllable-modal">
		<div class="modal-content">
			<div class="modal-header p-3">
				<h5 class="modal-title" id="modalTitle">{{translate('Add Reply')}}
				</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal"
					aria-label="Close" ></button>
			</div>
			<form action="{{route('admin.canned.reply.store')}}" id="modalForm" method="post">
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
										<label class="form-label" for="text-editor">
											{{translate('Body')}}

											  <span class="text-danger"> *</span>

										</label>

										 <div class="text-editor-area">
											<textarea placeholder="{{translate("Type Here")}} ....." class="form-control summernote" name="body" id="text-editor" cols="30" rows="10">{{old("body")}}</textarea>

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




<div class="modal fade modal-custom-bg" id="shareCanned" tabindex="-1" aria-labelledby="shareCanned" aria-hidden="true">

	<div class="modal-dialog">
		<div class="modal-content">
			<form action="{{route('admin.canned.reply.share')}}" method="post" >
				@csrf
				<div class="modal-header p-3">
					<h5 class="modal-title" >{{translate('Share canned reply')}}
					</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal"
						aria-label="Close" ></button>
				</div>

				<div class="modal-body">
					<input class="canned-id" hidden type="text" name="id"  value="">

					<div class="mb-3">

					
						
						<label class="form-label" for="adminId">
							{{translate('Share with')}}

							  <span class="text-danger"> *</span>
						</label>

			 
						<select name="admin_ids[]" id="adminId" multiple required class="form-select">

					   
								@forelse($admins as $agent)

									<option  value="{{$agent->id}}">
										{{$agent->name}}
									</option>

								@empty
						
								@endforelse
						</select>

					 
					</div>


 
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-light" data-bs-dismiss="modal">
						{{translate("Close")}}
					</button>
					<button type="submit"  class="btn btn-primary assignedToBtn">
						{{translate('Submit')}}
					</button>
				</div>
		   </form>
		</div>
	</div>
</div>

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


		   $("#adminId").select2({
              dropdownParent: $("#shareCanned"),
            });
		
		   $(document).on('click','.share-canned', function(e){
                var modal = $("#shareCanned");

                var id = $(this).data('canned-id');
                var share = $(this).data('share');
                
                modal.find('.canned-id').val(id);

                modal.find('#adminId').val(null).trigger('change');

                if (Array.isArray(share)) {
                    $('#adminId').val(share).trigger('change');
                }


                modal.modal('show')
                e.preventDefault()
            })



		document.addEventListener("DOMContentLoaded", function () {
            new DataTable("#datatable", {
                fixedHeader: !0
            })
        })


		var modal = $("#addCanned");

		$(document).on('click','.updateReply',function(e){

			$('#modalForm').attr('action',"{{route('admin.canned.reply.update')}}")
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

			$('#modalForm').attr('action',"{{route('admin.canned.reply.store')}}")
			$('#id').val('')
			$('#title').val('')
			$('#modalTitle').html('Add Reply')

			$('.summernote').summernote('destroy');
			$('.summernote').html("");
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


