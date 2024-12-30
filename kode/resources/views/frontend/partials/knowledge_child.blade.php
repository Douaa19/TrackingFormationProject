<ul class="sub-menu collapse show"  id="node-ul-{{$parent_id}}">

    @foreach($childs as $child)

        <li class="document-menu-item" value="{{$child->id}}">

            @php

            $hasChildren = $child->childs->where('status',App\Enums\StatusEnum::true->status())->count() > 0 ?  true : false ;

            $href        =  $hasChildren
                                    ? "javascript:void(0)"
                                    : route("knowledgebase",['slug' => $department->slug , 'knowledge_slug' => $child->slug]) ;
            @endphp
            <a class="document-menu-link {{request()->route('knowledge_slug') == $child->slug ? 'active' : '' }}" href="{{$href}}">

                @if( $hasChildren)
                    <p  class="node-element" id="{{$child->id}}"  type="button" data-bs-toggle="collapse" data-bs-target="#node-ul-{{$child->id}}" aria-expanded="true" aria-controls="node-ul-{{$child->id}}">
                        <small><i class="bi bi-chevron-down align-middle"></i></small>
                        {{ $child->name }}
                    </p>
                @else
                    <p>
                        {{ $child->name }}
                    </p>
                @endif

            </a>

            @if( $hasChildren)
                    @include('frontend.partials.knowledge_child', [
                        'childs'    => $child->childs->where('status',App\Enums\StatusEnum::true->status()),'parent_id' => $child->id,
                        'department'=> $department
                    ])
            @endif
        </li>
    @endforeach


</ul>
