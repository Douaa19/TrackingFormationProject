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
								{{translate('Articles')}}
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
								@if(request()->routeIs('admin.category.article.show'))
							     	{{@get_translation($category->name)}} -
								@endif
								{{translate('Article List')}}
							</h5>
						</div>
					</div>

					<div class="col-sm-auto">

						@php

						   $route = route('admin.article.create');
						   if(request()->route('id')){
							 $route = route('admin.category.article.create',request()->route('id'));
						   }
						@endphp

						<div class="d-flex flex-wrap align-items-start gap-2">
							<a href="{{$route }}" class="btn btn-success add-btn waves ripple-light"><i
									class="ri-add-line align-bottom me-1"></i>
									{{translate('Add New Article')}}
					     	</a>
						</div>
					</div>

				</div>
			</div>




			<form hidden id="bulkActionForm" action="{{route("admin.article.bulk")}}" method="post">
				@csrf
				 <input type="hidden" name="bulk_id" id="bulkid">
				 <input type="hidden" name="value" id="value">
				 <input type="hidden" name="type" id="type">
			</form>

			@php
			    $routeName = route('admin.article.list');
			@endphp


			<div class="card-body border border-dashed border-end-0 border-start-0">

					<form action="{{$routeName}}" method="get"  class="flex-grow-1 ">

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

										</ul>

									</div>
								</div>

							</div>


							<div class="col-xxl-9 col-lg-9 d-flex justify-content-end gap-2 flex-sm-nowrap flex-wrap order-lg-2 order-1">

								<div class="search-box flex-lg-grow-1 flex-grow-1">
									<input type="text" name="search_value" value="{{request()->input("search_value")}}" class="form-control search" placeholder="{{translate("Search By Title , Items or Category")}}">
									<i class="ri-search-line search-icon"></i>
								</div>

								<div>
									<button type="submit" class="btn btn-primary w-100"> <i class="ri-equalizer-fill me-1 align-bottom"></i>
										{{translate("Filter")}}
									</button>
								</div>

								<div>
									<a href="{{$routeName}}" class="btn btn-danger w-100"> <i class="ri-refresh-line me-1 align-bottom"></i>
										{{translate("Reset")}}
									</a>
								</div>
							</div>


						</div>

					</form>


			</div>

			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-centered align-middle table-nowrap mb-0 text-center">
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
									{{translate('Title')}}
								</th>

								<th scope="col">
									{{(translate('Category'))}}
								</th>


								@if(!request()->routeIs('admin.category.article.show'))
									<th scope="col">
										{{translate('Item')}}
									</th>
								@endif


								<th scope="col">
									{{translate('Status')}}
								</th>
								<th scope="col">
									{{translate('Options')}}
								</th>
							</tr>
						</thead>
						<tbody>
							@forelse ($articles as $article)
								<tr>
									<td class="fw-medium">
										<div class="form-check">
											<input class="form-check-input data-checkbox" id="{{$article->id}}" type="checkbox"
											value="{{$article->id}}" name="ids[]">
												<label  class="ms-2 mb-0" for="{{$article->id}}">{{$loop->iteration}}</label>

										</div>
									</td>
									<td>
									    {{
											$article->name
										}}

									</td>

									<td>
									    {{
										   @$article->category->name
										}}

									</td>
									@if(!request()->routeIs('admin.category.article.show'))
										<td>
											{{
												@get_translation($article->items->name)
											}}

										</td>
									@endif

									<td>
										<div class="form-check text-center form-switch">
											<input id="status-{{$article->id}}" type="checkbox" class="status-update form-check-input"
												data-column="status"
												data-route="{{ route('admin.article.status.update') }}"

												data-status="{{ $article->status == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status():App\Enums\StatusEnum::true->status()}}"
												data-id="{{$article->id}}" {{$article->status == App\Enums\StatusEnum::true->status() ? 'checked' : ''}}>
											<label class="form-check-label" for="status-{{$article->id}}"></label>
										</div>
									</td>

									<td>
										<div class="hstack gap-3 justify-content-center">

											<a href="{{route('admin.article.edit',$article->id)}}"  class=" fs-18 link-warning">
                                                <i class="ri-pencil-line"></i>
                                            </a>

                                            <a href="javascript:void(0);" data-href="{{route('admin.article.destroy',$article->id)}}" class="delete-item fs-18 link-danger">
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
					<nav >

							{{$articles->links()}}

					</nav>
				</div>
			</div>
		</div>
	</div>

@include('modal.delete_modal')
@include('modal.bulk_delete_modal')

@endsection





