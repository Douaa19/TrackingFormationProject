@extends('admin.layouts.master')
@section('content')
	<div class="container-fluid">

		<div class="position-relative mx-n4 mt-n4">
			<div class="profile-wid-bg profile-setting-img">
				<img src="{{getImageUrl(getFilePaths()['profile']['admin']['path'].'/profile_cover.png') }}" class="profile-wid-img" alt="profile_cover.png">
			</div>
		</div>

		<div class="row">
			<div class="col-xxl-3">
				<div class="card mt-n5">
					<div class="card-body p-4">
						<div class="text-center">
							<div class="profile-user position-relative d-inline-block mx-auto  mb-4">
								<img src="{{ getImageUrl(getFilePaths()['profile']['admin']['path'] . '/' . $admin->image) }}" class="rounded-circle avatar-xl img-thumbnail user-profile-image" alt="{{ $admin->image }}">
							</div>
							<h5 class="fs-16 mb-1">
								{{$admin->name}}
							</h5>
							
						</div>
					</div>
				</div>
			</div>
			
			<div class="col-xxl-9">
				<div class="card mt-xxl-n5">
					<div class="card-header">

						 <div class="row g-4 align-items-center">
							<div class="col-sm">
								<div>
									<h5 class="card-title mb-0">
										{{translate('Profile Settings')}}
									</h5>
								</div>
							</div>
		
							<div class="col-sm-auto">
								<div class="d-flex flex-wrap align-items-start gap-2">
									<a href="{{route('admin.password')}}" class="btn btn-danger fs-16 add-btn waves ripple-light"><i
											class="ri-key-2-line align-bottom me-1"></i>
											{{translate("Password")}}
								   </a>
								</div>
							</div>
		
						</div>
					</div>
					<div class="card-body p-4">
						<div class="tab-content">
						
							<form action="{{route('admin.profile.update')}}"  method="POST"  enctype="multipart/form-data">
								@csrf
								<div class="row">
									<div class="col-lg-6">
										<div class="mb-3">
											<label for="name" class="form-label">
												{{translate("Name")}} <span class="text-danger" >*</span>
											</label>
											<input value="{{$admin->name}}" name="name" type="text" class="form-control" id="name"
												placeholder="{{translate('Enter your Name')}}" >
										</div>
									</div>
									
									<div class="col-lg-6">
										<div class="mb-3">
											<label for="userName" class="form-label">
												{{translate("User Name")}} <span class="text-danger" >*</span>
											</label>
											<input type="text" name="username" class="form-control" id="userName"
												placeholder="{{translate('Enter your User Name')}}" value="{{$admin->username}}">
										</div>
									</div>
									
									<div class="col-lg-6">
										<div class="mb-3">
											<label for="phonenumberInput" class="form-label">
												{{translate('Phone
												Number')}}
											</label>
											<input type="text" class="form-control"
												id="phonenumberInput" name="phone"
												placeholder="{{translate('Enter your phone number')}}"
												value="{{$admin->phone}}">
										</div>
									</div>
									
									<div class="col-lg-6">
										<div class="mb-3">
											<label for="emailInput" class="form-label">
												{{translate('Email
												Address')}} <span class="text-danger" >*</span>
											</label>
											<input type="email" name="email" class="form-control" id="emailInput"
												placeholder="{{translate('Enter your email')}}"
												value="{{$admin->email}}">
										</div>
									</div>

									<div class="col-lg-{{site_settings('geo_location') == 'map_base' && site_settings('auto_ticket_assignment')  == '1' ? 12:6}} mb-2">
										<div class="mb-3">
											<label for="formFile" class="form-label">
												{{translate('Image')}}  <span class="text-danger">
													({{getFilePaths()['profile']['admin']['size'] }})
												</span>
											</label>
											<input id="formFile" data-size ="{{getFilePaths()['profile']['admin']['size']}}" type="file" class=" form-control "
												name="image">
										</div>
		
									</div>

									@if(site_settings('geo_location') == 'map_base' && site_settings('auto_ticket_assignment')  == App\Enums\StatusEnum::true->status())
										<div class="col-xl-12 col-lg-12">
											<label for="address-input" class="form-label">
													{{translate('Address')}} <span class="text-danger" >*</span>
											</label>
			
											@php
												$address = json_decode($admin->address,true);
												$address_val = '';
												$latitude = $admin->latitude;
												$longitude = $admin->longitude;
												if(isset($address['address'])){
													$address_val = $address['address'];
												}
											@endphp
										
											<input type="text" id="address-input" name="address" value="{{ $address_val}}" class="form-control map-input">
											<input type="hidden" name="latitude" id="address-latitude" value="{{$latitude }}" />
											<input type="hidden" name="longitude" id="address-longitude" value="{{ $longitude}}" />
										</div>
								
										<div  class="col-lg-12 mt-3 map-container" >
											<div class="g-map" id="address-map"></div>
										</div>
									@endif
			
						
									<div class="col-lg-12 mt-3">
										<div class="hstack gap-2 justify-content-start">
											<button type="submit"
												class="btn btn-primary">
												{{translate('Update')}}
											</button>
										</div>
									</div>
							
								</div>
								
							</form>

						</div>
					</div>
				</div>
			</div>
		
		</div>


	</div>
@endsection

@push('script-include')

    @if(site_settings('auto_ticket_assignment')  == '1' &&  site_settings('geo_location') == 'map_base')
        <script src="https://maps.googleapis.com/maps/api/js?key={{site_settings('google_map_key')}}&libraries=places&callback=initialize" async defer></script>
        <script src="{{asset('assets/global/js/map.js')}}"></script>
    @endif
@endpush
