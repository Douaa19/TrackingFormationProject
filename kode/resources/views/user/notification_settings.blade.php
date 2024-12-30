@extends('user.layouts.master')
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
							<li class="breadcrumb-item"><a href="{{route('user.dashboard')}}">
								{{translate('Home')}}
							</a></li>
							<li class="breadcrumb-item active">
								{{translate('Settings')}}
							</li>
						</ol>
					</div>

				</div>
			</div>
		</div>

        @php

         $user_notifications =  auth_user('web')->notification_settings ? json_decode(auth_user('web')->notification_settings,true) : user_notification();

        @endphp

		<div class="card">

			<div class="card-body">
                <form action="{{route('user.update.notification.settings')}}" method="post">
                    @csrf
                    <div class="list-group">
                        <div class="notification-item">
                            <div class="header">
                            <div class="title"><h6> {{translate("Notify me when")}}  …</h6></div>
                                <div class="checkbox-list">
                                    <ul class="channel-list">

                                        @if(site_settings("email_notifications") ==  App\Enums\StatusEnum::true->status())
                                            <li>
                                                <span>{{translate("Email")}}</span>
                                                @if(site_settings("email_notifications") ==  App\Enums\StatusEnum::true->status())
                                                <input class="notification-chanel  form-check-input me-1"  type="checkbox" id="email" value="email-notifications">
                                                @endif
                                            </li>
                                        @endif
                                        @if(site_settings("sms_notifications") ==  App\Enums\StatusEnum::true->status())
                                            <li>
                                                <span>{{translate("Sms")}}</span>
                                                @if(site_settings("sms_notifications") ==  App\Enums\StatusEnum::true->status())
                                                <input class="notification-chanel   form-check-input me-1" id="sms" type="checkbox" value="sms-notifications">
                                                @endif
                                            </li>
                                        @endif
                                        <li>
                                            <span>{{translate("Browser")}}</span>
                                            <input class="notification-chanel  form-check-input me-1" id="browser"  type="checkbox" value="browser-notifications">
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="body">
                                <div class="list-item">
                                    <div class="text">
                                        <p class="mb-0">
                                            {{translate("There is a New Conversation")}}
                                        </p>
                                    </div>
                                    <div class="checkbox-list">
                                        <ul class="channel-list">
                                            @if(site_settings("email_notifications") ==  App\Enums\StatusEnum::true->status())
                                               <li>
                                                <input {{$user_notifications['email']['new_chat'] == App\Enums\StatusEnum::true->status() ? "checked" :"" }}
                                                  class="email-notifications form-check-input me-1" name="user_notificatoon[email][new_chat]" type="checkbox" value="{{App\Enums\StatusEnum::true->status()}}">
                                               </li>
                                            @endif

                                            @if(site_settings("sms_notifications") ==  App\Enums\StatusEnum::true->status())
                                               <li>
                                                <input {{@$user_notifications['sms']['new_chat'] == App\Enums\StatusEnum::true->status() ? "checked" :"" }}  class=" sms-notifications form-check-input me-1"  name="user_notificatoon[sms][new_chat]" type="checkbox" value="{{App\Enums\StatusEnum::true->status()}}">
                                               </li>
                                            @endif

                                            <li>
                                                <input {{$user_notifications['browser']['new_chat'] == App\Enums\StatusEnum::true->status() ? "checked" :"" }} class=" browser-notifications  form-check-input me-1"  name="user_notificatoon[browser][new_chat]"  type="checkbox" value="{{App\Enums\StatusEnum::true->status()}}">
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="list-item">
                                    <div class="text">
                                        <p class="mb-0">
                                            {{translate('There Is A Ticket Reply')}}
                                        </p>
                                    </div>
                                    <div class="checkbox-list">
                                        <ul class="channel-list">
                                            @if(site_settings("email_notifications") ==  App\Enums\StatusEnum::true->status())
                                               <li>
                                                  <input  {{$user_notifications['email']['ticket_reply'] == App\Enums\StatusEnum::true->status() ? "checked" :"" }} class="email-notifications form-check-input me-1" name="user_notificatoon[email][ticket_reply]"  type="checkbox" value="{{App\Enums\StatusEnum::true->status()}}">
                                               </li>
                                            @endif

                                            @if(site_settings("sms_notifications") ==  App\Enums\StatusEnum::true->status())
                                               <li>
                                                <input {{@$user_notifications['sms']['ticket_reply'] == App\Enums\StatusEnum::true->status() ? "checked" :"" }} class="sms-notifications form-check-input me-1"  name="user_notificatoon[sms][ticket_reply]" type="checkbox" value="{{App\Enums\StatusEnum::true->status()}}">
                                               </li>
                                            @endif

                                            <li>
                                                <input {{$user_notifications['browser']['ticket_reply'] == App\Enums\StatusEnum::true->status() ? "checked" :"" }} name="user_notificatoon[browser][ticket_reply]"  class="browser-notifications form-check-input me-1" type="checkbox" value="{{App\Enums\StatusEnum::true->status()}}">
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button  class="btn btn-sm btn-info">
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

        $(document).on('click','.email-notifications' ,function(e){
          checkebox_event(".email-notifications",'#email');
        })

        $(document).on('click','.sms-notifications' ,function(e){
            checkebox_event(".sms-notifications",'#sms');
        })
        $(document).on('click','.browser-notifications' ,function(e){
            checkebox_event(".browser-notifications",'#browser');
        })



	})(jQuery);
</script>
@endpush





