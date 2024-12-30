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
							<li class="breadcrumb-item"><a href="{{route('admin.sms.gateway.index')}}">
								{{translate('SMS Gateway')}}
							</a></li>
							<li class="breadcrumb-item active">
								{{translate('Update')}}
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
                                {{translate('Update Gateway')}}
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
             <div class="card-body">
				<form action="{{route('admin.sms.gateway.update', $smsGateway->id)}}" method="POST"  enctype="multipart/form-data">
                    @csrf
                    <div class="row g-4">
						@foreach($smsGateway->credential as $key => $parameter)
							<div class="col-lg-6">
								<div >
									<label for="{{$key}}" class="form-label">{{ucwords(str_replace('_', ' ', @$key))}} <span class="text-danger"> *</span></label>
									<input type="text" name="sms_method[{{@$key}}]" id="{{@$key}}" value="{{is_demo() ? "@@@":@$parameter}}" class="form-control" placeholder="{{translate('Enter Valid API Data')}}" required>
								</div>
							</div>
						@endforeach
						<div class="col-lg-6">
							<label for="status" class="form-label">{{translate('Status')}} <span class="text-danger"> *</span></label>
							<select class="form-control" name="status" id="status" required>
								<option value="{{App\Enums\StatusEnum::true->status()}}" @if($smsGateway->status == App\Enums\StatusEnum::true->status()) selected @endif>{{translate('Active')}}</option>
								<option value="{{App\Enums\StatusEnum::false->status()}}" @if($smsGateway->status == App\Enums\StatusEnum::false->status()) selected @endif>{{translate('Inactive')}}</option>
							</select>
						</div>
                        <div class="col-12">
                            <div class="text-start">
                                <button type="submit" class="btn btn-success">
                                    {{translate('Update')}}
                                </button>
                            </div>
                        </div><!--end col-->
                    </div><!--end row-->
                </form>
			 </div>

         </div>
    </div>

@endsection

