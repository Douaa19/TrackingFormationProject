@extends('admin.layouts.master')
@push('style-include')

   <link href="{{asset('assets/global/css/colorpicker.min.css')}}" rel="stylesheet">
   <link href="{{asset('assets/global/css/summnernote.css')}}" rel="stylesheet" type="text/css" />

@endpush
@section('content')
@php

    use Illuminate\Support\Arr;
	$ticketStatus = App\Models\TicketStatus::active()->get();
    $social_login_settings = json_decode(site_settings('social_login'),true);

    
    $medium = 'envato_oauth';
    $envatoOauthSetting =  @$social_login_settings['envato_oauth'];
     if(is_array($envatoOauthSetting) && !Arr::exists($envatoOauthSetting,'personal_token')){
        $envatoOauthSetting['personal_token']  = '@@';
     }

@endphp
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">{{ translate(@$title) }}</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">{{ translate('Home') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ translate(@$title) }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row basic-setting">
        

        @if(auth_user()->agent == App\Enums\StatusEnum::false->status())

            <div class="col-12">
                
                    <form class="d-flex flex-column gap-4 settingsForm envato-setting-form" data-route="{{ route('admin.setting.envato.plugin.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card">
                            <div class="card-header border-bottom-dashed">
                                <div class="d-flex align-items-center justify-content-start">
                                    <h5 class="d-inline-block card-title mb-0">{{ translate("Envato Business Configuration") }}</h5>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                          
                                           
                                    @foreach($envatoOauthSetting as $key => $val)


                                    

                                        <div class="col-lg-6">
                                            <label  class="form-label">
                                                {{
                                                    Str::ucfirst(str_replace("_"," ",$key))
                                                }}  <span class="text-danger" >*</span>
                                            </label>


                                            @if($key == 'status')

                                                <select class="form-select" name="site_settings[social_login][{{$medium}}][{{$key}}]"  >

                                                    <option {{$val == App\Enums\StatusEnum::true->status() ? "selected" :""}} value="{{App\Enums\StatusEnum::true->status()}}">
                                                        {{translate('Active')}}
                                                    </option>
                                                    <option {{$val == App\Enums\StatusEnum::false->status() ? "selected" :""}} value="{{App\Enums\StatusEnum::false->status()}}">
                                                        {{translate('Inactive')}}
                                                    </option>
                                                </select>

                                            @else
                                                <input required class="form-control" value="{{is_demo() ? "@@@" :$val}}" name='site_settings[social_login][{{$medium}}][{{$key}}]' placeholder="************" type="text" id="envato_{{$key}}">
                                            @endif
                                        </div>
                                    @endforeach
                           
                                    <div class="col-lg-6">
                                        <label for="cburl-envato" class="form-label">
                                            {{translate('Callback Url')}}
                                        </label>
                                        <div class="input-group">
                                            <input id="cburl-envato" readonly value="{{route('social.login.callback',str_replace("_oauth","","envato_oauth"))}}" type="text" class="form-control" aria-label="Recipient's username with two button addons">
                                            <button data-text ="{{route('social.login.callback',str_replace("_oauth","","envato_oauth"))}}" class="copy-text btn btn-info" type="button"><i class=' fs-18 bx bx-copy'></i></button>
                                        </div>
                                    </div>
                                    <div class="text-start">
                                        <button type="submit" class="btn btn-success waves ripple-light confirmation">
                                            {{ translate('Save & Sync') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
            </div>
        @endif
        <div class="col-12">
            <div class="card">

                <div class="card-header border-bottom-dashed">
                    <div class="row g-4 align-items-center">
                        <div class="col-sm">
                            <div>
                                <h5 class="card-title mb-0">
                                    {{translate('Envato Settings')}}
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form data-route="{{route('admin.setting.store')}}" class="settingsForm" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-4">

                            <div class="col-lg-6">

                                <label for="envato_verification" class="form-label">
                                    {{translate('Envato verifications')}}
                                        
                                    <span  class=" fs-15 link-danger  waves ripple-light"><i  data-bs-toggle="tooltip" data-bs-placement="top" title="{{translate('Enabling this option will activate Envato verification during ticket creation if the product is synced from Envato.')}}" class="ri-information-line"></i>
                                    </span>
                                </label>
                                <select class="select2" name="site_settings[envato_verification]" id="envato_verification">
                                    <option {{site_settings(key:'envato_verification',default:0) == 1 ? 'selected' :''}}  value="1">
                                            {{translate('Enable')}}
                                    </option>
                                    <option {{site_settings(key:'envato_verification',default:0) == 0 ? 'selected' :''}}  value="0">
                                            {{translate('Disable')}}
                                    </option>
                                </select>
                
                            </div>


                            <div class="col-lg-6">
                                <label for="envato_support_verification" class="form-label">
                                    {{translate('Enable support duration verification')}}
                                    <span  class=" fs-15 link-danger  waves ripple-light"><i  data-bs-toggle="tooltip" data-bs-placement="top" title="{{translate('Enabling this option will activate validation of the Envato product support duration during ticket creation')}}" class="ri-information-line"></i>
                                    </span>
                                </label>
                                
                                <select class="select2" name="site_settings[envato_support_verification]" id="envato_support_verification">
                                    <option {{site_settings(key:'envato_support_verification',default:0) == 1 ? 'selected' :''}}  value="1">
                                            {{translate('Enable')}}
                                    </option>
                                    <option {{site_settings(key:'envato_support_verification',default:0) == 0 ? 'selected' :''}}  value="0">
                                            {{translate('Disable')}}
                                    </option>
                                </select>
                            </div>
                            
                            


                            <div class="col-lg-12">
                        
        
                        
                                <div class="row align-items-center d-dos-input g-2">
                                    <div class="col-auto">
                                        <label class="form-label" > 
                                            {{translate("Ticket status is ")}}
                                        </label>
                                    </div>
                                    <div class="col-auto one-line">
                                        <select name="site_settings[ticket_support_expire_status]"  class="select2">
                                            <option value="">
                                                {{translate('Select Status')}}
                                            </option>

                                            @foreach($ticketStatus as $status)
                                                <option {{site_settings(key:'ticket_support_expire_status',default:-1) == $status->id ? 'selected' :''}}  value="{{$status->id}}">
                                                    {{
                                                        ucfirst(strtolower($status->name))
                                                    }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <label class="w-nowrap" > 
                                            {{translate("if the envato support is expired")}}
                                        </label>
                                    </div>
                                                
                                </div>
                            </div>


                            <div class="col-lg-12">

                                <div>
                                    <label for="envato_expired_email" class="form-label">
                                        {{translate('Envatio support expired mail')}} <span class="text-danger" >*</span>

                                        <span  class=" fs-15 link-danger  waves ripple-light"><i  data-bs-toggle="tooltip" data-bs-placement="top" title="{{translate('This email will be sent when a clients Envato support has expired')}}" class="ri-information-line"></i>
                                        </span>
                                    </label>

                                        <textarea class="form-control summernote"  name="site_settings[envato_expired_email]" id="envato_expired_email" cols="30" rows="10" required>{{site_settings('envato_expired_email')}}</textarea>
                                </div>
                            </div>


                            <div class="col-12">
                                <div class="text-start">
                                    <button type="submit" class="btn btn-success">
                                        {{translate('Update')}}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
        
    
    </div>
</div>

<div class="modal fade zoomIn" id="envato-item-sync-confirmation" tabindex="-1" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="mt-2 text-center">
                    <lord-icon src="{{ asset('assets/global/json/yxczfiyc.json') }}" trigger="loop"
                               colors="primary:#f7b84b,secondary:#f06548"
                               class="loader-icon"></lord-icon>
                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                        <h4>{{ translate('Are you sure?') }}</h4>
                        <p class="text-muted mx-4 mb-0">
                            {{ translate('This will reset any previous item changes of this Author') }}
                        </p>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">
                        {{ translate('Close') }}
                    </button>
                    <button type="submit" class="btn w-sm btn-danger confirmed">
                        {{ translate('Yes') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script-include')

  
	<script src="{{asset('assets/global/js/summernote.min.js')}}"></script>
	<script src="{{asset('assets/global/js/editor.init.js')}}"></script>

@endpush
@push('script-include')
<script>
    $(".select2").select2({
        placeholder:"{{translate('Select Status')}}",

    })
</script>
<script>
    'use strict';

    $(document).ready(function() {

        $('.confirmation').on('click', function() {
            event.preventDefault();
            var personalToken = $('#envato_personal_token').val();
            var $button = $(this);

            if (!personalToken) {

                toastr('Personal token is required', 'danger');
                return;
            }
            $('#envato-item-sync-confirmation').modal({
                backdrop: 'static',
                keyboard: false
            }).modal('show');
            $('.confirmed').data('personal-token', personalToken);
        });

        $('.confirmed').on('click', function() {

            var $button = $(this);
            var personalToken = $button.data('personal-token');
            var syncRoute = "{{ route('admin.setting.envato.sync.items') }}";
            var formData = {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'personal_token': personalToken
            };
            $button.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Processing...');

            $.ajax({
                url: syncRoute,
                type: 'POST',
                data: formData,
                success: function(response) {
                    toastr(response.message, response.status);
                    $('#envato-item-sync-confirmation').modal('hide');
                    $('.envato-setting-form').submit();
                },
                error: function(error) {
                    if (error && error.responseJSON) {
                        if (error.responseJSON.errors) {
                            for (let i in error.responseJSON.errors) {
                                toastr(error.responseJSON.errors[i][0], 'danger');
                            }
                        } else {
                            toastr(error.responseJSON.message || error.responseJSON.error, 'danger');
                        }
                    } else {
                        toastr(error.message, 'danger');
                    }
                },
                complete: function() {
                    $button.prop('disabled', false).html('{{translate("Yes")}}');
                }
            });
        });
    });

</script>
@endpush
