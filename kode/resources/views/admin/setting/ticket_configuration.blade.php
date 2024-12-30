@extends('admin.layouts.master')

@push('style-include')

   <link href="{{asset('assets/global/css/colorpicker.min.css')}}" rel="stylesheet">
   <link href="{{asset('assets/global/css/summnernote.css')}}" rel="stylesheet" type="text/css" />

@endpush

@push('styles')

<style>

		.dragable-card{
			cursor: grab;
		}
       .config-card {
            border: 1px solid #eee;
            padding: 25px;
        }
        ul.config-list{
            list-style: none;
            padding: 0;
            margin: 0;
        }
        ul.config-list li{
            margin-bottom: 12px;
            padding-bottom: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #eee;
        }
        ul.config-list li span{
            display: inline-block;
            color: var(--vz-body-color);
        }
        ul.config-list li span:last-child{
            font-weight: 600;
            color: var(--text-primary);
        }

		#modalLoader{
			display: flex;
			justify-content: center;
			align-items: center;
			min-height: 250px;
		}


		#cardloader{
			position: absolute;
			display: flex;
			justify-content: center;
			align-items: center;
			min-height: 250px;
			z-index: 5 !important;
			top: 50%;
			left: 50%;
			transform: translate(-50%,-50%);
		}
</style>


@endpush

@section('content')

@php

	$ticketSettings  = json_decode(site_settings('ticket_settings'),true);
	$inputTypes      = getInputTypes();
	$ticketStatus    = App\Models\TicketStatus::active()->get();
	$widths          = App\Enums\FieldWidth::toArray();

