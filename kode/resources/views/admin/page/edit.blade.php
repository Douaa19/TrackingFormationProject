@extends('admin.layouts.master')
@push('styles')
 <link href="{{asset('assets/global/css/summnernote.css')}}" rel="stylesheet" type="text/css" />
@endpush
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">
                        {{translate('Update Page')}}
                    </h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">
                                {{translate('Home')}}
                            </a></li>
                            <li class="breadcrumb-item"><a href="{{route('admin.page.list')}}">
                                {{translate('Pages')}}
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
                                {{translate('Update Page')}}
                            </h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <form action="{{route('admin.page.update')}}" method="POST"  enctype="multipart/form-data">
                    <input  type="hidden" name="id" value="{{$page->id}}"  class="form-control"  id="name">
                    @csrf
                    <div class="row g-3 pb-3">
                        <div class="col-xl-12 col-lg-12">
                            <div>
                                <label class="form-label" for="title">
                                    {{translate('Title')}}

                                      <span class="text-danger">*</span>

                                </label>

                                <input type="text" name="title" id="title" class="form-control"  placeholder="{{translate("Enter title")}}"value="{{$page->title}}" required>

                            </div>
                        </div>

                        <div class="col-xl-12 col-lg-12">

                            <label class="form-label" for="text-editor">
                                {{translate('Description')}}

                                  <span class="text-danger">*</span>

                            </label>

                             <div class="text-editor-area">
                                <textarea placeholder="{{translate("Start typing...")}}" class="form-control summernote" name="description" id="text-editor" cols="30" rows="10">{{$page->description}}</textarea>

                                @if(site_settings("open_ai")  ==  App\Enums\StatusEnum::true->status())

                                    <button type="button" class="ai-generator-btn mt-3 ai-modal-btn " >
                                        <span class="ai-icon btn-success waves ripple-light">
                                                <span class="spinner-border d-none" aria-hidden="true"></span>
        
                                                <i class="ri-robot-line"></i>
                                        </span>
        
                                        <span class="ai-text">
                                            {{translate('Generate With AI')}}
                                        </span>
                                    </button>
        
                                @endif
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
	<script src="{{asset('assets/global/js/summernote.min.js')}}"></script>
	<script src="{{asset('assets/global/js/editor.init.js')}}"></script>
@endpush





