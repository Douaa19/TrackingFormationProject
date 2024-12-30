
    <div class="live-search-top">
        <p>
            {{translate("Total Items")}}
        </p>
        <span>
              {{$knowledgebases->count()}}
        </span>
    </div>

    <ul class="search-result">

        @forelse ($knowledgebases->take(10) as $knowledgebase)

            <li class="found-item">
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <h6>
                            <a href="{{route("knowledgebase",['slug' => $knowledgebase->department->slug , 'knowledge_slug' => $knowledgebase->slug])}}"> {{$knowledgebase->name}}</a>
                        </h6>

                        <a href="{{route("knowledgebase",['slug' => $knowledgebase->department->slug ])}}" class="badge rounded-pill text-bg-secondary fs-10">
                            {{$knowledgebase->department->name}}
                        </a>
                    </div>

                    <p>
                        {{limit_words(strip_tags($knowledgebase->description),150)}}
                    </p>

            </li>

        @empty
            <li class="text-center">
                @include('frontend.partials.not_found')
            </li>

        @endforelse



    </ul>

    <div class="live-search-bottom text-center">
        <a href="{{route('article.search',['search' => $searchTerm])}}">

            {{translate('See all result ')}}
            <i class="bi bi-arrow-right"></i>
        </a>
    </div>
