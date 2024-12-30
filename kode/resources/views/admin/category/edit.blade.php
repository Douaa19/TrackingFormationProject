@extends('admin.layouts.master')

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
                            <li class="breadcrumb-item"><a href="{{request()->routeIs('admin.article.category.edit')? route('admin.article.category') : route('admin.category.index') }}">
                                {{ route('admin.article.category') ?  translate('Topics') : translate('Categories')}}
                            </a></li>
                            <li class="breadcrumb-item active">
                                {{translate('Update')}}
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <form hidden id="bulkActionForm" action="{{route("admin.category.bulk")}}" method="post">
            @csrf
             <input type="hidden" name="bulk_id" id="bulkid">
             <input type="hidden" name="value" id="value">
             <input type="hidden" name="type" id="type">
        </form>

        <form action="{{route('admin.category.update')}}" method="post"  enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card">
                        <input type="hidden" value="{{$category->id}}" name="id" id="id">
                        <div class="card-header border-bottom-dashed">
                            <div class="row g-4 align-items-center">
                                <div class="col-sm">
                                    <div>
                                        <h5 class="card-title mb-0">
                                            {{ route('admin.article.category') ?  translate('Update Topics') :translate('Update category')}}
                                        </h5>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="card-body">
                                <div>
                                    <div class="step-arrow-nav mb-4">
                                        <ul class="nav nav-pills custom-nav nav-justified localize-lang " role="tablist">

                                            @php
                                                $nameArr = json_decode($category->name,true);

                                                $localeArray = $languages->pluck('code')->toArray();
                                                $appLanguage = session()->get("locale");
                                                usort($localeArray, function ($a, $b) {
                                                    $systemLocale = session()->get("locale");
                                                    $systemLocaleIndex = array_search($systemLocale, [$a, $b]);

                                                    return $systemLocaleIndex === false ? 0 : ($systemLocaleIndex === 0 ? -1 : 1);
                                                });
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
                                                                        {{translate('Name')}} ({{$key}})

                                                                        @if(session()->get("locale") == strtolower($key))
                                                                            <span class="text-danger">*</span>
                                                                        @endif
                                                                    </label>
                                                                    @php
                                                                        $lang_code =  strtolower($key);
                                                                        $val  = Arr::get($nameArr,$key,"");
                                                                    @endphp

                                                                    <input id="{{$key}}-input" type="text" name="name[{{strtolower($key)}}]" class="form-control"  placeholder="{{translate("Enter Name")}}"
                                                                        value="{{$val}}"
                                                                    {{session()->get("locale") == strtolower($key) ? "required" :""}}
                                                                    >
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                        @endforeach
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="image">
                                                    {{translate('Image')}} <span class="text-danger">
                                                    ({{getFilePaths()['category']['size']}})
                                                    </span>
                                            </label>

                                            <input id="image" name="image" class="form-control" type="file">

                                                <div class="mt-2">

                                                <img src="{{getImageUrl(getFilePaths()['category']['path']."/". $category->image) }}" alt="{{$category->image}}" class="avatar-xs rounded-circle">

                                                </div>

                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="sort_details">

                                                    {{translate('Sort Details')}} <span class="text-danger">*</span>

                                            </label>

                                            <textarea required class="form-control" placeholder="{{translate("Write sort Details Here")}} ....." name="sort_details" id="sort_details" cols="30" rows="10">{{$category->sort_details}}</textarea>

                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <div class="d-flex gap-2 flex-wrap">

                                                <div class="form-group form-check form-check-success  ">
                                                    <input  type="checkbox" class="form-check-input "
                                                        class="form-check-input" type="checkbox" value="1" id="ticketVisibility" {{ $category->ticket_display_flag == App\Enums\StatusEnum::true->status() ? "checked" : ""}} name="ticket_display_flag" >
                                                    <label class="form-check-label" for="ticketVisibility">
                                                        {{translate("Show In Ticket")}}
                                                    </label>
                                                </div>
                                                <div class="form-group form-check form-check-success  ">
                                                    <input  type="checkbox" class="form-check-input "
                                                        class="form-check-input" type="checkbox" value="1" id="articleVisibility" {{ $category->article_display_flag == App\Enums\StatusEnum::true->status() ? "checked" : ""}} name="article_display_flag" >
                                                    <label class="form-check-label" for="articleVisibility">
                                                        {{translate("Show In Article")}}
                                                    </label>
                                                </div>

                                            </div>


                                        </div>
                                    </div>
                                </div>


                                <button type="submit"
                                class="btn btn-success waves ripple-light"
                                id="add-btn">
                                {{translate('Submit')}}
                                </button>




                        </div>

                    </div>
                </div>
            </div>

        </form>
    </div>



@endsection








