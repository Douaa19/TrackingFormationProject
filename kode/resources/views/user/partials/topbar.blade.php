<header id="header">
    <div class="header-layout">
        <div class="header-navbar">

                <div class="d-flex">
                <!-- LOGO -->
                <div class="brand-logo horizontal-logo">

                    <a href="{{route('user.dashboard')}}" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="{{ getImageUrl(getFilePaths()['site_logo']['path']."/".site_settings('site_logo_sm')) }}" alt="{{site_settings('site_logo_sm')}}" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ getImageUrl(getFilePaths()['site_logo']['path']."/".site_settings('site_logo_lg')) }}" alt="{{site_settings('site_logo_lg')}}" height="17">
                        </span>
                    </a>
                </div>
                <div class="header-action-btn d-flex gap-2 align-items-center me-md-2 me-xl-3">
                    <button type="button"
                        class="btn btn-sm px-3 fs-22 vertical-menu-btn hamburger-btn btn-ghost-secondary topbar-btn btn-icon rounded-circle waves ripple-dark"
                        id="hamburger-btn">
                        <i class='bx bx-chevrons-left'></i>
                    </button>



                    {{-- <a href="{{route('ticket.create')}}" class="btn btn-primary btn-sm  waves ripple-light">
                        <i class="ri-add-line align-bottom me-1"></i>
                            {{translate('Create Ticket')}}
                    </a> --}}

                </div>
            </div>

            <div class="d-flex align-items-center">

                <div class="dropdown ms-1 topbar-head-dropdown header-item">
                    @php
                        $lang = $languages->where('code',session()->get('locale'));

                        $code = count($lang)!=0 ? $lang->first()->code:"en";
                        $languages = $languages->where('code','!=',$code)->where('status','1');
                    @endphp
                    <button type="button" class="btn btn-icon topbar-btn btn-ghost-secondary rounded-circle"
                    @if(count($languages) != 0)
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" @endif>
                        <img id="header-lang-img" src="{{asset('assets/images/global/flags/'.strtoupper($code ).'.png') }}" alt="{{strtoupper($code ).'.png'}}" height="20"
                            class="rounded">
                    </button>
                    @if(count($languages) != 0)
                        <div class="dropdown-menu dropdown-menu-end">
                            @foreach($languages as $language)
                                <a href="{{route('language.change',$language->code)}}" class="dropdown-item notify-item language py-2" data-lang="{{$language->code}}"
                                    title="{{$language->name}}">
                                    <img src="{{asset('assets/images/global/flags/'.strtoupper($language->code ).'.png') }}" alt="{{$language->code.".jpg"}}" class="me-2 rounded" height="18">
                                    <span class="align-middle">
                                        {{$language->name}}
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>

                @php
                   $counter = auth_user('web')->unreadNotifications()->count();
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
                                            <h6 class="m-0 fs-16 fw-semibold text-white">
                                                {{translate("Notifications")}}
                                            </h6>
                                        </div>
                                        @if($counter != 0)
                                            <div class="col-auto dropdown-tabs">
                                                <span class="badge badge-soft-light fs-13">
                                                    {{$counter}} {{translate("New")}}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="tab-content position-relative" id="notificationItemsTabContent">
                                <div class="tab-pane fade show active" id="all-noti-tab" role="tabpanel">

                                    <div data-simplebar  class="mxh-300 pe-2">
                                        @if($counter != 0)
                                            @foreach(auth_user('web')->unreadNotifications->take(6) as $notification)
                                                <div class="text-reset notification-item d-block dropdown-item position-relative">
                                                    <div class="d-flex">
                                                        @if($notification->admin)
                                                        <img src="{{getImageUrl(getFilePaths()['profile']['admin']['path'].'/'.$notification->admin->image,getFilePaths()['profile']['admin']['size'])}}"
                                                            class="me-2 rounded-circle avatar-xs" alt="{{$notification->admin->image}}">
                                                        @endif
                                                        <div class="flex-1">

                                                            @php
                                                               $data = $notification->data ? json_decode($notification->data,true) :[];
                                                            @endphp

                                                            <h6 class="mt-0 mb-1 fs-12 fw-semibold">
                                                                @if($notification->notify_by)

                                                                   {{$notification->admin? $notification->admin->name : 'N/A'}}
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
                                                <a href="{{route('user.notifications')}}"  class="btn btn-soft-success ">
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


                            @php
                                $url = getImageUrl(getFilePaths()['profile']['user']['path'].'/'.auth_user('web')->image,getFilePaths()['profile']['user']['size']);
                                if(filter_var(auth_user('web')->image, FILTER_VALIDATE_URL) !== false){
                                    $url = auth_user('web')->image;
                                }




                            @endphp

                            <img class="rounded-circle header-profile-user" src="{{$url}}"
                                alt="{{auth_user('web')->image}}">
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">
                                    {{auth_user('web')->name}}
                                </span>
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <h6 class="dropdown-header">
                            {{translate('Welcome')}}
                            {{auth_user('web')->name}}</h6>
                              <a class="dropdown-item" href="{{route('user.profile')}}"><i
                                class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i><span
                                class="align-middle">
                               {{translate('Settings')}}
                               </span>
                             </a>

                        <a class="dropdown-item" href="{{route('user.logout')}}"><i
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
</header>
