@extends('admin.layouts.master')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">
                        {{ translate('System Configuration') }}
                    </h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">
                                    {{ translate('Home') }}
                                </a></li>
                            <li class="breadcrumb-item active">
                                {{ translate('System Configuration') }}
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div>
                    <ul class="list-group">
                        <li
                            class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-3 justify-content-between align-items-center">
                            <div>
                                <p class="fw-bold mb-0">{{ translate('Email Notification') }}</p>
                                <p class="mb-0">
                                    <small>{{ translate("Enable or disable email notifications for various events or activities within the system. This allows you to stay updated via email.") }}</small>
                                </p>
                            </div>
                            <div>
                                <div class="form-check form-switch form-switch-md" dir="ltr">
                                    <input
                                        {{ site_settings('email_notifications') == App\Enums\StatusEnum::true->status() ? 'checked' : '' }}
                                        type="checkbox" class="form-check-input status-update"
                                        data-key='email_notifications'
                                        data-status='{{ site_settings('email_notifications') == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status() }}'
                                        data-route="{{ route('admin.setting.status.update') }}"
                                        id="email-notification">

                                    <label class="form-check-label" for="email-notification"></label>
                                </div>
                            </div>
                        </li>

                        <li
                            class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-2 justify-content-between align-items-center">
                            <div>
                                <p class="fw-bold mb-0">{{ translate('SMS Notification') }}</p>
                                <p class="mb-0">
                                    <small>{{ translate("Activate or deactivate SMS notifications, which can be used to receive important alerts or updates via text messages.") }}</small>
                                </p>
                            </div>
                            <div class="form-group">
                                <div class="form-check form-switch form-switch-md" dir="ltr">
                                    <input
                                        {{ site_settings('sms_notifications') == App\Enums\StatusEnum::true->status() ? 'checked' : '' }}
                                        type="checkbox" class="form-check-input status-update"
                                        data-key='sms_notifications'
                                        data-status='{{ site_settings('sms_notifications') == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status() }}'
                                        data-route="{{ route('admin.setting.status.update') }}"
                                        id="sms-notification">
                                    <label class="form-check-label" for="sms-notification"></label>
                                </div>
                            </div>
                        </li>

                        <li
                            class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-2 justify-content-between align-items-center">
                            <div>
                                <p class="fw-bold mb-0">{{ translate('Captcha Validations') }}</p>
                                <p class="mb-0">
                                    <small>{{ translate("Enable or disable Captcha validations, which help prevent automated spam or abuse by requiring users to complete a verification process.") }}</small>
                                </p>
                            </div>
                            <div class="form-group">
                                <div class="form-check form-switch form-switch-md" dir="ltr">
                                    <input
                                        {{ site_settings('captcha') == App\Enums\StatusEnum::true->status() ? 'checked' : '' }}
                                        type="checkbox" class="form-check-input status-update" data-key='captcha'
                                        data-status='{{ site_settings('captcha') == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status() }}'
                                        data-route="{{ route('admin.setting.status.update') }}" id="captcha">
                                    <label class="form-check-label" for="captcha"></label>
                                </div>
                            </div>
                        </li>

                        <li
                            class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-2 justify-content-between align-items-center">
                            <div>
                                <p class="fw-bold mb-0">{{ translate('Database Notifications') }}</p>
                                <p class="mb-0">
                                    <small>{{ translate("Control the system's notifications related to database activities, such as updates or changes to the database.") }}</small>
                                </p>
                            </div>
                            <div class="form-group">
                                <div class="form-check form-switch form-switch-md" dir="ltr">
                                    <input
                                        {{ site_settings('database_notifications') == App\Enums\StatusEnum::true->status() ? 'checked' : '' }}
                                        type="checkbox" class="form-check-input status-update"
                                        data-key='database_notifications'
                                        data-status='{{ site_settings('database_notifications') == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status() }}'
                                        data-route="{{ route('admin.setting.status.update') }}"
                                        id="database_notifications">
                                    <label class="form-check-label" for="database_notifications"></label>
                                </div>
                            </div>
                        </li>


                        <li
                            class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-2 justify-content-between align-items-center">
                            <div>
                                <p class="fw-bold mb-0">{{ translate('Slack Notifications') }}</p>
                                <p class="mb-0">
                                    <small>{{ translate("Integrate the system with Slack and receive notifications directly in your Slack workspace for real-time updates.") }}</small>
                                </p>
                            </div>

                            <div class="form-group">
                                <div class="form-check form-switch form-switch-md" dir="ltr">
                                    <input
                                        {{ site_settings('slack_notifications') == App\Enums\StatusEnum::true->status() ? 'checked' : '' }}
                                        type="checkbox" class="form-check-input status-update"
                                        data-key='slack_notifications'
                                        data-status='{{ site_settings('slack_notifications') == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status() }}'
                                        data-route="{{ route('admin.setting.status.update') }}"
                                        id="slack_notifications">
                                    <label class="form-check-label" for="slack_notifications"></label>
                                </div>
                            </div>

                        </li>

                        <li
                            class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-2 justify-content-between align-items-center">
                            <div>
                                <p class="fw-bold mb-0">{{ translate('Cookie Activation') }}</p>
                                <p class="mb-0">
                                    <small>{{ translate("Enable or disable the use of cookies for user sessions and tracking purposes.") }}</small>
                                </p>
                            </div>
                            <div class="form-group">
                                <div class="form-check form-switch form-switch-md" dir="ltr">
                                    <input
                                        {{ site_settings('cookie') == App\Enums\StatusEnum::true->status() ? 'checked' : '' }}
                                        type="checkbox" class="form-check-input status-update" data-key='cookie'
                                        data-status='{{ site_settings('cookie') == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status() }}'
                                        data-route="{{ route('admin.setting.status.update') }}" id="cookie">
                                    <label class="form-check-label" for="cookie"></label>
                                </div>
                            </div>
                        </li>

                        <li
                            class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-2 justify-content-between align-items-center">
                            <div>
                                <p class="fw-bold mb-0">{{ translate('Automatic Ticket Assign') }}</p>
                                <p class="mb-0">
                                    <small>{{ translate("Configure the system to automatically assign incoming tickets or tasks to specific agents or teams based on predefined rules or criteria.") }}</small>
                                </p>
                            </div>
                            <div class="form-group">
                                <div class="form-check form-switch form-switch-md" dir="ltr">
                                    <input
                                        {{ site_settings('auto_ticket_assignment') == App\Enums\StatusEnum::true->status() ? 'checked' : '' }}
                                        type="checkbox" class="form-check-input status-update"
                                        data-key='auto_ticket_assignment'
                                        data-status='{{ site_settings('auto_ticket_assignment') == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status() }}'
                                        data-route="{{ route('admin.setting.status.update') }}"
                                        id="auto_ticket_assignment">
                                    <label class="form-check-label" for="auto_ticket_assignment"></label>
                                </div>
                            </div>
                        </li>


                        <li
                        class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-2 justify-content-between align-items-center">
                        <div>
                            <p class="fw-bold mb-0">{{ translate('Group Base Ticket Assign') }}</p>
                            <p class="mb-0">
                                <small>{{ translate("Configure the system to automatically assign incoming tickets or tasks to specific agents or teams based on Priority Group") }}</small>
                            </p>
                        </div>
                        <div class="form-group">
                            <div class="form-check form-switch form-switch-md" dir="ltr">
                                <input
                                    {{ site_settings('group_base_ticket_assign') == App\Enums\StatusEnum::true->status() ? 'checked' : '' }}
                                    type="checkbox" class="form-check-input status-update"
                                    data-key='group_base_ticket_assign'
                                    data-status='{{ site_settings('group_base_ticket_assign') == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status() }}'
                                    data-route="{{ route('admin.setting.status.update') }}"
                                    id="group_base_ticket_assign">
                                <label class="form-check-label" for="group_base_ticket_assign"></label>
                            </div>
                        </div>
                        </li>
                        <li
                        class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-2 justify-content-between align-items-center">
                            <div>
                                <p class="fw-bold mb-0">{{ translate('Ticket Security') }}</p>
                                <p class="mb-0">
                                    <small>{{ translate("Enabling the security CAPTCHA feature will enhance the platform's security measures, adding an additional layer of protection to the ticket creation page to mitigate spam and unauthorized submissions") }}</small>
                                </p>
                            </div>
                            <div class="form-group">
                                <div class="form-check form-switch form-switch-md" dir="ltr">
                                    <input
                                        {{ site_settings('ticket_security') == App\Enums\StatusEnum::true->status() ? 'checked' : '' }}
                                        type="checkbox" class="form-check-input status-update"
                                        data-key='ticket_security'
                                        data-status='{{ site_settings('ticket_security') == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status() }}'
                                        data-route="{{ route('admin.setting.status.update') }}"
                                        id="ticket_security">
                                    <label class="form-check-label" for="ticket_security"></label>
                                </div>
                            </div>
                        </li>




                        <li
                            class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-2 justify-content-between align-items-center">
                            <div>
                                <p class="fw-bold mb-0">{{ translate('User Registration') }}</p>
                                <p class="mb-0">
                                    <small>{{ translate("Enabling the first module also activates the User Register Module, indicating a relationship between the two. The User Register Module is likely either a prerequisite for the proper functioning of the first module or is dependent on it for its functionality.") }}</small>
                                </p>
                            </div>

                            <div class="form-group">
                                <div class="form-check form-switch form-switch-md" dir="ltr">
                                    <input
                                        {{ site_settings('user_register') == App\Enums\StatusEnum::true->status() ? 'checked' : '' }}
                                        type="checkbox" class="form-check-input status-update"
                                        data-key='user_register'
                                        data-status='{{ site_settings('user_register') == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status() }}'
                                        data-route="{{ route('admin.setting.status.update') }}"
                                        id="user_register">
                                    <label class="form-check-label" for="user_register"></label>
                                </div>
                            </div>
                        </li>

                        <li class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-2 justify-content-between align-items-center">
                            <div>
                                <p class="fw-bold mb-0">{{ translate('User Notifications') }}</p>
                                <p class="mb-0">
                                    <small>{{ translate("Activating the initial module will enable browser and email notifications for newly registered users") }}</small>
                                </p>
                            </div>

                            <div class="form-group">
                                <div class="form-check form-switch form-switch-md" dir="ltr">
                                    <input
                                        {{ site_settings('default_notification') == App\Enums\StatusEnum::true->status() ? 'checked' : '' }}
                                        type="checkbox" class="form-check-input status-update"
                                        data-key='default_notification'
                                        data-status='{{ site_settings('default_notification') == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status() }}'
                                        data-route="{{ route('admin.setting.status.update') }}"
                                        id="default_notification">
                                    <label class="form-check-label" for="default_notification"></label>
                                </div>
                            </div>
                       </li>

                        <li
                            class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-2 justify-content-between align-items-center">

                            <div>
                                <p class="fw-bold mb-0">{{ translate('Email Verifications') }}</p>
                                <p class="mb-0">
                                    <small>{{ translate("Set up email verification processes to ensure that users email addresses are valid and to enhance security and authenticity.") }}</small>
                                </p>
                            </div>

                            <div class="form-group">
                                <div class="form-check form-switch form-switch-md" dir="ltr">
                                    <input
                                        {{ site_settings('email_verification') == App\Enums\StatusEnum::true->status() ? 'checked' : '' }}
                                        type="checkbox" class="form-check-input status-update"
                                        data-key='email_verification'
                                        data-status='{{ site_settings('email_verification') == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status() }}'
                                        data-route="{{ route('admin.setting.status.update') }}"
                                        id="email_verification">
                                    <label class="form-check-label" for="email_verification"></label>
                                </div>
                            </div>
                        </li>

                        <li
                            class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-2 justify-content-between align-items-center">

                            <div>
                                <p class="fw-bold mb-0">{{ translate('Agent Chat Module') }}</p>
                                <p class="mb-0">
                                    <small>{{ translate("Manage the agent chat module, enabling agents to communicate and provide real-time support to users through a chat interface.") }}</small>
                                </p>
                            </div>

                            <div class="form-group">
                                <div class="form-check form-switch form-switch-md" dir="ltr">
                                    <input
                                        {{ site_settings('chat_module') == App\Enums\StatusEnum::true->status() ? 'checked' : '' }}
                                        type="checkbox" class="form-check-input status-update"
                                        data-key='chat_module'
                                        data-status='{{ site_settings('chat_module') == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status() }}'
                                        data-route="{{ route('admin.setting.status.update') }}" id="chat_module">
                                    <label class="form-check-label" for="chat_module"></label>
                                </div>
                            </div>
                        </li>

                        <li
                        class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-2 justify-content-between align-items-center">
                            <div>
                                <p class="fw-bold mb-0">{{ translate('App Debug') }}</p>
                                <p class="mb-0">
                                    <small>{{ translate("Enable or disable the app debug mode, which allows for the detection and resolution of software bugs or issues by providing detailed error messages or logs.") }}</small>
                                </p>
                            </div>

                            <div class="form-group">
                                <div class="form-check form-switch form-switch-md" dir="ltr">
                                    <input {{ env('app_debug') || env('APP_DEBUG')? 'checked' : '' }} type="checkbox"
                                        class="form-check-input status-update" data-key='app_debug'
                                        data-status='{{ env('app_debug') || env('APP_DEBUG') ? App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status() }}'
                                        data-route="{{ route('admin.setting.status.update') }}" id="app_debug">
                                    <label class="form-check-label" for="app_debug"></label>
                                </div>
                            </div>
                        </li>
                        <li
                            class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-2 justify-content-between align-items-center">

                            <div>
                                <p class="fw-bold mb-0">{{ translate('Terms & Conditions Validation') }}</p>
                                <p class="mb-0">
                                    <small>{{ translate("Implement validation mechanisms to ensure that users agree to and comply with the terms and conditions of using the system or application.") }}</small>
                                </p>
                            </div>

                            <div class="form-group">
                                <div class="form-check form-switch form-switch-md" dir="ltr">
                                    <input
                                        {{ site_settings('terms_accepted_flag') == App\Enums\StatusEnum::true->status() ? 'checked' : '' }}
                                        type="checkbox" class="form-check-input status-update"
                                        data-key='terms_accepted_flag'
                                        data-status='{{ site_settings('terms_accepted_flag') == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status() }}'
                                        data-route="{{ route('admin.setting.status.update') }}" id="terms_accepted_flag">
                                    <label class="form-check-label" for="terms_accepted_flag"></label>
                                </div>
                            </div>
                        </li>


                        <li
                        class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-2 justify-content-between align-items-center">

                            <div>
                                <p class="fw-bold mb-0">{{ translate('Automated Best Agent Identification') }}</p>
                                <p class="mb-0">
                                    <small>{{ translate("Enabling this module activates the automatic best agent selection feature.") }}</small>
                                </p>
                            </div>

                            <div class="form-group">
                                <div class="form-check form-switch form-switch-md" dir="ltr">
                                    <input
                                        {{ site_settings('auto_best_agent') == App\Enums\StatusEnum::true->status() ? 'checked' : '' }}
                                        type="checkbox" class="form-check-input status-update"
                                        data-key='auto_best_agent'
                                        data-status='{{ site_settings('auto_best_agent') == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status() }}'
                                        data-route="{{ route('admin.setting.status.update') }}" id="auto_best_agent">
                                    <label class="form-check-label" for="auto_best_agent"></label>
                                </div>
                            </div>
                        </li>


                        <li
                        class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-2 justify-content-between align-items-center">

                            <div>
                                <p class="fw-bold mb-0">{{ translate('Site Maintenance Mode') }}</p>
                                <p class="mb-0">
                                    <small>{{ translate("Enabling this module puts the site in maintenance mode") }}</small>
                                </p>
                            </div>

                            <div class="form-group">
                                <div class="form-check form-switch form-switch-md" dir="ltr">
                                    <input
                                        {{ site_settings('maintenance_mode') == App\Enums\StatusEnum::true->status() ? 'checked' : '' }}
                                        type="checkbox" class="form-check-input status-update"
                                        data-key='maintenance_mode'
                                        data-status='{{ site_settings('maintenance_mode') == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status() }}'
                                        data-route="{{ route('admin.setting.status.update') }}" id="maintenance_mode">
                                    <label class="form-check-label" for="maintenance_mode"></label>
                                </div>
                            </div>
                        </li>


                        <li
                        class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-2 justify-content-between align-items-center">

                            <div>
                                <p class="fw-bold mb-0">{{ translate('Force SSL') }}</p>
                                <p class="mb-0">
                                    <small>{{ translate("Enabling this feature mandates the use of HTTPS for your site.") }}</small>
                                </p>
                            </div>

                            <div class="form-group">
                                <div class="form-check form-switch form-switch-md" dir="ltr">
                                    <input
                                        {{ site_settings('force_ssl') == App\Enums\StatusEnum::true->status() ? 'checked' : '' }}
                                        type="checkbox" class="form-check-input status-update"
                                        data-key='force_ssl'
                                        data-status='{{ site_settings('force_ssl') == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status() }}'
                                        data-route="{{ route('admin.setting.status.update') }}" id="force_ssl">
                                    <label class="form-check-label" for="force_ssl"></label>
                                </div>
                            </div>
                        </li>


                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

