<?php

use App\Http\Controllers\Admin\AdminChatController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\SystemUpdateController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\NewPasswordController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminTicketController;
use App\Http\Controllers\Admin\AgentController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\CannedController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\EmailTemplateController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\FrontendController;
use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\Admin\KnowledgeBaseController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\MailConfigurationController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PriorityController;
use App\Http\Controllers\Admin\SecurityController;
use App\Http\Controllers\Admin\SmsGatewayController;
use App\Http\Controllers\Admin\SmsTemplateController;
use App\Http\Controllers\Admin\TicketStatusController;
use App\Http\Controllers\Admin\TriggerController;

Route::middleware(['sanitizer',"dos.security"])->prefix('admin')->name('admin.')->group(function () {

	Route::get('/', [LoginController::class, 'showLogin'])->name('login');
	Route::post('authenticate', [LoginController::class, 'authenticate'])->name('authenticate');
	Route::get('logout', [LoginController::class, 'logout'])->name('logout');

	Route::get('forgot-password', [NewPasswordController::class, 'create'])->name('password.request');
	Route::post('password/email', [NewPasswordController::class, 'store'])->name('password.email');
	Route::get('password/verify/code', [NewPasswordController::class, 'passwordResetCodeVerify'])->name('password.verify.code');
	Route::post('password/code/verify', [NewPasswordController::class, 'emailVerificationCode'])->name('email.password.verify.code');

	Route::get('reset-password/{token}', [ResetPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset/password', [ResetPasswordController::class, 'store'])->name('password.reset.update');

	Route::middleware(['admin','demo.mode'])->group(function () {

            Route::controller(AdminController::class)->group(function(){
                //Dashboard
                Route::any('dashboard','index')->name('dashboard')->middleware(['agent:view_dashboard']);
                //profile update
                Route::prefix('profile')->name('profile.')->group(function () {
                    Route::get('/','profile')->name('index');
                    Route::post('/update', 'profileUpdate')->name('update');
                });
                //Password Update
                Route::prefix('passwords')->group(function () {
                    Route::get('/','password')->name('password');
                    Route::post('/update', 'passwordUpdate')->name('password.update');
                });

               //notifications control route
                Route::get('/notificatios/settings','notificationSettings')->name('notification.settings');
                Route::post('/notificatios/settings','updateNotificationSettings')->name('update.notification.settings');
                Route::get('/notifications','notification')->name('notifications');
                Route::post('/read-notification','readNotification')->name('read.notification');
                Route::get('/clear/notification','clearNotitfication')->name('clear.notification');
            });


            //agent chat route
            Route::middleware(['agent:chat_module'])->controller(AdminChatController::class)->prefix('chat')->name('chat.')->group(function(){

                Route::get('/list','chat')->name('list');
                Route::post('/user/chat','userChat')->name('user');
                Route::post('/send/message','sendMessage')->name('send.message');
                Route::post('/delete/message','deleteMessage')->name('delete.message');
                Route::post('/delete/conversation','deleteConversation')->name('delete.conversation');
                Route::post('/block/user','blockUser')->name('block.user');
                Route::post('/mute/user','muteUser')->name('mute.user');
                Route::post('/assign/chat','assign')->name('assign');
            });


            //User
            Route::middleware(['agent:manage_users'])->prefix('users')->name('user.')->group(function () {

                Route::get('/', [UserController::class, 'index'])->name('index');
                Route::get('/create', [UserController::class, 'create'])->name('create');
                Route::post('/store', [UserController::class, 'store'])->name('store');
                Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');
                Route::get('/login/{id}', [UserController::class, 'login'])->name('login');
                Route::post('/status-update',[UserController::class,'statusUpdate'])->name('status.update');
                Route::post('/update', [UserController::class, 'update'])->name('update');
                Route::post('/password/update', [UserController::class, 'passwordUpdate'])->name('password.update');
                Route::get('/delete/{id}', [UserController::class, 'delete'])->name('delete');
                Route::get('/training/{training_type}/phase/{phase}/list', [UserController::class, 'phaseUsers'])->name('phase.list');
                Route::post('/assign-agent', [UserController::class, 'assignAgent'])->name('assign_agent');
            });

            //General Setting
            Route::middleware(['agent:system_configuration'])->prefix('settings')->name('setting.')->group(function () {

                Route::get('/', [SettingController::class, 'index'])->name('index');
                Route::get('/ai-configuration', [SettingController::class, 'aiSettings'])->name('ai');
                Route::post('/store', [SettingController::class, 'store'])->name('store');
                Route::post('/ticket/input/store', [SettingController::class, 'ticketInput'])->name('ticket.store');
                Route::post('/ticket/input/edit/', [SettingController::class, 'ticketInputEdit'])->name('ticket.input.edit');
                Route::post('/ticket/input/update/', [SettingController::class, 'ticketInput'])->name('ticket.input.update');
                Route::post('/ticket/input/order/', [SettingController::class, 'ticketInputOrder'])->name('ticket.input.order');
                Route::get('/ticket/input/delete/{name}', [SettingController::class, 'ticketInputDelete'])->name('ticket.input.delete');
                Route::post('/plugin/store', [SettingController::class, 'pluginSetting'])->name('plugin.store');
                Route::post('/envato/store', [SettingController::class, 'envatoPluginSetting'])->name('envato.plugin.store');
                Route::post('/logo/store', [SettingController::class, 'logoSetting'])->name('logo.store');
                Route::post('/status/update', [SettingController::class, 'settingsStatusUpdate'])->name('status.update');
                Route::get('/cache/clear', [SettingController::class, 'cacheClear'])->name('cache.clear')->withoutMiddleware('agent:system_configuration');
                Route::get('system/info', [SettingController::class, 'systemInfo'])->name('system.info');
                Route::prefix('/envato')->name('envato.')->group(function() {
                    Route::get('/configuration', [SettingController::class, 'envatoConfiguration'])->name('configuration');
                    Route::post('/sync/items', [SettingController::class, 'envatoItemSync'])->name('sync.items');
                });

                Route::post('/business/hour', [SettingController::class, 'businessHour'])->name('business.hour');

                /** new ticket configuration */

                Route::get('/ticket/configuration', [SettingController::class, 'ticketConfiguration'])->name('ticket.configuration');

                Route::prefix('configurations')->name('configuration.')->group(function () {
                    Route::get('/', [SettingController::class, 'systemConfiguration'])->name('index');
                });

                Route::get('/update-system', [SettingController::class, 'sysyemUpdate'])->name('system.update');
            });

            //Language section
            Route::middleware(['agent:manage_language'])->controller(LanguageController::class)->prefix("/language")->name('language.')->group(function(){

                Route::get('/list','index')->name('index');
                Route::post('/store','store')->name('store');
                Route::post('/status-update','statusUpdate')->name('status.update');
                Route::get('/make/default/{id}','setDefaultLang')->name('make.default');
                Route::get('/destroy/{id}','destroy')->name('destroy');
                Route::get('translate/{code}','translate')->name('translate');
                Route::post('translate-key','tranlateKey')->name('tranlateKey');
                Route::get('destroy/translate-key/{id}','destroyTranslateKey')->name('destroy.key');
            });

            //category section
            Route::middleware(['agent:manage_category'])->controller(CategoryController::class)->prefix("/category")->name('category.')->group(function(){

                Route::get('/list','index')->name('index');
                Route::get('/article/create/{id}','article')->name('article.create');
                Route::get('/article/show/{id}','show')->name('article.show');
                Route::post('/store','store')->name('store');
                Route::get('/edit/{id}','edit')->name('edit');
                Route::post('/update','update')->name('update');
                Route::post('/status-update','statusUpdate')->name('status.update');
                Route::get('/destroy/{id}','destroy')->name('destroy');
                Route::post('/bulk/action','bulkAction')->name('bulk');
            });

            //agent section
            Route::controller(AgentController::class)->prefix("/agent")->name('agent.')->group(function(){

                Route::get('/list','index')->name('index');
                Route::get('/create','create')->name('create');
                Route::post('/store','store')->name('store');
                Route::get('/edit/{id}','edit')->name('edit');
                Route::get('/login/{id}','login')->name('login');
                Route::post('/update','update')->name('update');
                Route::post('/password/update', 'passwordUpdate')->name('password.update');
                Route::post('/status-update','statusUpdate')->name('status.update');
                Route::post('/popular/status-update','popularStatusUpdate')->name('popular.status.update');
                Route::get('/destroy/{id}','delete')->name('destroy');
                Route::get('/chat/list/{id}','chatReport')->name('chat.list');
                Route::post('/chat','userChat')->name('chat');
                Route::post('/delete/message','deleteMessage')->name('delete.message');
                Route::post('/block/user','blockUser')->name('block.user');
                Route::post('/delete/conversation','deleteConversation')->name('delete.conversation');

            });

             //agent group section
            Route::controller(GroupController::class)->prefix("/group")->name('group.')->group(function(){

                Route::get('/list','index')->name('index');
                Route::get('/create','create')->name('create');
                Route::post('/store','store')->name('store');
                Route::get('/edit/{id}','edit')->name('edit');
                Route::post('/update','update')->name('update');
                Route::post('/status-update','statusUpdate')->name('status.update');
                Route::get('/login/{id}','login')->name('login');
                Route::get('/destroy/{id}','destroy')->name('destroy');


            });

            //Mail Configuration
            Route::middleware(['agent:mail_configuration'])->prefix('mail/')->name('mail.')->group(function () {

                Route::controller(MailConfigurationController::class)->group(function (){

                    Route::get('outgoing/configuration','index')->name('configuration');
                    Route::post('/update/{id}','mailUpdate')->name('update');
                    Route::get('/edit/{id}','edit')->name('edit');
                    Route::post('/send/method','sendMailMethod')->name('send.method');
                    Route::get('global/template','globalTemplate')->name('global.template');
                    Route::post('test/gateway','testGateway')->name('test');



                    #incoming configuration

                    Route::get('incoming/configuration','incoming')->name('incoming');

                    Route::post('incoming/configuration/store/{id?}','incomingStore')->name('incoming.store');
                    Route::get('incoming/configuration/edit/{id}','incomingEdit')->name('incoming.edit');
                    Route::post('incoming/configuration/update','incomingUpdate')->name('incoming.update');
                    Route::post('incoming/configuration/status-update','statusUpdate')->name('incoming.status.update');
                    Route::get('incoming/configuration/destroy/{id}','destroy')->name('incoming.destroy');

                });

                Route::controller(EmailTemplateController::class)->prefix('templates/')->name("templates.")->group(function (){

                    Route::get('list','index')->name('index');
                    Route::get('edit/{id}','edit')->name('edit');
                    Route::post('update/{id}','update')->name('update');
                });

            });

            Route::middleware(['agent:sms_configuration'])->prefix('sms/')->name('sms.')->group(function (){

                //sms gateway route
                Route::controller(SmsGatewayController::class)->group(function (){

                    Route::get('/gateway','index')->name('gateway.index');
                    Route::get('gateway/edit/{id}','edit')->name('gateway.edit');
                    Route::post('gateway/update/{id}','update')->name('gateway.update');
                    Route::post('default/gateway', 'defaultGateway')->name('default.gateway');
                    Route::get('global/template','globalSMSTemplate')->name('global.template');
                });

                // sms temaplate route
                Route::controller(SmsTemplateController::class)->prefix('templates/')->name("template.")->group(function (){

                    Route::get('list','index')->name('index');
                    Route::get('edit/{id}','edit')->name('edit');
                    Route::post('update/{id}','update')->name('update');
                });


            });


            Route::middleware(['agent:system_configuration'])->prefix('security/')->name('security.')->group(function (){
                #security section
                Route::controller(SecurityController::class)->group(function(){

                    #ip section
                    Route::prefix("/ip")->name('ip.')->group(function(){
                        Route::get('/chart', 'ipChart')->name('chart');
                        Route::get('/list','ipList')->name('list');
                        Route::post('/store','ipStore')->name('store');
                        Route::post('/status-update','ipStatus')->name('update.status');
                        Route::get('/destroy/{id}','ipDestroy')->name('destroy');

                    });

                    #dos security
                    Route::get('/dos','dos')->name('dos');
                    Route::post('/dos/update','dosUpdate')->name('dos.update');


                });

            });


            /** trigger route */

            Route::middleware(['agent:system_configuration'])->controller(TriggerController::class)->prefix('trigger')->name('trigger.')->group(function () {

                Route::get('/list','list')->name('list');
                Route::get('/create','create')->name('create');
                Route::post('/store','store')->name('store');
                Route::get('/edit/{id}','edit')->name('edit');
                Route::post('/update','update')->name('update');
                Route::get('/destroy/{id}','destroy')->name('destroy');
                Route::post('/status-update','statusUpdate')->name('status.update');

                Route::get('/add-conditon','addCondition')->name('add.conditon');

            });


            /** tickets route */

            Route::middleware(['agent:manage_tickets'])->prefix('tickets/')->name('ticket.')->controller(AdminTicketController::class)->group(function (){

                Route::any('/','index')->name('list');
                Route::any('/messages','messages')->name('messages');
                Route::get('/pending/list','index')->name('pending');
                Route::get('/solved/list','index')->name('solved');
                Route::get('/closed/list','index')->name('closed');
                Route::get('/create','create')->name('create');
                Route::get('/sync/purchase/{ticket_number}','syncPurchase')->name('sync.purchase');
                Route::post('/verify/purchase','verifyEnvatoPurchase')->name('verify.purchase');
                Route::post('/store','store')->name('store');
                Route::post('/merge','merge')->name('merge');
                Route::get('/edit/{id}', 'edit')->name('edit');
                Route::post('/update/{id}', 'update')->name('update');
                Route::get('/category/{categoryId}','index')->name('category');
                Route::get('/agent/tickets/{id}','index')->name('agent');
                Route::post('/mark','mark')->name('mark');
                Route::get('{id}','view')->name('view');
                Route::post('modal/view','getModalView')->name('modal.view');
                Route::post('reply','reply')->name('reply');
                Route::get('delete/message/{id}','deleteMessage')->name('delete.message');
                Route::post('update-status','statusUpdate')->name('status.update');
                Route::get('{id}/delete/','delete')->name('delete');
                Route::any('download/file/','download')->name('download.file');
                Route::any('delete/file/','deleteFile')->name('delete.file');
                Route::get('export/{extension}','export')->name('export');
                Route::get('/mute/{ticket_number}','makeMute')->name('make.mute');
                Route::post('/update/message/body','updateMessage')->name('update.message');
                Route::any('/saveDraft','saveDraft')->name('save.draft');

                /** newly addded route */
                Route::post('/update/notifications','updateNotification')->name('update.notification');
                Route::post('/add/note','addNote')->name('add.note');

            });

            //canned replay route
            Route::middleware(['agent:manage_tickets'])->prefix('tickets/canned-reply/')->name('canned.reply.')->controller(CannedController::class)->group(function (){

                Route::get('/list','index')->name('list');
                Route::get('/edit/{id}','edit')->name('edit');
                Route::post('/store','store')->name('store');
                Route::post('/update','update')->name('update');
                Route::post('/status-update','statusUpdate')->name('status.update');
                Route::get('/destroy/{id}','destroy')->name('destroy');

                Route::post('/share','share')->name('share');

            });

            //faq route
            Route::middleware(['agent:manage_faqs'])->prefix('faq/')->name('faq.')->controller(FaqController::class)->group(function (){

                Route::get('/','index')->name('list');
                Route::post('/update','update')->name('update');
                Route::get('/edit/{id}','edit')->name('edit');
                Route::post('/store','store')->name('store');
                Route::post('/status-update','statusUpdate')->name('status.update');
                Route::get('/destroy/{id}','destroy')->name('destroy');
            });


            //ticket priority route
            Route::middleware(['agent:manage_priorites'])->prefix('priority/')->name('priority.')->controller(PriorityController::class)->group(function (){

                Route::get('/list','index')->name('list');
                Route::get('/create','create')->name('create');
                Route::post('/store','store')->name('store');
                Route::get('/edit/{id}','edit')->name('edit');
                Route::post('/update','update')->name('update');
                Route::post('/status-update','statusUpdate')->name('status.update');
                Route::post('/set-default','setDefault')->name('set.default');
                Route::get('/destroy/{id}','destroy')->name('destroy');
            });




             //ticket status route
            Route::middleware(['agent:manage_ticket_status'])->prefix('ticket-status/')->name('ticket-status.')->controller(TicketStatusController::class)->group(function (){

                Route::get('/list','index')->name('list');
                Route::get('/create','create')->name('create');
                Route::post('/store','store')->name('store');
                Route::get('/edit/{id}','edit')->name('edit');
                Route::post('/update','update')->name('update');
                Route::post('/status-update','statusUpdate')->name('status.update');
                Route::post('/set-default','setDefault')->name('set.default');
                Route::get('/destroy/{id}','destroy')->name('destroy');
            });


            //ticket department route
            Route::middleware(['agent:manage_product'])->prefix('product/')->name('department.')->controller(DepartmentController::class)->group(function (){
                Route::get('/list','index')->name('list');
                Route::post('/store','store')->name('store');
                Route::post('/update','update')->name('update');
                Route::post('/status-update','statusUpdate')->name('status.update');
                Route::get('/destroy/{id}','destroy')->name('destroy');
            });




            //frontends route
            Route::middleware(['agent:manage_frontends'])->prefix('frontends/')->name('frontend.')->controller(FrontendController::class)->group(function (){

                Route::get('/','index')->name('list');
                Route::post('/update/{id}','update')->name('update');

            });


            //faq route
            Route::middleware(['agent:manage_faqs'])->prefix('page/')->name('page.')->controller(PageController::class)->group(function (){

                Route::get('/','index')->name('list');
                Route::post('/update','update')->name('update');
                Route::get('/edit/{id}','edit')->name('edit');
                Route::post('/store','store')->name('store');
                Route::post('/status-update','statusUpdate')->name('status.update');
                Route::get('/destroy/{id}','destroy')->name('destroy');

            });



            //knowledge base  route
            Route::middleware(['agent:manage_article'])->prefix('knowledge-base/')->name('knowledgebase.')->controller(KnowledgeBaseController::class)->group(function (){

                Route::get('/{slug?}/{id?}','index')->name('list');
                Route::post('/store','store')->name('store');
                Route::post('/update','update')->name('update');
                Route::post('/change/parent','changeParent')->name('change.parent');
                Route::get('/item/destroy/{id}','destroy')->name('destroy');

            });



            //canned replay route
            Route::middleware(['agent:manage_frontends'])->prefix('menu')->name('menu.')->controller(MenuController::class)->group(function (){

                Route::get('/list','index')->name('list');
                Route::post('/store','store')->name('store');
                Route::post('/update','update')->name('update');
                Route::post('/status-update','statusUpdate')->name('status.update');
                Route::get('/destroy/{id}','destroy')->name('destroy');
            });


            //contact replay route
            Route::middleware(['agent:manage_frontends'])->prefix('contact')->name('contact.')->controller(ContactController::class)->group(function (){

                Route::get('/list','index')->name('list');
                Route::get('/subscribers','subscriber')->name('subscriber');
                Route::get('/destroy/{id}','destroy')->name('destroy');
                Route::get('/delete/{id}','deleteContact')->name('delete');
                Route::post('/send-mail','sendMail')->name('send.mail');
            });

            //article route

            Route::middleware(['agent:manage_frontends'])->prefix('article')->name('article.')->controller(ArticleController::class)->group(function (){

                //article route
                Route::get('/','index')->name('list');
                Route::get('/create','create')->name('create');
                Route::get('/edit/{id}','edit')->name('edit');
                Route::post('/store','storeArticle')->name('store');
                Route::post('/update','updateArticle')->name('update');
                Route::post('/status-update','articleStatusUpdate')->name('status.update');
                Route::get('/destroy/{id}','destroyArticle')->name('destroy');
                Route::get('/topics','category')->name('category');
                Route::get('/topics/edit/{id}','categoryEdit')->name('category.edit');

                Route::post('/bulk/action','bulkAction')->name('bulk');

                //article categpry list
                Route::prefix('/subcategory')->name('category.')->group(function (){

                    Route::get('/list','subCategory')->name('list');
                    Route::post('/store','store')->name('store');
                    Route::post('/update','update')->name('update');
                    Route::post('/status-update','statusUpdate')->name('status.update');
                    Route::get('/destroy/{id}','destroy')->name('destroy');
                    Route::post('/bulk/action','bulkCategoryAction')->name('bulk');

                });

            });


            Route::controller(SystemUpdateController::class)->middleware(["sanitizer"])->group(function () {
                Route::get('/system-update',"init")->name('system.update.init');
                Route::post('/update',"update")->name('system.update');
            });

	});

});
