@extends('admin.layouts.master')
@push('styles')

  <link rel="stylesheet" href="{{asset('assets/global/css/dataTables.bootstrap5.min.css') }}">
  <link rel="stylesheet" href="{{asset('assets/global/css/responsive.bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{asset('assets/global/css/buttons.dataTables.min.css') }}">
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
								{{translate('Incoming Email Gateways')}}
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
                                {{ @$gateway ?  translate('Update Gateway') :  translate('Create Gateway')    }}
                            </h5>
                        </div>
                    </div>
                    
                    @if(@$gateway)
                        <div class="col-sm-auto">
                            <div class="d-flex flex-wrap align-items-start gap-2">
                                <a href="{{route('admin.mail.incoming')}}" class="btn btn-success add-btn waves ripple-light"
                                ><i class="ri-add-line align-bottom me-1"></i>
                                        {{translate('Add New ')}}
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card-body">
                <form action="{{route('admin.mail.incoming.store',@$gateway->id)}}" method="POST"  enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3 pb-3">

                        <div class="col-xl-6 col-lg-6">
                            <div>
                                <label for="Name" class="form-label">
                                    {{translate('Name')}} <span  class="text-danger">*</span>
                                </label>
                                <input required type="text" name="name" value="{{ @$gateway->name }}"  class="form-control" placeholder="{{translate("Enter your Name")}}" id="Name">
                                <span class="text-danger">{{translate("Must be unique")}}</span>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6">
                            <div >
                                <label for="product" class="form-label">
                                    {{translate('Product')}} 
                                </label>

                                <select name="department_id" id="product" class="form-select">
                                     <option value="">
                                        {{
                                            translate("Seletct product")
                                        }}
                                     </option>

                                     @foreach ($departments as  $department)
                                        <option  {{ @$gateway && @$gateway->department_id == $department->id ? "selected" : ""  }}   value="{{$department->id}}">
                                              {{ $department->name }}
                                         </option>
                                     @endforeach
                                </select>
     
                            </div>
                        </div>

                        @php
                          
                          $credentialKeys  =    [
                                    'host' ,
                                    'port',
                                    'encryption' ,
                                    'username' ,
                                    'password' ,
                                    'protocol'
                             ]; 
                                        
                        @endphp

                        @foreach ( $credentialKeys as  $credentialKey)

                              <div class="col-6">
                                    <div>
                                        <label for="{{$credentialKey}}" class="form-label">
                                            {{ucfirst($credentialKey)}} <span  class="text-danger">*</span>
                                        </label>
                                        <input required type="text" name="credentials[{{$credentialKey}}]" value="{{@$gateway->credentials->{$credentialKey} }}"  class="form-control" placeholder="@@@@" id="{{$credentialKey}}">
                                  
                                    </div>
                              </div>
                            
                        @endforeach



                        <div class="col-lg-12 ">

                            <div class="border p-3">
                              

                               @php
                                   $emailKeywords = @$gateway->match_keywords ?? [];



                               @endphp
                       
       
                                   <div>
                                       <label class="form-label" > 
                                           {{translate("Convert incoming email to ticket if email body or subject contains  any of the specified keywords")}}
                                       </label>
                                   </div>
                                   <div>
                                       <select required name="match_keywords[]" multiple class="select2" required>

                                           @if($emailKeywords && @$gateway)

                                              @foreach ($emailKeywords as  $keyword)
                                                 <option selected value="{{ $keyword}}">
                                                      {{ $keyword }}
                                                </option>
                                                  
                                              @endforeach
                                           @endif
                             

                            
                                       </select>
                                       <span class="text-danger d-inline-block mt-1">
                                           {{translate('Comma separated')}}
                                       </span>
                                     
                                   </div>
                          
                            </div>
                           
                       </div>



                        <div class="col-12">
                            <div class="text-start">
                                <button type="submit" class="btn btn-success">
                                    {{  @$gateway ?  translate('Update') : translate('Add')}}
                                </button>

                            </div>
                        </div>

                    </div>


                </form>
            </div>
        </div>

		<div class="card">
			<div class="card-header border-bottom-dashed">
				<div class="row g-4 align-items-center">
					<div class="col-sm">
						<div>
							<h5 class="card-title mb-0">
								{{translate('Gateways')}}
							</h5>
						</div>
					</div>

				

				</div>
			</div>
			<div class="card-body">

				<div class="table-responsive">
					<table id="datatable" class="w-100 table table-bordered dt-responsive nowrap table-striped align-middle">
						<thead class="text-muted table-light">
							<tr>
								<th scope="col">#</th>

                                <th scope="col">
									{{translate('Name')}}
								</th>

            
								<th scope="col">
									{{translate('Product')}}
								</th>


                                <th scope="col">
									{{translate('Status')}}
								</th>


								<th scope="col">
									{{translate('Options')}}
								</th>
							</tr>
						</thead>
						<tbody>
							@forelse ($gateways as $gateway)

								<tr>
									<td class="fw-medium">
									   {{$loop->iteration}}
									</td>

                                    <td class="fw-medium">
										  {{$gateway->name}}
                                    </td>
                                    <td class="fw-medium">
										  {{$gateway->product ? $gateway->product->name : "N/A"}}
                                    </td>
									 

									<td >
										<div class="form-check  form-switch">
											<input id="status-{{$gateway->id}}" type="checkbox" class="status-update form-check-input"
												data-column="status"
												data-route="{{ route('admin.mail.incoming.status.update') }}"
												data-model="IncommingMailGateway"
												data-status="{{ $gateway->status == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status():App\Enums\StatusEnum::true->status()}}"
												data-id="{{$gateway->id}}" {{$gateway->status == App\Enums\StatusEnum::true->status() ? 'checked' : ''}} >
											<label class="form-check-label" for="status-{{$gateway->id}}"></label>
										</div>
									</td>



									<td>
										<div class="hstack gap-3 ">

											<a href="{{route('admin.mail.incoming.edit',$gateway->id)}}"  class=" fs-18 link-warning add-btn waves ripple-light"> <i class="ri-pencil-line"></i>
                                            </a>


									
                                            <a href="javascript:void(0);" data-href="{{route('admin.mail.incoming.destroy',$gateway->id)}}" class="delete-item fs-18 link-danger">
                                            <i class="ri-delete-bin-line"></i></a>

										
										</div>
									</td>
								</tr>
							@empty

							   @include('admin.partials.not_found')

							@endforelse
						</tbody>
					</table>
				</div>

			</div>
		</div>
	</div>

@include('modal.delete_modal')

@endsection

@push('script-include')
	<script src="{{asset('assets/global/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{asset('assets/global/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{asset('assets/global/js/dataTables.responsive.min.js') }}"></script>
@endpush


@push('script-push')
<script>
	(function($){
       	"use strict";
        document.addEventListener("DOMContentLoaded", function () {
            new DataTable("#datatable", {
                fixedHeader: !0
            })
        })

        $(".select2").select2({

            tags: true,
            tokenSeparators: [',']
		})

	})(jQuery);
</script>
@endpush




