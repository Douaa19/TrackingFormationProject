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
								{{request()->routeIs("admin.article.category") ? translate('Topics') : translate('Categories')}}
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
								{{ request()->routeIs("admin.article.category") ? translate('Topics List') : translate('Category List')}}
							</h5>
						</div>
					</div>

					<div class="col-sm-auto">
						<div class="d-flex flex-wrap align-items-start gap-2">
							<button type="button" class="btn btn-success add-btn waves ripple-light"
								data-bs-toggle="modal" data-bs-target="#addCategory"><i
									class="ri-add-line align-bottom me-1"></i>
									{{translate('Add New')}}
							</button>
						</div>
					</div>

				</div>
			</div>


			<form hidden id="bulkActionForm" action="{{route("admin.category.bulk")}}" method="post">
				@csrf
				 <input type="hidden" name="bulk_id" id="bulkid">
				 <input type="hidden" name="value" id="value">
				 <input type="hidden" name="type" id="type">
			</form>


			<div class="card-body border border-dashed border-end-0 border-start-0">

		
					<form action="{{route(Route::currentRouteName())}}" method="get"  class="flex-grow-1 ">

						<div class="row g-3">

							<div class="col-xxl-3 col-lg-3 order-lg-1 order-2 ">

								<div class="btn-group bulk-action d-none">
								
									<button type="submit" class="btn btn-danger w-100 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"> 
										<i class="ri-settings-4-line align-bottom">
										
									   </i>
										
									</button>

									<div class="dropdown-menu dropdownmenu-info">
									

									
											@foreach(App\Enums\StatusEnum::toArray() as $k => $v)
											
													<button type="button"  name="bulk_status" data-type ="status" value="{{$v}}" class="dropdown-item bulkActionBtn" > {{translate($k)}}</button>
												
											@endforeach

										
											<button type="button"  id="deleteModal" class="dropdown-item">
												{{translate("Delete")}}
											</button>
										
									
										
									</div>
								</div>

							</div>

					
							<div class="col-xxl-9 col-lg-9 d-flex justify-content-end gap-2 flex-sm-nowrap flex-wrap order-lg-2 order-1">

								<div class="search-box flex-lg-grow-0 flex-grow-1">
									<input type="text" name="name" value="{{request()->input("name")}}" class="form-control search" placeholder="{{translate("Search By Name")}}">
									<i class="ri-search-line search-icon"></i>
								</div>
								<div>
									<button type="submit" class="btn btn-primary w-100"> <i class="ri-equalizer-fill me-1 align-bottom"></i>
										{{translate("Filter")}}
									</button>
								</div>

								<div>
									<a href="{{route(Route::currentRouteName())}}" class="btn btn-danger w-100"> <i class="ri-refresh-line me-1 align-bottom"></i>
										{{translate("Reset")}}
									</a>
								</div>
							</div>

						</div>
						
					</form>

			</div>

	
			<div class="card-body">
				<div class="table-responsive">
					<table class="table  table align-middle table-nowrap mb-0">
						<thead class="text-muted table-light">
							<tr>
								<th scope="col">
									<div class="form-check">
										<input class="form-check-input check-all" type="checkbox"
											id="checkAll" value="option">

											<label  class="ms-2 mb-0" for="checkAll">#</label>
											
									</div>
								</th>
								<th scope="col">
									{{translate('Name')}}
								</th>

								<th scope="col">
									{{translate('Status')}}
								</th>
								<th class="text-center" scope="col">
									{{translate('Options')}}
								</th>
							</tr>
						</thead>
						<tbody>
							@forelse ($categories as $category)
								<tr>
									<td class="fw-medium">
										<div class="form-check">
											<input class="form-check-input data-checkbox" type="checkbox"
											value="{{$category->id}}" id="{{$category->id}}" name="ids[]">
												<label  class="ms-2 mb-0" for="{{$category->id}}">{{$loop->iteration}}</label>
												
										</div>
									   
									</td>
									<td>

										<div class="d-flex gap-2 align-items-center">
											<div class="flex-shrink-0">
												<img src="{{getImageUrl(getFilePaths()['category']['path']."/". $category->image) }}" alt="{{$category->image}}" class="avatar-xs rounded-circle">
											</div>
											<div class="flex-grow-1">
												{{
													get_translation($category->name)
												}}
											</div>
										</div>


									</td>

									<td>
										<div class="form-check  form-switch">
											<input id="status-{{$category->id}}" type="checkbox" class="status-update form-check-input"
												data-column="status"
												data-route="{{ route('admin.category.status.update') }}"
												data-model="Category"
												data-status="{{ $category->status == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status():App\Enums\StatusEnum::true->status()}}"
												data-id="{{$category->id}}" {{$category->status == App\Enums\StatusEnum::true->status() ? 'checked' : ''}} >
											<label class="form-check-label" for="status-{{$category->id}}"></label>
										</div>

									</td>

									<td>
										<div class="hstack gap-3 justify-content-center ">

											@if(!request()->routeIs('admin.category.index') && $category->article_display_flag == App\Enums\StatusEnum::true->status())
												<a href="{{route('admin.category.article.create',$category->id)}}"  class=" fs-18 link-success">
													<i class="ri-add-line"></i>
												</a>
												<a href="{{route('admin.category.article.show',$category->id)}}"  class=" fs-18 link-info">
													<i class="ri-eye-line"></i>
												</a>
											@endif


											@if(request()->routeIs('admin.category.index') && $category->ticket_display_flag == App\Enums\StatusEnum::true->status())

										      	<a href="{{route('admin.ticket.category',$category->id)}}" id="create" class=" fs-18 link-success">
													<i class="ri-eye-line"></i>
											   </a>

											@endif

											@php
									   		   $updateRoute = request()->routeIs('admin.category.index')? route('admin.category.edit',$category->id) : route('admin.article.category.edit',$category->id);
										    @endphp
							 

											
											<a href="{{$updateRoute}}" class=" fs-18 link-warning">
                                                <i class="ri-pencil-line"></i>
                                            </a>

                                            <a href="javascript:void(0);" data-href="{{route('admin.category.destroy',$category->id)}}" class="delete-item fs-18 link-danger">
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
				<div class="pagination d-flex justify-content-end mt-3 ">
					<nav>
							{{$categories->links()}}
					</nav>
				</div>
			</div>
		</div>
	</div>


