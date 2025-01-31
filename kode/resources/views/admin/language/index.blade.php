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
								{{translate('Language')}}
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
								{{translate('Language List')}}
							</h5>
						</div>
					</div>

					<div class="col-sm-auto">
						<div class="d-flex flex-wrap align-items-start gap-2">
							<button type="button" class="btn btn-success add-btn waves ripple-light"
								data-bs-toggle="modal" data-bs-target="#addLanguage"><i
									class="ri-add-line align-bottom me-1"></i>
									{{translate('Add New Language')}}
							</button>
						</div>
					</div>

				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-centered align-middle table-nowrap mb-0">
						<thead class="text-muted table-light">
							<tr>
								<th scope="col">#</th>
								<th scope="col">
									{{translate('Language')}}
								</th>
								<th scope="col">
									{{translate('Code')}}
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
							@forelse ($languages as $language)
								<tr>
									<td class="fw-medium">
									{{$loop->iteration}}
									</td>
									<td>
										<div class="d-flex align-items-center">
											<div class="flex-shrink-0 me-2">
												<img class="rounded-circle avatar-xxs" src="{{asset('assets/images/global/flags/'.strtoupper($language->code ).'.png') }}" alt="{{strtoupper($language->code ).'.png'}}"
													class="avatar-sm p-2">
											</div>
											<div class="flex-grow-1">
												{{$language->name}}

												@if($language->is_default == App\Enums\StatusEnum::true->status())

													<span class="badge badge-soft-success">
														<i class="ri-star-s-fill"></i>  {{translate('Default')}}
													</span>
												@endif

											</div>
										</div>
									</td>
									<td>
										{{$language->code}}
									</td>
									<td>
										<div class="form-check form-switch">
											<input id="status-{{$language->id}}" type="checkbox" class="status-update form-check-input"
												data-column="status"
												data-route="{{ route('admin.language.status.update') }}"
												data-model="Language"
												data-status="{{ $language->status == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status():App\Enums\StatusEnum::true->status()}}"
												data-id="{{$language->id}}" {{$language->status == App\Enums\StatusEnum::true->status() ? 'checked' : ''}} >
											<label class="form-check-label" for="status-{{$language->id}}"></label>
										</div>

									</td>
									<td>
										<div class="hstack gap-3">

											@if($language->is_default != App\Enums\StatusEnum::true->status())
												<a href="{{route('admin.language.make.default',$language->id)}}" class="pointer badge badge-soft-success">
													<i class="ri-star-s-fill"></i>  {{translate('Make Default')}}
												</a>
											@endif
											<a href="{{route('admin.language.translate',$language->code)}}" class=" fs-18 link-warning"><i
													class="ri-translate"></i></a>


											@if($language->code !='en' && $language->is_default != App\Enums\StatusEnum::true->status() && session()->get('locale') != $language->code   )
												<a href="javascript:void(0);" data-href="{{route('admin.language.destroy',$language->id)}}" class="delete-item fs-18 link-danger">
												<i class="ri-delete-bin-line"></i></a>
											@endif

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



<div class="modal fade" id="addLanguage"  data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header p-3">
				<h5 class="modal-title" id="modalTitle">{{translate('Add Language')}}
				</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal"
					aria-label="Close" ></button>
			</div>
			<form action="{{route('admin.language.store')}}" method="post">
				@csrf
				<div class="modal-body">
					<div class="row g-3">
						<div>
							<label for="langName" class="form-label">
								{{translate('Name')}}  <span  class="text-danger"> *</span>
							</label>
							<select name="name" id="langName" class="form-control select2">
								@foreach ($countryCodes as $codes)
								 <option value="{{$codes['name']}}//{{$codes['code']}}">
									{{$codes['name']}}
								 </option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="modal-footer px-0 pb-0 pt-3">
						<div class="hstack gap-2 justify-content-end">
							<button type="button"
								class="btn btn-danger waves ripple-light"
								data-bs-dismiss="modal">
								{{translate('Close
								')}}
							</button>
							<button type="submit"
								class="btn btn-success waves ripple-light"
								id="add-btn">
								{{translate('Add')}}
							</button>
						</div>
					</div>

				</div>
			</form>
		</div>
	</div>
</div>


@include('modal.delete_modal')

@endsection


@push('script-push')
<script>
	(function($){

       	"use strict";
		
		$(".select2").select2({
			placeholder:"{{translate('Select Country')}}",
			dropdownParent: $("#addLanguage"),
		})

	})(jQuery);
</script>
@endpush

