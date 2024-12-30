@extends('admin.layouts.master')

@push('style-include')


   <link href="{{asset('assets/global/css/colorpicker.min.css')}}" rel="stylesheet">
   <link href="{{asset('assets/global/css/summnernote.css')}}" rel="stylesheet" type="text/css" />

@endpush

@section('content')

@php

	$ticketSettings = json_decode(site_settings('ticket_settings'),true);
	$inputTypes = ['number','textarea','date','email','text'];
	$mimeTypes = json_decode(site_settings('mime_types'),true);
	$awsSettings = json_decode(site_settings('aws_s3'),true);
	$pusher_settings = json_decode(site_settings('pusher_settings'),true);
	$google_recaptcha = json_decode(site_settings('google_recaptcha'),true);
	$socail_login_settings = json_decode(site_settings('social_login'),true);
	$widths  =  App\Enums\FieldWidth::toArray();

@endphp



	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box d-sm-flex align-items-center justify-content-between">
					<h4 class="mb-sm-0">
						{{translate('General Setting')}}
					</h4>
					<div class="page-title-right">
						<ol class="breadcrumb m-0">
							<li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">
								{{translate('Home')}}
							</a></li>
							<li class="breadcrumb-item active">
								{{translate('General Setting')}}
							</li>
						</ol>
					</div>
				</div>
			</div>
		</div>

		<div class="row basic-setting">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<div class="nav flex-row nav-pills text-center gap-sm-2 gap-1" id="v-pills-tab" role="tablist" aria-orientation="vertical">

							<a class="nav-link active" id="v-pills-basic-settings-tab" data-bs-toggle="pill" href="#v-pills-basic-settings" role="tab" aria-controls="v-pills-basic-settings" aria-selected="false" tabindex="-1">
								<i class='bx bx-cog'></i> {{translate('Basic Settings')}}
							</a>

							@if(auth_user()->agent == App\Enums\StatusEnum::false->status())
								<a class="nav-link " id="v-pills-agent-setting-tab" data-bs-toggle="pill" href="#v-pills-agent-settings" role="tab" aria-controls="v-pills-agent-settings" aria-selected="false" tabindex="-1">

									<i class='bx bx-group'></i>{{translate('Agent Settings')}}
								</a>

							@endif

							<a class="nav-link " id="v-pills-basic-theme-setting-tab" data-bs-toggle="pill" href="#v-pills-basic-theme-settings" role="tab" aria-controls="v-pills-basic-theme-settings" aria-selected="false" tabindex="-1">
								<i class='bx bxs-palette'></i>{{translate('Theme Settings')}}
							</a>



							<a class="nav-link " id="v-pills-storage-tab" data-bs-toggle="pill" href="#v-pills-storage" role="tab" aria-controls="v-pills-storage" aria-selected="true">
								<i class="ri-database-2-line"></i> {{translate('Storage Settings')}}
							</a>

							<a class="nav-link " id="v-pills-pusher-tab" data-bs-toggle="pill" href="#v-pills-pusher" role="tab" aria-controls="v-pills-pusher" aria-selected="true">
								<i class="ri-notification-3-line"></i> {{translate('Pusher Settings')}}
							</a>

							@if(site_settings('slack_notifications') == App\Enums\StatusEnum::true->status())
								<a class="nav-link " id="v-pills-slack-tab" data-bs-toggle="pill" href="#v-pills-slack" role="tab" aria-controls="v-pills-slack" aria-selected="true">
									<i class="ri-slack-line"></i> {{translate('Slack Settings')}}
								</a>
							@endif

							@if(site_settings('captcha') == App\Enums\StatusEnum::true->status())
								<a class="nav-link " id="v-pills-recap-tab" data-bs-toggle="pill" href="#v-pills-recap" role="tab" aria-controls="v-pills-recap" aria-selected="true">
									<i class="ri-lock-line"></i>	{{translate('Recaptcha Settings')}}
								</a>
							@endif

							<a class="nav-link " id="v-pills-social-login-tab" data-bs-toggle="pill" href="#v-pills-social-login" role="tab" aria-controls="v-pills-social-login" aria-selected="true">
								<i class="ri-login-circle-line"></i> {{translate('3rd Party Login')}}
							</a>

							<a class="nav-link" id="v-pills-logo-tab" data-bs-toggle="pill" href="#v-pills-logo" role="tab" aria-controls="v-pills-logo" aria-selected="false" tabindex="-1">
								<i class="ri-image-line"></i> {{translate('Logo Settings')}}
							</a>
						</div>
					</div>
				</div>
			</div>

			<div class="col-12">
				<div class="tab-content text-muted mt-4 mt-md-0" id="v-pills-tabContent">
					<div class="tab-pane fade active show" id="v-pills-basic-settings" role="tabpanel" aria-labelledby="v-pills-basic-settings-tab">
						<form class="d-flex flex-column gap-4 settingsForm" data-route="{{route('admin.setting.store')}}"  enctype="multipart/form-data">
							@csrf

							<div class="card">
                                <div class="card-header border-bottom-dashed">
                                    <div class="row g-4 align-items-center">
                                        <div class="col-sm">
                                            <div>
                                                <h5 class="card-title mb-0">
                                                    {{translate('Basic Settings')}}
                                                </h5>
                                            </div>
                                        </div>

                                        <div class="col-sm-auto">
                                            <div class="d-flex flex-wrap align-items-start gap-2">
                                            <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#cronjob" class="btn btn-success waves ripple-light px-3 py-1 rounded"><i class="ri-key-2-line"></i>
                                                {{translate("Setup Cron Jobs")}}
                                            </a>
                                            </div>
                                        </div>

                                    </div>
                                </div>

								<div class="card-body">
									<div class="form-group form-check form-check-success mb-3 ">
										<input {{ site_settings('same_site_name') == App\Enums\StatusEnum::true->status() ? 'checked' :"" }} type="checkbox" class="form-check-input status-update"
										data-key ='same_site_name'
										data-status ='{{ site_settings('same_site_name') ==  App\Enums\StatusEnum::true->status() ?  App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status()}}'
										data-route="{{ route('admin.setting.status.update') }}" class="form-check-input" type="checkbox" id="sameSiteName" >
										<label class="form-check-label" for="sameSiteName">
											{{translate("Use Same Site Name")}}
										</label>
									</div>

									<div class="row g-4">
											<div class="col-lg-{{site_settings('same_site_name') == App\Enums\StatusEnum::true->status() ? 12 : 6}} site-name">
												<label for="site_name" class="form-label">
													{{translate('Site Name')}} <span class="text-danger" >*</span>
												</label>
												<input type="text" name="site_settings[site_name]" id="site_name" class="form-control" value="{{site_settings('site_name')}}" required placeholder="{{translate("Name")}}">
											</div>

											<div class="{{site_settings('same_site_name') == App\Enums\StatusEnum::true->status() ? 'd-none' : ""}}  col-lg-6 user-site-name">
												<label for="user_site_name" class="form-label">
													{{translate('User Site Name')}} <span class="text-danger" >*</span>
												</label>
												<input type="text" name="site_settings[user_site_name]" id="user_site_name" class="form-control" value="{{site_settings('user_site_name')}}" required placeholder="{{translate("User Site Name")}}">
											</div>

											<div class="col-lg-6">
												<label for="phone" class="form-label">
													{{translate('Phone')}} <span class="text-danger" >*</span>
												</label>
												<input type="text" name="site_settings[phone]" id="phone" class="form-control" value="{{site_settings('phone')}}" required placeholder="{{translate("Phone")}}">
											</div>

											<div class="col-lg-6">
												<label for="email" class="form-label">
													{{translate('Email')}} <span class="text-danger" >*</span>
												</label>
												<input type="text" name="site_settings[email]" id="email" class="form-control" value="{{site_settings('email')}}"  placeholder="{{translate("email")}}">
											</div>


											<div class="col-lg-6">
												<label for="address" class="form-label">
													{{translate('Address')}} <span class="text-danger" >*</span>
												</label>
												<input type="text" name="site_settings[address]" id="address" class="form-control" value="{{site_settings('address')}}"  placeholder="{{translate("address")}}">
											</div>

											<div class="col-lg-6">
												<label for="copy_right_text" class="form-label">
													{{translate('Copy Right Text')}} <span class="text-danger" >*</span>
												</label>
												<input type="text" name="site_settings[copy_right_text]" id="copy_right_text" class="form-control" value="{{site_settings('copy_right_text')}}"  placeholder="{{translate("Copy Right Text")}}">
											</div>

											<div class="col-lg-6">
												<label for="pagination_number" class="form-label">
													{{translate('Pagination Number')}} <span class="text-danger" >*</span>
												</label>
												<input type="number" min="0" name="site_settings[pagination_number]" id="pagination_number" class="form-control" value="{{site_settings('pagination_number')}}" required placeholder="{{translate("Pagination Number")}}">
											</div>

											<div class="col-lg-6">

												<label for="time_zone">
													{{translate('Time Zone')}} <small class="text-danger" >*</small>
												</label>
												<select  name="site_settings[time_zone]" id="time_zone" class="select2">
													@foreach($timeZones as $timeZone)
														<option value="'{{@$timeZone}}'" @if(config('app.timezone') == $timeZone) selected @endif>{{$timeZone}}</option>
													@endforeach
												</select>

											</div>

											@if(site_settings('cookie') == App\Enums\StatusEnum::true->status())
												<div class="col-lg-12">
													<label for="cookie_text" class="form-label">
														{{translate('Cookie  Text')}} <span class="text-danger" >*</span>
													</label>
													<input type="text"  name="site_settings[cookie_text]" id="cookie_text" class="form-control" value="{{site_settings('cookie_text')}}" required placeholder="{{translate("Enter Cookie Text")}}">
												</div>
											@endif


											<div class="col-lg-6">
												<label for="maintenance_title" class="form-label">
													{{translate('Maintenance Mode Title')}} <span class="text-danger" >*</span>
												</label>
												<input type="text" name="site_settings[maintenance_title]" id="maintenance_title" class="form-control" value="{{site_settings('maintenance_title')}}"  placeholder="{{translate("Enter title")}}">
											</div>

											<div class="col-lg-6">
												<label for="maintenance_title" class="form-label">
													{{translate('Maintenance Mode Description')}} <span class="text-danger" >*</span>
												</label>
												<input type="text" name="site_settings[maintenance_description]" id="maintenance_description" class="form-control" value="{{site_settings('maintenance_description')}}"  placeholder="{{translate("Enter description")}}">
											</div>


											@if(site_settings("auto_ticket_assignment") == App\Enums\StatusEnum::true->status())
													<div class="col-lg-{{site_settings('cookie') == App\Enums\StatusEnum::true->status() ? 12 :6}}">
														<label for="geo_location" class="form-label">
															{{translate('Geo Tracking')}} <span class="text-danger" >*</span>
														</label>

														<select class="form-select" name="site_settings[geo_location]" id="geo_location">

															<option {{site_settings("geo_location") == "map_base" ? "selected" :""}} value="map_base">
																{{translate('By Google Map')}}
															</option>
															<option {{site_settings("geo_location") == "ip_base" ? "selected" :""}} value="ip_base">
																{{translate('By Client Ip')}}
															</option>

														</select>
													</div>


													<div class="col-lg-12 {{site_settings("geo_location") != "map_base" ? "d-none" :""}}" id="map-key">
														<label for="google_map_key" class="form-label">
															{{translate('Map Api Key')}} <span class="text-danger" >*</span>
														</label>

														<input type="text"  name="site_settings[google_map_key]" id="google_map_key" class="form-control" value="{{site_settings('google_map_key')}}"  placeholder="*********">
													</div>
											@endif

											<div class="text-start">
												<button type="submit"
													class="btn btn-success waves ripple-light">
													{{translate('Submit')}}
												</button>
											</div>

									</div>

								</div>
							</div>
						</form>
					</div>

					@if(auth_user()->agent == App\Enums\StatusEnum::false->status())

						<div class="tab-pane fade  " id="v-pills-agent-settings" role="tabpanel" aria-labelledby="v-pills-agent-settings">
							<form class="d-flex flex-column gap-4 settingsForm" data-route="{{route('admin.setting.store')}}"   enctype="multipart/form-data">
								@csrf

								<div class="card">
									<div class="card-header border-bottom-dashed">
										<div class="d-flex align-items-center justify-content-start">
											<h5 class="d-inline-block card-title mb-0 ">
												{{translate('Best Agent Settings')}}
											</h5>

										</div>

									</div>
									<div class="card-body">
										<div class="row g-4">
											<div class="col-lg-6">
												<label for="avg_response_time" class="form-label">
													{{translate('Avg Response Time')}} <span class="text-danger" >* ({{translate("In Miniutes")}})</span>

													<i class="ri-information-line pointer" data-toggle="tooltip" data-placement="top" title="{{translate("Avg Response Time Required To Become a Best/Popular Agent")}}"></i>
												</label>
												<input type="number" min="1" name="site_settings[avg_response_time]" id="avg_response_time" class="form-control" value="{{site_settings('avg_response_time')}}" required placeholder="{{translate("Avg Response Time")}}">

											</div>

											<div class="col-lg-6">
												<label for="number_of_tickets" class="form-label">
													{{translate('Minimum No. Of Responsed Ticket')}} <span class="text-danger" >*</span>

													<i class="ri-information-line pointer" data-toggle="tooltip" data-placement="top" title="{{translate("To attain the status of a top agent, the requisite minimum number of tickets to respond to is ...")}}"></i>
												</label>

												<input type="number" min="1" name="site_settings[number_of_tickets]" id="number_of_tickets" class="form-control" value="{{site_settings('number_of_tickets')}}" required placeholder="{{translate("Enter Number")}}">
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

					<div class="tab-pane fade" id="v-pills-basic-theme-settings" role="tabpanel" aria-labelledby="v-pills-basic-theme-settings">
						<form class="d-flex flex-column gap-4 settingsForm" data-route="{{route('admin.setting.store')}}"  enctype="multipart/form-data">
							@csrf

							<div class="card">
								<div class="card-header border-bottom-dashed">
									<div class="d-flex align-items-center justify-content-start">
										<h5 class="d-inline-block card-title mb-0 ">
											{{translate('Frontend Theme/Color Settings')}}
										</h5>

										<i class="reset-color pointer ms-3 fs-18 link-danger ri-refresh-line"></i>
									</div>

								</div>
								<div class="card-body">


									<div class="row g-4">

										<div class="col-lg-6">
											<label for="primary_color" class="form-label">
												{{translate('Primary Color')}} <span class="text-danger" >*</span>
											</label>
											<input type="text" name="site_settings[primary_color]" id="primary_color" class="form-control colorpicker" value="{{site_settings('primary_color')}}" required placeholder="{{translate("Primary Color")}}">
										</div>

										<div class="col-lg-6">
											<label for="secondary_color" class="form-label">
												{{translate('Secondary Color')}} <span class="text-danger" >*</span>
											</label>
											<input type="text" name="site_settings[secondary_color]" id="secondary_color" class="form-control colorpicker" value="{{site_settings('secondary_color')}}" required placeholder="{{translate("Secondry Color")}}">
										</div>

										<div class="col-lg-6">
											<label for="text_primary" class="form-label">
												{{translate('Text Primary Color')}} <span class="text-danger" >*</span>
											</label>
											<input type="text" name="site_settings[text_primary]" id="text_primary" class="form-control colorpicker" value="{{site_settings('text_primary')}}" required placeholder="{{translate("Text Primary Color")}}">
										</div>

										<div class="col-lg-6">
											<label for="text_secondary" class="form-label">
												{{translate('Text Secondary Color')}} <span class="text-danger" >*</span>
											</label>
											<input type="text" name="site_settings[text_secondary]" id="text_secondary" class="form-control colorpicker" value="{{site_settings('text_secondary')}}" required placeholder="{{translate("Text Secondry Color")}}">
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


					<div class="tab-pane fade" id="v-pills-storage" role="tabpanel" aria-labelledby="v-pills-storage-tab">
							<div class="card">
								<div class="card-header border-bottom-dashed">
									<div class="d-flex align-items-center">
										<h5 class="card-title mb-0 flex-grow-1">
											{{translate('Storage Settings')}}
										</h5>
									</div>
								</div>

								<div class="card-body">


									<!-- Nav tabs -->
									<ul class="nav nav-pills nav-success mb-3 gap-2" role="tablist">
                                        <li class="nav-item waves-effect waves-light" role="presentation">
                                            <a class="nav-link active" data-bs-toggle="tab" href="#local" role="tab" aria-selected="true">
                                                {{translate('local')}}
                                            </a>
                                        </li>
                                        <li class="nav-item waves-effect waves-light" role="presentation">
                                            <a class="nav-link" data-bs-toggle="tab" href="#aws-s3" role="tab" aria-selected="false" tabindex="-1">
                                                {{translate ('Aws S3')}}
                                            </a>
                                        </li>
									</ul>

									<!-- Tab panes -->
									<div class="tab-content text-muted">
										<div class="tab-pane active show" id="local" role="tabpanel">
											<form class="d-flex flex-column gap-4 settingsForm"  data-route="{{route('admin.setting.plugin.store')}}"  enctype="multipart/form-data">
												@csrf
												<div class="card shadow-none">
													<div class="card-header border-bottom-dashed px-0">
														<div class="row g-4 align-items-center">
															<div class="col-sm">
																<div>
																	<h5 class="card-title mb-0">
																		{{translate('Local Storage Settings')}}
																	</h5>
																</div>
															</div>


															<div class="col-sm-auto">
																<div class="d-flex flex-wrap align-items-start gap-2">
																	<div class="form-check form-switch form-switch-md mb-3" dir="ltr">
																		<input {{ site_settings('storage') == "local" ? 'checked' :"" }} type="checkbox" class="form-check-input"
																		value ='local'
																		name="site_settings[storage]"  id="storage">
																		<label class="form-check-label" for="storage"></label>
																	</div>
																</div>
															</div>


														</div>
													</div>

													<div class="card-body px-0">
														<div class="row g-4">
															<div class="col-12">
																<label  class="form-label">
																	{{translate('Supported File Types')}}  <span class="text-danger" >*</span>
																</label>
																<select multiple class="form-select select2" name="site_settings[mime_types][]">

																	@foreach(file_types() as $file_type)

																		<option {{in_array($file_type,$mimeTypes) ? "selected" :"" }} value="{{$file_type}}">
																			{{$file_type}}
																		</option>

																	@endforeach

																</select>
															</div>

															<div class="col-lg-6">
																<label for="max_file_upload" class="form-label">
																	{{translate('Maximum File Upload')}}  <span class="text-danger" >*
																		({{translate('You Can Not Upload More Than That At A Time ')}})
																	</span>
																</label>

																<input type="number" min="1" max="10" id="max_file_upload" required  value ="{{site_settings('max_file_upload')}}" name="site_settings[max_file_upload]" class="form-control" type="text">
															</div>

															<div class="col-lg-6">
																<label for="max_file_size" class="form-label">
																	{{translate('Max File Upload size')}}  <span class="text-danger" >*
																		({{translate('In Kilobyte')}})
																	</span>
																</label>

																<input type="number" min="1"  required  value ="{{site_settings('max_file_size')}}" name="site_settings[max_file_size]" class="form-control" id="max_file_size" type="text">
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

										<div class="tab-pane" id="aws-s3" role="tabpanel">
											<form class="d-flex flex-column gap-4 settingsForm" data-route="{{route('admin.setting.plugin.store')}}"  enctype="multipart/form-data">
												@csrf
												<div class="card shadow-none">
													<div class="card-header border-bottom-dashed px-0">
														<div class="row g-4 align-items-center">
															<div class="col-sm">
																<div>
																	<h5 class="card-title mb-0">
																		{{translate('S3 Storage Settings')}}
																	</h5>
																</div>
															</div>


															<div class="col-sm-auto">
																<div class="d-flex flex-wrap align-items-start gap-2">
																	<div class="form-check form-switch form-switch-md mb-3" dir="ltr">
																		<input {{ site_settings('storage') == "s3" ? 'checked' :"" }} type="checkbox" class="form-check-input"
																		value ='s3'
																		name="site_settings[storage]"  id="storage-s3">
																		<label class="form-check-label" for="storage-s3"></label>
																	</div>
																</div>
															</div>


														</div>
													</div>

													<div class="card-body px-0">

														<div class="row g-4">

															@foreach($awsSettings as $awsKey => $val)

																<div class="col-lg-6">
																		<label for="{{$awsKey}}" class="form-label">
																			{{
																				ucfirst(str_replace('_',' ',$awsKey))
																			}}  <span class="text-danger" >*</span>
																		</label>
																		<input required type="text"
																		 name="site_settings[aws_s3][{{$awsKey}}]" id="{{$awsKey}}" class="form-control" value="{{is_demo() ? "@@@" :$val}}" required placeholder="**********">
																</div>
															@endforeach

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
									</div>
								</div>
							</div>
					</div>

					<div class="tab-pane fade" id="v-pills-pusher" role="tabpanel" aria-labelledby="v-pills-pusher-tab">

						<form class="d-flex flex-column gap-4 settingsForm" data-route="{{route('admin.setting.plugin.store')}}" method="POST" enctype="multipart/form-data">
							@csrf

							<div class="card">
								<div class="card-header border-bottom-dashed">
									<div class="d-flex align-items-center">
										<h5 class="card-title mb-0 flex-grow-1">
											{{translate('Pusher Settings')}}
										</h5>
									</div>
								</div>
								<div class="card-body">

									<div class="row g-4">
										@foreach($pusher_settings as $key => $settings)
											<div class="col-lg-6">
												<label for="{{$key}}" class="form-label">
													{{
														Str::ucfirst(str_replace("_"," ",$key))
													}}  <span class="text-danger" >*</span>
												</label>

												<input id="{{$key}}" required class="form-control" value="{{is_demo() ? "@@@" :$settings}}" name='site_settings[pusher_settings][{{$key}}]' placeholder="************" type="text">

											</div>
										@endforeach

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

					@if(site_settings('slack_notifications') == App\Enums\StatusEnum::true->status())
						<div class="tab-pane fade" id="v-pills-slack" role="tabpanel" aria-labelledby="v-pills-slack-tab">

							<form class="d-flex flex-column gap-4 settingsForm" data-route="{{route('admin.setting.plugin.store')}}"  enctype="multipart/form-data">
								@csrf

								<div class="card">
									<div class="card-header border-bottom-dashed">
										<div class="d-flex align-items-center">
											<h5 class="card-title mb-0 flex-grow-1">
												{{translate('Slack Settings')}}
											</h5>
										</div>
									</div>
									<div class="card-body">

										<div class="row g-4">

											<div class="col-lg-6">
												<label for="web_hook_url" class="form-label">
													{{translate('Web Hook Url')}}
													 <span class="text-danger" >*</span>
												</label>

												<input id="web_hook_url" required class="form-control" value="{{is_demo() ? "@@@" :site_settings("slack_web_hook_url")}}" name='site_settings[slack_web_hook_url]' placeholder="************" type="text">

											</div>

											<div class="col-lg-6">
												<label for="slack_channel" class="form-label">
													{{translate("Chanel Name")}}
													 <span class="text-danger" >*
														({{translate('Optional')}})
													 </span>
												</label>

												<input id="slack_channel" required class="form-control" value="{{is_demo() ? "@@@" :site_settings("slack_channel")}}" name='site_settings[slack_channel]' placeholder="************" type="text">

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


					 @if(site_settings('captcha') == App\Enums\StatusEnum::true->status())
						<div class="tab-pane fade" id="v-pills-recap" role="tabpanel" aria-labelledby="v-pills-recap-tab">

							<form class="d-flex flex-column gap-4 settingsForm" data-route="{{route('admin.setting.plugin.store')}}" method="POST" enctype="multipart/form-data">
								@csrf
								<div class="card">
									<div class="card-header border-bottom-dashed">
										<div class="row g-4 align-items-center">
											<div class="col-sm">
												<div>
													<h5 class="card-title mb-0">
														{{translate('Recaptcha Settings')}}
													</h5>
												</div>
											</div>

										</div>
									</div>


									<div class="card-body">
										<form class="d-flex flex-column gap-4 settingsForm"  data-route="{{route('admin.setting.plugin.store')}}"  enctype="multipart/form-data">
											@csrf

												<div class="form-group form-check form-check-success mb-2 ">
													<input {{ site_settings('default_recaptcha') == App\Enums\StatusEnum::true->status() ? 'checked' :"" }} type="checkbox" class="form-check-input status-update"

													data-key ='default_recaptcha'
													data-status ='{{ site_settings('default_recaptcha') == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status() :App\Enums\StatusEnum::true->status()}}'
													data-route="{{ route('admin.setting.status.update') }}" class="form-check-input" type="checkbox" id="defaultCaptcha" >
													<label class="form-check-label" for="defaultCaptcha">
														{{translate("Use Default Captcha")}}
													</label>
												</div>

												<div class="row g-4 google-captcha">

													@foreach($google_recaptcha as $key => $settings)
														<div class="col-lg-6">
															<label for="{{$key}}" class="form-label">
																{{
																	Str::ucfirst(str_replace("_"," ",$key))
																}}  <span class="text-danger" >*</span>
															</label>
															@if($key == 'status')
															<select   name='site_settings[google_recaptcha][{{$key}}]' class="form-select"  id="{{$key}}" >
																@foreach( App\Enums\StatusEnum::toArray() as $key => $val)
																<option {{$settings ==  $val ? 'selected' :""}}  value="{{$val}}">
																	{{$key}}
																</option>
																@endforeach

															</select>
															@else
															<input id="{{$key}}" required class="form-control" value="{{is_demo() ? "@@@" :$settings}}" name='site_settings[google_recaptcha][{{$key}}]' placeholder="************" type="text">
															@endif

														</div>
													@endforeach

													<div class="text-start">
														<button type="submit"
															class="btn btn-success waves ripple-light">
															{{translate('Submit')}}
														</button>
													</div>

												</div>

										</form>

									</div>
								</div>

							</form>

						</div>
					 @endif


					<div class="tab-pane fade" id="v-pills-social-login" role="tabpanel" aria-labelledby="v-pills-social-login-tab">

						<form class="d-flex flex-column gap-4 settingsForm" data-route="{{route('admin.setting.plugin.store')}}" method="POST" enctype="multipart/form-data">
							@csrf
							<div class="card">
								<div class="card-header border-bottom-dashed">
									<div class="d-flex align-items-center">
										<h5 class="card-title mb-0 flex-grow-1">
											{{translate('Social Login Setup')}}
										</h5>
									</div>
								</div>

								<div class="card-body">
										@foreach($socail_login_settings as $medium => $settings)

											<div class="card shadow-none">
												<div class="card-header border-bottom-dashed px-0">
													<div class="d-flex align-items-center">
														<h5 class="card-title mb-0 flex-grow-1">
															{{ ucWords(str_replace('_',' ',$medium))}}
														</h5>
													</div>
												</div>

												<div class="card-body px-0">
													@php
														$social_settings = ($settings);

														if($medium == 'envato_oauth'){

															if(is_array($settings) && !Arr::exists($settings,'personal_token')){
																$settings['personal_token']  = '@@';
															}
								
														}
													
													@endphp

													<div class="row g-4">
														@foreach( $settings as $key => $val)
															<div class="col-lg-6">
																<label  class="form-label">
																	{{
																		Str::ucfirst(str_replace("_"," ",$key))
																	}}  <span class="text-danger" >*</span>
																</label>


																@if($key == 'status')

																	<select class="form-select" name="site_settings[social_login][{{$medium}}][{{$key}}]"  >

																		<option {{$val == App\Enums\StatusEnum::true->status() ? "selected" :""}} value="{{App\Enums\StatusEnum::true->status()}}">
																			{{translate('Active')}}
																		</option>
																		<option {{$val == App\Enums\StatusEnum::false->status() ? "selected" :""}} value="{{App\Enums\StatusEnum::false->status()}}">
																			{{translate('Inactive')}}
																		</option>
																	</select>

																@else
																	<input required class="form-control" value="{{is_demo() ? "@@@" :$val}}" name='site_settings[social_login][{{$medium}}][{{$key}}]' placeholder="************" type="text">
																@endif



															</div>
														@endforeach

														<div class="col-lg-6">
															<label for="cburl-{{$loop->index}}" class="form-label">
																{{translate('Callback Url')}}
															</label>
															<div class="input-group">

																<input id="cburl-{{$loop->index}}" readonly value="{{route('social.login.callback',str_replace("_oauth","",$medium))}}" type="text" class="form-control" aria-label="Recipient's username with two button addons">
																<button data-text ="{{route('social.login.callback',str_replace("_oauth","",$medium))}}" class="copy-text btn btn-info" type="button"><i class=' fs-18 bx bx-copy'></i></button>
															</div>
														</div>
													</div>
												</div>
											</div>
										
										@endforeach

										<div class="text-start">
											<button type="submit"
												class="btn btn-success waves ripple-light"
												>
												{{translate('Submit')}}
											</button>
										</div>

								</div>

							</div>

						</form>

					</div>

					<div class="tab-pane fade" id="v-pills-logo" role="tabpanel" aria-labelledby="v-pills-logo-tab">

						<form class="d-flex flex-column gap-4 settingsForm" data-route="{{route('admin.setting.logo.store')}}"   enctype="multipart/form-data">
							@csrf

							<div class="card">
								<div class="card-header border-bottom-dashed">
									<div class="d-flex align-items-center">
										<h5 class="card-title mb-0 flex-grow-1">
											{{translate('Logo Settings')}}
										</h5>
									</div>
								</div>
								<div class="card-body">
									<div class="row g-4">
											<div class="col-lg-6">
												<label for="site_logo_lg" class="form-label">
													{{translate('Site Logo')}} <span class="text-danger" >*</span>
												</label>
												<input data-size="100x100" type="file" name="site_settings[site_logo_lg]" id="site_logo_lg" class="form-control img-preview">

												<div class="mt-2 image-preview-section ">
													<img src="{{ getImageUrl(getFilePaths()['site_logo']['path']."/".site_settings('site_logo_lg')) }}" alt="{{site_settings('site_logo_lg')}}"  class="bg-dark logo-preview">
												</div>

											</div>

											<div class="col-lg-6">
												<label for="logo_sm" class="form-label">
													{{translate('Logo Icon')}} <span class="text-danger" >*</span>
												</label>
												<input data-size="50x50" type="file" name="site_settings[site_logo_sm]" id="logo_sm" class="form-control img-preview">

												<div class="mt-2 image-preview-section ">
													<img src="{{ getImageUrl(getFilePaths()['site_logo']['path']."/".site_settings('site_logo_sm')) }}" alt="{{site_settings('site_logo_sm')}}" class="logo-preview">
												</div>

											</div>

											<div class="col-lg-6">
												<label for="frontendLogo" class="form-label">
													{{translate('Frontend Logo')}} <span class="text-danger" >*</span>
												</label>
												<input data-size="100x100" type="file" name="site_settings[frontend_logo]" id="frontendLogo" class="form-control img-preview">
												<div class="fav-preview-image mt-2 image-preview-section ">
													<img src="{{ getImageUrl(getFilePaths()['site_logo']['path']."/".site_settings('frontend_logo')) }}" alt="{{site_settings('frontend_logo')}}" class="logo-preview">
												</div>
											</div>

											<div class="col-lg-6">
												<label for="favicon" class="form-label">
													{{translate('Site Favicon')}} <span class="text-danger" >*</span>
												</label>
												<input  data-size="50x50" type="file" name="site_settings[site_favicon]" id="favicon" class="form-control img-preview">
												<div class="fav-preview-image mt-2 image-preview-section ">
													<img src="{{ getImageUrl(getFilePaths()['site_logo']['path']."/".site_settings('site_favicon')) }}" alt="{{site_settings('site_favicon')}}" class="logo-preview">
												</div>
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
				</div>
			</div><!--  end col -->
		</div>
	</div>

	<div class="modal fade" id="cronjob" tabindex="-1"  aria-hidden="true">
		<div class="modal-dialog  modal-md">
			<div class="modal-content">
				<div class="modal-header p-3">
					<h5 class="modal-title" id="modalTitle">{{translate('Cron Job Setting')}}
					</h5>

				</div>

				<div class="modal-body">
					<div class="mb-3">
						<label for="queue_url" class="form-label">{{translate('Cron Job ')}} <span class="text-danger">({{translate('Set time for 1 minute')}})</span></label>

						<div class="input-group mb-2">
							<input readonly id="queue_url"  class="form-control" value="curl -s {{route('queue.work')}}">
							<button data-modal = "modal" data-text ="curl -s {{route('queue.work')}}" class="copy-text btn btn-info" type="button"><i class=' fs-18 bx bx-copy'></i></button>
						</div>

						<div class="input-group">
							<input readonly class="form-control" value="curl -s {{route('cron.run')}}">
							<button  data-modal ="modal" data-text ="curl -s {{route('cron.run')}}" class="copy-text btn btn-info" type="button"><i class=' fs-18 bx bx-copy'></i></button>
						</div>
					</div>

				</div>

				<div class="modal-footer">
					<div class="hstack gap-2 justify-content-end">
						<button type="button"
							class="btn btn-danger waves ripple-light"
							data-bs-dismiss="modal">
							{{translate('Close
							')}}
						</button>

					</div>
				</div>
			</div>
		</div>
	</div>




@endsection


@push('script-include')

    <script src="{{asset('assets/global/js/colorpicker.min.js')}}"></script>
	<script src="{{asset('assets/global/js/summernote.min.js')}}"></script>
	<script src="{{asset('assets/global/js/editor.init.js')}}"></script>

@endpush
@push('script-push')
<script>
  "use strict";
       var widths = @json($widths);

       $('.colorpicker').colorpicker();

        var count = "{{count($ticketSettings)-1}}";

		// add more ticket option
		$(document).on('click','#add-ticket-option',function(e){

			var options = "";

			for(var i in widths){
				options += `<option value="${i}">${widths[i]}%</option>`;

			}

			count++
			var html = `<tr>
							<td >
								<input type="text" name="ticket_setting[${count}][labels]" class="form-control">
							</td>
							<td>
								<select class="form-select" name="ticket_setting[${count}][type]" >
									<option value="text">Text</option>
									<option value="email">Email</option>
									<option value="number">Number</option>
									<option value="date">Date</option>
									<option value="textarea">Textarea</option>
								</select>
							</td>
							<td>
								<select class="form-select" name="ticket_setting[${count}][width]" >
									${options}
								</select>
							</td>


							<td>
								<select class="form-select" name="ticket_setting[${count}][required]" >
									<option value="1">Yes</option>
									<option value="0">No</option>
								</select>
							</td>

							<td>
								<select class="form-select" name="ticket_setting[${count}][visibility]" >
									<option value="1">Visible</option>
									<option value="0">Hidden</option>
								</select>
							</td>


							<td>
								<input   type="text" name="ticket_setting[${count}][placeholder]" class="form-control">
								<input   type="hidden" name="ticket_setting[${count}][default]" class="form-control" value="0">
								<input   type="hidden" name="ticket_setting[${count}][multiple]" class="form-control" value="0">
								<input   type="hidden" name="ticket_setting[${count}][name]" class="form-control" value="">

							</td>

							<td>
								<div class="hstack gap-3">
									<a href="javascript:void(0);" class="delete-option fs-18 link-danger">
									<i class="ri-delete-bin-line"></i></a>
								</div>
							</td>
						</tr>`;
				$('#ticketField').append(html)

			e.preventDefault()
		})
		//delete ticket options
		$(document).on('click','.delete-option',function(e){
			$(this).closest("tr").remove()
			count--
			e.preventDefault()
		})
		$(".select2").select2({
			tokenSeparators: [',', ' ']
		})
        $(document).on('change','#geo_location',function(e){
			 var trackBy = $(this).val();
			 if(trackBy == 'map_base'){
				$('#map-key').removeClass('d-none')
			 }
			 else{
				$('#map-key').addClass('d-none')
			 }
		})

		$(document).on('click','.reset-color',function(e){

			$("[name='site_settings[primary_color]']").val("#5db6ff")
			$("[name='site_settings[secondary_color]']").val("#654ce6")
			$("[name='site_settings[text_primary]']").val("#0f2335")
			$("[name='site_settings[text_secondary]']").val("#777777")

			toastr("{{translate('Successfully Reseted')}}",'success')

		});

		//same site name toggle
		$(document).on('click','#sameSiteName',function(e){

			if ($(this).prop('checked')) {
				$('.user-site-name').addClass('d-none')
				$('.site-name').removeClass('col-lg-6')
				$('.site-name').addClass('col-lg-12')
			}else{
				$('.site-name').removeClass('col-lg-12')
				$('.site-name').addClass('col-lg-6')
				 $('.user-site-name').removeClass('d-none')
			}
			e,preventDefault();
		})






</script>
@endpush
