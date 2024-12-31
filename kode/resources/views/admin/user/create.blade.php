@extends('admin.layouts.master')
@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">
                        {{translate('Create  User')}}
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
                                {{translate('Create User')}}
                            </h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <form action="{{route('admin.user.store')}}" method="POST"  enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3 pb-3">
                        <div class="col-xl-6 col-lg-6">
                            <div >
                                <label for="Name" class="form-label">
                                    {{translate('Name')}} <span  class="text-danger">*</span>
                                </label>
                                <input required type="text" name="name" value="{{old('name')}}"  class="form-control" placeholder="{{translate("Enter your Name")}}" id="Name">
                            </div>
                        </div>



                        <div class="col-xl-6 col-lg-6">
                            <div >
                                <label for="emailidInput" class="form-label">
                                    {{translate('Email')}} <span  class="text-danger"  >*</span>
                                </label>
                                <input required type="email" name="email" value="{{old('email')}}" class="form-control" placeholder="{{translate("example@gamil.com")}}" id="emailidInput">
                            </div>
                        </div>

                        <div class="col-xl-6 col-lg-6">
                            <div >
                                <label for="password" class="form-label">
                                    {{translate('Password')}} <span  class="text-danger">* ({{translate('Minimum 5 Character Required!!')}})</span>
                                </label>
                                <input required type="password" name="password" value="{{old('password')}}" class="form-control" placeholder="*************" id="password">
                            </div>
                        </div>

                        <div class="col-xl-6 col-lg-6">
                            <div >
                                <label for="confirmPassword" class="form-label">
                                    {{translate('Confirm Password')}} <span  class="text-danger"  >*</span>
                                </label>
                                <input required type="password" name="password_confirmation" value="{{old('confirm_password')}}" class="form-control" placeholder="*************" id="confirmPassword">
                            </div>
                        </div>


                        <div class="col-xl-6 col-lg-6">
                            <div >
                                <label for="phone" class="form-label">
                                    {{translate('Phone')}} <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="phone" value="{{old('phone')}}" class="form-control" placeholder="{{translate("Enter Phone Number")}}" id="phone">
                            </div>
                        </div>
                        
                        <div class="col-xl-6 col-lg-6">
                            <div >
                                <label for="whatsappNumber" class="form-label">
                                    {{translate('WhatsApp Number')}} <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="whatsapp_number" value="{{old('whatsapp_number')}}" class="form-control" placeholder="{{translate("Enter WhatsApp Number")}}" id="whatsappNumber">
                            </div>
                        </div>

                        <div class="col-xl-6 col-lg-6">
                            <div >
                                <label for="cnss" class="form-label">
                                    {{translate('CNSS')}} <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="cnss" value="{{old('cnss')}}" class="form-control" placeholder="{{translate("Enter CNSS Number")}}" id="cnss">
                            </div>
                        </div>

                        <div class="col-xl-6 col-lg-6">
                            <div >
                                <label for="tranings" class="form-label capitalize">
                                    {{translate('training')}} <span class="text-danger">*</span>
                                </label>

                                <select required class="form-select" name="traning" id="tranings">
                                    <option {{old('status') == 'direct_training' ? 'selected' :''}} value="1">{{translate('Direct Training')}} (CSF)</option>
                                    <option {{old('status') == 'engineering_training' ? 'selected' :''}}  value="0">{{translate('Engineering + Training')}} (GIAC + CSF)</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-xl-6 col-lg-6">
                            <div >
                                <label for="cities" class="form-label">
                                    {{translate('City')}} <span class="text-danger">*</span>
                                </label>

                                <select required class="form-select" name="city" id="cities">
                                </select>
                            </div>
                        </div>

                        <div class="col-xl-6 col-lg-6">
                            <div >
                                <label for="garageName" class="form-label">
                                    {{translate('Garage Name')}} <span  class="text-danger">*</span>
                                </label>
                                <input required type="text" name="garage_name" value="{{old('garage_name')}}"  class="form-control" placeholder="{{translate("Enter your Garage Name")}}" id="garageName">
                            </div>
                        </div>
                        
                        <div class="col-xl-6 col-lg-6">
                            <div >
                                <label for="revenue" class="form-label">
                                    {{translate('Garage Revenue')}} <span  class="text-danger">*</span>
                                </label>
                                <input required type="text" name="revenue" value="{{old('revenue')}}"  class="form-control" placeholder="{{translate("Enter your Revenue")}}" id="revenue">
                            </div>
                        </div>


                        <div class="col-xl-6 col-lg-6">
                            <div >
                                <label for="status" class="form-label">
                                    {{translate('status')}} <span class="text-danger">*</span>
                                </label>

                                <select required class="form-select" name="status" id="status">
                                </select>
                            </div>
                        </div>

                        <!-- <div class="col-xl-6 col-lg-6">
                            <div>
                                <label for="formFile" class="form-label">
                                    {{translate('Image')}}  <span class="text-danger">
                                        ({{getFilePaths()['profile']['user']['size'] }})
                                    </span>
                                </label>
                                <input id="formFile" data-size ="{{getFilePaths()['profile']['user']['size']}}" type="file" class="preview form-control w-100"
                                    name="image">
                            </div>
                            <div id="image-preview-section">

                            </div>
                        </div> -->

                        @if(site_settings('geo_location') == 'map_base' && site_settings('auto_ticket_assignment')  == '1')
                            <div class="col-xl-6 col-lg-6">
                                <label for="address-input" class="form-label">
                                        {{translate('Address')}} <span class="text-danger" >*</span>
                                </label>
                                <input type="text" id="address-input" name="address" class="form-control map-input">
                                <input type="hidden" name="latitude" id="address-latitude" value="0" />
                                <input type="hidden" name="longitude" id="address-longitude" value="0" />
                            </div>

                            <div  class="col-12 map-container" >
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

    @if(site_settings('auto_ticket_assignment')  == '1' &&  site_settings('geo_location') == 'map_base')
        <script src="https://maps.googleapis.com/maps/api/js?key={{site_settings('google_map_key')}}&libraries=places&callback=initialize" async defer></script>
        <script src="{{asset('assets/global/js/map.js')}}"></script>
    @endif
