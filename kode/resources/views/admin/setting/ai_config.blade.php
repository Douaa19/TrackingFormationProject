@extends('admin.layouts.master')
@section('content')

	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box d-sm-flex align-items-center justify-content-between">
					<h4 class="mb-sm-0">
						{{translate(@$title)}}
					</h4>
					<div class="page-title-right">
						<ol class="breadcrumb m-0">
							<li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">
								{{translate('Home')}}
							</a></li>
							<li class="breadcrumb-item active">
                                {{translate(@$title)}}
							</li>
						</ol>
					</div>
				</div>
			</div>
		</div>

		<div class="row basic-setting">
			
			<div class="col-md-12">
				<div class="tab-content text-muted mt-4 mt-md-0" id="v-pills-tabContent">


			
					@if(auth_user()->agent == App\Enums\StatusEnum::false->status())
					
						<div class="tab-pane fade active show  " id="v-pills-chatgpt-settings" role="tabpanel" aria-labelledby="v-pills-chatgpt-settings">
							<form class="d-flex flex-column gap-4 settingsForm" data-route="{{route('admin.setting.store')}}"   method="POST" enctype="multipart/form-data">
								@csrf

								<div class="card">
									<div class="card-header border-bottom-dashed">
										<div class="d-flex align-items-center justify-content-start">
											<h5 class="d-inline-block card-title mb-0 ">
												{{translate('Chat Gpt Settings')}}
											</h5>

										</div>

									</div>
									<div class="card-body">


										<div class="row g-3">

											<div class="col-lg-6 e">

												<label for="open_ai_key" class="form-label">
													{{translate('Open AI Api Key')}} <span class="text-danger" >* </span>
												</label>
												<input type="text" name="site_settings[open_ai_key]" id="open_ai_key" class="form-control" value="{{!is_demo()? site_settings('open_ai_key') :"@@@@"}}" required placeholder="{{translate("Api Key")}}">

											</div>


											<div class="col-lg-6 e">

												<label for="open_ai" class="form-label">
													{{translate('Status')}} <span class="text-danger" >* </span>
										
												</label>


												<select id="open_ai" class="form-select" name="site_settings[open_ai]" >

													<option {{site_settings('open_ai') == App\Enums\StatusEnum::true->status() ?'selected' :""}} value="{{App\Enums\StatusEnum::true->status()}}">
														{{translate('Active')}}
													</option>
													<option {{site_settings('open_ai') == App\Enums\StatusEnum::false->status() ?'selected' :""}} value="{{App\Enums\StatusEnum::false->status()}}">
														{{translate('Inactive')}}
													</option>

												</select>


											</div>
									
											
											<div class="text-start">
												<button type="submit"
													class="btn btn-success waves ripple-light"
													>
													{{translate('Submit')}}
												</button>
											</div>

										</div>

									</div>
								</div>
							</form>
						</div>
					@endif

					
				</div>
			</div>
		</div>
	</div>






@endsection


