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
								{{translate('SMS Gateway')}}
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
								{{translate('SMS Gateway List')}}
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
							@forelse ($smsGateways as $smsGateway)
							<tr>
								<td class="fw-medium">
									{{$loop->iteration}}
								</td>
								<td>
									{{ucfirst($smsGateway->name)}}
									@if(site_settings("sms_gateway_id") == $smsGateway->id) 
										<span class="text-success fs-5">
											<i class="las la-check-double"></i> 
										</span> 
									@endif
								</td>
	
								<td>
									<div class="form-check form-switch">
										<input  class="form-check-input smsDefaultBtn" {{(site_settings("sms_gateway_id") == $smsGateway->id) ? 'checked' : ''}} type="checkbox" value="{{$smsGateway->id}}" role="switch">
									</div>
								</td>
								<td>
									@if($smsGateway->status == App\Enums\StatusEnum::true->status())
								     	<span class="badge badge-soft-success">{{translate('Active')}}</span>
									@else
										<span class="badge badge-soft-danger">{{translate('Inactive')}}</span>
									@endif
								</td>
				
								<td>
									<div class="hstack gap-3">
										
										<a href="{{route('admin.sms.gateway.edit', $smsGateway->id)}}" class="pointer 
											link-warning fs-18
											">
											<i class="ri-pencil-fill"></i> 
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

				<div class="pagination d-flex justify-content-end mt-3 ">
					<nav >

							{{$smsGateways->appends(request()->all())->links()}}
					
					</nav>
				</div>
			</div>
		</div>

	</div>


	<form class="d-none" id="smsDefaultForm" action="{{route('admin.sms.default.gateway')}}" method="POST" >	
		@csrf
		<div class="row align-items-center">
			<div class="col-12 col-md-12 col-lg-6 col-xl-8">
				<input id="smsDefaultFormInput" type="hidden" name="id" value="">						
			</div>					
		</div>						
	</form>

@endsection
@push('script-push')
	<script>
		$(function(){
			"use strict";
			$(document).on('click', '.smsDefaultBtn', function(){
				var id = $(this).val();
				$('#smsDefaultFormInput').val(id);
				$('#smsDefaultForm').submit();
			})
		})		
	</script>
@endpush