@extends('user.layouts.master')
@section('content')
	<div class="container-fluid">

		<div class="position-relative mx-n4 mt-n4">
			@php
			$url = getImageUrl(getFilePaths()['profile']['user']['path'].'/'.$user->image,getFilePaths()['profile']['user']['size']);
				if(filter_var($user->image, FILTER_VALIDATE_URL) !== false){
					$url = $user->image;
				}
			@endphp
			<div class="profile-wid-bg profile-setting-img">
				<img src="{{$url }}" class="profile-wid-img" alt="{{$user->image}}">
			</div>
		</div>

		<div class="row">
			<div class="col-xxl-3">
				<div class="card mt-n5">
					<div class="card-body p-4">
						<div class="text-center">

							<div class="profile-user position-relative d-inline-block mx-auto  mb-4">
								<img src="{{$url }}"
									class="rounded-circle avatar-xl img-thumbnail user-profile-image"
									alt="{{$user->image}}">
							</div>
							<h5 class="fs-16 mb-1">
								{{$user->name}}
							</h5>

						</div>
					</div>
				</div>
			</div>

			<div class="col-xxl-9">
				<div class="card mt-xxl-n5">
					<div class="card-header">
						<ul class="nav nav-tabs-custom rounded  border-bottom-0 mt-0"
							role="tablist">
							<li class="nav-item">
								<a class="nav-link fw-semibold text-body active" data-bs-toggle="tab"
									href="#personalDetails" role="tab">
									{{translate('Personal Details')}}
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link fw-semibold text-body" data-bs-toggle="tab" href="#changePassword"
									role="tab">
									{{translate('Change Password')}}
								</a>
							</li>

						</ul>
					</div>

					<div class="card-body p-4">
						<div class="tab-content">
							<div class="tab-pane active" id="personalDetails" role="tabpanel">
								<form action="{{route('user.profile.update')}}"  method="POST"  enctype="multipart/form-data">
									@csrf
									<div class="row">
										<div class="col-lg-6">
											<div class="mb-3">
												<label for="name" class="form-label">
													{{translate("Name")}} <span class="text-danger" >*</span>
												</label>
												<input value="{{$user->name}}" name="name" type="text" class="form-control" id="name"
													placeholder="{{translate("Enter your Name")}}">
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
													placeholder="{{translate("Enter your phone number")}}"
													value="{{$user->phone}}">
											</div>
										</div>

										<div class="col-lg-6">
											<div class="mb-3">
												<label for="emailInput" class="form-label">
													{{translate('Email
													Address')}} <span class="text-danger" >*</span>
												</label>
												<input type="email" name="email" class="form-control" id="emailInput"
													placeholder="{{translate("Enter your email")}}"
													value="{{$user->email}}">
											</div>
										</div>

										<div class="col-lg-6 mb-2">
											<div class="mb-3">
												<label for="formFile" class="form-label">
													{{translate('Image')}}  <span class="text-danger">
														({{getFilePaths()['profile']['user']['size'] }})
													</span>
												</label>
												<input id="formFile" data-size ="{{getFilePaths()['profile']['user']['size']}}" type="file" class=" form-control "
													name="image">
											</div>

										</div>

										@if(site_settings('geo_location') == 'map_base' && site_settings('auto_ticket_assignment')  == App\Enums\StatusEnum::true->status())
											<div class="col-xl-12 col-lg-12">
												<label for="address-input" class="form-label">
														{{translate('Address')}} <span class="text-danger" >*</span>
												</label>

												@php
													$address = json_decode($user->address,true);
													$address_val = '';
													$latitude = $user->latitude;
													$longitude = $user->longitude;
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

							<div class="tab-pane" id="changePassword" role="tabpanel">
								<form method="post"  action="{{route('user.password.update')}}">
									@csrf
									<div class="row g-2">
										<div class="col-lg-12">
											<div>
												<label for="oldpasswordInput" class="form-label">
													 {{translate("Old
													 Password")}}

													 <span class="text-danger" >*</span>

													</label>
												<input type="password" required value="{{old('current_password')}}" name="current_password" class="form-control"
													id="oldpasswordInput"
													placeholder="{{translate("Enter current password")}}">
											</div>
										</div>

										<div class="col-lg-6">
											<div>
												<label for="newpasswordInput" class="form-label">
													{{translate('New
													Password')}}  <span class="text-danger" >*</span>
												</label>
												<input type="password" name="password" value="{{old('password')}}" class="form-control"
													id="newpasswordInput" placeholder="{{translate("Enter new password")}}">
											</div>
										</div>

										<div class="col-lg-6">
											<div>
												<label for="confirmpasswordInput" class="form-label">
													{{translate('Confirm
													Password')}}  <span  class="text-danger"  >*</span>
													</label>
												<input type="password" name="password_confirmation" class="form-control"
													id="confirmpasswordInput"
													placeholder="{{translate("Confirm password")}}">
											</div>
										</div>


										<div class="col-lg-12">
											<div class="text-end">
												<button type="submit" class="btn btn-success">
													{{translate('Change
													Password')}}
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


	</div>
@endsection

@push('script-include')

    @if(site_settings('auto_ticket_assignment')  == '1' &&  site_settings('geo_location') == 'map_base')
        <script src="https://maps.googleapis.com/maps/api/js?key={{site_settings('google_map_key')}}&libraries=places&callback=initialize" async defer></script>
        <script src="{{asset('assets/global/js/map.js')}}"></script>
    @endif
@endpush
