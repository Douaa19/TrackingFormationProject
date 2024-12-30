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
								{{translate('Global Template')}}
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
										{{translate('Sms Template Short Code')}}
									</h5>
								</div>
							</div>
						</div>
					</div>

					<div class="card-body">
						<form action="{{route('admin.setting.store')}}" method="POST">

							@csrf
								<div class="row g-3 mb-3 ">
									<div class="col-lg-12">
										<label for="body" class="form-label">{{translate('Body')}}<span class="text-danger"> *</span></label>
										<textarea class="form-control " name="site_settings[default_sms_template]" rows="5" id="body" required>{{site_settings('default_sms_template')}}</textarea>
									</div>
									<div class="col-lg-12">
										<button type="submit" class="btn btn-success fs-6">{{translate('Submit')}}</button>
										
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
								<h6>{{translate('Sms Template Short Code')}}</h6>
							</div>
							<div class="mt-3">
								<div class="text-center">
									<div class="d-flex align-items-center justify-content-between  ">
										<div class="me-2">
											<h6>{{translate('Username')}}</h6>
										</div>
										<p class="mb-0">@{{username}}</p>
									</div>
									<div class="d-flex  align-items-center justify-content-between ">
										<div class="me-2">
											<h6>{{translate('Body')}}</h6>
										</div>
										<p class="mb-0">@{{message}}</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


@endsection

