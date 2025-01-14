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
								{{translate('Mail Gateway')}}
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
								{{translate('Mail Gateway List')}}
							</h5>
						</div>
					</div>
					
				</div>
			</div>
			
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-centered align-middle table-nowrap mb-0">
						<thead class="text-muted table-light">
							<tr>
								<th scope="col">#</th>
								<th scope="col">
									{{translate('Gateway Name')}}
								</th>
								<th scope="col">
									{{translate('Default')}}
								</th>
								<th scope="col">
									{{translate('Status')}}
								</th>
								<th scope="col">
									{{translate('Action')}}
								</th>
							</tr>
						</thead>
						<tbody>
							@forelse ($mails as $mail)
							<tr>
								<td class="fw-medium">
									{{$loop->iteration}}
								</td>
								<td>
									{{ucfirst($mail->name)}}
									
								</td>
								<td>
									<div class="form-check form-switch">
										<input id="mailDefaultBtn" class="form-check-input" {{(site_settings("email_gateway_id") == $mail->id) ? 'checked' : ''}} type="checkbox" value="{{$mail->id}}" role="switch">
									</div>
								</td>
								<td>
									@if($mail->status == App\Enums\StatusEnum::true->status())
									<span class="badge badge-soft-success">{{translate('Active')}}</span>
									@else
										<span class="badge badge-soft-danger">{{translate('Inactive')}}</span>
									@endif
									
								</td>
								<td>
									<div class="hstack gap-3">
										@if( $mail->driver_information)
											<a href="{{route('admin.mail.edit', $mail->id)}}" class="pointer 
												link-warning fs-18
												">
												<i class="ri-pencil-fill"></i> 
											</a>
										@endif
									
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
						
							{{$mails->links()}}
						
					</nav>
				</div>
			</div>
		</div>

	</div>

	<form class="d-none" id="mailDefaultForm" action="{{route('admin.mail.send.method')}}" method="POST" >	
		@csrf
		<div class="row align-items-center">
			<div class="col-12 col-md-12 col-lg-6 col-xl-8">
				<input id="mailDefaultFormInput" type="hidden" name="id" value="">						
			</div>					
		</div>						
	</form>
@endsection
@push('script-push')
	<script>
	
		$(function(){
			
			"use strict";
			$(document).on('click', '#mailDefaultBtn', function(){
				var id = $(this).val();
				$('#mailDefaultFormInput').val(id);
				$('#mailDefaultForm').submit();
			})
		})		
	</script>
@endpush