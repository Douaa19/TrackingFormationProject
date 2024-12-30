<?php

use App\Http\Controllers\Admin\SettingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CoreController;
use App\Http\Controllers\FloatingMessageController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\GuestTicketController;
use App\Http\Controllers\SystemUpdateController;
use App\Http\Controllers\User\ChatController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\CannedController;
use App\Http\Controllers\User\UserTicketController;
use Illuminate\Support\Facades\DB;


use Illuminate\Support\Facades\Artisan;

Route::get('migrate', function () {
    Artisan::call('migrate',
    array(
        '--path' => 'database/migrations/2024_05_04_125335_create_incomming_mail_gateways_table.php',
        '--force' => true));
});


Route::get('queue-work', function () {
    return Illuminate\Support\Facades\Artisan::call('queue:work', ['--stop-when-empty' => true]);
})->name('queue.work')->middleware(['sanitizer','maintenance.mode']);

$globalMiddleware = ['sanitizer','maintenance.mode',"dos.security"];

try {
    DB::connection()->getPdo();
    if(DB::connection()->getDatabaseName()){
        $globalMiddleware = ['sanitizer','maintenance.mode',"dos.security","throttle:refresh"];
    }
} catch (\Exception $ex) {
    //throw $th;
}


Route::middleware($globalMiddleware)->group(function () {

    Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {

        Route::middleware(['checkUserStatus'])->group(function(){

            Route::controller(HomeController::class)->group(function(){

                Route::get('/dashboard', 'dashboard')->name('dashboard');
                Route::get('/envato/purchase-list', 'envatoPurchaseList')->name('envato.purchase.list');
                Route::get('/envato/purchase-details/{envatoItemId}', 'envatoPurchaseDetails')->name('envato.purchase.details');
                Route::get('/profile', 'profile')->name('profile');
                Route::post('/profile/update', 'profileUpdate')->name('profile.update');
                //Password Update
                Route::prefix('passwords')->name('password.')->group(function () {
                    Route::post('/update', 'passwordUpdate')->name('update');
                });
                
                //notification route
                Route::get('/notificatios/settings','notificationSettings')->name('notification.settings');
                Route::post('/notificatios/settings','updateNotificationSettings')->name('update.notification.settings');
                Route::get('/notifications','notification')->name('notifications');
                Route::post('/read-notification','readNotification')->name('read.notification');

            });
        
            // user chat route
            Route::controller(ChatController::class)->prefix('chat')->name('chat.')->group(function(){

                Route::get('/list','chat')->name('list');
                Route::post('/agent/chat','agentChat')->name('agent');
                Route::post('/send/message','sendMessage')->name('send.message');
                Route::post('/delete/message','deleteMessage')->name('delete.message');
                Route::post('/delete/conversation','deleteConversation')->name('delete.conversation');
                Route::post('/mute/agent','muteAgent')->name('mute.agent');
            });

            /** tickets route */
            Route::prefix('tickets/')->name('ticket.')->controller(UserTicketController::class)->group(function (){
                
                Route::any('/','index')->name('list');
                Route::any('/messages','messages')->name('messages');
                Route::get('/mark','mark')->name('mark');
                Route::get('{id}','view')->name('view');
                Route::post('reply','reply')->name('reply')->withoutMiddleware('auth');
                Route::get('{id}/delete/','delete')->name('delete');
                Route::any('download/file','download')->name('download.file')->withoutMiddleware('auth');
                Route::get('export/{extension}','export')->name('export');

            });


            //canned replay route
            Route::prefix('tickets/canned-reply/')->name('canned.reply.')->controller(CannedController::class)->group(function (){

                Route::get('/list','index')->name('list');
                Route::post('/store','store')->name('store');
                Route::post('/update','update')->name('update');
                Route::post('/status-update','statusUpdate')->name('status.update');
                Route::get('/destroy/{id}','destroy')->name('destroy');

            });

        });
    });

    Route::get('/language/change/{code?}', [CoreController::class, 'languageChange'])->name('language.change');
    Route::get('/cron/run', [CoreController::class, 'cron'])->name('cron.run');
    Route::post('ai-content',[CoreController::class, 'aiContent'])->name('ai.content');



    /** guest ticket route */
    Route::controller(GuestTicketController::class)->name('ticket.')->group(function(){

        Route::get('/create/ticket/{purchase_code?}/{item_id?}','create')->name('create');
        Route::get('/tickets/{ticketId}/reply', 'reply')->name('reply');
        Route::any('/load/messages', 'messages')->name('messages');
        Route::post('/store/ticket', 'store')->name('store');
        Route::any('/ticket/search', 'search')->name('search');
        Route::any('/ticket/otp-verification', 'otpVerification')->name('otp.verification');

        Route::any('/ticket/solved-request/{ticketId}/{status}', 'solveRequest')->name('solve.request');
        Route::any('/ticket/close/{id}', 'ticketClose')->name('close');
        Route::any('/ticket/open/{id}', 'ticketOpen')->name('open');

    });

    Route::controller(FrontendController::class)->group(function(){
        
        Route::get('/','index')->name('home');
        Route::any('/articles/{slug?}/{id?}','articles')->name('articles');
        Route::any('/article/search','articleSearch')->name('article.search');
        Route::get('/articles/{item}/{category}/{title}/{id}','articleView')->name('article.view');
        Route::post('/contacts','contactStore')->name('contact.store');
        Route::get('/pages/{slug}','pages')->name('pages');
        Route::post('/subscribe','subscribe')->name('subscribe');

        Route::any('/knowledgebases/{slug?}/{knowledge_slug?}','knowledgebase')->name('knowledgebase');
    });


    Route::controller(FloatingMessageController::class)->group(function(){

        Route::any('/get-message','getMessage')->name('get.message');
        Route::post('/send-message','sendMessage')->name('send.message');
        Route::post('/set-cookie','setCookie')->name('set.cookie');
    });



});


//fallback route
Route::fallback(function() {
    return view('errors.404');
});


Route::get('/maintenance-mode', [CoreController::class, 'maintenanceMode'])->name('maintenance.mode')->middleware(['sanitizer']);

 /** security and captcha */
 Route::controller(CoreController::class)->middleware(["sanitizer"])->group(function () {

    Route::get('/security-captcha',"security")->name('dos.security');
    Route::post('/security-captcha/verify',"securityVerify")->name('dos.security.verify');
    Route::get('/default/image/{size}', [CoreController::class, 'defaultImageCreate'])->name('default.image');
    Route::get('/default-captcha/{randCode}', [CoreController::class,'defaultCaptcha'])->name('captcha.genarate');

});



Route::get('/error/{message?}', function (?string $message = null) {
    abort(403,$message ?? unauthorized_message());
})->name('error')->middleware(['sanitizer']);






