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
                        <li class="breadcrumb-item"><a href="{{route('user.envato.purchase.list')}}">{{translate('Envato Purchases')}}</a></li>
                        <li class="breadcrumb-item active">{{translate('Purchase Details')}}</li>
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
                            <th scope="col">{{translate('Action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($purchases as $product)
                            <tr>
                                <td class="fw-medium">{{$loop->iteration}}</td>
                                <td class="d-flex align-item-center justify-content-center">
                                    <img src="{{getImageUrl(getFilePaths()['department']['path']."/". $department->image ?? null , getFilePaths()['department']['size']) }}" alt="{{$department->image->image ?? null}}" class="avatar-xs rounded-3 me-2">
                                    <div>
                                        <h5 class="fs-13 mb-0">{{ limit_words($department->name) }}</h5>
                                    </div>
                                </td>
                                <td>{{ $product->sold_at ? getDateTime($product->sold_at) : translate('N/A')}}</td>
                                <td>{{ $product->license ?? translate('N/A') }}</td>
                                <td>{{ $product->supported_until ?? translate('Unlimited') }}</td>
                                <td>
                                    <a href="{{route('ticket.create', ['purchase_code' => $product->purchase_code, 'item_id' => $product->envato_item_id])}}" class="btn btn-primary btn-sm waves ripple-light">
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