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
                        {{translate($title)}}
                    </h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">
                                {{translate('Home')}}
                            </a></li>
                            <li class="breadcrumb-item"><a href="{{route('admin.article.list')}}">
                                {{translate('Articles')}}
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
                                {{translate('Create Article')}}
                            </h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <form action="{{route('admin.article.store')}}" method="POST"  enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3 pb-3">

                        <div class="col-xl-6 col-lg-6">
                            <div class="mb-0">
                                <label class="form-label" for="name">
                                    {{translate('Title')}}

                                      <span class="text-danger"> *</span>
                                </label>

                                <input type="text" name="name" id="name" class="form-control"  placeholder="{{translate("Enter Title")}}"
                                    value="{{old("name")}}" required>

                            </div>
                        </div>

                        <div class="col-xl-6 col-lg-6">
                            <div class="mb-0">
                                <label class="form-label" for="serial_id">
                                    {{translate('Serial')}}

                                      <span class="text-danger"> *</span>
                                </label>

                                <input type="number" name="serial_id" id="serial_id" class="form-control"  placeholder="{{translate("Enter Serial Id")}}"
                                    value="{{old("serial_id") ? old("serial_id") :$serial_id }}" required>

                            </div>
                        </div>


                        <div class="col-xl-6 col-lg-6">

                            <div class="mb-0">
                                <label class="form-label" for="category_id">
                                    {{translate('Items')}}

                                      <span class="text-danger"> *</span>

                                </label>

                                <select class="form-select" required name="category_id" id="category_id">
                                     <option value="">
                                        {{translate('Select Item')}}

                                        @php
                                         $category_id = request()->route('id') ?  request()->route('id') :  old("category_id");
                                        @endphp

                                        @foreach($items as $item)

                                          <option {{$category_id  == $item->id ? "selected" :"" }} value="{{$item->id}}">
                                             {{get_translation($item->name)}}
                                          </option>

                                        @endforeach


                                     </option>
                                </select>



                            </div>

                        </div>

                        <div class="col-xl-6 col-lg-6">

                            <div class="mb-0">
                                <label class="form-label" for="article_category_id">
                                    {{translate('Category')}}

                                      <span class="text-danger"> *</span>

                                </label>

                                <select class="form-select" required name="article_category_id" id="article_category_id">
                                     <option value="">
                                        {{translate('Select Category')}}

                                        @foreach($categories as $category)

                                          <option {{old("article_category_id") == $category->id ? "selected" :"" }} value="{{$category->id}}">
                                            {{($category->name)}}
                                          </option>

                                        @endforeach


                                     </option>
                                </select>



                            </div>
                        </div>

                        <div class="col-xl-12 col-lg-12">

                            <div class="mb-0">
                                <label class="form-label" for="text-editor">
                                    {{translate('Description')}}

                                        <span class="text-danger"> *</span>

                                </label>

                

                                
                                <div class="text-editor-area">
                
                                    <textarea placeholder="{{translate("Type Here")}} ....." class="form-control summernote" name="description" id="text-editor" cols="30" rows="10">{{old("description")}}</textarea>

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
                        </div>


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
	<script src="{{asset('assets/global/js/summernote.min.js')}}"></script>
	<script src="{{asset('assets/global/js/editor.init.js')}}"></script>
@endpush








