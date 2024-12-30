@extends('admin.layouts.master')
@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box d-sm-flex align-items-center justify-content-between">
					<h4 class="mb-sm-0">
						{{translate('Manage Notifications')}}
					</h4>

					<div class="page-title-right">
						<ol class="breadcrumb m-0">
							<li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">
								{{translate('Home')}}
							</a></li>
							<li class="breadcrumb-item active">
								{{translate('Notifications Settings')}}
							</li>
						</ol>
					</div>

				</div>
			</div>
		</div>

        @php

          $default_notifications = admin_notification();
          if(auth_user()->agent  ==  App\Enums\StatusEnum::true->status()){
             $default_notifications = agent_notification();
          }
          $admin_notifications =  auth_user()->notification_settings ? json_decode(auth_user()->notification_settings,true) :$default_notifications;

        @endphp

		<div class="card">

			<div class="card-body">
                <form action="{{route('admin.update.notification.settings')}}" method="post">
                    @csrf
                    <div class="list-group">

                        <div class="notification-item">
                            <div class="header">
                                <div class="title"><h6> {{translate("Notify me when")}}  …</h6></div>
                                <div class="checkbox-list">
                                    <ul class="channel-list">
                                        @if(site_settings("email_notifications") ==  App\Enums\StatusEnum::true->status())
                                            <li>
                                                <span>
                                                    {{translate("Email")}}
                                                </span>
                                                @if(site_settings("email_notifications") ==  App\Enums\StatusEnum::true->status())
                                                <input class="notification-chanel  form-check-input me-1"  type="checkbox" id="email" value="email-notifications">
                                            @endif
                                            </li>
                                        @endif

                                        @if(site_settings("sms_notifications") ==  App\Enums\StatusEnum::true->status())
                                            <li>
                                                <span>
                                                    {{translate("Sms")}}
                                                </span>
                                                @if(site_settings("sms_notifications") ==  App\Enums\StatusEnum::true->status())
                                            <input class="notification-chanel   form-check-input me-1" id="sms" type="checkbox" value="sms-notifications">
                                        @endif
                                            </li>
                                        @endif

                                        <li>
                                            <span>
                                                {{translate("Browser")}}
                                            </span>
                                            <input class="notification-chanel  form-check-input me-1" id="browser"  type="checkbox" value="browser-notifications">
                                        </li>

                                        @if( auth_user()->agent == App\Enums\StatusEnum::false->status() && site_settings("slack_notifications") ==  App\Enums\StatusEnum::true->status())
                                            <li>
                                                <span>
                                                    {{translate("Slack")}}
                                                </span>
                                                <input class="notification-chanel  form-check-input me-1" id="slack"  type="checkbox" value="slack-notifications">
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            <div class="body">
                                <div class="list-item">
                                    <div class="text">
                                        <p class="mb-0">
                                            {{translate("There is a New Ticket/Conversation")}}
                                        </p>
                                    </div>
                                    <div class="checkbox-list">
                                        <ul class="channel-list">
                                            @if(site_settings("email_notifications") ==  App\Enums\StatusEnum::true->status())
                                               <li>
                                                <input {{$admin_notifications['email']['new_ticket'] == App\Enums\StatusEnum::true->status() ? "checked" :"" }}
                                                  class="email-notifications form-check-input me-1" name="admin_notifications[email][new_ticket]" type="checkbox" value="{{App\Enums\StatusEnum::true->status()}}">
                                               </li>
                                            @endif

                                            @if(site_settings("sms_notifications") ==  App\Enums\StatusEnum::true->status())
                                              <li>
                                                <input {{$admin_notifications['sms']['new_ticket'] == App\Enums\StatusEnum::true->status() ? "checked" :"" }}  class=" sms-notifications form-check-input me-1"  name="admin_notifications[sms][new_ticket]" type="checkbox" value="{{ App\Enums\StatusEnum::true->status()}}">
                                              </li>
                                            @endif

                                            <li>
                                                <input {{$admin_notifications['browser']['new_ticket'] == App\Enums\StatusEnum::true->status() ? "checked" :"" }} class=" browser-notifications  form-check-input me-1"  name="admin_notifications[browser][new_ticket]"  type="checkbox" value="{{ App\Enums\StatusEnum::true->status()}}">
                                            </li>


                                            @if( auth_user()->agent == App\Enums\StatusEnum::false->status() && site_settings("slack_notifications") ==  App\Enums\StatusEnum::true->status())
                                              <li>
                                                <input {{$admin_notifications['slack']['new_ticket'] == App\Enums\StatusEnum::true->status() ? "checked" :"" }} class=" slack-notifications  form-check-input me-1"  name="admin_notifications[slack][new_ticket]"  type="checkbox" value="{{ App\Enums\StatusEnum::true->status()}}">
                                              </li>
                                            @endif

                                        </ul>
                                    </div>
                                </div>
                                @if(auth_user()->agent == App\Enums\StatusEnum::true->status())
                                    <div class="list-item">
                                        <div class="text">
                                            <p class="mb-0">
                                                {{translate("Admin Assign A Conversations To Me")}}
                                            </p>
                                        </div>
                                        <div class="checkbox-list">
                                            <ul class="channel-list">
                                                @if(site_settings("email_notifications") ==  App\Enums\StatusEnum::true->status())
                                                    <li>
                                                        <input {{$admin_notifications['email']['admin_assign_ticket'] == App\Enums\StatusEnum::true->status() ? "checked" :"" }}
                                                    class="email-notifications form-check-input me-1" name="admin_notifications[email][admin_assign_ticket]" type="checkbox" value="{{App\Enums\StatusEnum::true->status()}}">
                                                    </li>
                                                @endif

                                                @if(site_settings("sms_notifications") ==  App\Enums\StatusEnum::true->status())
                                                <li>
                                                    <input {{$admin_notifications['sms']['admin_assign_ticket'] == App\Enums\StatusEnum::true->status() ? "checked" :"" }}  class=" sms-notifications form-check-input me-1"  name="admin_notifications[sms][admin_assign_ticket]" type="checkbox" value="{{ App\Enums\StatusEnum::true->status()}}">
                                                </li>
                                                @endif

                                                <li>
                                                    <input {{$admin_notifications['browser']['admin_assign_ticket'] == App\Enums\StatusEnum::true->status() ? "checked" :"" }} class=" browser-notifications  form-check-input me-1"  name="admin_notifications[browser][admin_assign_ticket]"  type="checkbox" value="{{ App\Enums\StatusEnum::true->status()}}">
                                                </li>

                                            </ul>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>
             
                        <div class="notification-item">
                            <div class="header">
                                <div class="title"><h6> {{translate("Notify me when Agent")}}  …</h6></div>

                            </div>
                            @if( auth_user()->agent == App\Enums\StatusEnum::false->status())
                                <div class="body">
                                    <div class="list-item">
                                        <div class="text">
                                            <p class="mb-0">
                                                {{translate("Replied To A Conversations")}}
                                            </p>
                                        </div>
                                        <div class="checkbox-list">
                                            <ul class="channel-list">
                                                @if(site_settings("email_notifications") ==  App\Enums\StatusEnum::true->status())
                                                <li>
                                                    <input {{$admin_notifications['email']['agent_ticket_reply'] == App\Enums\StatusEnum::true->status() ? "checked" :"" }}
                                                    class="email-notifications form-check-input me-1" name="admin_notifications[email][agent_ticket_reply]" type="checkbox" value="{{App\Enums\StatusEnum::true->status()}}">
                                                </li>
                                                @endif

                                                @if(site_settings("sms_notifications") ==  App\Enums\StatusEnum::true->status())
                                                <li>
                                                    <input {{$admin_notifications['sms']['agent_ticket_reply'] == App\Enums\StatusEnum::true->status() ? "checked" :"" }}  class=" sms-notifications form-check-input me-1"  name="admin_notifications[sms][agent_ticket_reply]" type="checkbox" value="{{ App\Enums\StatusEnum::true->status()}}">
                                                </li>
                                                @endif

                                                <li>
                                                    <input {{$admin_notifications['browser']['agent_ticket_reply'] == App\Enums\StatusEnum::true->status() ? "checked" :"" }} class=" browser-notifications  form-check-input me-1"  name="admin_notifications[browser][agent_ticket_reply]"  type="checkbox" value="{{ App\Enums\StatusEnum::true->status()}}">
                                                </li>


                                                @if( auth_user()->agent == App\Enums\StatusEnum::false->status() && site_settings ("slack_notifications") ==  App\Enums\StatusEnum::true->status())
                                                <li>
                                                    <input {{$admin_notifications['slack']['agent_ticket_reply'] == App\Enums\StatusEnum::true->status() ? "checked" :"" }} class=" slack-notifications  form-check-input me-1"  name="admin_notifications[slack][agent_ticket_reply]"  type="checkbox" value="{{ App\Enums\StatusEnum::true->status()}}">
                                                </li>
                                                @endif

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="body">
                                <div class="list-item">
                                    <div class="text">

                                        <p class="mb-0">
                                            {{translate("Assign a Ticket To ")}} {{auth_user()->agent == App\Enums\StatusEnum::true->status() ? 'me' :"Other Agents"}}
                                        </p>
                                    </div>
                                    <div class="checkbox-list">
                                        <ul class="channel-list">
                                            @if(site_settings("email_notifications") ==  App\Enums\StatusEnum::true->status())
                                               <li>
                                                <input {{$admin_notifications['email']['agent_assign_ticket'] == App\Enums\StatusEnum::true->status() ? "checked" :"" }}
                                                  class="email-notifications form-check-input me-1" name="admin_notifications[email][agent_assign_ticket]" type="checkbox" value="{{App\Enums\StatusEnum::true->status()}}">
                                               </li>
                                            @endif

                                            @if(site_settings("sms_notifications") ==  App\Enums\StatusEnum::true->status())
                                               <li>
                                                <input {{$admin_notifications['sms']['agent_assign_ticket'] == App\Enums\StatusEnum::true->status() ? "checked" :"" }}  class=" sms-notifications form-check-input me-1"  name="admin_notifications[sms][agent_assign_ticket]" type="checkbox" value="{{ App\Enums\StatusEnum::true->status()}}">
                                               </li>
                                            @endif

                                            <li>
                                                <input {{$admin_notifications['browser']['agent_assign_ticket'] == App\Enums\StatusEnum::true->status() ? "checked" :"" }} class=" browser-notifications  form-check-input me-1"  name="admin_notifications[browser][agent_assign_ticket]"  type="checkbox" value="{{ App\Enums\StatusEnum::true->status()}}">
                                            </li>


                                            @if( auth_user()->agent == App\Enums\StatusEnum::false->status() && site_settings("slack_notifications") ==  App\Enums\StatusEnum::true->status())
                                              <li>
                                                <input {{$admin_notifications['slack']['agent_assign_ticket'] == App\Enums\StatusEnum::true->status() ? "checked" :"" }} class=" slack-notifications  form-check-input me-1"  name="admin_notifications[slack][agent_assign_ticket]"  type="checkbox" value="{{ App\Enums\StatusEnum::true->status()}}">
                                              </li>
                                            @endif

                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!--  customer convo -->

                        <div class="notification-item">
                            <div class="header">
                                <div class="title"><h6> {{translate("Notify me when Customer")}}  …</h6></div>
                            </div>

                            @if( auth_user()->agent == App\Enums\StatusEnum::false->status())

                                <div class="body">
                                    <div class="list-item">
                                        <div class="text">
                                            <p class="mb-0">
                                                {{translate("Replied To On Of My Conversations")}}
                                            </p>
                                        </div>
                                        <div class="checkbox-list">
                                            <ul class="channel-list">
                                                @if(site_settings("email_notifications") ==  App\Enums\StatusEnum::true->status())
                                                <li>
                                                    <input {{$admin_notifications['email']['user_reply_admin'] == App\Enums\StatusEnum::true->status() ? "checked" :"" }}
                                                    class="email-notifications form-check-input me-1" name="admin_notifications[email][user_reply_admin]" type="checkbox" value="{{App\Enums\StatusEnum::true->status()}}">
                                                </li>
                                                @endif

                                                @if(site_settings("sms_notifications") ==  App\Enums\StatusEnum::true->status())
                                                <li>
                                                    <input {{$admin_notifications['sms']['user_reply_admin'] == App\Enums\StatusEnum::true->status() ? "checked" :"" }}  class=" sms-notifications form-check-input me-1"  name="admin_notifications[sms][user_reply_admin]" type="checkbox" value="{{ App\Enums\StatusEnum::true->status()}}">
                                                </li>
                                                @endif

                                                <li>
                                                    <input {{$admin_notifications['browser']['user_reply_admin'] == App\Enums\StatusEnum::true->status() ? "checked" :"" }} class=" browser-notifications  form-check-input me-1"  name="admin_notifications[browser][user_reply_admin]"  type="checkbox" value="{{ App\Enums\StatusEnum::true->status()}}">
                                                </li>


                                                @if( auth_user()->agent == App\Enums\StatusEnum::false->status() && site_settings ("slack_notifications") ==  App\Enums\StatusEnum::true->status())
                                                    <li>
                                                        <input {{$admin_notifications['slack']['user_reply_admin'] == App\Enums\StatusEnum::true->status() ? "checked" :"" }} class=" slack-notifications  form-check-input me-1"  name="admin_notifications[slack][user_reply_admin]"  type="checkbox" value="{{ App\Enums\StatusEnum::true->status()}}">
                                                    </li>
                                                @endif

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                
          
                            @endif

                            <div class="body">
                                <div class="list-item">
                                    <div class="text">
                                        <p class="mb-0">
                                            {{translate("Start A New Chat (Message With Me)")}}
                                        </p>
                                    </div>
                                    <div class="checkbox-list">
                                        <ul class="channel-list">
                                            @if(site_settings("email_notifications") ==  App\Enums\StatusEnum::true->status())
                                            <li>
                                                <input {{@$admin_notifications['email']['new_chat'] == App\Enums\StatusEnum::true->status() ? "checked" :"" }}
                                                class="email-notifications form-check-input me-1" name="admin_notifications[email][new_chat]" type="checkbox" value="{{App\Enums\StatusEnum::true->status()}}">
                                            </li>
                                            @endif

                                            @if(site_settings("sms_notifications") ==  App\Enums\StatusEnum::true->status())
                                            <li>
                                                <input {{@$admin_notifications['sms']['new_chat'] == App\Enums\StatusEnum::true->status() ? "checked" :"" }}  class=" sms-notifications form-check-input me-1"  name="admin_notifications[sms][new_chat]" type="checkbox" value="{{ App\Enums\StatusEnum::true->status()}}">
                                            </li>
                                            @endif

                                            <li>
                                                <input {{@$admin_notifications['browser']['new_chat'] == App\Enums\StatusEnum::true->status() ? "checked" :"" }} class=" browser-notifications  form-check-input me-1"  name="admin_notifications[browser][new_chat]"  type="checkbox" value="{{ App\Enums\StatusEnum::true->status()}}">
                                            </li>


                                            @if( auth_user()->agent == App\Enums\StatusEnum::false->status() && site_settings ("slack_notifications") ==  App\Enums\StatusEnum::true->status())
                                            <li>
                                                <input {{@$admin_notifications['slack']['new_chat'] == App\Enums\StatusEnum::true->status() ? "checked" :"" }} class=" slack-notifications  form-check-input me-1"  name="admin_notifications[slack][new_chat]"  type="checkbox" value="{{ App\Enums\StatusEnum::true->status()}}">
                                            </li>
                                            @endif

                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="body">
                                <div class="list-item">
                                    <div class="text">
                                        <p class="mb-0">
                                            {{translate("Replied To ")}} {{ auth_user()->agent == App\Enums\StatusEnum::true->status() ? "My Conversations" :"a Agent Conversations" }}
                                        </p>
                                    </div>
                                    <div class="checkbox-list">
                                        <ul class="channel-list">
                                            @if(site_settings("email_notifications") ==  App\Enums\StatusEnum::true->status())
                                               <li>
                                                <input {{$admin_notifications['email']['user_reply_agent'] == App\Enums\StatusEnum::true->status() ? "checked" :"" }}
                                                  class="email-notifications form-check-input me-1" name="admin_notifications[email][user_reply_agent]" type="checkbox" value="{{App\Enums\StatusEnum::true->status()}}">
                                               </li>
                                            @endif

                                            @if(site_settings("sms_notifications") ==  App\Enums\StatusEnum::true->status())
                                               <li>
                                                <input {{$admin_notifications['sms']['user_reply_agent'] == App\Enums\StatusEnum::true->status() ? "checked" :"" }}  class=" sms-notifications form-check-input me-1"  name="admin_notifications[sms][user_reply_agent]" type="checkbox" value="{{ App\Enums\StatusEnum::true->status()}}">
                                               </li>
                                            @endif

                                            <li>
                                                <input {{$admin_notifications['browser']['user_reply_agent'] == App\Enums\StatusEnum::true->status() ? "checked" :"" }} class=" browser-notifications  form-check-input me-1"  name="admin_notifications[browser][user_reply_agent]"  type="checkbox" value="{{ App\Enums\StatusEnum::true->status()}}">
                                            </li>

                                            @if( auth_user()->agent == App\Enums\StatusEnum::false->status() && site_settings("slack_notifications") ==  App\Enums\StatusEnum::true->status())
                                              <li>
                                                <input {{$admin_notifications['slack']['user_reply_agent'] == App\Enums\StatusEnum::true->status() ? "checked" :"" }} class=" slack-notifications  form-check-input me-1"  name="admin_notifications[slack][user_reply_agent]"  type="checkbox" value="{{ App\Enums\StatusEnum::true->status()}}">
                                              </li>
                                            @endif

                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button  class="btn btn-sm btn-primary">
                            {{translate('Update')}}
                        </button>
                    </div>
                </form>
			</div>

		</div>
	</div>

@endsection



@push('script-push')
<script>
	(function($){
       	"use strict";

        // check box event
        var length = null;
        var checked_lenght = null;

        $(document).on('click','.notification-chanel' ,function(e){
            if($(this).is(':checked')){
                $(`.${$(this).val()}`).prop('checked', true);
            }
            else{
                $(`.${$(this).val()}`).prop('checked', false);
            }
        })

        checkebox_event(".email-notifications",'#email');
        checkebox_event(".browser-notifications",'#browser');
        checkebox_event(".sms-notifications",'#sms');
        checkebox_event(".slack-notifications",'#slack');

        $(document).on('click','.email-notifications' ,function(e){
          checkebox_event(".email-notifications",'#email');
        })

        $(document).on('click','.sms-notifications' ,function(e){
            checkebox_event(".sms-notifications",'#sms');
        })

        $(document).on('click','.browser-notifications' ,function(e){
            checkebox_event(".browser-notifications",'#browser');
        })
        $(document).on('click','.slack-notifications' ,function(e){
            checkebox_event(".slack-notifications",'#slack');
        })


	})(jQuery);
</script>
@endpush





