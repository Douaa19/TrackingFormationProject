@extends('admin.layouts.master')



@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">
                    {{translate('Create  Agent')}}
                </h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">
                                {{translate('Home')}}
                            </a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin.agent.index')}}">
                                {{translate('Agents')}}
                            </a></li>
                        <li class="breadcrumb-item active">
                            {{translate('Create')}}
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
                            {{translate('Create Agent')}}
                        </h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <form action="{{route('admin.agent.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-4">

                    <div class="col-lg-6">
                        <div>
                            <label for="type" class="form-label">
                                {{translate('type')}} <span class="text-danger">*</span>
                            </label>

                            <select name="type" id="type" class="form-select">
                                <option value="0">
                                    {{translate("Agent")}}
                                </option>
                                <option value="1">
                                    {{translate("Super Agent")}}
                                </option>
                                <option value="2">
                                    {{translate("Supervisor")}}
                                </option>
                            </select>

                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div>
                            <label for="Name" class="form-label">
                                {{translate('Name')}} <span class="text-danger">*</span>
                            </label>
                            <input required type="text" name="name" value="{{old('name')}}" class="form-control"
                                placeholder="{{translate("Enter your Name")}}" id="Name">
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div>
                            <label for="emailidInput" class="form-label">
                                {{translate('Email')}} <span class="text-danger">*</span>
                            </label>
                            <input required type="email" name="email" value="{{old('email')}}" class="form-control"
                                placeholder="{{translate(" example@gamil.com")}}" id="emailidInput">
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div>
                            <label for="emailidInput" class="form-label">
                                {{translate('Type')}} <span class="text-danger">*</span>
                            </label>
                            <input required type="email" name="email" value="{{old('email')}}" class="form-control"
                                placeholder="{{translate(" example@gamil.com")}}" id="emailidInput">
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div>
                            <label for="Phone" class="form-label">
                                {{translate('Phone')}} <span class="text-danger">*</span>
                            </label>
                            <input required type="text" name="phone" value="{{old('phone')}}" class="form-control"
                                placeholder="{{translate("Enter Phone Number")}}" id="Phone">
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div>
                            <label for="username" class="form-label">
                                {{translate('Username')}} <span class="text-danger">*</span>
                            </label>
                            <input required type="text" name="username" value="{{old('username')}}" class="form-control"
                                placeholder="{{translate("Enter Username")}}" id="username">
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div>
                            <label for="password" class="form-label">
                                {{translate('Password')}} <span class="text-danger">*
                                    ({{translate('Minimum 5 Character Required!!')}})</span>
                            </label>
                            <input required type="password" name="password" value="{{old('password')}}"
                                class="form-control" placeholder="*************" id="password">
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div>
                            <label for="confirmPassword" class="form-label">
                                {{translate('Confirm Password')}} <span class="text-danger">*</span>
                            </label>
                            <input required type="password" name="password_confirmation"
                                value="{{old('confirm_password')}}" class="form-control" placeholder="*************"
                                id="confirmPassword">
                        </div>
                    </div>

                    <div class="col-lg-6 agent-category ">
                        <div>
                            <label for="categories" class="form-label">
                                {{translate('Access Categories')}} <span class="text-danger">*</span>
                            </label>
                            <select multiple class="form-select select2" name="categories[]" id="categories">
                                @foreach($categories as $category)
                                                            <option value="{{$category->id}}">
                                                                {{
                                    get_translation($category->name)
                                                                            }}
                                                            </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div>
                            <label for="formFile" class="form-label">
                                {{translate('Image')}} <span class="text-danger">
                                    ({{getFilePaths()['profile']['admin']['size'] }})
                                </span>
                            </label>
                            <input data-size="{{getFilePaths()['profile']['admin']['size']}}" type="file"
                                class="preview form-control w-100" name="image" id="formFile">
                        </div>
                        <div id="image-preview-section">

                        </div>
                    </div>

                    <div class="col-12 agent-permission">
                        <div class="d-flex flex-row flex-wrap permission-wrapper">
                            <label class="form-label">
                                {{translate('Permissions')}} <span class="text-danger">*</span>
                            </label>
                            @foreach(agent_permissions() as $permission)
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" name="permissions[]" value="{{$permission}}"
                                                            type="checkbox" id="{{$loop->index}}">
                                                        <label class="form-check-label" for="{{$loop->index}}">
                                                            {{
                                ucfirst(str_replace("_", " ", $permission))
                                                                        }}
                                                        </label>
                                                    </div>
                            @endforeach

                        </div>
                    </div>


                    @if(site_settings('geo_location') == 'map_base' && site_settings('auto_ticket_assignment') == App\Enums\StatusEnum::true->status())

                        <div class="col-12">
                            <label for="address-input" class="form-label">
                                {{translate('Address')}} <span class="text-danger">*</span>
                            </label>
                            <input type="text" id="address-input" name="address" class="form-control map-input">
                            <input type="hidden" name="latitude" id="address-latitude" value="0" />
                            <input type="hidden" name="longitude" id="address-longitude" value="0" />
                        </div>

                        <div class="col-12 map-container">
                            <div class="g-map" id="address-map"></div>
                        </div>
                    @endif

                    <div class="col-12">
                        <div class="text-start">
                            <button type="submit" class="btn btn-success">
                                {{translate('Add')}}
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

    @if(site_settings('auto_ticket_assignment') == '1' && site_settings('geo_location') == 'map_base')
        <script
            src="https://maps.googleapis.com/maps/api/js?key={{site_settings('google_map_key')}}&libraries=places&callback=initialize"
            async defer></script>
        <script src="{{asset('assets/global/js/map.js')}}"></script>
    @endif
@endpush

@push('script-push')
    <script>
        "use strict";

        $(".select2").select2({
            tags: true,
            tokenSeparators: [','],
        })





        $(document).on('change', '#type', function (e) {

            if ($(this).val() == 1) {
                $('.agent-category').addClass('d-none');
                $('.agent-permission').addClass('d-none');
            } else {
                $('.agent-category').removeClass('d-none');
                $('.agent-permission').removeClass('d-none');
            }

        })

    </script>
@endpush
