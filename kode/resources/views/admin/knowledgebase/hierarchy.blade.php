

<div class="hierarchy-wrapper pb-3" data-simplebar id="dragParent">

        @php
                   $knowledgeBase = $knowledgeDepartment->parentKnowledgeBases;
        @endphp

        @foreach ( $knowledgeBase  as  $knowledgeBase )

                <ul class="sidebar-menu">
                    <li class="sidebar-menu-item" value="{{$knowledgeBase->id}}">
                        <div class="sidebar-menu-link"
                            role="button">
                            @if ($knowledgeBase->childs->count() > 0)
                                <p class="node-element" type="button" id="{{$knowledgeBase->id}}" data-bs-toggle="collapse" data-bs-target="#node-ul-{{$knowledgeBase->id}}" aria-expanded="true" aria-controls="node-ul-{{$knowledgeBase->id}}">
                                    <small><i class="las la-angle-down"></i></small>
                                      {{$knowledgeBase->name}}
                                </p>
                            @else
                                <p  id="{{$knowledgeBase->id}}" class="node-element">
                                    {{$knowledgeBase->name}}
                                </p>
                            @endif

                            <div class="menu-link-action">
                                <a href="{{route("admin.knowledgebase.list",['slug'=>$knowledgeDepartment->slug , 'id' => $knowledgeBase->id ])}}" class="menu-action-icon edit">
                                    <i class="ri-edit-box-line"></i>
                                </a>

                                <a href="javascript:void(0);" data-href="{{route('admin.knowledgebase.destroy', $knowledgeBase->id)}}" class="menu-action-icon delete delete-item">
                                    <i class="ri-delete-bin-6-line"></i>
                                </a>

                                <span class="menu-action-icon ms-1">
                                    <i class="bi bi-grip-vertical"></i>
                                </span>
                            </div>
                        </div>


                        @if ($knowledgeBase->childs->count() > 0)
                            @include('admin.knowledgebase.child_hierarchy', [
                                'childs'     => $knowledgeBase->childs,'parent_id' => $knowledgeBase->id,
                                'department' => $knowledgeDepartment
                            ])
                        @endif

                    </li>
                </ul>
        @endforeach


        <ul class="sidebar-menu" id="pre-state"></ul>

        <ul class="sidebar-menu" id="drophere" ondragstart="return false;" ondrop="return false;">
            <li class="sub-menu-item">
                <p id="newElement" class="drophere node-element mb-0">
                    {{translate("Drop here for new parent")}}
                    <span class="drop-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="none" height="24" viewBox="0 0 24 24" width="24"><clipPath id="clip0_1884_12236"><path d="m0 0h24v24h-24z"/></clipPath><g clip-path="url(#clip0_1884_12236)"><path d="m21.5 24h-10c-1.378 0-2.5-1.122-2.5-2.5v-4c0-.276.224-.5.5-.5s.5.224.5.5v4c0 .827.673 1.5 1.5 1.5h10c.827 0 1.5-.673 1.5-1.5v-10c0-.827-.673-1.5-1.5-1.5h-5c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h5c1.378 0 2.5 1.122 2.5 2.5v10c0 1.378-1.122 2.5-2.5 2.5z"/><path d="m7.5 15h-.5c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h.5c.276 0 .5.224.5.5s-.224.5-.5.5z"/><path d="m4.979 15h-1.011c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h1.011c.276 0 .5.224.5.5s-.224.5-.5.5zm-3.025-.076c-.045 0-.091-.006-.137-.019-.405-.115-.778-.333-1.078-.632-.196-.194-.197-.511-.002-.707.195-.195.512-.197.707-.002.18.179.404.31.646.379.266.075.42.352.344.618-.062.22-.263.363-.48.363zm-1.454-2.367c-.276 0-.5-.224-.5-.5v-1.011c0-.276.224-.5.5-.5s.5.224.5.5v1.011c0 .276-.224.5-.5.5zm0-3.033c-.276 0-.5-.224-.5-.5v-1.011c0-.276.224-.5.5-.5s.5.224.5.5v1.011c0 .276-.224.5-.5.5zm0-3.032c-.276 0-.5-.224-.5-.5v-1.011c0-.276.224-.5.5-.5s.5.224.5.5v1.011c0 .276-.224.5-.5.5zm14-1.031c-.276 0-.5-.224-.5-.5v-1.011c0-.276.224-.5.5-.5s.5.223.5.5v1.011c0 .276-.224.5-.5.5zm-14-2.002c-.276 0-.5-.224-.5-.5v-.459c0-.23.032-.459.094-.68.075-.267.353-.424.617-.345.266.075.42.351.345.617-.037.132-.056.269-.056.408v.459c0 .276-.224.5-.5.5zm13.919-1.023c-.217 0-.416-.142-.48-.36-.07-.241-.204-.463-.384-.643-.196-.194-.198-.511-.004-.707.194-.197.511-.198.707-.004.301.298.523.669.641 1.073.078.265-.075.542-.34.62-.047.015-.094.021-.14.021zm-12.481-1.356c-.216 0-.416-.141-.48-.359-.077-.265.075-.543.34-.621.227-.066.463-.1.702-.1h.441c.276 0 .5.224.5.5s-.223.5-.5.5h-.441c-.144 0-.285.02-.421.06-.047.014-.094.02-.141.02zm10.101-.08h-1.011c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h1.011c.276 0 .5.224.5.5s-.224.5-.5.5zm-3.033 0h-1.01c-.276 0-.5-.224-.5-.5s.223-.5.5-.5h1.011c.276 0 .5.224.5.5s-.224.5-.501.5zm-3.032 0h-1.011c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h1.011c.276 0 .5.224.5.5s-.224.5-.5.5z"/><path d="m14.5 8c-.276 0-.5-.224-.5-.5v-.5c0-.276.224-.5.5-.5s.5.224.5.5v.5c0 .276-.224.5-.5.5z"/><path d="m12.5488 17.9999h-2.05c-1.37805 0-2.50005-1.122-2.50005-2.5v-1.793l-.448-.448c-.295-.294-.457-.687-.457-1.104s.162-.809.457-1.104c.244-.244.555-.397.892-.443-.03-.435.121-.87996.453-1.21196.347-.347.845-.509 1.32205-.442.0569-.296.199-.579.428-.808.42-.42 1.072-.561 1.617-.371.073-.23.201-.447.383-.629.608-.608 1.599-.608 2.207 0l1.55 1.55c1.029 1.03 1.596 2.39896 1.596 3.85396 0 3.005-2.445 5.45-5.45 5.45zm-3.55005-3.293v.793c0 .827.673 1.5 1.50005 1.5h2.05c2.454 0 4.45-1.996 4.45-4.45 0-1.188-.4631-2.306-1.3031-3.14596l-1.5499-1.55c-.219-.219-.574-.219-.793 0-.106.105-.165.246-.165.396s.0579.291.1639.396c.098.098.1471.226.1471.354s-.049.256-.146.354c-.195.195-.512.195-.707 0l-.5-.5c-.212-.212-.581-.212-.793 0-.219.219-.219.574 0 .793l.5.49996c.097.097.146.225.146.353s-.049.256-.146.354c-.195.195-.512.195-.707 0l-.75-.75c-.212-.21196-.58105-.21196-.79305 0-.219.219-.219.574 0 .793l1.25005 1.25c.097.097.146.225.146.353s-.049.256-.146.354c-.195.195-.512.195-.707 0l-1.09505-1.095c-.212-.212-.581-.212-.793 0-.106.106-.164.247-.164.396s.058.291.164.396l2.59505 2.595c.097.098.146.226.146.354s-.049.256-.146.354c-.195.195-.512.195-.707 0z"/></g></svg>
                    </span>
                </p>
           </li>
        </ul>

</div>
