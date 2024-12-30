@extends('admin.layouts.master')
@push('style-include')
   <link href="{{asset('assets/global/css/colorpicker.min.css')}}" rel="stylesheet">
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
                            <li class="breadcrumb-item"><a href="{{route('admin.ticket-status.list')}}">
                                {{translate('Ticket status')}}
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
                                {{translate('Update Ticket status')}}
                            </h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <form action="{{route('admin.ticket-status.update')}}" method="POST"  enctype="multipart/form-data">
                    @csrf
                    <div class="row g-4 pb-3">

                         <input type="hidden" name="id" value="{{$ticket_status->id}}">


            
                        
                        <div class="col-lg-12">

                            <div>
                                <div class="step-arrow-nav mb-4">
                                    <ul class="nav nav-pills custom-nav nav-justified localize-lang " role="tablist">

                                        @php

                                            $localeArray = $languages->pluck('code')->toArray();
                                            $appLanguage = session()->get("locale");
                                            usort($localeArray, function ($a, $b) {
                                                $systemLocale = session()->get("locale");
                                                $systemLocaleIndex = array_search($systemLocale, [$a, $b]);

                                                return $systemLocaleIndex === false ? 0 : ($systemLocaleIndex === 0 ? -1 : 1);
                                            });

                                            array_unshift( $localeArray, "default" );
                                        @endphp


                                        @foreach( $localeArray as $key)

                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link   nowrap
                                                    {{$loop->index == 0 ? "active" :""}}
                                                    " id="lang-tab-{{$key}}" data-bs-toggle="pill" data-bs-target="#lang-tab-content-{{$key}}" type="button" role="tab" aria-controls="lang-tab-content-{{$key}}" aria-selected="true">

                                                    <img src="{{asset('assets/images/global/flags/'.strtoupper($key).'.png') }}" alt="{{strtoupper($key).'.png'}}" class="me-2 rounded" height="18">
                                                    <span class="align-middle">
                                                        {{$key}}

                                                        @if(session()->get("locale") == strtolower($key))
                                                            <span class="text-danger d-inline-block ms-1 fs-18" >*</span>
                                                        @endif
                                                    </button>
                                                </li>

                                        @endforeach
                                    </ul>
                                </div>

                                <div class="tab-content">
                                    @foreach( $localeArray as $key)

                                            <div class="tab-pane fade  {{$loop->index == 0 ? " show active" :""}}   " id="lang-tab-content-{{$key}}" role="tabpanel" aria-labelledby="lang-tab-{{$key}}">
                                                <div>
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="{{$key}}-input">
                                                                     {{translate("Name")}}
                                                                    @if("default" == strtolower($key))
                                                                       <span class="text-danger d-inline-block nowrap fs-18" >*</span>
                                                                    @else
                                                                       ({{$key}})
                                                                    @endif
                                                                </label>
                                                                @php
                                                                    $lang_code =  strtolower($key);
                                                                @endphp

                                                                <input class="form-control" id="{{$key}}-input" type="text" name="name[{{$lang_code}}]"   placeholder='{{translate("Enter name")}}'
                                                                value='{{Arr::get($ticket_status->translateable_locale, $lang_code)}}'>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                    @endforeach
                                </div>
                            </div>

                          
                        </div>


                        <div class="col-lg-12">

                            <div>
                                <label class="form-label" for="colorCode">
                                    {{translate('Color Code')}}

                                      <span class="text-danger"> *</span>
                                </label>

                                <input type="text" name="color_code" id="colorCode" class="form-control"  placeholder="{{translate("Enter Color Code")}}"
                                    value="{{$ticket_status->color_code}}" >

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

@endsection

@push('script-include')

    <script src="{{asset('assets/global/js/colorpicker.min.js')}}"></script>

@endpush

@push('script-push')
<script>
  "use strict";
       $('#colorCode').colorpicker();
 </script>
@endpush







