<div class="app-menu navbar-menu">
    <div class="brand-logo">
        <a href="{{route('admin.dashboard')}}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ getImageUrl(getFilePaths()['site_logo']['path']."/".site_settings('site_logo_sm')) }}" alt="{{site_settings('site_logo_sm')}}" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ getImageUrl(getFilePaths()['site_logo']['path']."/".site_settings('site_logo_lg')) }}" alt="{{site_settings('site_logo_lg')}}" height="35">
            </span>
        </a>

        <a href="{{route('admin.dashboard')}}" class="logo logo-light">
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

                @if(check_agent('view_dashboard'))
                   <li class="menu-title"><span>{{translate('Menu')}}</span></li>
                    <li class="nav-item">

                        <a class="nav-link menu-link {{request()->routeIs('admin.dashboard') ? 'active' : ''}}" href="{{route('admin.dashboard')}}">
                            <i class="ri-dashboard-line"></i> <span>{{translate('Dashboard')}}</span>
                        </a>
                    </li>
                @endif


                @if(site_settings('chat_module') == App\Enums\StatusEnum::true->status())
                    <li class="nav-item">
                        <a class="nav-link menu-link {{url()->current() === url('admin/tickets/testmsg') ? 'active' : ''}}" href="{{ url('admin/tickets/testmsg') }}">
                            <i class="ri-message-2-line"></i> <span>{{translate('Messenger')}}</span>
                        </a>
                    </li>
               @endif



                @if(check_agent('manage_tickets') || check_agent('manage_category') ||  check_agent('manage_priorites'))
                  <li class="menu-title"><span>{{translate('Tickets,Agents & Users')}}</span></li>
                @endif


                <!-- @if(check_agent('manage_tickets'))
                    <li class="nav-item">

                        <a class="nav-link menu-link {{   (!request()->routeIs('admin.ticket.*') || !request()->routeIs('admin.canned.*') ||  !request()->routeIs('admin.category.*') || !request()->routeIs('admin.priority.*')) && request()->routeIs('admin.ticket.pending') ?"collapsed" :""  }}  " @if($pending_tickets > 0)  data-toggle="tooltip" data-placement="top" title="{{translate('Pending Tickets: ').$pending_tickets}}" @endif     href="#manageTicket" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="manageTicket">
                            <i class="ri-mail-send-line"></i><span>
                                {{translate('Tickets')}} 
                            </span>
                            @if($pending_tickets > 0)
                                <i class="ri-error-warning-line notify-icon link-danger" ></i>
                            @endif
                      
                        </a>
                        
                        <div 
                            {{translate('Tickets Lists')}} class="pt-1 collapse {{ request()->routeIs('admin.ticket.*') && !request()->routeIs('admin.ticket.pending')    ?"show" :""  }}  menu-dropdown" id="manageTicket">
                            <ul class="nav nav-sm flex-column gap-1">

                                @if(check_agent('manage_tickets'))
                                    <li class="nav-item">
                                        <a class="nav-link
                                        {{request()->routeIs('admin.ticket.*') && !request()->routeIs('admin.ticket.pending')?'active' :''}}
                                        "href="{{route('admin.ticket.list')}}" @if($pending_tickets > 0)  data-toggle="tooltip" data-placement="top" title="{{translate('Pending Tickets: ').$pending_tickets}}" @endif  >
                                                {{translate('Tickets Lists')}}

                                                @if($pending_tickets > 0)
                                                  <span class="badge badge-pill bg-danger" data-key="t-hot">{{$pending_tickets}}</span>
                                                @endif
                                        </a>
                                    </li> 

                                    <li class="nav-item">
                                        <a class="nav-link
                                        {{request()->routeIs('admin.ticket.create')  ?'active' :''}}
                                        "href="{{route('admin.ticket.create')}}">
                                                {{translate('Create Ticket')}}

                                        </a>
                                    </li> 
                                @endif
                            </ul>
                        </div>
                    </li>

                @endif -->

                @if( check_agent('system_configuration') || check_agent('manage_tickets') || check_agent('manage_category') ||  check_agent('manage_priorites'))

    
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ !request()->routeIs('admin.setting.ticket.*') ?"collapsed" :""  }}  " href="#ticketConfiguration" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="ticketConfiguration">
                            <i class="ri-tools-line"></i> <span>
                                {{translate('Ticket Configuration')}}
                            </span>
                        </a>

                        <div class="pt-1 collapse  {{ ((request()->routeIs('admin.category.*') && !request()->routeIs('admin.category.article.show') && !request()->routeIs('admin.category.article.create') ) || request()->routeIs('admin.setting.ticket.*') || request()->routeIs('admin.trigger.*')  ||  request()->routeIs('admin.canned.*') ||  request()->routeIs('admin.priority.*')) || request()->routeIs('admin.ticket-status.*') ||  request()->routeIs('admin.department.*')    ?"show" :""  }}   
                            menu-dropdown" id="ticketConfiguration">
                            <ul class="nav nav-sm flex-column gap-1">
                                <li class="nav-item">
                                    <a href="{{route('admin.setting.ticket.configuration')}}" class="nav-link {{ request()->routeIs('admin.setting.ticket.configuration')?'active' :""  }}  ">
                                        {{translate('General Configuration')}}
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{route('admin.trigger.list')}}" class="nav-link {{ request()->routeIs('admin.trigger.*')?'active' :""  }}  ">
                                        {{translate('Triggering')}}
                                    </a>
                                </li>
                                @if(check_agent('manage_ticket_status'))
                                    <li class="nav-item">
                                        <a class="nav-link
                                        {{request()->routeIs('admin.ticket-status.*')?'active' :''}}
                                        "href="{{route('admin.ticket-status.list')}}">
                                                {{translate('Ticket Status')}}
                                        </a>
                                    </li>
                                @endif


                                @if(check_agent('manage_product'))
                                    <li class="nav-item">
                                        <a class="nav-link
                                        {{request()->routeIs('admin.department.*')?'active' :''}}
                                        "href="{{route('admin.department.list')}}">
                                                {{translate('Products')}}
                                        </a>
                                    </li>
                                @endif


                                @if(check_agent('manage_priorites'))
                                    <li class="nav-item">
                                        <a class="nav-link
                                        {{request()->routeIs('admin.priority.*')?'active' :''}}
                                        "href="{{route('admin.priority.list')}}">
                                                {{translate('Ticket Priority')}}
                                        </a>
                                    </li>
                                @endif


                                @if(check_agent('manage_category'))
                                    <li class="nav-item">
                                        <a class="nav-link
                                        {{request()->routeIs('admin.category.*') && !request()->routeIs('admin.category.article.show') && !request()->routeIs('admin.category.article.create')?'active' :''}}
                                        "href="{{route('admin.category.index')}}">
                                                {{translate('Ticket Categories')}}
                                        </a>
                                    </li>
                                @endif

                                @if(check_agent('manage_tickets'))

                                    <li class="nav-item">
                                        <a class="nav-link
                                        {{request()->routeIs('admin.canned.*')?'active' :''}}
                                        "href="{{route('admin.canned.reply.list')}}">
                                                {{translate('Predefined Response')}}
                                        </a>
                                    </li>
                                    
                                @endif
                            </ul>
                        </div>



                    </li>
                    
                @endif

                <!-- agent section -->
                @if(auth_user()->agent == App\Enums\StatusEnum::false->status())

                    <li class="nav-item">
                        <a class="nav-link menu-link {{   !request()->routeIs('admin.agent.*') || !request()->routeIs('admin.group.*')  }}  " href="#manageAgent" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="manageAgent">
                            <i class="ri-group-line"></i><span>
                                {{translate('Agent Management')}}
                            </span>
                        </a>

                        <div class="pt-1 collapse {{ request()->routeIs('admin.agent.*') || request()->routeIs('admin.group.*')  ?"show" :""  }}  menu-dropdown" id="manageAgent">
                            <ul class="nav nav-sm flex-column gap-1">

                                    <li class="nav-item">
                                        <a class="nav-link
                                        {{request()->routeIs('admin.agent.create')?'active' :''}}
                                        "href="{{route('admin.agent.create')}}">
                                                {{translate('Add New')}}
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link
                                        {{request()->routeIs('admin.agent.index') ||request()->routeIs('admin.agent.edit') || request()->routeIs('admin.agent.chat.list')?'active' :''}}
                                        "href="{{route('admin.agent.index')}}">
                                                {{translate('Agent List')}}
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link
                                        {{request()->routeIs('admin.group.*')?'active' :''}}
                                        "href="{{route('admin.group.index')}}">
                                                {{translate('Agent Group')}}
                                        </a>
                                    </li>

                            </ul>
                        </div>
                    </li>
                @endif


                <!-- user section -->
                @if(check_agent('manage_users'))
     

                    <li class="nav-item">
                        <a class="nav-link menu-link {{   !request()->routeIs('admin.user.*')  }}  " href="#manageUser" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="manageUser">
                            <i class="ri-team-line"></i><span>
                                {{translate('Manage User')}}
                            </span>
                        </a>

                        <div class="pt-1 collapse {{ request()->routeIs('admin.user.*')  ?"show" :""  }}  menu-dropdown" id="manageUser">
                            <ul class="nav nav-sm flex-column gap-1">

                                    <li class="nav-item">
                                        <a class="nav-link
                                        {{request()->routeIs('admin.user.create')?'active' :''}}
                                        "href="{{route('admin.user.create')}}">
                                                {{translate('Add New')}}
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link
                                        {{request()->routeIs('admin.user.index')?'active' :''}}
                                        "href="{{route('admin.user.index')}}">
                                                {{translate('User List')}}
                                        </a>
                                    </li>

                            </ul>
                        </div>
                    </li>

                @endif


                @if(check_agent('manage_frontends'))
                  <li class="menu-title"><span>{{translate('Appearance & Others')}}</span></li>
                @endif

                <!-- frontend section -->
                @if(check_agent('manage_frontends') ||  check_agent('manage_pages') ||  check_agent('manage_faqs'))
        
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ (!request()->routeIs('admin.frontend.*') || !request()->routeIs('admin.menu.*') || !request()->routeIs('admin.page.*') || !request()->routeIs('admin.faq.*') ) ?"collapsed" :""  }}  " href="#manageFrontend" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="manageFrontend">
                            <i class="ri-earth-line"></i> <span>
                                {{translate('Appearance Settings')}}
                            </span>
                        </a>
                        <div class="pt-1 collapse {{ request()->routeIs('admin.frontend.*') ||  request()->routeIs('admin.menu.*') || request()->routeIs('admin.faq.*') || request()->routeIs('admin.page.*')     ?"show" :""  }}  menu-dropdown" id="manageFrontend">
                            <ul class="nav nav-sm flex-column gap-1">

                                @if(check_agent('manage_frontends'))
                                    <li class="nav-item">
                                        <a class="nav-link
                                            {{request()->routeIs('admin.frontend.*')?'active' :''}}
                                        "href="{{route('admin.frontend.list')}}">

                                                {{translate('Section Manage')}}
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link
                                            {{request()->routeIs('admin.menu.*')?'active' :''}}
                                        "href="{{route('admin.menu.list')}}">

                                                {{translate('Menu Manage')}}

                                        </a>
                                    </li>

                                @endif


                                @if(check_agent('manage_pages'))
                                    <li class="nav-item">
                                        <a class="nav-link
                                            {{request()->routeIs('admin.page.*')?'active' :''}}
                                        "href="{{route('admin.page.list')}}">

                                                {{translate('Dynamic Pages')}}

                                        </a>
                                    </li>
                                @endif


                                @if(check_agent('manage_faqs'))
                                    <li class="nav-item">
                                        <a class="nav-link
                                            {{request()->routeIs('admin.faq.*')?'active' :''}}
                                        "href="{{route('admin.faq.list')}}">

                                                {{translate('FAQ Section')}}

                                        </a>
                                    </li>
                                @endif


                               
                            </ul>
                        </div>
                    </li>
                @endif

            
                @if(check_agent('manage_article'))
                    
                    <li class="nav-item">
                        <a class="nav-link menu-link
                            {{request()->routeIs('admin.knowledgebase.*')?'active' :''}}
                        " href="{{route('admin.knowledgebase.list')}}">
                        <i class="ri-article-line"></i> <span>
                                {{ucfirst(translate('knowledgebase'))}}
                            </span>
                        </a>
                    </li>
                 @endif
                <!-- article section -->
                @if(check_agent('manage_frontends'))
                    <li class="nav-item">

                        <a class="nav-link menu-link {{ (!request()->routeIs('admin.article.*') || !request()->routeIs('admin.category.article.create') || !request()->routeIs('admin.category.article.show')) ?"collapsed" :""  }}  " href="#manageArticle" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="manageArticle">
                            <i class="ri-article-line"></i> <span>
                                {{translate('Article Administration')}}
                            </span>
                        </a>
                        <div class="pt-1 collapse {{ request()->routeIs('admin.article.*') || request()->routeIs('admin.category.article.create') || request()->routeIs('admin.category.article.show')   ?"show" :""  }}  menu-dropdown" id="manageArticle">
                            <ul class="nav nav-sm flex-column gap-1">

                                @if(check_agent('manage_frontends'))


                                    <li class="nav-item">
                                        <a class="nav-link
                                            {{request()->routeIs('admin.article.category') || request()->routeIs('admin.article.category.edit')   ?'active' :''}}
                                        "href="{{route('admin.article.category')}}">
                                                {{translate('Article Topics')}}
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link
                                            {{ !request()->routeIs('admin.article.category.edit') && request()->routeIs('admin.article.category.*')  ?'active' :''}}
                                        "href="{{route('admin.article.category.list')}}">

                                                {{translate('Article Categories')}}

                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link
                                            {{ request()->routeIs('admin.article.create') ||  request()->routeIs('admin.category.article.create')   ?'active' :''}}
                                        "href="{{route('admin.article.create')}}">

                                                {{translate('Add New')}}
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link
                                            {{ request()->routeIs('admin.article.list') || request()->routeIs('admin.article.edit') || request()->routeIs('admin.category.article') ||   request()->routeIs('admin.category.article.show')  ?'active' :''}}
                                        "href="{{route('admin.article.list')}}">

                                                {{translate('Article List')}}
                                        </a>
                                    </li>


                                @endif

                            </ul>
                        </div>
                    </li>
                @endif


                @if(check_agent('manage_frontends') )
                 
                   <li class="nav-item">
                       <a class="nav-link menu-link {{ (!request()->routeIs('admin.contact.subscriber') || !request()->routeIs('admin.contact.list') ) ?"collapsed" :""  }}  " href="#promotional" data-bs-toggle="collapse" role="button"
                           aria-expanded="false" aria-controls="promotional">
                           <i class="ri-funds-line"></i> <span>
                               {{translate('Marketing/Promotion')}}
                           </span>
                       </a>
                       <div class="pt-1 collapse {{ request()->routeIs('admin.contact.subscriber') || request()->routeIs('admin.contact.list')   ?"show" :""  }}  menu-dropdown" id="promotional">
                           <ul class="nav nav-sm flex-column gap-1">

                               @if(check_agent('manage_frontends'))
                                   <li class="nav-item">
                                       <a class="nav-link
                                           {{request()->routeIs('admin.contact.list')?'active' :''}}
                                       "href="{{route('admin.contact.list')}}">
                                               {{translate('Contact Message')}}
                                       </a>
                                   </li>

                                   <li class="nav-item">
                                       <a class="nav-link
                                           {{request()->routeIs('admin.contact.subscriber')?'active' :''}}
                                       "href="{{route('admin.contact.subscriber')}}">
                                               {{translate('Subscribers')}}
                                       </a>
                                   </li>

                               @endif

                           </ul>
                       </div>
                   </li>
                @endif

                <!-- email & sms section -->
                @if(check_agent('mail_configuration') || check_agent('sms_configuration'))
                  <li class="menu-title"><span>{{translate('Email & SMS Config')}}</span></li>
                @endif


                @if(check_agent('mail_configuration'))
                    <li class="nav-item">
                        <a class="nav-link  {{!request()->routeIs('admin.mail.*') ? "collapsed"  :""   }}   menu-link" href="#emailConfiguration" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="emailConfiguration">
                            <i class="ri-mail-settings-line"></i> <span>
                                {{translate('Email Configuration')}}
                            </span>
                        </a>
                        <div class="collapse {{request()->routeIs('admin.mail.*') ? "show"  :""   }}
                        menu-dropdown mt-1" id="emailConfiguration">
                            <ul class="nav nav-sm flex-column gap-1">
                                <li class="nav-item">
                                    <a href="{{route('admin.mail.configuration')}}" class=' {{request()->routeIs('admin.mail.configuration') || request()->routeIs('admin.mail.edit') ? "active"  :""   }}  nav-link'>
                                        {{translate('Outgoing Method')}}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('admin.mail.incoming')}}" class='{{request()->routeIs('admin.mail.incoming') ? 'active' : ''}}  nav-link'>
                                        {{translate('Incoming Method')}}
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{route('admin.mail.global.template')}}" class="

                                    {{request()->routeIs('admin.mail.global.template') ? "active"  :""   }}
                                    nav-link">
                                    {{translate('Global template')}}
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{route('admin.mail.templates.index')}}" class="
                                    {{request()->routeIs('admin.mail.templates.index') || request()->routeIs('admin.mail.templates.edit') ? "active"  :""   }}

                                    nav-link">
                                    {{translate('Mail templates')}}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endif

                @if(check_agent('sms_configuration'))

                    <li class="nav-item">
                        <a class="nav-link menu-link {{ !request()->routeIs('admin.sms.*') ?"collapsed" :""  }}  " href="#smsConfiguration" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="smsConfiguration">
                            <i class="ri-chat-settings-line"></i> <span>
                                {{translate('SMS Configuration')}}
                            </span>
                        </a>
                        <div class="pt-1 collapse {{request()->routeIs('admin.sms.*') ?"show" :""  }}  menu-dropdown" id="smsConfiguration">
                            <ul class="nav nav-sm flex-column gap-1">
                                <li class="nav-item">
                                    <a href="{{route('admin.sms.gateway.index')}}" class="nav-link {{ request()->routeIs('admin.sms.gateway.index') || request()->routeIs('admin.sms.gateway.edit')  ?'active' :""  }}  ">
                                        {{translate('SMS Gateway')}}
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{route('admin.sms.global.template')}}" class=" {{ request()->routeIs('admin.sms.global.template') ?'active' :""  }}  nav-link">
                                    {{translate('Global Setting')}}
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{route('admin.sms.template.index')}}" class=" {{ request()->routeIs('admin.sms.template.index') || request()->routeIs('admin.sms.template.edit')  ?'active' :""  }}  nav-link">
                                    {{translate('SMS templates')}}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endif



                <li class="menu-title"><span>{{translate('Setup & Configurations')}}</span></li>
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ !request()->routeIs('admin.setting.envato.configuration') || !request()->routeIs('admin.notification.settings') || !request()->routeIs('admin.setting.index') || !request()->routeIs('admin.setting.configuration.index') || !request()->routeIs('admin.setting.ai')? "collapsed" :""  }}  " href="#managaeSettings" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="managaeSettings">
                            <i class="ri-settings-line"></i> <span>
                                {{translate('Application Settings')}}
                            </span>
                        </a>
                        <div class="pt-1 collapse {{request()->routeIs('admin.setting.envato.configuration') || request()->routeIs('admin.notification.settings') || request()->routeIs('admin.setting.index') || request()->routeIs('admin.setting.configuration.index') || request()->routeIs('admin.setting.ai')     ?"show" :""  }}  menu-dropdown" id="managaeSettings">
                            <ul class="nav nav-sm flex-column gap-1">

                                @if(check_agent('system_configuration'))
                                    <li class="nav-item">
                                        <a class="nav-link
                                            {{request()->routeIs('admin.setting.index')?'active' :''}}
                                        "href="{{route('admin.setting.index')}}">
                                                {{translate('App Settings')}}
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link
                                            {{request()->routeIs('admin.setting.envato.configuration')?'active' :''}}
                                        "href="{{route('admin.setting.envato.configuration')}}">
                                                {{translate('Envato Configuration')}}
                                        </a>
                                    </li>

                                    @if(auth_user()->agent == App\Enums\StatusEnum::false->status())
                                        <li class="nav-item">
                                            <a class="nav-link
                                                {{request()->routeIs('admin.setting.ai')?'active' :''}}
                                            "href="{{route('admin.setting.ai')}}">
                                                 AI {{translate('Configuration')}}
                                            </a>
                                        </li>
                                    @endif


                                    <li class="nav-item">
                                        <a class="nav-link
                                            {{request()->routeIs('admin.setting.configuration.index')?'active' :''}}
                                        "href="{{route('admin.setting.configuration.index')}}">
                                                {{translate('System Preferences')}}
                                        </a>
                                    </li>
                                @endif

                                <li class="nav-item">
                                    <a class="nav-link
                                        {{request()->routeIs('admin.notification.settings')?'active' :''}}
                                    "href="{{route('admin.notification.settings')}}">
                                            {{translate('Notification settings')}}
                                    </a>
                                </li>


                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link menu-link {{ !request()->routeIs('admin.security.*')   ?"collapsed" :""  }}  " href="#managaeSecurity" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="managaeSecurity">
                            <i class="ri-shield-check-line"></i> <span>
                                {{translate('Security Settings')}}
                            </span>
                        </a>
                        <div class="pt-1 collapse {{ request()->routeIs('admin.security.*')     ?"show" :""  }}  menu-dropdown" id="managaeSecurity">
                            <ul class="nav nav-sm flex-column gap-1">

                                @if(check_agent('system_configuration'))
                                    <li class="nav-item">
                                        <a class="nav-link
                                            {{request()->routeIs('admin.security.ip.list')?'active' :''}}
                                        "href="{{route('admin.security.ip.list')}}">
                                                {{translate('Visitors')}}
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link
                                            {{request()->routeIs('admin.security.dos')?'active' :''}}
                                        "href="{{route('admin.security.dos')}}">
                                                {{translate('Dos Security')}}
                                        </a>
                                    </li>
                                @endif

                            
                            </ul>
                        </div>
                    </li>


                    <!-- language  section  -->
                    @if(check_agent('manage_language'))
                    
                        <li class="nav-item">
                            <a class="nav-link menu-link
                                {{request()->routeIs('admin.system.update.init')?'active' :''}}
                            " href="{{route('admin.system.update.init')}}">
                            <i class="ri-refresh-line"></i> <span>
                                    {{translate('System Upgrade')}}
                                </span>
                            </a>
                        </li>
                    @endif

                

                    <!-- language  section  -->
                    @if(check_agent('manage_language'))
                    
                        <li class="nav-item">
                            <a class="nav-link menu-link
                                {{request()->routeIs('admin.language.*')?'active' :''}}
                            " href="{{route('admin.language.index')}}">
                                <i class="ri-translate"></i> <span>
                                    {{translate('Languages')}}
                                </span>
                            </a>
                        </li>
                    @endif

                    @if(check_agent('system_configuration'))
                
                        <li class="nav-item">
                            <a class="nav-link menu-link {{request()->routeIs('admin.setting.system.info')?'active' :''}}" href="{{route('admin.setting.system.info')}}">
                                <i class="ri-server-line"></i> <span>{{translate('About System')}}</span>

                        
                            </a>
                        </li>


                    @endif

  
       

            </ul>
        </div>
    </div>
    <div class="sidebar-background"></div>
</div>
