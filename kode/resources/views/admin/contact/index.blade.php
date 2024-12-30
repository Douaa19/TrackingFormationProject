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
								{{translate('Contacts')}}
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
								{{translate('Contact List')}}
							</h5>
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
									{{translate('Email')}}
								</th>
                                <th scope="col">
									{{translate('Subject')}}
								</th>

                                <th scope="col">
									{{translate('Message')}}
								</th>

                                <th scope="col">
									{{translate('Options')}}
								</th>


							</tr>
						</thead>
						<tbody>
							@forelse ($contacts  as $contact)
								<tr>
									<td class="fw-medium">
									   {{$loop->iteration}}
									</td>
									<td>
									    {{
											$contact->name
										}}

									</td>
									<td>
									    {{
											$contact->email
										}}
									</td>
									<td>
									    {{
										  limit_words(strip_tags($contact->subject),60)
										}}
									</td>
									<td>
									    {{
										  limit_words(strip_tags($contact->message),60)
										}}
									</td>


									<td>
										<div class="hstack gap-3">


                                            <a href="javascript:void(0);" data-href="{{route('admin.contact.delete',$contact->id)}}" class="delete-item fs-18 link-danger">
                                            <i class="ri-delete-bin-line"></i></a>

                                            <a href="javascript:void(0);" data-email="{{$contact->email}}"  class="sendMail  fs-18 link-success add-btn waves ripple-light"
												data-bs-toggle="modal" data-bs-target="#sendMailModal"> <i class="ri-send-plane-line"></i>
											</a>

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


<div class="modal fade" id="sendMailModal"  data-bs-keyboard="false" tabindex="-1"  aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md">
		<div class="modal-content">
			<div class="modal-header p-3">
				<h5 class="modal-title" >{{translate('Send Mail')}}
				</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal"
					aria-label="Close" id="close-modal"></button>
			</div>
			<form action="{{route('admin.contact.send.mail')}}" method="post">
				@csrf
				<div class="modal-body">
					<div class="row g-3">
						<div class="col-xl-12">
							<div class="row">
								<div class="col-lg-12">

									<input  type="hidden" id="inputEmail" name="email">

									<div class="mb-3">
										<label for="message" class="form-label" >
											{{translate('Message')}}

											  <span class="text-danger"> *</span>

										</label>

										<textarea id="message" required placeholder="{{translate('Type Here')}} ....." class="form-control" name="message"  cols="30" rows="10"></textarea>

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
								{{translate('Send')}}
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

		$(document).on('click','.sendMail',function(e){
			$('#inputEmail').val($(this).attr('data-email'))
		})


		document.addEventListener("DOMContentLoaded", function () {
            new DataTable("#datatable", {
                fixedHeader: !0
            })
        })



	})(jQuery);
</script>
@endpush






