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
                            <div class="mt-3">
                                <div >
                                    <label for="Name" class="form-label">
                                        {{translate('Full Name')}} <span  class="text-danger">*</span>
                                    </label>
                                    <input required type="text" name="name" value="{{$user->name}}"  class="form-control" placeholder="{{translate("Enter your Name")}}" id="Name">
                                </div>
                            </div>

                            <div class="mt-3">
                                <div >
                                    <label for="emailidInput" class="form-label">
                                        {{translate('Email')}} <span  class="text-danger"  >*</span>
                                    </label>
                                    <input required type="email" name="email" value="{{$user->email}}" class="form-control" placeholder="{{translate("example@gamil.com")}}" id="emailidInput">
                                </div>
                            </div>


                            <div class="mt-3">
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

                            <div class="mt-3">
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

                            <div class="mt-3">
                                <div>
                                    <label for="whatsappNumber" class="form-label">
                                        {{translate('WhatsApp Number')}}
                                        <span class="text-danger">
                                            *
                                        </span>
                                    </label>
                                    <input value="{{$user->whatsapp_number}}" type="text" class="form-control w-100"
                                        name="whatsapp_number" id="whatsappNumber">
                                </div>
                            </div>

                            <div class="mt-3">
                                <div>
                                    <label for="cities" class="form-label">
                                        {{translate('City')}} <span class="text-danger">*</span>
                                    </label>

                                    <select required class="form-select" name="city" id="cities">
                                    </select>
                                </div>
                            </div>

                            <div class="mt-3">
                                <div>
                                    <label for="cnss" class="form-label">
                                        {{translate('CNSS')}}
                                        <span class="text-danger">
                                            *
                                        </span>
                                    </label>
                                    <input value="{{$user->cnss}}" type="text" class=" form-control w-100"
                                        name="cnss" id="cnss">
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

                        </div>

                        <div class="col-xl-6 col-lg-6">
                            <div class="mt-3">
                                <div>
                                    <label for="companyName" class="form-label">
                                        {{translate('Company Name')}} <span  class="text-danger">*</span>
                                    </label>
                                    <input required type="text" name="garage_name" value="{{$user->garage_name}}"  class="form-control" id="companyName">
                                </div>
                            </div>

                            <div class="mt-3">
                                <div>
                                    <label for="Revenue" class="form-label">
                                        {{translate('Garage Revenue')}} <span  class="text-danger">*</span>
                                    </label>
                                    <input required type="text" name="revenue" value="{{$user->revenue ? $user->revenue : 0}}"  class="form-control" id="Revenue">
                                </div>
                            </div>

                            {{-- <div class="mt-3">
                                <div>
                                    <label for="traning_type" class="form-label capitalize">
                                        {{translate('Training Type')}} <span class="text-danger">*</span>
                                    </label>

                                    <select required class="form-select" name="traning_type" id="traning_type">
                                        <option value="direct_training_(CSF)" {{ $user->training_type == 'direct_training_(CSF)' ? 'selected' : '' }}>
                                            {{ translate('Direct Training') }} (CSF)
                                        </option>
                                        <option value="engineering_training_(GIAC+CSF)" {{ $user->training_type == 'engineering_training_(GIAC+CSF)' ? 'selected' : '' }}>
                                            {{ translate('Engineering + Training') }} (GIAC + CSF)
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="mt-3">
                                <div>
                                    <label for="tranings" class="form-label capitalize">
                                        {{translate('Trainings')}} <span class="text-danger">*</span>
                                    </label>

                                    <select required class="form-select" name="traning" id="tranings">
                                        <option value="ebva_training" {{ $user->training == 'ebva_training' ? 'selected' : '' }}>
                                            {{ translate('EBVA Training') }}
                                        </option>
                                        <option value="diagnosis_training" {{ $user->training == 'diagnosis_training' ? 'selected' : '' }}>
                                            {{ translate('Diagnosis Training') }}
                                        </option>
                                        <option value="towing_training" {{ $user->training == 'towing_training' ? 'selected' : '' }}>
                                            {{ translate('Towing Training') }}
                                        </option>
                                        <option value="adas_training" {{ $user->training == 'adas_training' ? 'selected' : '' }}>
                                            {{ translate('ADAS Training') }}
                                        </option>
                                        <option value="preparation_for_the_electrical_activation_of_ev_charging_infrastructures" {{ $user->training == 'preparation_for_the_electrical_activation_of_ev_charging_infrastructures' ? 'selected' : '' }}>
                                            {{ translate('Preparation for the electrical activation of EV charging infrastructures') }}
                                        </option>
                                        <option value="preparation_for_VE/VH_electrical_clearance" {{ $user->training == 'preparation_for_VE/VH_electrical_clearance' ? 'selected' : '' }}>
                                            {{ translate('Preparation for VE/VH Electrical Clearance') }}
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="mt-3">
                                <label for="status" class="form-label">
                                    {{ translate('Status') }} <span class="text-danger">*</span>
                                </label>

                                <select required class="form-select" name="status" id="status">
                                    <!-- Options will be populated dynamically -->
                                </select>
                            </div> --}}
                        </div>

                    </div>

                    <div class="col-12">
                        <div class="text-start">
                            <button type="submit" class="btn btn-success">
                                {{translate('Submit')}}
                            </button>
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