@endphp

	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box d-sm-flex align-items-center justify-content-between">
					<h4 class="mb-sm-0">
						{{@$title}}
					</h4>
					<div class="page-title-right">
						<ol class="breadcrumb m-0">
							<li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">
								{{translate('Home')}}
							</a></li>
							<li class="breadcrumb-item active">
								{{translate('Ticket Configurations')}}
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
								<a class="nav-link active" id="v-pills-ticket-basic-tab" data-bs-toggle="pill" href="#v-pills-ticket-basic" role="tab" aria-controls="v-pills-ticket-basic" aria-selected="false" tabindex="-1">
									<i class="ri-settings-2-line"></i> {{translate("Settings")}}
								</a>



								<a class="nav-link" id="v-pills-ticket-settings-tab" data-bs-toggle="pill" href="#v-pills-ticket-settings" role="tab" aria-controls="v-pills-ticket-settings" aria-selected="false" tabindex="-1">
									<i class="ri-input-cursor-move"></i> {{translate("Field Settings")}}
								</a>


								<a class="nav-link" id="v-pills-operating-hour-tab" data-bs-toggle="pill" href="#v-pills-operating-hour" role="tab" aria-controls="v-pills-operating-hour" aria-selected="false" tabindex="-1">
									
									<i class="ri-history-line"></i>{{translate("Operating Hour")}}
								</a>

							
						</div>
					</div>
				</div>

			</div>
			<div class="col-12">
				<div class="tab-content text-muted mt-4 mt-md-0" id="v-pills-tabContent">

                    <div class="tab-pane fade active show" id="v-pills-ticket-basic" role="tabpanel" aria-labelledby="v-pills-ticket-basic-tab">
						<div class="card">

							<div class="card-header border-bottom-dashed">
								<div class="row g-4 align-items-center">
									<div class="col-sm">
										<div>
											<h5 class="card-title mb-0">
												{{translate('Ticket Settings')}}
											</h5>
										</div>
									</div>
								</div>
							</div>

							<div class="card-body">

								<form data-route="{{route('admin.setting.store')}}" class="settingsForm" method="post">
									@csrf
									<div class="row g-4">

										<div class="col-lg-6">
											<label for="email_to_ticket" class="form-label">
												{{translate('Email To Ticket')}}
													
												<span  class=" fs-15 link-danger  waves ripple-light"><i  data-bs-toggle="tooltip" data-bs-placement="top" title="{{translate('Enabling this option will activate Email to ticket feature')}}" class="ri-information-line"></i>
												</span>
											</label>
											<select class="select2" name="site_settings[email_to_ticket]" id="email_to_ticket">
												<option {{site_settings(key:'email_to_ticket',default:0) == 1 ? 'selected' :''}}  value="1">
														{{translate('Enable')}}
												</option>
												<option {{site_settings(key:'email_to_ticket',default:0) == 0 ? 'selected' :''}}  value="0">
														{{translate('Disable')}}
												</option>
											</select>
							
										</div>


										<div class="col-lg-6">
											<label for="ticket_department" class="form-label">
												{{translate('Enable ticket product')}}
													
												<span  class=" fs-15 link-danger  waves ripple-light"><i  data-bs-toggle="tooltip" data-bs-placement="top" title="{{translate('Enabling this option will activate ticket product selection during ticket create')}}" class="ri-information-line"></i>
												</span>
											</label>
											<select class="select2" name="site_settings[ticket_department]" id="ticket_department">
												<option {{site_settings(key:'ticket_department',default:0) == 1 ? 'selected' :''}}  value="1">
														{{translate('Enable')}}
												</option>
												<option {{site_settings(key:'ticket_department',default:0) == 0 ? 'selected' :''}}  value="0">
														{{translate('Disable')}}
												</option>
											</select>
							
										</div>


										<div class="col-lg-6">

											<label for="agent_name_privacy" class="form-label">
												{{translate('Agent name privacy')}}
													
												<span  class=" fs-15 link-danger  waves ripple-light"><i  data-bs-toggle="tooltip" data-bs-placement="top" title="{{translate('Enabling this option will activated agent name privacy in user reply section. user will not able to see who replied')}}" class="ri-information-line"></i>
												</span>
											</label>
											<select class="select2" name="site_settings[agent_name_privacy]" id="agent_name_privacy">
												<option {{site_settings(key:'agent_name_privacy',default:0) == 1 ? 'selected' :''}}  value="1">
														{{translate('Enable')}}
												</option>
												<option {{site_settings(key:'agent_name_privacy',default:0) == 0 ? 'selected' :''}}  value="0">
														{{translate('Disable')}}
												</option>
											</select>
							
										</div>


										<div class="col-lg-6">
											
											<label for="message_seen_status" class="form-label">
												{{translate('Message seen status')}}
													
												<span  class=" fs-15 link-danger  waves ripple-light"><i  data-bs-toggle="tooltip" data-bs-placement="top" title="{{translate('By enabling this option, users will be able to see whether their messages have been seen by an agent or not')}}" class="ri-information-line"></i>
												</span>
											</label>
											<select class="select2" name="site_settings[message_seen_status]" id="message_seen_status">
												<option {{site_settings(key:'message_seen_status',default:1) == 1 ? 'selected' :''}}  value="1">
														{{translate('Enable')}}
												</option>
												<option {{site_settings(key:'message_seen_status',default:1) == 0 ? 'selected' :''}}  value="0">
														{{translate('Disable')}}
												</option>
											</select>
							
										</div>
										


										<div class="col-lg-6">

											<label for="user_ticket_close" class="form-label">
												{{translate('User ticket close')}}
													
												<span  class=" fs-15 link-danger  waves ripple-light"><i  data-bs-toggle="tooltip" data-bs-placement="top" title="{{translate('Enabling this option will allow user to close their ticket')}}" class="ri-information-line"></i>
												</span>
											</label>
											<select class="select2" name="site_settings[user_ticket_close]" id="user_ticket_close">
												<option {{site_settings(key:'user_ticket_close',default:0) == 1 ? 'selected' :''}}  value="1">
														{{translate('Enable')}}
												</option>
												<option {{site_settings(key:'user_ticket_close',default:0) == 0 ? 'selected' :''}}  value="0">
														{{translate('Disable')}}
												</option>
											</select>
							
										</div>
										<div class="col-lg-6">

											<label for="user_ticket_open" class="form-label">
												{{translate('User ticket re-open')}}
													
												<span  class=" fs-15 link-danger  waves ripple-light"><i  data-bs-toggle="tooltip" data-bs-placement="top" title="{{translate('Enabling this option will allow user to re-open their cloesed ticket')}}" class="ri-information-line"></i>
												</span>
											</label>
											<select class="select2" name="site_settings[user_ticket_open]" id="user_ticket_open">
												<option {{site_settings(key:'user_ticket_open',default:0) == 1 ? 'selected' :''}}  value="1">
														{{translate('Enable')}}
												</option>
												<option {{site_settings(key:'user_ticket_open',default:0) == 0 ? 'selected' :''}}  value="0">
														{{translate('Disable')}}
												</option>
											</select>
							
										</div>

										
										<div class="col-lg-6">
											<label for="ticket_prefix" class="form-label">
												{{translate('Ticket Prefix')}} <span class="text-danger" >*</span>
											</label>
											<input type="text" name="site_settings[ticket_prefix]" id="ticket_prefix" class="form-control" value="{{site_settings('ticket_prefix')}}" required placeholder="{{translate("Ticket Prefix")}}">
										</div>

										<div class="col-lg-6">
											<label for="ticket_suffix" class="form-label">
												{{translate('Ticket Suffix')}} <span class="text-danger" >*</span>
											</label>
											<select class="select2" name="site_settings[ticket_suffix]" id="ticket_suffix">
												<option {{site_settings(key:'ticket_suffix',default:1) == 1 ? 'selected' :''}}  value="1">
														{{translate('Random Number')}} (6599F2)
												</option>
												<option {{site_settings(key:'ticket_suffix',default:1) == 0 ? 'selected' :''}}  value="0">
														{{translate('Incremental')}}(1,2,3,4)
												</option>
											</select>
							
										</div>

										<div class="col-lg-6">
											<label for="guest_ticket" class="form-label">
												{{translate('Guest Ticket')}} <span class="text-danger" >*</span>
											</label>
											<select class="select2" name="site_settings[guest_ticket]" id="guest_ticket">
												<option {{site_settings(key:'guest_ticket',default:1) == 1 ? 'selected' :''}}  value="1">
														{{translate('Enable')}}
												</option>
												<option {{site_settings(key:'guest_ticket',default:1) == 0 ? 'selected' :''}}  value="0">
														{{translate('Disable')}}
												</option>
											</select>
							
										</div>

										<div class="col-lg-6">
											<label for="custom_file" class="form-label">
												{{translate('Custom files')}} <span class="text-danger" >* ({{translate("In Ticket Reply")}}) </span>
											</label>
											<select class="select2" name="site_settings[custom_file]" id="custom_file">
												<option {{site_settings(key:'custom_file',default:1) == 1 ? 'selected' :''}}  value="1">
														{{translate('Enable')}}
												</option>
												<option {{site_settings(key:'custom_file',default:1) == 0 ? 'selected' :''}}  value="0">
														{{translate('Disable')}}
												</option>
											</select>
							
										</div>
						
										<div class="col-lg-6">
											<label for="ticket_search_otp" class="form-label">
												{{translate('Ticket View OTP')}}
													
												<span  class=" fs-15 link-danger  waves ripple-light"><i  data-bs-toggle="tooltip" data-bs-placement="top" title="{{translate('Enabling this option will activate the OTP system for ticket View')}}" class="ri-information-line"></i>
												</span>
											</label>
											<select class="select2" name="site_settings[ticket_search_otp]" id="ticket_search_otp">
												<option {{site_settings(key:'ticket_search_otp',default:0) == 1 ? 'selected' :''}}  value="1">
														{{translate('Enable')}}
												</option>
												<option {{site_settings(key:'ticket_search_otp',default:0) == 0 ? 'selected' :''}}  value="0">
														{{translate('Disable')}}
												</option>
											</select>
							
										</div>
										<div class="col-lg-6">
											<label for="user_ticket_delete" class="form-label">
												{{translate('User Ticket Delete')}}
													
												<span  class=" fs-15 link-danger  waves ripple-light"><i  data-bs-toggle="tooltip" data-bs-placement="top" title="{{translate('Enabling this option will allow user to delete ticket ')}}" class="ri-information-line"></i>
												</span>
											</label>
											<select class="select2" name="site_settings[user_ticket_delete]" id="user_ticket_delete">
												<option {{site_settings(key:'user_ticket_delete',default:0) == 1 ? 'selected' :''}}  value="1">
														{{translate('Enable')}}
												</option>
												<option {{site_settings(key:'user_ticket_delete',default:0) == 0 ? 'selected' :''}}  value="0">
														{{translate('Disable')}}
												</option>
											</select>
							
										</div>

										<div class="col-lg-12">
											<div>
												<label for="autoTicketClose" class="me-2">{{translate('Auto Close Ticket')}}</label>
							

												<input  {{ site_settings('ticket_auto_close') == App\Enums\StatusEnum::true->status() ? 'checked' : '' }}
														type="checkbox" class="form-check-input status-update"
														data-key='ticket_auto_close'
														data-status='{{ site_settings('ticket_auto_close') == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status() }}'
														data-route="{{ route('admin.setting.status.update') }}" id="autoTicketClose">
											</div>
					
									
											<div class="row align-items-center d-dos-input g-2">
												<div class="col-auto">
													<label class="form-label" > 
														{{translate("Ticket With the status")}}
													</label>
												</div>
												<div class="col-auto one-line">
													<select name="site_settings[ticket_close_status]"  class="select2">
														<option value="">
															{{translate('Select Status')}}
														</option>

														@foreach($ticketStatus as $status)
															<option {{site_settings(key:'ticket_close_status',default:-1) == $status->id ? 'selected' :''}}  value="{{$status->id}}">
																{{
																	ucfirst(strtolower($status->name))
																}}
															</option>
														@endforeach
													</select>
												</div>
												<div class="col-auto">
													<label class="w-nowrap" > 
														{{translate("will be automatically closed if there is no response from the user within")}}
													</label>
												</div>
												<div class="col-auto">
													<input class="form-control" value='{{site_settings(key:'ticket_close_days',default:1)}}'  required type="number" name="site_settings[ticket_close_days]" >
												</div>
												<div class="col-auto">
													<label class="w-nowrap"> 
														{{translate("Days")}}
													</label>
												</div>						
											</div>
										</div>


										<div class="col-lg-12">
											<div>
												<label for="duplicateTicket" class="me-2">{{translate('Duplicate ticket Prevent')}}</label>
							
												<input  {{ site_settings('duplicate_ticket_prevent') == App\Enums\StatusEnum::true->status() ? 'checked' : '' }}
														type="checkbox" class="form-check-input status-update"
														data-key='duplicate_ticket_prevent'
														data-status='{{ site_settings('duplicate_ticket_prevent') == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status() }}'
														data-route="{{ route('admin.setting.status.update') }}" id="duplicateTicket">
											</div>
				


											@php
												$duplicateStatus = site_settings(key:'ticket_duplicate_status');
								
												$statusArr = [];
												if($duplicateStatus){
													$statusArr = json_decode($duplicateStatus,true);

												}

											@endphp
									
											<div class="row d-dos-input align-items-center">
					
												<div class="col-auto">
													<label class="form-label" > 
														{{translate("User Can't create multiple tickets with the same category if status is ")}}
													</label>
												</div>
												<div class="col-auto">
													<select required name="site_settings[ticket_duplicate_status][]" multiple class="select2">
														<option value="">
															{{translate('Select Status')}}
														</option>

														@foreach($ticketStatus as $status)
	
															<option @if(in_array($status->id ,$statusArr )) selected @endif  value="{{$status->id}}">
																{{
																	ucfirst(strtolower($status->name))
																}}
															</option>
													
														@endforeach
	
													</select>
												</div>
											</div>
										</div>


										<div class="col-lg-12">

											<div>
												<label for="ticket_notes" class="form-label">
													{{translate('Ticket Short Notes')}} <span class="text-danger" >*</span>
												</label>
		
													<textarea class="form-control summernote"  name="site_settings[ticket_notes]" id="ticket_notes" cols="30" rows="10" required>{{site_settings('ticket_notes')}}</textarea>
											</div>
										</div>


										<div class="col-12">
											<div class="text-start">
												<button type="submit" class="btn btn-success">
													{{translate('Update')}}
												</button>
											</div>
										</div>
									</div>
								</form>
								
							</div>
						</div>
					</div>



					


					<div class="tab-pane fade" id="v-pills-ticket-settings" role="tabpanel" aria-labelledby="v-pills-ticket-settings-tab">
		
							<div class="card">
								<div class="card-header border-bottom-dashed">
									<div class="row g-4 align-items-center">
										<div class="col-sm">
											<div>
												<h5 class="card-title mb-0">
													{{ translate('Field Configuration') }}
												</h5>
											</div>
										</div>
	
										<div class="col-sm-auto">
											<div class="d-flex flex-wrap align-items-start gap-2">
												<button id="add-ticket-option" type="button"
													class="btn btn-sm btn-success add-btn waves ripple-light"><i
														class="ri-add-line align-bottom me-1"></i>
													{{ translate('Add More') }}
												</button>
											</div>
										</div>
	
									</div>
								</div>


								<form class="input-card-form">
									@csrf
									<div class="position-relative">

										<div class="d-none" id="cardloader">
											<div class="spinner-border text-primary avatar-sm" role="status">
												<span class="visually-hidden"></span>
											</div>
										</div>
						
										<div class="row p-4" id="ticketInputCards">
											@include('admin.setting.partials.ticket_field_card')
									    </div>
										

									</div>
							    </form>

						
							</div>
				
					</div>


					<div class="tab-pane fade " id="v-pills-operating-hour" role="tabpanel" aria-labelledby="v-pills-operating-hour-tab">


						<div class="row">

							<div class="col-lg-8">
								<div class="card">

									<div class="card-header border-bottom-dashed">
										<div class="row g-4 align-items-center">
											<div class="col-sm">
												<div>
													<h5 class="card-title mb-0">
														{{translate('Operating Hours Note')}}
													</h5>
												</div>
											</div>
										</div>
									</div>
		
									<div class="card-body">
		
										<form data-route="{{route('admin.setting.store')}}" class="settingsForm" method="post">
											@csrf
		
											
											<div>
												<form class="settingsForm p-3" data-route ="">
													@csrf
												
		
														<div>
															<label for="operating_note">
																{{translate('Note')}}  <span class="text-danger">*</span>
															</label>
															<textarea placeholder="{{translate('Enter note')}}" class="form-control summernote" required="required" name="site_settings[operating_note]" id="operating_note" cols="50" rows="4">{{site_settings('operating_note')}}</textarea>
														</div>
		
		
											
									
													<div class="text-start mt-2">
														<button type="submit"
															class="btn btn-success waves ripple-light"
															id="add-btn">
															{{translate('Submit')}}
														</button>
													</div>
												</form>
											</div>
									
										</form>
									 
									</div>
								</div>
							</div>

							<div class="col-lg-4">
								<div class="card">
									<div class="card-header border-bottom-dashed">
										<div>
											<h5 class="card-title mb-0">
												{{translate('Variables')}}
											</h5>
										</div>
									</div>
				
									<div class="card-body">
										<div>
								
				
											<div class="mt-3">
												<div class="text-center">
													<div class="d-flex align-items-center justify-content-between">
														<div>
															<h6 class="mb-0">
																[timezone]
															</h6>
														</div>
														<p class="mb-0">
															 {{translate("System timezone")}}
														</p>
													</div>
													
												</div>
											</div>
										</div>
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
												{{translate('Operating Hours')}}
											</h5>
										</div>
									</div>
								</div>
							</div>

							<div class="card-body">

								<form data-route="{{route('admin.setting.business.hour')}}" class="settingsForm" method="post">
									@csrf
									<div class="row g-4">


										<div class="mb-lg-0 mb-3">
											<div class="form-check d-flex align-items-center gap-2 mb-0 fs-14">
												<input   {{ site_settings('enable_business_hour') == App\Enums\StatusEnum::true->status() ? 'checked' : '' }}
												type="checkbox" class="form-check-input status-update"
												data-key='enable_business_hour'
												data-status='{{ site_settings('enable_business_hour') == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status() }}'
												data-route="{{ route('admin.setting.status.update') }}" class="form-check-input" type="checkbox" id="enable_business_hour">
												<label class="form-check-label" for="enable_business_hour">
													{{translate('Enable business hours')}}
												</label>
											</div>
										</div>
				


										<div class="table-responsive operating-table">
											<table class="table align-middle table-nowrap mb-0 ">
												<thead class="table-light ">
													<tr>
													
														<th scope="col">
															{{translate('Days')}}
														</th>
														<th scope="col">
															{{translate('Start time')}}
														</th>
														<th scope="col">
															{{translate('End time')}}
														</th>
	
													</tr>
												</thead>
												<tbody>

													@php
														$days =  [
															'Mon' =>  'Monday',
															'Tue' =>  'Tuesday',
															'Wed' =>  'Wednesday',
															'Thu' =>  'Thursday',
															'Fri' =>  'Friday',
															'Sat' =>  'Saturday',
															'Sun' =>  'Sunday',
														];
														$operatingTimes = generateOperatingTimes();
													@endphp
													@php
													  $business_hours =   site_settings(key:'business_hour',default:null) 
													                     ? json_decode(site_settings(key:'business_hour',default:null),true)
																		 : [];

														
													@endphp
														@foreach ($days as $key => $day )
															<tr>
															     @php

                                                                   $businessDay =  Arr::get($business_hours ,$key,[]);
																   $is_holiday  =  Arr::get($businessDay ,'is_off',false);
																   $startTime  =  Arr::get($businessDay ,'start_time',null);
																   $endTime  =  Arr::get($businessDay ,'end_time',null);
																 @endphp
																	<td>
																		<input {{$is_holiday ? "checked" :'' }}  class="form-check-input" name="operating_day[]" type="checkbox" value="{{$key}}" id="{{$key}}">
																		<label class="form-check-label fs-14" for="{{$key}}">
																			{{$day}}
																		</label>
																	</td>

																	<td>
																		<select name="start_time[{{$key}}]" class="form-select select-time start-time">

																			<option value="">
																				{{translate('Select time')}}
																			</option>
																			<option {{$startTime == '24H' ? "selected" :''}} value="24H">
																				  {{translate("24 Hour")}}
																			</option>

																		
																			@foreach($operatingTimes as $time)
																				<option {{$startTime == $time ? "selected" :''}} value="{{$time}}">{{$time}}</option>
																			@endforeach
																		</select>
																	</td>
																	<td class="endtime_td">
																		<select @if($startTime == '24H') disabled @endif name="end_time[{{$key}}]" class="form-select select-time" >

																			<option label="{{translate('Select end time')}}"></option>
																			@foreach($operatingTimes as $time)
																				<option {{$endTime == $time ? "selected" :''}} value="{{$time}}">{{$time}}</option>
																			@endforeach
																		</select>
																	</td>
												
															</tr>
														@endforeach
	
												</tbody>
	
											</table>
										</div>
										

										<div class="col-12 mt-2">
											<div class="text-start">
												<button type="submit" class="btn btn-success">
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
	</div>
    @include('admin.setting.partials.modal.add_ticket_field')
    @include('admin.setting.partials.modal.edit_ticket_field')
    @include('modal.delete_modal')


