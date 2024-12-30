@extends('admin.layouts.master')
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
							<li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">
								{{translate('Home')}}
							</a></li>

							<li class="breadcrumb-item active">
								{{translate('Global Email Template')}}
							</li>
						</ol>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-xl-9">
				<div class="card">
					<div class="card-header border-bottom-dashed">
						<div class="row g-4 align-items-center">
							<div class="col-sm">
								<div>
									<h5 class="card-title mb-0">
										{{translate('Email Template Short Code')}}
									</h5>
								</div>
							</div>
						</div>
					</div>
					<div class="card-body">
						<form class="settingsForm" data-route="{{route('admin.setting.store')}}" >
							@csrf
								<div class="row g-3 mb-3">
									<div class=" col-12">
										<label for="mail_from" class="form-label">{{translate('Sent From Email')}}<span class="text-danger"> *</span></label>
										<input id="mail_from" type="email" name="site_settings[email]" class="form-control" value="{{site_settings("email")}}" placeholder="{{translate('Enter Email')}}" required>
									</div>

									<div class=" col-12">
										<label for="body" class="form-label">{{translate('Email Template')}}<span class="text-danger"> *</span></label>
										<textarea class="form-control summernote" name="site_settings[default_mail_template]" rows="5" id="body" required>{{site_settings('default_mail_template')}}</textarea>
									</div>
									<div class="col-lg-6">
										<button type="submit" class="btn btn-success">{{translate('Submit')}}</button>

									
							      	</div>
								</div>
						</form>
					</div>
			   </div>
			</div>
			<div class="col-xl-3">
				<div class="card">
					<div class="card-header border-bottom-dashed">
						<div class="row g-4 align-items-center">
							<div class="col-sm">
								<div>
									<h5 class="card-title mb-0">
										{{translate('Template')}}
									</h5>
								</div>
							</div>
						</div>
					</div>

					<div class="card-body">
						<div>
							<div >
								<h6 class="mb-0">{{translate('Mail Template Short Code')}}</h6>
							</div>

							<div class="mt-3">
								<div class="text-center">
									<div class="d-flex gap-2 align-items-center justify-content-between">
										<div >
											<h6 class="mb-0">{{translate('Username')}}</h6>
										</div>
										<p class="mb-0">@{{username}}</p>
									</div>
									<div class="d-flex gap-2 align-items-center justify-content-between">
										<div>
											<h6 class="mb-0">{{translate('Mail Body')}}</h6>
										</div>
										<p class="mb-0">@{{message}}</p>
									</div>
									<div class="d-flex gap-2 align-items-center justify-content-between">
										<div>
											<h6 class="mb-0">{{translate('Site Name')}}</h6>
										</div>
										<p class="mb-0">@{{site_name}}</p>
									</div>
									<div class="d-flex gap-2 align-items-center justify-content-between">
										<div>
											<h6 class="mb-0">{{translate('Site Logo')}}</h6>
										</div>
										<p class="mb-0">@{{logo}}</p>
									</div>
								</div>
							</div>
						</div>
				   </div>
				</div>
			</div>
		</div>

	<div>



@endsection
@push('script-include')
	<script src="{{asset('assets/global/js/summernote.min.js')}}"></script>
	<script src="{{asset('assets/global/js/editor.init.js')}}"></script>
@endpush



