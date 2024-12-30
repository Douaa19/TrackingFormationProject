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
							<li class="breadcrumb-item"><a href="{{route('admin.language.index')}}">
								{{translate('Language')}}
							</a></li>
							<li class="breadcrumb-item active">
								{{translate('Translate')}}
							</li>
						</ol>
					</div>
				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-header border-bottom-dashed">
				<div class="row g-4 align-items-center">
					<div class="col-8">
						<div>
							<h5 class="card-title mb-0">
								{{translate('Translate Language')}}
							</h5>
						</div>
					</div>

					<div class="col-4">

						<form action="{{route(Route::currentRouteName(),Route::current()->parameters())}}" method="get">
							<div class="d-flex gap-2">
								<input type="search" value='{{request()->input("search")}}' placeholder="{{translate("Search Here")}}"  name="search"  class="form-control"  >

								<button type="submit" class="filter btn btn-primary btn-md"> <i class="ri-search-line me-1 align-bottom"></i>

								</button>

								<a  href="{{route(Route::currentRouteName(),Route::current()->parameters())}}" class="btn btn-danger btn-md res">
									<i class="ri-refresh-line align-bottom"></i>
								</a>
							</div>
						</form>

					</div>
				</div>
			</div>
			<div class="card-body">
				
				<div class="table-responsive">
					<table id='transaltionTable' class="table table-centered align-middle table-nowrap mb-0">
						<thead class="text-muted table-light">
							<tr>
								<th scope="col">#</th>
								<th scope="col">
									{{translate('key')}}
								</th>
								<th scope="col">
									{{translate('value')}}
								</th>
				
								<th scope="col">
									{{translate('Options')}}
								</th>
							</tr>
						</thead>
						<tbody>
							@forelse ($translations as $translate)
								<tr>
									<td class="fw-medium">
										{{$loop->iteration}}
									</td>
									<td>
										{{limit_words($translate->value,10)}}
									</td>
									<td>
										<input  id="lang-key-value-{{ $loop->iteration }}" name='translate[{{$translate->key }}]' value="{{ $translate->value }}" class="form-control w-100" type="text">
									</td>
							
									<td>
										<div class="hstack gap-3">
									
											<a href="javascript:void(0)" data-translate-id ="{{$translate->id}}" data-id ="{{$loop->iteration}}"  title="save" class="translate fs-18 link-info"><i class="ri-save-line"></i></a>
											<a href="javascript:void(0);" data-href="{{route('admin.language.destroy.key',$translate->id)}}" class="delete-item fs-18 link-danger">
												<i class="ri-delete-bin-line"></i></a>
											
										</div>
									</td>
								</tr>
							@empty
						
								@include('admin.partials.not_found')
							
							@endforelse
						</tbody>
					</table>
					<div class="pagination d-flex justify-content-end mt-3 ">
						<nav >
							
								{{ $translations->links() }}
					
						</nav>
					</div>
				</div>
			
			</div>
			
		</div>
	</div>

@include('modal.delete_modal')
@endsection

@push('script-push')
<script>
	(function($){
       	"use strict";

        //search result
        $(document).on('keyup','#search-key',function(e){

            e.preventDefault()
            var value = $(this).val().toLowerCase();
            if(value){
                $('.pagination').addClass('d-none')
            }
            else{
                $('.pagination').removeClass('d-none')
            }
            $("#transaltionTable tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        })

        // save translation
        $(document).on('click','.translate',function(e){

            e.preventDefault()
            var id  = $(this).attr('data-id')
            var tranId  = $(this).attr('data-translate-id')
            var value = $(`#lang-key-value-${id}`).val()
            var submitButton = $(this);
			const data = {
		
				"id"    :$(this).attr('data-translate-id'),
				"value" :$(`#lang-key-value-${id}`).val()
			}

			$.ajax({
				method:'post',
				url: "{{ route('admin.language.tranlateKey') }}",
				data:{
					"_token" : "{{csrf_token()}}",
					data
				},
			    dataType: 'json',
				beforeSend: function() {
                    submitButton.html(`<div class="ms-1 spinner-border spinner-border-sm  note-btn-spinner " role="status">
                            <span class="visually-hidden"></span>
                        </div>`);
                },

				success: function(response){
						if(response.success){
							toastr("{{translate('Successfully Translated')}}",'success')
						}
						else{
							toastr("{{translate('Translation Failed')}}",'danger')
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
                    submitButton.html(`<i class="ri-save-line"></i>`)
					$('#cardloader').addClass('d-none');
				},

				
	
			})





        })

	})(jQuery);
</script>
@endpush

