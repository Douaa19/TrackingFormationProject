
@extends('frontend.layouts.master')
@section('content')

<div class="inner-banner">
    <div class="container">
        <h1 class="breadcrumb-title">
            {{ucfirst(str_replace("-"," ",$title))}}
        </h1>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('home')}}">
            {{translate('Home')}}
            </a></li>
            @if(request()->routeIs("article.view"))
                <li class="breadcrumb-item">
                    <a href="{{route('articles',[request()->route('item'),$item->id])}}">
                        {{ucfirst(str_replace("-"," ",request()->route('item')))}}
                    </a>
               </li>

               <li class="breadcrumb-item active" aria-current="page"> {{translate(ucfirst(str_replace("-"," ",$title)))}}</li>
            @else
              <li class="breadcrumb-item active" aria-current="page">  {{translate(ucfirst(str_replace("-"," ",$title)))}}</li>
            @endif

        </ol>
      </nav>
    </div>
</div>

<section class="pt-100 pb-100">
    <div class="container">
        <div class="document">

            <div class="document-sidebar">
                <div class="document-left">
                    <div class="d-flex align-items-center justify-content-between w-100">
                        <div class="mobile-site-logo">
                            <img src="{{ getImageUrl(getFilePaths()['site_logo']['path']."/".site_settings('frontend_logo')) }}" alt="{{site_settings('frontend_logo')}}">
                        </div>
                        <div class="close-sidebar close-document-menu d-lg-none">
                            <i class="bi bi-x"></i>
                        </div>
                    </div>

                    <ul class="document-menus div-sticky">
                        @foreach($categories as $category)

                            @php
                                $active = null;
                                $collapsed = true;

                                if(request()->routeIs("articles") )
                                {
                                    if($loop->index == 0){
                                        $active = "show";
                                        $collapsed = false;
                                    }
                                }
                                if(request()->route("category")  == make_slug($category->name)){
                                    $active = "show";
                                    $collapsed = false;
                                }
                            @endphp
                            <li>
                                <div class="custiom-accordion-small">
                                    <div class="accordion " id="accordian-{{$category->id}}">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="heading-{{$category->id}}">
                                                <button class="accordion-button {{$collapsed ? "collapsed" :""}} " type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapse-{{$category->id}}"
                                                    aria-expanded="true" aria-controls="collapse-{{$category->id}}">
                                                    {{$category->name}}
                                                </button>
                                            </h2>

                                            <div id="collapse-{{$category->id}}" class="accordion-collapse  collapse {{ $active}}"
                                                aria-labelledby="heading-{{$category->id}}" data-bs-parent="#accordian-{{$category->id}}">
                                                <div class="accordion-body">
                                                    <ul class="document-sub-menus">
                                                        @foreach($category->articles as $article)
                                                            <li class="document-sub-menu ">
                                                                <a class="{{$articleDetails->name == $article->name ? "article-active" :""}}  " href="{{route("article.view",[
                                                                    "item"=>make_slug(get_translation($item->name)) ,"category"=>$category->slug ,"title" => make_slug($article->name) ,'id'=>$article->id
                                                                ])}}">{{$article->name}}</a>
                                                            </li>
                                                        @endforeach

                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                         @endforeach

                    </ul>

                </div>
                <div class="document-overlay d-lg-none"></div>
            </div>

            <div class="document-right">
                <div class="d-flex align-items-center short-docu-menu d-lg-none">
                    <div class="docu-menu-btn">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>

                    <div>
                        <span>{{$categories->first()?->name}}</span>
                        <span class="text-muted">
                             {{$articleDetails?->name}}
                        </span>
                    </div>
                </div>

                <div>

                    <div class="mb-3">
                        <h3>{{$articleDetails?->name}}</h3>
                    </div>
                    @php echo $articleDetails?->description @endphp


                </div>
            </div>
        </div>
        @if(count($categories) == 0)
            <div class="row justify-content-center">
                <div class="col-lg-6 text-center">
                    @include('frontend.partials.not_found')

                </div>
            </div>
        @endif

    </div>
</section>
@endsection
