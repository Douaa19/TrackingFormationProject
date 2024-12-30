

@php
   $routes = ['password.reset','password.verify.code','password.request','login','registration.verify.code','register'];
@endphp


<header class="header @if(!request()->routeIs('home') ) header-two @endif">

    <div class="container-xl container-fluid">
        <div class="header-wrap">
            <a href="{{route('home')}}" class="site-logo">
                <img src="{{ getImageUrl(getFilePaths()['site_logo']['path']."/".site_settings('frontend_logo')) }}" alt="{{site_settings('frontend_logo')}}">
            </a>

            <div class="main-nav">
                <div class="nav-menu-wrap">
                    <div class="d-flex align-items-center justify-content-between w-100">
                        <div class="mobile-site-logo">
                            <img src="{{ getImageUrl(getFilePaths()['site_logo']['path']."/".site_settings('frontend_logo')) }}" alt="{{site_settings('frontend_logo')}}" >
                        </div>
                        <div class="close-sidebar d-lg-none">
                            <i class="bi bi-x"></i>
                        </div>
                    </div>

                    <nav class="nav-menu me-lg-5">
                        <ul>
                             @foreach($menus as $menu)
                                <li>
                                    @php

                                        if($menu->url != url('/') && $menu->url ==  url()->current()){
                                                $class = 'active';
                                        }

                                    @endphp

                                    <a class="{{@$class}}" href="{{url($menu->url)}}">
                                      {{$menu->name}}
                                    </a>

                                 </li>
                             @endforeach
                        </ul>
                    </nav>
                    <a href="{{route("ticket.search")}}" class="header-search d-lg-none d-flex">
                        <i class="bi bi-compass"></i>
                      	<span>
                            {{translate("Track")}}
                        </span>
                    </a>

                    @if(!auth_user("web"))
                        <a href="{{route('ticket.create')}}" class="Btn btn--sm secondary-btn btn-icon-hover header-button d-flex d-lg-none mt-3">
                            <span class="show-content-one">
                                {{translate('Create Ticket')}}
                            </span>
                            <i class="bi bi-arrow-right-short"></i>
                        </a>

                        <a href="{{route('login')}}" class="Btn btn--sm primary-btn btn-icon-hover header-button d-flex d-lg-none">
                            <span class="show-content-one">
                                {{translate('Login')}}
                            </span>
                            <i class="bi bi-arrow-right-short"></i>
                        </a>
                    @endif

                </div>
                <div class="main-nav-overlay d-lg-none"></div>
            </div>

            <div class="header-right">
                <a href="{{route("ticket.search")}}" class="header-search d-lg-flex d-none">
                    <i class="bi bi-compass"></i><span>
                        {{translate("Track")}}
                    </span>
                </a>

                <div class="dropdown topbar-head-dropdown header-item language-dropdown">
                    @php
                        $lang = $languages->where('code',session()->get('locale'));

                        $code = count($lang)!=0 ? $lang->first()->code:"en";
                        $languages = $languages->where('code','!=',$code)->where('status',App\Enums\StatusEnum::true->status());
                    @endphp
                    <button type="button" class="btn-icon topbar-btn btn-ghost-secondary"
                    @if(count($languages) != 0) data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" @endif>
                        <img id="header-lang-img" src="{{asset('assets/images/global/flags/'.strtoupper($code ).'.png') }}" alt="{{strtoupper($code ).'.png'}}" height="20">
                    </button>
                    @if(count($languages) != 0)
                        <div class="dropdown-menu dropdown-menu-end">
                            @foreach($languages as $language)
                                <a href="{{route('language.change',$language->code)}}" class="dropdown-item notify-item language py-1" data-lang="{{$language->code}}"
                                    title="{{$language->name}}">
                                    <img src="{{asset('assets/images/global/flags/'.strtoupper($language->code ).'.png') }}" alt="{{$language->code.".png"}}" class="me-2" height="18">
                                    <span class="align-middle">
                                        {{$language->name}}
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>

                @if(auth_user('web'))
                    <div class="dropdown header-item topbar-user">
                        <button type="button"  id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                            @php
                            $url = getImageUrl(getFilePaths()['profile']['user']['path'].'/'.auth_user('web')->image,getFilePaths()['profile']['user']['size']);
                            if(filter_var(auth_user('web')->image, FILTER_VALIDATE_URL) !== false){
                                $url = auth_user('web')->image;
                            }




                           @endphp
                            <div class="header-profile-user">
                                <img src="{{  $url }}"
                                    alt="{{auth_user('web')->image}}">

                            </div>
                        </button>

                        <div class="dropdown-menu dropdown-menu-end">
                            <h6 class="dropdown-header">
                                {{translate('Welcome')}}
                                {{auth_user('web')->name}}
                            </h6>

                            <a class="dropdown-item" href="{{route('ticket.create')}}"><i
                                class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i>
                                <span class="align-middle">
                                        {{translate('Create Ticket')}}
                                </span>
                            </a>

                            <a class="dropdown-item" href="{{route('user.dashboard')}}"><i
                                class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i><span
                                class="align-middle">
                                       {{translate('Dashboard')}}
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
                @endif

                @if(!auth_user("web"))
                    <a href="{{route('ticket.create')}}" class="Btn btn--sm secondary-btn btn-icon-hover header-button d-sm-flex d-none">
                        <span class="show-content-one">
                            {{translate('Create Ticket')}}
                        </span>
                        <i class="bi bi-arrow-right-short"></i>
                    </a>

                    <a href="{{route('login')}}" class="Btn btn--sm primary-btn-outline btn-icon-hover header-button d-sm-flex d-none">
                        <span class="show-content-one">
                            {{translate('Login')}}
                        </span>
                        <i class="bi bi-arrow-right-short"></i>
                    </a>
                @endif

                <div class="d-lg-none">
                    <span class="bars"><i class="bi bi-list"></i></span>
                </div>
            </div>
        </div>

    </div>
</header>
