@extends('admin.layouts.master')
@push('styles')

    <style>

            .loader-wrapper {
                height: 100%;
                width: 100%;
                position: fixed;
                inset: 0;
                z-index: 2000;
                background: var(--vz-body-bg);
                display: flex;
                align-items: center;
                justify-content: center;
                flex-direction: column;
                text-align: center;
            }

           .loader {
                position: relative;
                margin: 0 auto;
                width: 5em;
                height: 5em;
                border-radius: 50%;
                box-shadow: inset 0 0 0 0.8em;
                color: red;
                animation: color 6.4s infinite step-end;
                margin-bottom: 30px;
            }

            .mask {
                position: absolute;
                width: 2.5em;
                height: 5em;
                background-color: var(--vz-body-bg);
                left: 2.5em;
                transform-origin: 0em 2.5em;
                animation: spin 1.6s ease-out infinite;
            }

            .mask2 {
                    position: absolute;
                    width: 2.5em;
                    height: 5em;
                    background-color: var(--vz-body-bg);
                    left: 0em;
                    transform-origin: 2.5em 2.5em;
                    animation: spinNoDelay 1.6s infinite 0.2s;
            }

            @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            50%, 100% {
                transform: rotate(360deg);
            }
            }

            @keyframes spinNoDelay {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(353deg);
            }
            }

            @keyframes color {
            0% {
                color: #3cba54
            }

            25% {
                color: #f4c20d
            }

            50% {
                color: #db3236
            }

            75% {
                color: #4885ed
            }
            }


            .dots-container {
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }

            .dot {
                height: 10px;
                width: 10px;
                margin-right: 10px;
                border-radius: 10px;
                background-color: var(--color-primary);
                animation: pulse 1.5s infinite ease-in-out;
            }

            .dot:last-child {
               margin-right: 0;
            }

            .dot:nth-child(1) {
               animation-delay: -0.3s;
            }

            .dot:nth-child(2) {
              animation-delay: -0.1s;
            }

            .dot:nth-child(3) {
               animation-delay: 0.1s;
            }

            @keyframes pulse {
                0% {
                    transform: scale(0.8);
                    background-color: var(--color-primary);
                    box-shadow: 0 0 0 0 var(--color-primary-light);
                }

                50% {
                    transform: scale(1.1);
                    background-color: var(--color-secondary);
                    box-shadow: 0 0 0 6px var(--color-secondary-light);
                }

                100% {
                    transform: scale(0.8);
                    background-color: var(--color-primary);
                    box-shadow: 0 0 0 0 var(--color-primary-light);
                }
            }

            .warning-text{
                font-size: 24px ;
                font-weight: 600;
                margin-bottom: 0;
            }



    </style>
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
								{{translate('System Update')}}
							</li>
						</ol>
					</div>

				</div>
			</div>
		</div>


		<div class="card mt-3">
            <div class="card-header">
                <h4 class="card-title">
                     {{trans('default.system_update_title')}}
                </h4>
            </div>
            <div class="card-body">
                <ul class="update-list">
                     @php  echo trans('default.update_note') @endphp
                </ul>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h4 class="card-title">
                      {{translate("Update Application")}}
                </h4>
            </div>
            <div class="card-body">
                <form class="update-system" data-route="{{route('admin.system.update')}}"  enctype="multipart/form-data">
                    @csrf
                    <div class="row align-items-center">
                        <div class="col-lg-12">
                            <div class="d-flex align-items-center flex-md-nowrap flex-wrap gap-3 mb-4">
                                <div class="version">
                                    <span>
                                        {{translate("Current Version")}}
                                    </span>
                                    <h4>{{translate('V')}}{{site_settings("app_version",1.1)}}</h4>
                                    <p>
                                        {{get_date_time(site_settings("system_installed_at",\Carbon\Carbon::now()))}}
                                    </p>
                                </div>

                            </div>
                            <div class="mt-4 mb-4">
                                <label  for="file" class="feedback-file">
                                    <input name="updateFile" hidden accept=".zip" type="file" name="image" id="file" >
                                    <span><i class="ri-file-zip-line"></i>
                                        {{translate("Upload Zip file")}}
                                    </span>
                                </label>

                            </div>
                            <button class="btn btn-success" type="submit">
                                {{translate("Update Now")}}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>


    
	</div>

@endsection


@push('script-push')
    <script>
         "use strict";

         $(document).on('submit','.update-system',function(e){

                e.preventDefault();
                var data =   new FormData(this)
                var route = $(this).attr('data-route')
                var submitButton = $(e.originalEvent.submitter);
                $.ajax({
                    method:'post',
                    url: route,
                    dataType: 'json',
                    cache: false,
                    processData: false,
                    contentType: false,
                    data: data,
                    beforeSend: function() {
                                var counter = 1;
                                var count = 1;
                            submitButton.find(".note-btn-spinner").remove();

                            submitButton.append(`<div class="ms-1 spinner-border spinner-border-sm text-white note-btn-spinner " role="status">
                                    <span class="visually-hidden"></span>
                                </div>`);


                         $('.update-loader').removeClass('d-none');
                         $('body').css('overflow', 'hidden');

                        },
                    success: function(response){

                        var className = 'success';
                        if(!response.status){
                            className = 'danger';
                        }
                        toastr( response.message,className)
                        location.reload();

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

                        $('.update-loader').addClass('d-none');
                        submitButton.find(".note-btn-spinner").remove();
                        $('body').css('overflow', '');

                  },
                })

                });




    </script>
@endpush
