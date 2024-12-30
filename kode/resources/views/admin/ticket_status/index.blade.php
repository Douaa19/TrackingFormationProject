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
								{{translate('Ticket Status List')}}
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
								{{translate('Ticket Status List')}}
							</h5>
						</div>
					</div>

					<div class="col-sm-auto">
						<div class="d-flex flex-wrap align-items-start gap-2">
							<a href="{{route('admin.ticket-status.create')}}" class="btn btn-success add-btn waves ripple-light"><i
									class="ri-add-line align-bottom me-1"></i>
								{{translate('Add New')}}
                            </a>
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
									{{translate('Status')}}
								</th>


								<th scope="col">
									{{translate('Default')}}
								</th>

			
								<th scope="col">
									{{translate('Options')}}
								</th>
							</tr>
						</thead>
						<tbody>
							@forelse ($ticket_statuses as $ticketStatus)

								<tr>
									<td class="fw-medium">
									   {{$loop->iteration}}
									</td>

                                    <td class="fw-medium">
										 @php echo ticket_status($ticketStatus->name,$ticketStatus->color_code) @endphp
                                    </td>
									 

									<td >
										<div class="form-check  form-switch">
											<input id="status-{{$ticketStatus->id}}" type="checkbox" class="status-update form-check-input"
												data-column="status"
												data-route="{{ route('admin.ticket-status.status.update') }}"
												data-model="TicketStatus"
												data-status="{{ $ticketStatus->status == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status():App\Enums\StatusEnum::true->status()}}"
												data-id="{{$ticketStatus->id}}" {{$ticketStatus->status == App\Enums\StatusEnum::true->status() ? 'checked' : ''}} >
											<label class="form-check-label" for="status-{{$ticketStatus->id}}"></label>
										</div>
									</td>


									<td>
										<div class="form-check  form-switch">
											<input id="status-{{$ticketStatus->id}}" type="checkbox" class="status-update form-check-input"
												data-column="default"
												data-route="{{ route('admin.ticket-status.set.default') }}"
												data-model="TicketStatus"
												data-status="{{ $ticketStatus->default == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status():App\Enums\StatusEnum::true->status()}}"
												data-id="{{$ticketStatus->id}}" {{$ticketStatus->default == App\Enums\StatusEnum::true->status() ? 'checked' : ''}} >
											<label class="form-check-label" for="status-{{$ticketStatus->id}}"></label>
										</div>
									</td>

									<td>
										<div class="hstack gap-3 ">

											<a href="{{route('admin.ticket-status.edit',$ticketStatus->id)}}"  class=" fs-18 link-warning add-btn waves ripple-light"> <i class="ri-pencil-line"></i>
                                            </a>


											@if(!in_array($ticketStatus->id , array_values(App\Enums\TicketStatus::toArray())))

                                            <a href="javascript:void(0);" data-href="{{route('admin.ticket-status.destroy',$ticketStatus->id)}}" class="delete-item fs-18 link-danger">
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

	})(jQuery);
</script>
@endpush




