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
							<li class="breadcrumb-item"><a href="{{route('admin.mail.templates.index')}}">
								{{translate('Email Template')}}
							</a></li>
							<li class="breadcrumb-item active">
								{{translate('Update')}}
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
										{{translate('Update Template')}}
									</h5>
								</div>
							</div>
						</div>
					</div>
					<div class="card-body">
					<form action="{{route('admin.mail.templates.update', $emailTemplate->id)}}" method="POST"  enctype="multipart/form-data">
						@csrf
						<div class="row g-3">
							<div class="col-lg-6">
								<label for="subject" class="form-label">{{translate('Subject')}}<span class="text-danger"> *</span></label>
								<input type="text" id="subject" name="subject" class="form-control" value="{{$emailTemplate->subject}}" placeholder="{{translate('Enter Subject')}}" required>
							</div>

							<div class="col-lg-6">
								<label for="status" class="form-label">{{translate('Status')}} <span class="text-danger"> *</span></label>
								<select class="form-select" name="status" id="status" required>
									<option value="1" @if($emailTemplate->status == App\Enums\StatusEnum::true->status()) selected @endif>{{translate('Active')}}</option>
									<option value="0" @if($emailTemplate->status == App\Enums\StatusEnum::false->status()) selected @endif>{{translate('Inactive')}}</option>
								</select>
							</div>

							<div class="col-12">
								<label for="text-editor" class="form-label">{{translate('Description')}}<span class="text-danger"> *</span></label>
			
									<div class="text-editor-area">
               
										<textarea class="form-control summernote " name="body" rows="5" id="text-editor" required>
											@php echo $emailTemplate->body @endphp </textarea>		
										@if(site_settings("open_ai")  ==  App\Enums\StatusEnum::true->status())
		
											<button type="button" class="ai-generator-btn mt-3 ai-modal-btn " >
												<span class="ai-icon btn-success waves ripple-light">
														<span class="spinner-border d-none" aria-hidden="true"></span>
				
														<i class="ri-robot-line"></i>
												</span>
				
												<span class="ai-text">
													{{translate('Generate With AI')}}
												</span>
											</button>
				
										@endif
									</div>
							</div>
						</div>

						<div class="text-start mt-3">
							<button type="submit" class="btn btn-success">
								{{translate('Update')}}
							</button>

						
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
										{{translate('Email Template Short Code')}}
									</h5>
								</div>
							</div>

						</div>
					</div>
					 <div class="card-body">
						@foreach($emailTemplate->codes as $key => $value)
							<div class="d-flex align-items-center justify-content-between ">
								<div class="me-2">
									<h6 class="mb-0">{{$value}}</h6>
								</div>
								<p class="mb-0">@php echo "{{". $key ."}}"  @endphp</p>
							</div>
						@endforeach
					 </div>
				</div>
			</div>
		</div>

	</div>


@endsection

@push('script-include')
	<script src="{{asset('assets/global/js/summernote.min.js')}}"></script>
	<script src="{{asset('assets/global/js/editor.init.js')}}"></script>
@endpush
