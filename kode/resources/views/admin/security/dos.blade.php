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
								{{translate('Dos Security Settings')}}
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
								{{translate('Security Settings')}}
							</h5>
						</div>
					</div>
				</div>
			</div>


			<div class="card-body">

                <form action="{{route('admin.security.dos.update')}}" method="post">
                    @csrf
                
                    <div class="col-12">
                        <li class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-2 ps-0 ">
                            <div>
                                <p class="fw-bold mb-0">{{translate('Prevent Dos Attack')}}</p>
                            
                            </div>
    
                            <div class="form-group">
                                <div class="form-check form-switch form-switch-md" dir="ltr">
                                    <input
                                        {{ site_settings('dos_prevent') == App\Enums\StatusEnum::true->status() ? 'checked' : '' }}
                                        type="checkbox" class="form-check-input status-update"
                                        data-key='dos_prevent'
                                        data-status='{{ site_settings('dos_prevent') == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status() }}'
                                        data-route="{{ route('admin.setting.status.update') }}"
                                        id="dos_prevent">
                                    <label class="form-check-label" for="dos_prevent"></label>
                                </div>
                            </div>
                       </li>
                    </div>

                    <div class="col-lg-12">
                    
                        <div class="d-flex align-items-center flex-wrap d-dos-input">

                            <div class="form-inner d-flex align-items-center gap-2 me-4">
                                <label class="form-label" > 
                                    {{translate("If there are more than")}}
                                </label>
                                <input class="form-control" value='{{site_settings("dos_attempts")}}'  required type="number" name="site_settings[dos_attempts]" >
                            </div>
                            <div class="form-inner d-flex align-items-center gap-2">
                                <label class="w-nowrap" > 
                                    {{translate("attempts in")}}
                                </label>

                                <input class="form-control" value='{{site_settings("dos_attempts_in_second")}}'  required type="number" name="site_settings[dos_attempts_in_second]" >

                                <label class="w-nowrap"> 
                                    {{translate("second")}}
                                </label>
                            </div>
                        </div>

                        <div class="form-inner d-flex mb-3">
                            <div class="me-3">
                                <input class="form-check-input" {{site_settings("dos_security") == "captcha" ? "checked" :"" }} type="radio" name="site_settings[dos_security]" id="captcha" value="captcha">
                                <label class="form-check-label" for="captcha">
                                    {{translate('Show Captcha')}}
                                </label>
                            </div>
                            <div>
                                <input class="form-check-input" type="radio" {{site_settings("dos_security") == "block_ip" ?  "checked" :"" }} name="site_settings[dos_security]" id="blokedIp" value="block_ip">
                                <label class="form-check-label" for="blokedIp">
                                    {{translate('Block Ip')}}
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="text-start">
                            <button type="submit" class="btn btn-success">
                                {{translate('Update')}}
                            </button>
                        </div>
                    </div>

                </form>
                    
			</div>
		</div>
	</div>









@endsection





