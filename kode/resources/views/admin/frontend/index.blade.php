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
								{{translate('Frontends')}}
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
								{{translate('Section List')}}
							</h5>
						</div>
					</div>

					<div class="col-sm-auto">
						<div class="d-flex flex-wrap align-items-start gap-2">

						

							<input placeholder="{{translate("Search Here")}}" class="form-control w-fit" id='search' type="search">

						</div>
					</div>


				</div>
			</div>

			<div class="card-body">
				<div class="row g-4 mb-4">
					@foreach($frontends as $frontend)
						<form class="col-lg-12 search-sections" enctype="multipart/form-data" method="post" action="{{route('admin.frontend.update',$frontend->id)}}" >
							@csrf
							<div class="border rounded">
								<div class="card-header border-bottom-solid px-3 py-2">
									<div class="d-flex align-items-center justify-content-between">
										<h5 class="mb-0 fs-14">
											{{$frontend->name}}
											@if($frontend->slug == 'social_section')

												<a target="blank" href="https://icons.getbootstrap.com/">
													<span class="ms-0 ms-sm-2 mt-sm-0 mt-2 badge badge-outline-success">
														{{translate('See Icon')}}
													</span>
												</a>
											@endif
										</h5>

										<div class="d-flex align-items-center gap-2">
											<div class="form-check form-switch">
												<input id="status-{{$frontend->id}}" type="checkbox" class=" form-check-input"
													name="status"
													value="{{ App\Enums\StatusEnum::true->status()}}" {{$frontend->status ==  App\Enums\StatusEnum::true->status() ? 'checked' : ''}} >
												<label class="form-check-label" for="status-{{$frontend->id}}"></label>
											</div>
                                            <div class="arrow-button">
                                                <i class='bx bx-chevron-down'></i>
                                            </div>
										</div>
									</div>
								</div>
								<div class="frontend-scrollbar">
                                    @php

                                      $frontendSection = json_decode($frontend->value,true ) ;

                                    @endphp

                                     @if(isset($frontendSection['dynamic_element']))

                                     <button class="add-section-btn btn btn-sm btn-info">
                                        <i class="ri-add-line"></i>
                                     </button>
                                     @endif
									<div class="row g-4">
										@foreach($frontendSection as $secton_key=> $elements)
                                             @foreach( $elements as $keys=>$section_data)
											    @foreach( $section_data as $key=> $data)

												   @if($key == 'value')
													<div class="col-md-12">
														<label  class="form-label">
															{{@translate(ucfirst(str_replace("_"," ",$keys)))}}
															@if($section_data['type'] == 'file')
																<span class="text-danger" >({{$section_data['size']}})</span>
																@else
																<span class="text-danger" > {{($keys =='position' ? "(after)" : "") }} *</span>
															@endif
														</label>
														@if($section_data['type'] == 'textarea')
														 <textarea  required class="form-control" name="frontend[{{$secton_key}}][{{ $keys}}][{{$key}}]"  cols="30" rows="10">{{$section_data['value']}}</textarea>

														@else
														 <input placeholder="{{translate('Type Here')}} ... " @if($section_data['type'] !='file') required @endif name="frontend[{{ $secton_key}}][{{ $keys}}][{{$key}}]" type="{{$section_data['type']}}" @if($section_data['type'] !='file') value="{{$section_data['value']}} @endif" class="form-control"  >
														@endif

														@if($section_data['type'] == 'file')
															<div class="mt-2 preview">

																<img src="{{getImageUrl(getFilePaths()['frontend']['path'].'/'.@$section_data['value'])}}" alt="{{@$section_data['value']}}">
															</div>
														@endif
													</div>
												   @else

												   @if($key  == 'url' || $key  == 'icon' || $key  == 'sub_title' || $key  == 'title'   )

													<div class="col-md-6">
														<label  class="form-label">
														  {{ucfirst(str_replace("_"," ",$keys))}}	({{ucfirst(str_replace("_"," ",$key))}})
																<span class="text-danger" >*</span>
														</label>

														<input required name="frontend[{{ $secton_key}}][{{ $keys}}][{{$key}}]" type="text" value="{{$section_data[$key]}}"  class="form-control"  placeholder="{{$secton_key}}">
													</div>
												   @else
													<input hidden name="frontend[{{ $secton_key}}][{{ $keys}}][{{$key}}]" type="text"   value="{{$section_data[$key]}}" class="form-control"  placeholder="{{$secton_key}}">
												   @endif

												@endif

											    @endforeach
										    @endforeach
									    @endforeach

										<div class="text-end">
											<button type="submit"
												class="btn btn-success waves ripple-light">
												{{translate('submit')}}
											</button>
										</div>
									</div>
								</div>

							</div>
						</form>
					@endforeach
				</div>
			</div>
		</div>
	</div>


@endsection


@push('script-push')
<script>
	(function($){
       	"use strict";

		$('#search').keyup(function(){

			var value = $(this).val().toLowerCase();
			$('.search-sections').each(function(){
				var lcval = $(this).text().toLowerCase();
				if(lcval != 'Promotional Offer'){
					if(lcval.indexOf(value)>-1){
						$(this).show();
					} else {
						$(this).hide();
					}
				}
			});
		});
	})(jQuery);
</script>
@endpush
