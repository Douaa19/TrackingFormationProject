<div class="app-menu navbar-menu">
    <div class="brand-logo">
        <a href="{{route('user.dashboard')}}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ getImageUrl(getFilePaths()['site_logo']['path']."/".site_settings('site_logo_sm')) }}" alt="{{site_settings('site_logo_sm')}}" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ getImageUrl(getFilePaths()['site_logo']['path']."/".site_settings('site_logo_lg')) }}" alt="{{site_settings('site_logo_lg')}}" width="180">
            </span>
        </a>

        <a href="{{route('user.dashboard')}}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ getImageUrl(getFilePaths()['site_logo']['path']."/".site_settings('site_logo_sm')) }}" alt="{{site_settings('site_logo_sm')}}" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ getImageUrl(getFilePaths()['site_logo']['path']."/".site_settings('site_logo_lg')) }}" alt="{{site_settings('site_logo_lg')}}" width="180">
            </span>
        </a>

        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar" class="scroll-bar" data-simplebar>
        <div class="container-fluid">
            <div id="two-column-menu"></div>

            <ul class="navbar-nav gap-1" id="navbar-nav">
                <li class="menu-title"><span>{{translate('Menu')}}</span></li>

                <li class="nav-item">
                    <a target="_blank" class="nav-link menu-link {{request()->routeIs('home') ? 'active' : ''}}" href="{{route('home')}}">
                        <i class='bx bx-world' ></i> <span>{{translate('Home')}}</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link {{request()->routeIs('user.dashboard') ? 'active' : ''}}" href="{{route('user.dashboard')}}">
                        <i class="bx bxs-dashboard"></i> <span>{{translate('Dashboard')}}</span>
                    </a>
                </li>
                @if(site_settings(key:'envato_verification',default:0) == 1)
                    <li class="nav-item">
                        <a class="nav-link menu-link {{request()->routeIs('user.envato.purchase.*') ? 'active' : ''}}" href="{{route('user.envato.purchase.list')}}">
                            <i class='bx bx-shopping-bag'></i> <span>{{translate('Envato Purchases')}}</span>
                        </a>
                    </li>
                @endif

                @if(site_settings('chat_module') == App\Enums\StatusEnum::true->status())
                    <li class="nav-item">
                        <a class="nav-link menu-link {{request()->routeIs('user.chat.list') ? 'active' : ''}}" href="{{route('user.chat.list')}}">
                            <i class='bx bx-chat'></i> <span>{{translate('Chat')}}</span>
                        </a>
                    </li>
                @endif

                <li class="nav-item">
                    <a class="nav-link menu-link
                        {{request()->routeIs('user.ticket.*')?'active' :''}}
                    "href="{{route('user.ticket.list')}}">
                    <i class='bx bxs-paper-plane' ></i> <span>
                            {{translate('Manage Ticket')}}
                        </span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link
                        {{request()->routeIs('user.canned.*')?'active' :''}}
                    " href="{{route('user.canned.reply.list')}}">
                        <i class="ri-translate"></i> <span>
                            {{translate('Canned Reply')}}
                        </span>
                    </a>
                </li>


                <li class="nav-item">
                        <a class="nav-link menu-link {{request()->routeIs('user.notification.settings') ? 'active' : ''}}" href="{{route('user.notification.settings')}}">
                            <i class="bx bx-cog"></i> <span>{{translate('Notification Settings')}}</span>
                        </a>
                </li>
                
                <li class="nav-item">
                        <a class="nav-link menu-link " href="{{route('user.ticket.view',$ticket->ticket_number)}}">
                        <i class='bx bx-chat'></i>{{translate('discuter avec ocf')}}</span>
                        </a>
                </li>

            </ul>
        </div>
    </div>
    <div class="sidebar-background"></div>
</div>
