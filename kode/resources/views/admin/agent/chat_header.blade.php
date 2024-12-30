<div class="p-2 p-lg-3 user-chat-topbar ">
    <div class="row g-2 align-items-center">
        <div class="col-sm-6">
            <div class="d-flex align-items-center">
                <div
                    class="flex-shrink-0 d-block d-lg-none me-3">
                    <a href="javascript:void(0);"
                        class="user-chat-remove btn fs-20 btn-icon bg-light rounded-circle waves ripple-dark text-dark">
                        <i class="ri-menu-2-line align-bottom"></i>
                    </a>
                </div>
                @php
                    $flag = App\Enums\StatusEnum::false->status();
                    $block_list_user = json_decode($agent->blocked_user,true) ? json_decode($agent->blocked_user,true) :[];
                    if(in_array($user->id ,   $block_list_user)){
                      $flag = App\Enums\StatusEnum::true->status();
                    }
                @endphp
                <div class="flex-grow-1 overflow-hidden">
                    <div class="d-flex align-items-center">
                        <div
                            @php
                                $url = getImageUrl(getFilePaths()['profile']['user']['path'].'/'.$user->image,getFilePaths()['profile']['user']['size']);
                                if(filter_var($user->image, FILTER_VALIDATE_URL) !== false){
                                    $url = $user->image;
                                }
                            @endphp
                            class="flex-shrink-0 chat-user-img online user-own-img align-self-center me-2 ms-0">
                            <img src="{{$url}}"
                                class="rounded-circle avatar-xs"
                                alt="{{$user->image}}" />

                        </div>
                        <div
                            class="flex-grow-1 overflow-hidden">
                            <h5
                                class="text-truncate mb-0 fs-16">
                                {{$user->name}}  @if($flag == App\Enums\StatusEnum::true->status())<span class="text-danger">
                                    ({{translate('User Blocked')}})
                                </span> @endif
                            </h5>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <ul class="list-inline user-chat-nav text-end mb-0">
                @if(count($chat_messages) != 0)
                    <li
                        class="list-inline-item m-0">
                        <form action="{{route('admin.agent.delete.conversation')}}" method="post">
                            @csrf
                            <input type="hidden" name="user_id" value="{{$user->id}}">
                            <input type="hidden" name="agent_id" value="{{$agent->id}}">
                            <button type="submit"
                                class="btn btn-danger btn-icon">
                                <i class="ri-delete-bin-5-line icon-sm"></i>
                            </button>
                        </form>
                    </li>
                @endif

                <li
                    class="list-inline-item ms-2">

                    <form  id="block-form" method="post">
                        @csrf
                        <input type="hidden" name="user_id" value="{{$user->id}}">
                        <input type="hidden" name="agent_id" value="{{$agent->id}}">

                        <button id="block-user" type="submit"
                            class="btn btn-{{$flag == App\Enums\StatusEnum::false->status()?'danger':"success" }} btn-icon">
                            <i class="ri-user-{{$flag == App\Enums\StatusEnum::false->status() ?'un':"" }}follow-line icon-sm"></i>

                        </button>
                    </form>
                </li>

            </ul>
        </div>

    </div>
</div>
