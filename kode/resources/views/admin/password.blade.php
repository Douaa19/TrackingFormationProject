@extends('admin.layouts.master')
@section('content')
	<div class="container-fluid">

		<div class="position-relative mx-n4 mt-n4">
			<div class="profile-wid-bg profile-setting-img">
				<img src="{{getImageUrl(getFilePaths()['profile']['admin']['path']."/".$admin->image) }}" class="profile-wid-img" alt="{{$admin->image}}">
			</div>
		</div>

		<div class="row">
			<div class="col-xxl-3">
				<div class="card mt-n5">
					<div class="card-body p-4">
						<div class="text-center">
							<div class="profile-user position-relative d-inline-block mx-auto  mb-4">
								<img src="{{getImageUrl(getFilePaths()['profile']['admin']['path']."/".$admin->image) }}"
									class="rounded-circle avatar-xl img-thumbnail user-profile-image"
									alt="{{$admin->image}}">
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
										{{translate('Change Password')}}
									</h5>
								</div>
							</div>
		
							<div class="col-sm-auto">
								<div class="d-flex flex-wrap align-items-start gap-2">
									<a href="{{route("admin.profile.index")}}" class="btn btn-success fs-16 add-btn waves ripple-light"><i
											class="ri-user-settings-line align-bottom me-1"></i>
											{{translate("Profile")}}
                               
								   </a>
								</div>
							</div>
		
						</div>
					</div>
					<div class="card-body p-4">
						<div class="tab-content">

								<form method="post"  action="{{route('admin.password.update')}}">
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
													Password')}}  <span  class="text-danger">*</span>
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
@endsection

@push('script-include')

    @if(site_settings('auto_ticket_assignment')  == '1' &&  site_settings('geo_location') == 'map_base')
        <script src="https://maps.googleapis.com/maps/api/js?key={{site_settings('google_map_key')}}&libraries=places&callback=initialize" async defer></script>
        <script src="{{asset('assets/global/js/map.js')}}"></script>
    @endif
@endpush
