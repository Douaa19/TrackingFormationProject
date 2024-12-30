
@php
$muted = App\Enums\StatusEnum::false->status();
$muted_agent = json_decode(auth_user('web')->muted_agent,true) ? json_decode(auth_user('web')->muted_agent,true) :[];
$muted_class = 'ri-notification-off-line';

if(in_array($agent->id ,   $muted_agent)){
    $muted = App\Enums\StatusEnum::true->status();
    $muted_class = 'ri-notification-4-line';
}
@endphp
<div class="p-2 p-lg-3 user-chat-topbar ">
<div class="row g-2 align-items-center">
    <div class="col-sm-6">
        <div class="d-flex align-items-center">
            <div
                class="flex-shrink-0 d-block d-lg-none me-3">
                <a href="javascript: void(0);"
                    class="user-chat-remove btn fs-20 btn-icon bg-light rounded-circle waves ripple-dark text-dark"
                    >
                     <i class="ri-menu-2-line align-bottom"></i>
                </a>
            </div>

            <div class="flex-grow-1 overflow-hidden">
                <div class="d-flex align-items-center">
                    <div
                        class="flex-shrink-0 chat-user-img online user-own-img align-self-center me-2 ms-0">
                        <img src="{{getImageUrl(getFilePaths()['profile']['admin']['path']."/". $agent->image) }}"
                            class="rounded-circle avatar-xs"
                            alt="{{$agent->image}}" />

                    </div>
                    <div
                        class="flex-grow-1 overflow-hidden">
                        <h5
                            class="text-truncate mb-0 fs-16">
                            {{$agent->name}}
                        </h5>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <ul class="list-inline user-chat-nav text-end mb-0">


            <li
                class="list-inline-item">

                <form  id="mute-form" method="post">
                    @csrf
                    <input type="hidden" name="agent_id" value="{{$agent->id}}">

                    <button id="mute-agent" type="submit"
                        class="mute-btn btn btn-{{$muted == App\Enums\StatusEnum::false->status()?'danger':"success" }} btn-icon">
                        <i class="mute-icon {{$muted_class}} icon-sm"></i>
                    </button>
                </form>
            </li>

        </ul>
    </div>
</div>
</div>





