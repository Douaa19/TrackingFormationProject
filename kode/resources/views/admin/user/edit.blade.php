@extends('admin.layouts.master')
@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">
                        {{translate('Update  User')}}
                    </h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">
                                {{translate('Home')}}
                            </a></li>
                            <li class="breadcrumb-item"><a href="{{route('admin.user.index')}}">
                                {{translate('Users')}}
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
                                {{translate('Update User')}}
                            </h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <form action="{{route('admin.user.update')}}" method="POST"  enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{$user->id}}">
                    <div class="row g-3 pb-3">
                        <div class="col-xl-6 col-lg-6">
                            <div >
                                <label for="Name" class="form-label">
                                    {{translate('Name')}} <span  class="text-danger">*</span>
                                </label>
                                <input required type="text" name="name" value="{{$user->name}}"  class="form-control" placeholder="{{translate("Enter your Name")}}" id="Name">
                            </div>
                        </div>


                        <div class="col-xl-6 col-lg-6">
                            <div >
                                <label for="emailidInput" class="form-label">
                                    {{translate('Email')}} <span  class="text-danger"  >*</span>
                                </label>
                                <input required type="email" name="email" value="{{$user->email}}" class="form-control" placeholder="{{translate("example@gamil.com")}}" id="emailidInput">
                            </div>
                        </div>


                        <div class="col-xl-6 col-lg-6">
                            <div>
                                <label for="formFile" class="form-label">
                                    {{translate('Image')}}  <span class="text-danger">
                                        ({{getFilePaths()['profile']['user']['size'] }})
                                    </span>
                                </label>
                                <input id="formFile" data-size ="{{getFilePaths()['profile']['user']['size']}}" type="file" class="preview form-control w-100"
                                    name="image">
                            </div>

                        </div>
                        <div class="col-xl-6 col-lg-6">
                            <div>
                                <label for="phone" class="form-label">
                                    {{translate('Phone')}}
                                    <span class="text-danger">
                                        *
                                    </span>
                                </label>
                                <input value="{{$user->phone}}" type="text" class=" form-control w-100"
                                    name="phone" id="phone">
                            </div>

                        </div>

                        @if(site_settings('geo_location') == 'map_base' && site_settings('auto_ticket_assignment')  == App\Enums\StatusEnum::true->status())
                        <div class="col-xl-12 col-lg-12">
                            <label for="address-input" class="form-label">
                                    {{translate('Address')}} <span class="text-danger" >*</span>
                            </label>

                            @php
                              $address = json_decode($user->address,true);
                              $address_val = '';
                              $latitude = $user->latitude;
                              $longitude = $user->longitude;
                              if(isset($address['address'])){
                                $address_val = $address['address'];
                              }
                            @endphp

                            <input type="text" id="address-input" name="address" value="{{ $address_val}}" class="form-control map-input">
                            <input type="hidden" name="latitude" id="address-latitude" value="{{$latitude }}" />
                            <input type="hidden" name="longitude" id="address-longitude" value="{{ $longitude}}" />
                        </div>

                        <div  class="col-12 map-container" >
                            <div class="g-map" id="address-map"></div>
                        </div>
                      @endif

                        <div class="col-12">
                            <div class="text-start">
                                <button type="submit" class="btn btn-success">
                                    {{translate('Submit')}}
                                </button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection


@push('script-include')

    <script src="{{asset('assets/global/js/select2.min.js')}}"></script>

    @if(site_settings('auto_ticket_assignment')  == '1' &&  site_settings('geo_location') == 'map_base')
        <script src="https://maps.googleapis.com/maps/api/js?key={{site_settings('google_map_key')}}&libraries=places&callback=initialize" async defer></script>
        <script src="{{asset('assets/global/js/map.js')}}"></script>
    @endif
@endpush
