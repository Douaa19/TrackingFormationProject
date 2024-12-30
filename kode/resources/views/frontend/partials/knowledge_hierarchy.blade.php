@php
    $knowledgeBase = $knowledgeDepartment->parentKnowledgeBases;
@endphp

@foreach ( $knowledgeBase  as  $knowledgeBase )
    <ul class="document-menu">
        <li class="document-menu-item"   value="{{$knowledgeBase->id}}">

            @php
               $hasChildren = $knowledgeBase->childs->where('status',App\Enums\StatusEnum::true->status())->count() > 0 ?  true : false ;
               $ahref =   $hasChildren
                            ? "javascript:void(0)"
                            : route("knowledgebase",['slug' => $knowledgeDepartment->slug , 'knowledge_slug' => $knowledgeBase->slug]) ;
            @endphp
            <a class="document-menu-link {{request()->route('knowledge_slug') == $knowledgeBase->slug ? 'active' : '' }}"  href="{{$ahref}}"
               >
                @if ( $hasChildren)
                    <p class="node-element" type="button" id="{{$knowledgeBase->id}}" data-bs-toggle="collapse" data-bs-target="#node-ul-{{$knowledgeBase->id}}" aria-expanded="true" aria-controls="node-ul-{{$knowledgeBase->id}}">
                        <small><i class="bi bi-chevron-down align-middle"></i></small>

                        {{$knowledgeBase->name}}

                    </p>
                @else
                   <p>
                       {{$knowledgeBase->name}}
                   </p>

                @endif

            </a>

            @if ( $hasChildren)
                @include('frontend.partials.knowledge_child', [
                    'childs'     => $knowledgeBase->childs,'parent_id' => $knowledgeBase->id,
                    'department' => $knowledgeDepartment
                ])
            @endif
        </li>
    </ul>
@endforeach