<div class="modal fade" id="addCategory"  data-bs-keyboard="false" tabindex="-1"  aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
		<div class="modal-content">
			<div class="modal-header p-3">
				<h5 class="modal-title" id="modalTitle">
					
					 {{ request()->routeIs("admin.article.category") ? translate('Add Topics') : translate('Add Category')}}
				</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal"
					aria-label="Close" ></button>
			</div>
			<form action="{{route('admin.category.store')}}" method="post" enctype="multipart/form-data">
				@csrf
				<div class="modal-body">
					<div class="row g-3">
						<div class="col-xl-12">
							<div>
								<div class="step-arrow-nav mb-4">
									<ul class="nav nav-pills custom-nav  localize-lang" role="tablist">


										@php
										  $localeArray = $languages->pluck('code')->toArray();
                                                $appLanguage = session()->get("locale");
                                                usort($localeArray, function ($a, $b) {
                                                    $systemLocale = session()->get("locale");
                                                    $systemLocaleIndex = array_search($systemLocale, [$a, $b]);

                                                    return $systemLocaleIndex === false ? 0 : ($systemLocaleIndex === 0 ? -1 : 1);
                                                });
										@endphp

										@foreach($localeArray  as $key)

											<li class="nav-item" role="presentation">
												<button class="nav-link  nowrap
												{{$loop->index == 0 ? "active" :""}}
												" id="lang-tab-{{$key}}" data-bs-toggle="pill" data-bs-target="#lang-tab-content-{{$key}}" type="button" role="tab" aria-controls="lang-tab-content-{{$key}}" aria-selected="true">
													<img src="{{asset('assets/images/global/flags/'.strtoupper($key ).'.png') }}" alt="{{strtoupper($key ).'.png'}}" class="me-2 rounded" height="18">
													<span class="align-middle">
														{{$key}}

														@if(session()->get("locale") == strtolower($key))
														   <span class="text-danger d-inline-block nowrap fs-18" >*</span>
														@endif
													</span>
												</button>
											</li>

										@endforeach
									</ul>
								</div>
								<div class="tab-content">
									@foreach($localeArray  as $key)

										<div class="tab-pane fade  {{$loop->index == 0 ? " show active" :""}}   " id="lang-tab-content-{{$key}}" role="tabpanel" aria-labelledby="lang-tab-{{$key}}">
											<div>
												<div class="row">
													<div class="col-lg-12">
														<div class="mb-3">
															<label class="form-label" for="{{$key}}-input">
																{{translate('Name')}} ({{$key}})
																@if(session()->get("locale") == strtolower($key))
																  <span class="text-danger">*</span>
																@endif
															</label>
															@php
																$lang_code =  strtolower($key)
															@endphp

															<input id="{{$key}}-input" type="text" name="name[{{strtolower($key)}}]" class="form-control"  placeholder="{{translate("Enter Name")}}"
																value="{{old("name.$lang_code")}}"
															{{session()->get("locale") == strtolower($key) ? "required" :""}}>

														</div>
													</div>

												</div>
											</div>
										</div>
									@endforeach
								</div>

								<div class="col-lg-12">
									<div class="mb-3">
										<label class="form-label" for="image">
											 {{translate('Image')}} <span class="text-danger">
												({{getFilePaths()['category']['size']}})
											 </span>
										</label>

										<input id="image" name="image" class="form-control" type="file">

									</div>
								</div>

								<div class="col-lg-12">
									<div class="mb-3">
										<label class="form-label" for="sort_details">

											 {{translate('Sort Details')}} <span class="text-danger"> *</span>

										</label>

										 <textarea required class="form-control" placeholder="{{translate("Write sort Details Here")}} ....." name="sort_details" id="sort_details" cols="30" rows="10">{{old('sort_details')}}</textarea>

									</div>
								</div>

								@if(request()->routeIs('admin.category.index'))
								   <input type="hidden" name="ticket_display_flag" value="{{App\Enums\StatusEnum::true->status()}}" >
								@else

								   <input type="hidden" name="article_display_flag" value="{{App\Enums\StatusEnum::true->status()}}" >

								@endif

							</div>
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
@include('modal.bulk_delete_modal')



@endsection



