<header id="header">
    <div class="header-layout">
        <div class="header-navbar">
            <div class="d-flex">
                <div class="brand-logo horizontal-logo">
                    <a href="{{route('admin.dashboard')}}" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="{{ getImageUrl(getFilePaths()['site_logo']['path']."/".site_settings('site_logo_sm')) }}" alt="{{site_settings('site_logo_sm')}}" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ getImageUrl(getFilePaths()['site_logo']['path']."/".site_settings('site_logo_lg')) }}" alt="{{site_settings('site_logo_lg')}}" height="17">
                        </span>
                    </a>
                </div>

                <div class="header-action-btn d-flex align-items-center me-md-2 me-xl-3">
                    <button type="button"
                        class="btn btn-sm px-3 fs-22 vertical-menu-btn hamburger-btn btn-ghost-secondary topbar-btn btn-icon rounded-circle waves ripple-dark"
                        id="hamburger-btn">
                        <i class='bx bx-chevrons-left'></i>
                    </button>

                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="{{translate('Clear Cache')}}" href="{{route("admin.setting.cache.clear")}}"
                        class="btn btn-sm fs-22 btn-icon topbar-btn btn-ghost-secondary rounded-circle waves ripple-dark">
                        <i class='bx bx-brush'></i>
                    </a>
                    <a target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" title="{{translate('Browse Frontend')}}" href="{{route("home")}}"
                        class="btn btn-sm fs-22 btn-icon topbar-btn btn-ghost-secondary rounded-circle waves ripple-dark">
                        <i class='bx bx-world'></i>
                    </a>
                </div>
            </div>

            <div class="d-flex align-items-center">

                <div class="dropdown ms-1 topbar-head-dropdown header-item language-dropdown">
                    @php
                        $lang = $languages->where('code',session()->get('locale'));

                        $code = count($lang)!=0 ? $lang->first()->code:"en";
                        $languages = $languages->where('code','!=',$code)->where('status',App\Enums\StatusEnum::true->status());
                    @endphp
                    <button type="button" class="btn btn-icon topbar-btn btn-ghost-secondary rounded-circle"
                    @if(count($languages) != 0) data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" @endif>
                        <img id="header-lang-img" src="{{asset('assets/images/global/flags/'.strtoupper($code ).'.png') }}" alt="{{strtoupper($code ).'.png'}}" height="20"
                            class="rounded">
                    </button>
                    @if(count($languages) != 0)
                        <div class="dropdown-menu dropdown-menu-end" data-simplebar>
                            @foreach($languages as $language)
                                <a href="javascript:void(0);" class="dropdown-item notify-item language py-2" data-lang="{{$language->code}}"
                                    title="{{$language->name}}">
                                    <img src="{{asset('assets/images/global/flags/'.strtoupper($language->code ).'.png') }}" alt="{{strtoupper($language->code ).'.png'}}" class="me-2 rounded" height="18">
                                    <span class="align-middle">
                                        {{$language->name}}
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>

                @php
                  $counter = auth_user()->unreadNotifications()->count();
                @endphp


                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button"
                            class="btn btn-icon topbar-btn btn-ghost-secondary rounded-circle waves ripple-dark"
                            data-toggle="fullscreen">
                        <i class='bx bx-fullscreen fs-22'></i>
                    </button>
                </div>

                @if(site_settings('database_notifications') == App\Enums\StatusEnum::true->status())
                    <div class="dropdown topbar-head-dropdown ms-1 header-item" id="notificationDropdown">
                        <button type="button" class="btn btn-icon topbar-btn btn-ghost-secondary rounded-circle"
                                id="page-header-notifications-dropdown" data-bs-toggle="dropdown"
                                data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
                            <i class='bx bx-bell fs-22'></i>
                                @if($counter != 0)
                                    <span class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger">
                                            {{$counter}}
                                        <span
                                            class="visually-hidden">
                                            {{translate('Unread Notifications')}}
                                        </span>
                                    </span>
                                @endif
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                            aria-labelledby="page-header-notifications-dropdown">

                            <div class="dropdown-head bg-primary rounded-top">
                                <div class="p-3">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="m-0 fs-16 fw-semibold text-white">    {{translate("Notifications")}} </h6>
                                        </div>
                                        @if($counter != 0)
                                            <div class="col-auto dropdown-tabs">
                                                <a href="{{route('admin.clear.notification')}}" class="btn btn-sm btn-danger add-btn waves ripple-light">
                                                    <i class="ri-delete-bin-4-line  me-1"></i>
                                                {{translate('Clear all')}}
                                               </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="tab-content position-relative" id="notificationItemsTabContent">
                                <div class="tab-pane fade show active" id="all-noti-tab" role="tabpanel">
                                    <div data-simplebar class="mxh-300 pe-2">


                                        @if($counter != 0)
                                            @foreach(auth_user()->unreadNotifications->take(6) as $notification)
                                                <div class="text-reset notification-item d-block dropdown-item position-relative">
                                                    <div class="d-flex">


                                                        @php
                                                            $imgUlr = route('default.image',"150x150");
                                                            if($notification->admin){
                                                                $imgUlr = getImageUrl(getFilePaths()['profile']['admin']['path'].'/'.$notification->admin->image,getFilePaths()['profile']['admin']['size']);
                                                            }
                                                            elseif($notification->user){
                                                                $imgUlr = getImageUrl(getFilePaths()['profile']['user']['path'].'/'.$notification->user->image,getFilePaths()['profile']['user']['size']);
                                                            }
                                                       @endphp

                                                        <img src="{{$imgUlr}}"
                                                            class="me-2 rounded-circle avatar-xs" alt="profile.jpg">



                                                        <div class="flex-1">
                                                            @php
                                                              $data = $notification->data ? json_decode($notification->data,true) :[];
                                                            @endphp
                                                            <h6 class="mt-0 mb-1 fs-12 fw-semibold">
                                                                @if($notification->notify_by)

                                                                    @if($notification->admin)
                                                                        {{$notification->admin->name}}
                                                                    @elseif($notification->user)
                                                                        {{$notification->user->name}}
                                                                    @else
                                                                        {{translate("N/A")}}
                                                                    @endif

                                                                @else
                                                                    {{Arr::get($data,"name","demo")}}
                                                                @endif
                                                            </h6>


                                                            <div class="fs-12 text-muted">
                                                                @if(isset($data['route']))
                                                                    <a id="{{$notification->id}}" data-href= "{{($data['route'])}}" href="javascript:void(0)" class="read-notification mb-1">
                                                                        @if(isset($data['messsage']))
                                                                            {{$data['messsage']}}
                                                                            🔔.
                                                                        @endif

                                                                    </a>
                                                                @endif
                                                            </div>
                                                            <p class="mb-0 mt-2 fs-10 fw-medium text-uppercase text-muted">
                                                                <span><i class="mdi mdi-clock-outline"></i>
                                                                    {{getTimeDifference($notification->created_at)}}
                                                                </span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                            <div class="my-3 text-center view-all">
                                                <a href="{{route('admin.notifications')}}" class="btn btn-soft-success ">
                                                    {{translate("View All Notifications")}}
                                                    <i class="ri-arrow-right-line align-middle"></i></a>
                                            </div>
                                        @else
                                            <p class="text-center mt-3">{{translate('No New Notificatios')}}</p>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="dropdown ms-sm-3 ms-2 header-item topbar-user">
                    <button type="button" class="btn p-0" id="page-header-user-dropdown"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <img class="rounded-circle header-profile-user" src="{{getImageUrl(getFilePaths()['profile']['admin']['path'].'/'.auth_user()->image,getFilePaths()['profile']['admin']['size'])}}"
                                alt="{{auth_user()->image}}">
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">
                                    {{auth_user()->name}}
                                </span>
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">

                        <h6 class="dropdown-header">
                            {{translate('Welcome')}}
                            {{auth_user()->name}}</h6>
                              <a class="dropdown-item" href="{{route('admin.profile.index')}}"><i
                                class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span
                                class="align-middle">
                               {{translate('Profile')}}
                            </span></a>


                            <a class="dropdown-item" href="{{route('admin.password')}}"><i
                                class="mdi mdi-key text-muted fs-16 align-middle me-1"></i> <span
                                class="align-middle">
                               {{translate('Password')}}
                            </span></a>

                            <a class="dropdown-item" href="{{route('admin.dashboard')}}"><i
                                class="mdi mdi-view-dashboard text-muted fs-16 align-middle me-1"></i> <span
                                class="align-middle">
                               {{translate('Dashboard')}}
                            </span></a>


                            <a class="dropdown-item" href="{{route('admin.logout')}}"><i
                                    class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span
                                    class="align-middle">
                                    {{translate('Logout')}}
                                </span>
                            </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const languageLinks = document.querySelectorAll('.dropdown-item.language');
        
            languageLinks.forEach(link => {
                link.addEventListener('click', function () {
                    const languageCode = this.getAttribute('data-lang');
                
                    fetch(`{{ route('language.change', '') }}/${languageCode}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token
                        },
                        body: JSON.stringify({ language: languageCode })
                    })
                    .then(response => {
                        if (response.ok) {
                            location.reload(); // Reload the page to reflect the language change
                        } else {
                            console.error('Failed to change language');
                        }
                    })
                    .catch(error => console.error('Error:', error));
                });
            });
        });
    </script>

</header>
