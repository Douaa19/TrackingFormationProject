<ul class="sub-menu side-menu-dropdown collapse show"  id="node-ul-{{$parent_id}}">

        @foreach($childs as $child)

            <li class="sub-menu-item" value="{{$child->id}}">
                <div class="sidebar-menu-link">
                    @if($child->childs->count() > 0)
                        <p  class="node-element" id="{{$child->id}}" class="node-element" type="button" data-bs-toggle="collapse" data-bs-target="#node-ul-{{$child->id}}" aria-expanded="true" aria-controls="node-ul-{{$child->id}}">
                        <small><i class="las la-angle-down"></i></small>
                             {{ $child->name }}
                        </p>
                    @else
                       <p class="node-element" id="{{$child->id}}">{{ $child->name }}</p>
                    @endif

                    <div class="menu-link-action">
                        <a href="{{route("admin.knowledgebase.list",['slug'=>$department->slug , 'id' => $child->id ])}}" class="menu-action-icon edit">
                            <i class="ri-edit-box-line"></i>
                        </a>

                        <a href="javascript:void(0);" data-href="{{route('admin.knowledgebase.destroy', $child->id)}}" class="menu-action-icon delete delete-item">
                            <i class="ri-delete-bin-6-line"></i>
                        </a>

                        <span class="menu-action-icon ms-1">
                            <i class="bi bi-grip-vertical"></i>
                        </span>
                    </div>
                </div>


                @if($child->childs)
                        @include('admin.knowledgebase.child_hierarchy', [
                            'childs'    => $child->childs,'parent_id' => $child->id,
                            'department'=> $department
                        ])
                @endif
            </li>
        @endforeach


</ul>
