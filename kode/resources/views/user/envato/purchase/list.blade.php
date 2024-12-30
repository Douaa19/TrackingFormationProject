@extends('user.layouts.master')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">{{translate($title)}}</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('user.dashboard')}}">{{translate('Home')}}</a></li>
                        <li class="breadcrumb-item active">{{translate('Envato Purchases')}}</li>
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
                        <h5 class="card-title mb-0">{{translate($title)}}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-centered align-middle table-nowrap mb-0 text-center">
                    <thead class="text-muted table-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{translate('Product Name')}}</th>
                            <th scope="col">{{translate('Purchased At')}}</th>
                            <th scope="col">{{translate('License')}}</th>
                            <th scope="col">{{translate('Supported Until')}}</th>
                            <th scope="col">{{translate('Total purchase')}}</th>
                            <th scope="col">{{translate('Action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($productPurchases as $product)
                            @php
                               $envatoItem =    $product->latest_purchase;
                            
                            @endphp
                            <tr>
                                <td class="fw-medium">{{$loop->iteration}}</td>
								<td class="d-flex align-item-center justify-content-center">
									<img src="{{getImageUrl(getFilePaths()['department']['path']."/". $product->image ?? null , getFilePaths()['department']['size']) }}" alt="{{$product->image ?? null}}" class="avatar-xs rounded-3 me-2">
									<div>
										<h5 class="fs-13 mb-0">
                                            {{
                                                limit_words($product->name)
                                            }}
                                        </h5>
									</div>
								</td>
                                <td>{{ $envatoItem->sold_at ? getDateTime($envatoItem->sold_at) : '-' }}</td>
                                <td>{{ $envatoItem->license ?? '-' }}</td>
                                <td>{{ $envatoItem->supported_until ?? translate('Unlimited') }}</td>
                                <td>
                                    <a href="{{ route('user.envato.purchase.details', $envatoItem->envato_item_id) }}" 
                                       data-bs-toggle="tooltip" 
                                       data-bs-placement="top" 
                                       title="{{translate('View All')}}">
                                        {{ $envatoItem->quantity }}
                                    </a>
                                </td>
								<td>
									<a target="_blank" href="{{route('ticket.create', ['purchase_code' => $envatoItem->purchase_code, 'item_id' => $envatoItem->envato_item_id])}}" class="btn btn-primary btn-sm waves ripple-light">
										<i class="ri-add-line align-bottom me-1"></i>
										{{translate('Create Ticket')}}
									</a>
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
@endsection

@push('script')
<script>
    $(function () {
        $('[data-bs-toggle="tooltip"]').tooltip();
    });
</script>
@endpush