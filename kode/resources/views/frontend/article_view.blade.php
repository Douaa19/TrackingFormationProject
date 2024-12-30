
@extends('frontend.layouts.master')
@section('content')

@include('frontend.section.breadcrumb')

<section class="pt-100 pb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 mx-auto">
                <div class="search-history-wrapper">
                    <div class="d-flex align-items-center flex-wrap gap-3">
                        <a href="{{route('knowledgebase')}}" class="d-flex align-items-center gap-1">
                            <i class="bi bi-arrow-left align-middle fs-5"></i>

                            {{translate("Knowledgebase")}}
                        </a>
                        <span class="text-muted">{{translate('Showing')}} {{$knowledgebases->count()}}  {{translate('results for')}} "{{$searchTerm}}"</span>
                    </div>

                    <div class="mt-4">
                        <ul class="search-history">
                            @forelse ($knowledgebases as $knowledgebase)
                                <li class="history-item">
                                    <h4 class="mb-2">
                                        <span class="pe-1">
                                            <i class="{{$knowledgebase->icon}}"></i>
                                        </span>

                                        <a href="{{route("knowledgebase",['slug' => $knowledgebase->department->slug , 'knowledge_slug' => $knowledgebase->slug])}}">
                                           {{$knowledgebase->name}}
                                        </a>
                                    </h4>

                                    <div class="history-content">
                                            <p class="text-muted">
                                                {{limit_words(strip_tags($knowledgebase->description),150)}}
                                            </p>

                                            <div class="mt-1 fs-14">
                                                <a href="{{route("knowledgebase",['slug' => $knowledgebase->department->slug ])}}"> {{ $knowledgebase->department->name}}
                                                </a>

                                            </div>
                                    </div>
                                </li>
                            @empty
                                <li class="text-center">
                                    @include('frontend.partials.not_found')
                                </li>

                            @endforelse


                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