{{-- <script>
    const translations = {
        'direct_training_(CSF)': [
            { value: 'confirmation', text: @json(__('Confirmation')) },
            { value: 'qualification_phase', text: @json(__('Qualification Phase')) },
            { value: 'administrative_preliminary_phase', text: @json(__('Administrative Preliminary Phase')) },
            { value: 'validation_phase', text: @json(__('Validation Phase')) },
            { value: 'construction_phase', text: @json(__('Construction Phase')) },
            { value: 'repayment_phase', text: @json(__('Repayment Phase')) }
        ],
        'engineering_training_(GIAC+CSF)': [
            { value: 'confirmation', text: @json(__('Confirmation')) },
            { value: 'qualification_phase', text: @json(__('Qualification Phase')) },
            { value: 'engineering_phase_(GIAC)', text: @json(__('Engineering Phase (GIAC)')) },
            { value: 'phase_(CSF)', text: @json(__('Phase (CSF)')) },
            { value: 'construction_phase', text: @json(__('Construction Phase')) },
            { value: 'repayment_phase', text: @json(__('Repayment Phase')) }
        ]
    };
</script> --}}

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectElement = document.getElementById('cities');
        const userCity = @json($user->city);

        // Fetch the cities JSON
        fetch('/TrackingFormationProject/kode/assets/json/cities.json')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(cities => {

                selectElement.innerHTML = '';

                const defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.textContent = '{{ translate("Select City") }}';
                defaultOption.disabled = true;
                selectElement.appendChild(defaultOption);

                cities.forEach(city => {
                    const option = document.createElement('option');
                    option.value = city.ville;
                    option.textContent = city.ville;
                    if(city.ville === userCity) {
                        option.selected = true;
                    }

                    selectElement.appendChild(option);
                });
            })
            .catch(error => console.error('Error loading cities:', error));

            // Define the options for each training type
            // const statusSelect = document.getElementById('status');
            // const userTrainingType = @json($user->training_type);
            // const userStatus = @json($user->status);

            // if (translations[userTrainingType]) {
            //     translations[userTrainingType].forEach(optionData => {
            //         const option = document.createElement('option');
            //         option.value = optionData.value;
            //         option.textContent = optionData.text;

            //         if (optionData.value === userStatus) {
            //             option.selected = true;
            //         }

            //         statusSelect.appendChild(option);
            //     });
            // } else {
            //     const defaultOption = document.createElement('option');
            //     defaultOption.value = '';
            //     defaultOption.textContent = '{{ translate("Select a status") }}';
            //     defaultOption.disabled = true;
            //     defaultOption.selected = true;
            //     statusSelect.appendChild(defaultOption);
            // }
    });
</script>
