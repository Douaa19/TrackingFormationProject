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
                            <li class="breadcrumb-item"><a href="{{route('admin.priority.list')}}">
                                {{translate('Priorities')}}
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
                                {{translate('Update Priority')}}
                            </h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <form action="{{route('admin.priority.update')}}" method="POST"  enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="id" value="{{$priority->id}}">
                    <div class="row g-4">

                        <div class="col-lg-6">
                            <div>
                                <label class="form-label" for="name">
                                    {{translate('Name')}}

                                      <span class="text-danger"> *</span>
                                </label>

                                <input type="text" name="name" id="name" class="form-control"  placeholder="{{translate("Enter Name")}}"
                                    value="{{$priority->name}}" >
                                <span class="text-danger">
                                     {{translate("Must Be Unique")}}
                                </span>

                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div>
                                <label class="form-label" for="colorCode">
                                    {{translate('Color Code')}}

                                      <span class="text-danger"> *</span>
                                </label>

                                <input type="text" name="color_code" id="colorCode" class="form-control"  placeholder="{{translate("Enter Color Code")}}"
                                    value="{{$priority->color_code}}" >

                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div>
                                <label class="form-label" for="response">
                                    {{translate('Response In')}}

                                      <span class="text-danger"> *</span>
                                </label>

                                <div class="input-group">

                                    <input type="number" min="1" max="200" name="response[in]" id="response" class="form-control"  placeholder="{{translate("Response In")}}"
                                    value="{{$priority->response_time->in}}" required>


                                    <select class="form-select w-150" name="response[format]" id="responseFormat" aria-label="Example select with button addon">

                                        @foreach(App\Enums\ReponseFormat::toArray() as $k => $v)
                                            <option {{ $priority->response_time->format == $v ? "selected" :"" }} value="{{$v}}">
                                                {{$v}}
                                            </option>
                                        @endforeach


                                    </select>

                                </div>

                            </div>
                        </div>


                        <div class="col-lg-6">
                            <div>
                                <label class="form-label" for="resolve">
                                    {{translate('Resolve In')}}

                                      <span class="text-danger"> *</span>
                                </label>

                                <div class="input-group">

                                    <input type="number" min="1" max="200" name="resolve[in]" id="resolve" class="form-control"  placeholder="{{translate("Resolve In")}}"
                                    value="{{$priority->resolve_time->in}}" required>


                                    <select class="form-select w-150" name="resolve[format]" id="resolveFormat" aria-label="Example select with button addon">

                                        @foreach(App\Enums\ReponseFormat::toArray() as $k => $v)
                                            <option {{ $priority->resolve_time->format == $v ? "selected" :"" }} value="{{$v}}">
                                                {{$v}}
                                            </option>
                                        @endforeach


                                    </select>

                                </div>

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