@endsection


@push('script-include')

  
	<script src="{{asset('assets/global/js/summernote.min.js')}}"></script>
	<script src="{{asset('assets/global/js/editor.init.js')}}"></script>

	<script src="{{asset('assets/global/js/jquery-migrate-3.0.0.min.j') }}"></script>
    <script src="{{asset('assets/global/js/jscharting.js') }}"></script>
    <script src="{{asset('assets/global/js/jquery-ui.min.js') }}"></script>

@endpush
@push('script-push')
<script>
  "use strict";


        var count = "{{count($ticketSettings)-1}}";

		// add more ticket option
		$(document).on('click','#add-ticket-option',function(e){
			$('#add-ticket-field').modal('show');
            e.preventDefault()
	
		})
		//delete ticket options
		$(document).on('click','.delete-option',function(e){
			$(this).closest("tr").remove()
			count--
			e.preventDefault()
		})
		$(".select2").select2({
			placeholder:"{{translate('Select Status')}}",

		})
        $(".select-time").select2({
	
			placeholder:"{{translate('Select time')}}",
		});



		$('.start-time').on('change', function(e){
			    var value = e.target.value;
				var closestTd = $(this).closest('tr').find('.endtime_td');

				var find = closestTd[0];
				var endtime = find.firstElementChild;
				if(value == '24H'){
					$(this).closest('tr').find('.endtime_td select').val('').trigger('change');
					endtime.disabled = true;
				}else{
					endtime.disabled = false;
				}

		});




		//Add-modal select option
		$(document).on('change', '#type', function(e) {
	

			var modal =  $('#add-ticket-field').hasClass('show') 
			                      ? $('#add-ticket-field') 
								  : $('#edit-ticket-field');

			var selectedValue = $(this).val();

			if (selectedValue === "select" || selectedValue === "radio" || selectedValue === "checkbox") {

				var optionRow = `<div class="mb-3 mt-3">
										<div class="row">

											<div class="col slectChoice d-none">

											</div>

											<div class="col">
												<div class="hstack gap-3 mb-3 mt-4 justify-content-end">

												<a href="javascript:void(0);" class="add-option fs-18 link-success">
																	<i class="ri-add-box-fill"></i></a>
												</div>
											</div>

										</div>


										<div class="option-field-value">
										    <div class="row">
												<div class="col-6">
													<label class="form-label" for="optionValue">
														{{ translate('Option Value') }}
														<span class="text-danger"> *</span>
													</label>

													<input type="text" id="optionValue" name="option_value[]" class="form-control"
														placeholder="Set an Option Value">

												</div>

												<div class="col-6">
													<label class="form-label" for="option">
														{{ translate('Display Name') }}
														<span class="text-danger"> *</span>
													</label>

													<input type="text" id="option" name="option[]" class="form-control"
														placeholder="Set an Option">

												</div>
											</div>
										</div>
									</div>`;

				var selectChoice = `<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" name="multiple" id="multiselect-option" value="{{App\Enums\StatusEnum::true->status()}}">
										<label class="form-check-label" for="multiselect-option">
											  {{translate('Multiple Seclect')}}
										</label>
									</div>
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" name="multiple" id="singleSelect-option" value="{{App\Enums\StatusEnum::false->status()}}">
										<label class="form-check-label" for="singleSelect-option">
										     {{translate("Single Select")}}	
										</label>
									</div>`;




		        modal.find('.option-field').removeClass('d-none');

				modal.find('.option-field').html(optionRow);


				if(selectedValue === "select"){
					modal.find('.slectChoice').removeClass('d-none');
					modal.find('.slectChoice').html(selectChoice)
				}else{
					modal.find('.slectChoice').empty();
					modal.find('.slectChoice').addClass('d-none');
				}

			} else {
				modal.find('.option-field').empty();
				modal.find('.option-field').addClass('d-none');
				modal.find('.select-type').addClass('d-none');
				modal.find('.add-option-section').addClass('d-none');
			}
		});


		var optionIndex = 0; 


		//Add more option to option field
		$(document).on('click', '.add-option', function(e) {

			optionIndex++;
		
			var optionValueId =`optionValue-${optionIndex}` ; 
			var optionId =`option-${optionIndex}` ; 

			var optionRow = `<div class="mb-3 mt-3 optionRow">
								<div class="row">

									<div class="col-6">
												<label class="form-label" for="${optionValueId}">
													{{ translate('Option Value') }}
													<span class="text-danger"> *</span>
												</label>

												<input type="text" id="${optionValueId}" name="option_value[]" class="form-control"
													placeholder="{{translate('Option Value')}}">

									</div>
									<div class="col-5">
											<label class="form-label" for="${optionId}">
												{{ translate('Display Name') }}
												<span class="text-danger"> *</span>
											</label>

											<input type="text" id='${optionId}' name="option[]" class="form-control"
												placeholder="{{translate('Option display name')}}">

									</div>
									<div class="col-1 mt-md-4">
										<div class="hstack gap-3 mt-3">
											<a href="javascript:void(0);" class="delete-option fs-18 link-danger">
											<i class="ri-delete-bin-line"></i></a>
										</div>
									</div>
								</div>
							</div>` ;


			var modal =  $('#add-ticket-field').hasClass('show') 
			                      ? $('#add-ticket-field') 
								  : $('#edit-ticket-field');

			modal.find(".option-field-value").append(optionRow)
			e.preventDefault()
		})


		//Add modal delete option field
		$(document).on('click', '.delete-option', function(e) {
			$(this).closest('.optionRow').remove()
			e.preventDefault()
		})




        //Edit modal pop-up
	    $(document).on('click', '.edit-option', function(e) {

            var name = $(this).attr('data-name');
			$('#edit-ticket-field').modal('show');

            $.ajax({
                url: "{{ route('admin.setting.ticket.input.edit') }}",
                type: 'POST',
				beforeSend: function() {
                    $('#modalContent').empty();
                    $('#modalLoader').removeClass('d-none');
                },
                data: {
                    name: name,
                    _token: '{{ csrf_token() }}'
                },
                dataType: "json",
           
                success: function(response) {
					if(response.status){
	
						$('#modalContent').html(response.edit_html);
					}else{
						$('#edit-ticket-field').modal('hide');
						toastr(response.message,'danger')
					}
 
                },
				error: function (error){
					if(error && error.responseJSON){
						if(error.responseJSON.errors){
							for (let i in error.responseJSON.errors) {
								toastr(error.responseJSON.errors[i][0],'danger')
							}
						}
						else{
							if((error.responseJSON.message)){
								toastr(error.responseJSON.message,'danger')
							}
							else{
								toastr( error.responseJSON.error,'danger')
							}
						}
					}
					else{
						toastr(error.message,'danger')
					}
                },
				complete: function() {
					$('#modalLoader').addClass('d-none');
				},

            });

        })



		//delete ticket input modal
		$(document).on('click', '.delete-ticket-item', function(e) {
			e.preventDefault();
			var modal  = $("#delete-modal");
			modal.find('#delete-href').attr("href",'javascript:void(0)')
			modal.find('#delete-href').attr("ticket-input-href",$(this).attr("data-href"))
			modal.modal("show");

		})

		// delete ticket ajax

		$(document).on('click', '#delete-href', function(e) {

			e.preventDefault();

			var submitButton = $(this);

			$.ajax({
				url: $(this).attr('ticket-input-href'),
				type: 'GET',
				dataType: "json",
				beforeSend: function() {
                    submitButton.find(".note-btn-spinner").remove();

                    submitButton.append(`<div class="ms-1 spinner-border spinner-border-sm text-white note-btn-spinner " role="status">
                            <span class="visually-hidden"></span>
                        </div>`);

					$('#cardloader').removeClass('d-none');
                },
				success: function(response) {
					if(response.status){
						if(response.cards_html){
							$('#ticketInputCards').html(response.cards_html);
						}
						toastr(response.message,'success')
					}else{
						toastr(response.message,'danger')
					}
				},
				error: function (error){
					if(error && error.responseJSON){
						if(error.responseJSON.errors){
							for (let i in error.responseJSON.errors) {
								toastr(error.responseJSON.errors[i][0],'danger')
							}
						}
						else{
							if((error.responseJSON.message)){
								toastr(error.responseJSON.message,'danger')
							}
							else{
								toastr( error.responseJSON.error,'danger')
							}
						}
					}
					else{
						toastr(error.message,'danger')
					}
				},
				complete: function() {
					submitButton.find(".note-btn-spinner").remove();
					$('#cardloader').addClass('d-none');

					$("#delete-modal").modal("hide")
				},

			});


		})


		// init drag drop
		$( "#ticketInputCards" ).sortable({


			update: function (event, ui) {
				var data = $(this).sortable('serialize');

				$.ajax({
					url: '{{route("admin.setting.ticket.input.order")}}',
					type: 'post',
					data:$('.input-card-form').serialize(),
					dataType: "json",
					beforeSend: function() {
						$('#cardloader').removeClass('d-none');
					},
					success: function(response) {
						if(response.status){
							$('#ticketInputCards').html(response.cards_html);
						}
			
					},
					error: function (error){
						if(error && error.responseJSON){
							if(error.responseJSON.errors){
								for (let i in error.responseJSON.errors) {
									toastr(error.responseJSON.errors[i][0],'danger')
								}
							}
							else{
								if((error.responseJSON.message)){
									toastr(error.responseJSON.message,'danger')
								}
								else{
									toastr( error.responseJSON.error,'danger')
								}
							}
						}
						else{
							toastr(error.message,'danger')
						}
					},
					complete: function() {
						$('#cardloader').addClass('d-none');
					},

		});
            }
		});
        $( "#ticketInputCards" ).disableSelection();



	






</script>
@endpush