<div class="p-2 p-lg-3 user-chat-topbar ">
    <div class="row g-2 align-items-center">
        <div class="col-sm-6">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0 d-block d-lg-none me-3">
                    <a href="javascript: void(0);"
                        class="user-chat-remove btn fs-20 btn-icon bg-light rounded-circle waves ripple-dark text-dark">
                        <i class="ri-menu-2-line align-bottom"></i>
                    </a>
                </div>
                <div class="flex-grow-1 overflow-hidden">
                    <div class="d-flex align-items-center">
                        <div @php
                            $url = getImageUrl(getFilePaths()['profile']['user']['path'] . '/' . $user->image, getFilePaths()['profile']['user']['size']);
                            if (filter_var($user->image, FILTER_VALIDATE_URL) !== false) {
                                $url = $user->image;
                            }
                        @endphp
                            class="flex-shrink-0 chat-user-img online user-own-img align-self-center me-2 ms-0">
                            <img src="{{$url }}" class="rounded-circle avatar-xs" alt="{{$user->image}}" />

                        </div>
                        <div class="flex-grow-1 overflow-hidden">
                            <h5 class="text-truncate mb-0 fs-16">
                                {{$user->name ? $user->name : $user->email  }}
                            </h5>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        

        @php

            $flag = App\Enums\StatusEnum::false->status();
            $muted = App\Enums\StatusEnum::false->status();
            $block_list_user = json_decode(auth_user()->blocked_user, true) ? json_decode(auth_user()->blocked_user, true) : [];
            $muted_user = json_decode(auth_user()->muted_user, true) ? json_decode(auth_user()->muted_user, true) : [];
            $muted_class = 'ri-notification-off-line';
            if (in_array($user->id, $block_list_user)) {
                $flag = App\Enums\StatusEnum::true->status();
            }
            if (in_array($user->id, $muted_user)) {
                $muted = App\Enums\StatusEnum::true->status();
                $muted_class = 'ri-notification-4-line';
            }

        @endphp

        <div class="col-sm-6">
            <ul class="list-inline user-chat-nav text-end mb-0">
                @if(count($chat_messages) != 0)
                    <li class="list-inline-item m-0" data-bs-toggle="tooltip" data-bs-trigger="hover"
                        data-bs-placement="top" title="{{translate("Delete Conversation")}}">
                        <form action="{{route('admin.chat.delete.conversation')}}" method="post">
                            @csrf
                            @if($anonymous)
                                <input type="hidden" name="anonymous" value="{{$anonymous}}">
                            @endif
                            <input type="hidden" name="user_id" value="{{$user->id}}">
                            <button type="submit" class="btn btn-danger btn-icon">
                                <i class="ri-delete-bin-5-line icon-sm"></i>
                            </button>
                        </form>
                    </li>
                @endif

                <li class="list-inline-item ms-2" data-bs-toggle="tooltip" data-bs-trigger="hover"
                    data-bs-placement="top" title="Block">

                    <form id="block-form" method="post">

                        @csrf

                        @if($anonymous)
                                                <input type="hidden" name="anonymous" value="{{$anonymous}}">
                                                @php
                                                    $flag = $user->is_closed == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::true->status() : App\Enums\StatusEnum::false->status();
                                                @endphp
                        @endif

                        <input type="hidden" name="user_id" value="{{$user->id}}">

                        <button id="block-user" type="submit"
                            class="btn btn-{{$flag == App\Enums\StatusEnum::false->status() ? 'danger' : "success" }} btn-icon">
                            <i
                                class="ri-user-{{$flag == App\Enums\StatusEnum::false->status() ? 'un' : "" }}follow-line icon-sm"></i>
                        </button>

                    </form>
                </li>

                @if(!$anonymous)

                    <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top"
                        title="{{translate("Mute User")}}">

                        <form id="mute-form" method="post">
                            @csrf
                            <input type="hidden" name="user_id" value="{{$user->id}}">

                            <button id="mute-user" type="submit"
                                class="mute-btn btn btn-{{$muted == App\Enums\StatusEnum::false->status() ? 'danger' : "success" }} btn-icon">
                                <i class="mute-icon {{$muted_class}} icon-sm"></i>
                            </button>
                        </form>
                    </li>

                @endif


                @if($anonymous)


                                @php

                                    $agents = App\Models\Admin::agent()
                                        ->where('id', '!=', auth_user()->id)
                                        ->active()
                                        ->get();

                                @endphp

                                <li class="list-inline-item d-none d-lg-inline-block m-0 dropdown" data-bs-toggle="tooltip"
                                    data-bs-trigger="hover" data-bs-placement="top" title="{{translate("Assign")}}">
                                    <button class=" btn btn-info btn-icon" type="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <i class="ri-user-add-line align-bottom"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end">

                                        @foreach($agents as $agent)
                                            <button data-anonymous="{{$anonymous}}" value="{{ $agent->id}}" name="assign" id="assignBtn"
                                                class="dropdown-item">
                                                {{translate('To ') . $agent->name}}
                                            </button>
                                        @endforeach

                                    </div>
                                </li>

                                <form hidden id="assignForm" action="{{route("admin.chat.assign")}}" method="post">
                                    @csrf

                                    <input type="hidden" name="id" id="agentId">
                                    <input type="hidden" name="anonymous_id" id="chatId">

                                </form>


                @endif

            </ul>
        </div>

    </div>
</div>
