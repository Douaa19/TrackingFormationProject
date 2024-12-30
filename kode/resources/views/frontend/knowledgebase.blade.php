
@extends('frontend.layouts.master')
@section('content')
<div class="inner-banner">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 col-lg-9 mx-auto">
                <h1 class="breadcrumb-title mb-3">
                    {{translate('How can we help')}} ?
                </h1>

                <div class="search-wrapper">

                    <form class="banner-searchform" action="{{route('article.search')}}" method="post">
                        @csrf
                        <span><i class="bi bi-search"></i></span>
                        <input class="article-search" id="inner-search" type="search" name="search" placeholder="{{translate("Search Your Question ....")}}">
                        <button type="submit" class="btn--lg btn-icon-hover search-btn d-flex align-items-center justify-content-center gap-2">
                            <span>{{translate("Search")}}</span>
                            <i class="bi bi-arrow-right"></i>
                        </button>


                    </form>

                    <div class="live-search">


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@php
    $knowledgeDepartment =  $departments->where('slug',request()->route('slug'))->first();
@endphp

@if($knowledge &&  $knowledgeDepartment)

    <section>
        <div class="container">
            <div class="document">
                <div class="document-sidebar">
                    <div class="document-left border-end">
                        <div class="document-menu-container">

                            <div class="document-menu-wrapper py-lg-5 pe-1">
                                <div class="d-flex align-items-center justify-content-between mb-3 w-100">
                                    <h6 class="text-dark fs-18 fw-bold">
                                        {{ $knowledgeDepartment->name
                                        
                                        }}
                                    </h6>
                                    <div class="close-sidebar close-document-menu">
                                        <i class="bi bi-x"></i>
                                    </div>
                                </div>

                                 @include("frontend.partials.knowledge_hierarchy")
                            </div>

                        </div>
                    </div>

                    <div class="document-overlay d-lg-none"></div>
                </div>

                <div class="document-right py-5">
                    <div class="document-content">
                        <div class="short-docu-menu">
                            <div class="d-flex align-items-center">
                              <div class="docu-menu-btn d-lg-none">
                                <span></span>
                                <span></span>
                                <span></span>
                              </div>

                                <h6 class="text-dark">
                                    
                                   {{$knowledge->name}}
                                </h6>
                            </div>
                        </div>

                        @php echo $knowledge->description @endphp
                    </div>
                </div>
            </div>
        </div>
    </section>
@else
    <section class="pt-100 pb-100" >
        <div class="container">
            <div class="products">
                <h2 class="mb-3">
                    {{translate("Browse by Products")}}
                </h2>



                <div class="row g-4">

                    @forelse ($departments  as $department )

                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <a href="{{route("knowledgebase",['slug' => $department->slug])}}" class="product-item {{request()->route('slug') ==  $department->slug ? "active" :''}}">
                                <div class="product-logo">
                                    <img src="{{getImageUrl(getFilePaths()['department']['path']."/". $department->image , getFilePaths()['department']['size']) }}" alt="{{ $department->image}}">
                                </div>
                                <p>
                                    {{ limit_words($department->name,20)}}
                                </p>
                            </a>
                        </div>

                    @empty
                        <div class="col-12">
                                @include('frontend.partials.not_found')
                        </div>
                    @endforelse


                </div>
            </div>

            <div class="mt-5">

                @if($knowledgeDepartment )
                    <div>
                        <h3>
                            {{$knowledgeDepartment->name}}
                        </h3>
                        <p>  {{$knowledgeDepartment->description}}</p>
                    </div>

                    <div class="row g-5 mt-0">

                        @if($knowledgeDepartment->parentKnowledgeBases->count() > 0)

                            @foreach ($knowledgeDepartment->parentKnowledgeBases as  $knowledgeBase)

                                <div class="col-xl-4 col-md-6">
                                    <div class="category-item">
                                        <div class="category-title">
                                            <span class="category-icon">
                                                <i class="{{$knowledgeBase->icon}}"></i>
                                            </span>

                                            <h5>
                                                {{$knowledgeBase->name}} <span class="text-muted">({{$knowledgeBase->childs->count()}})</span>
                                            </h5>
                                        </div>

                                        <div class="category-content">

                                                <ul class="category-list">
                                                    @forelse ($knowledgeBase->childs as $child)
                                                        <li><a href="{{route("knowledgebase",['slug' => $knowledgeDepartment->slug , 'knowledge_slug' => $child->slug])}}">
                                                        {{ $child->name}}
                                                        </a></li>
                                                    @empty
                                                        <li>
                                                            {{translate("No result found")}}
                                                        </li>
                                                    @endforelse

                                                </ul>

                                        </div>
                                    </div>
                                </div>

                            @endforeach


                        @else
                            <div class="col-12 text-center">
                                @include('frontend.partials.not_found')
                            </div>
                        @endif


                    </div>

                @endif
            </div>
        </div>
    </section>
@endif



@endsection
