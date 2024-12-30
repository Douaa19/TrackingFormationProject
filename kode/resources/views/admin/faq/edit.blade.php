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
                            <li class="breadcrumb-item"><a href="{{route('admin.faq.list')}}">
                                {{translate('Faqs')}}
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
                                {{translate('Update Faq')}}
                            </h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <form action="{{route('admin.faq.update')}}" method="POST"  enctype="multipart/form-data">
                    <input  type="hidden" name="id" value="{{$faq->id}}"  class="form-control"  id="name">
                    @csrf
                    <div class="row g-3 pb-3">
                        <div class="col-xl-6 col-lg-6">
                            <div>
                                <label class="form-label" for="question">
                                    {{translate('Question')}}

                                      <span class="text-danger">*</span>

                                </label>

                                <input type="text" name="question" id="question" class="form-control"  placeholder="{{translate("Enter Question")}}"value="{{$faq->question}}" required>

                            </div>
                        </div>

                        <div class="col-xl-6 col-lg-6">
                            <div>
                                <label for="categories" class="form-label">
                                    {{translate('Category')}} <span class="text-danger">*</span>
                                </label>
                                    <select  required class="form-select select2" name="category_id" id="categories">
                                        @foreach($categories as $category)
                                            <option {{$category->id == $faq->category_id  ? 'selected' :""}}
                                             value="{{$category->id}}">
                                                  {{ get_translation($category->name)}}
                                            </option>
                                        @endforeach
                                    </select>
                            </div>
                        </div>

                        <div class="col-xl-12 col-lg-12">

                            <label class="form-label" for="text-editor">
                                {{translate('Answer')}}

                                  <span class="text-danger">*</span>

                            </label>



                            <div class="text-editor-area">
               
                                <textarea placeholder="{{translate("Type Here")}} ....." class="form-control summernote" name="answer" id="text-editor" cols="30" rows="10">{{$faq->answer}}</textarea>

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