@endpush

<script>
    const translations = {
        1: [
            { value: 0, text: @json(__('Confirmation')) },
            { value: 1, text: @json(__('Qualification Phase')) },
            { value: 2, text: @json(__('Administrative Preliminary Phase')) },
            { value: 3, text: @json(__('Validation Phase')) },
            { value: 4, text: @json(__('Construction Phase')) },
            { value: 5, text: @json(__('Repayment Phase')) }
        ],
        0: [
            { value: 0, text: @json(__('Confirmation')) },
            { value: 1, text: @json(__('Qualification Phase')) },
            { value: 2, text: @json(__('Engineering Phase (GIAC)')) },
            { value: 3, text: @json(__('Phase (CSF)')) },
            { value: 4, text: @json(__('Construction Phase')) },
            { value: 5, text: @json(__('Repayment Phase')) }
        ]
    };
</script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectElement = document.getElementById('cities');

        // Fetch the cities JSON
        fetch('/pixeldesk-new-installer-v2.1/kode/assets/json/cities.json')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(cities => {
                // Clear existing options
                selectElement.innerHTML = '';

                // Add a default "Select City" option
                const defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.textContent = 'Select City';
                defaultOption.disabled = true;
                defaultOption.selected = true;
                selectElement.appendChild(defaultOption);

                // Populate with cities
                cities.forEach(city => {
                    const option = document.createElement('option');
                    option.value = city.ville;
                    option.textContent = city.ville;
                    selectElement.appendChild(option);
                });
            })
            .catch(error => console.error('Error loading cities:', error));

        // Get references to the select elements
        const trainingSelect = document.getElementById('tranings');
        const statusSelect = document.getElementById('status');

        // Define the options for each training type
        const options = translations;

        // Function to update the status options
        const updateStatusOptions = () => {
            // Get the selected value of the training select
            const selectedTraining = trainingSelect.value;

            // Clear the current options in the status select
            statusSelect.innerHTML = '';

            // Populate the status select with the corresponding options
            if (options[selectedTraining]) {
                options[selectedTraining].forEach(option => {
                    const opt = document.createElement('option');
                    opt.value = option.value;
                    opt.textContent = option.text;
                    statusSelect.appendChild(opt);
                });
            }
        };

        // Update the status options when the training select changes
        trainingSelect.addEventListener('change', updateStatusOptions);

        // Initialize the status options on page load
        updateStatusOptions();
    });
</script>




