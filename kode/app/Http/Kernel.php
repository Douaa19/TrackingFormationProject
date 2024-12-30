<?php

namespace App\Http;

use App\Http\Middleware\AgentMiddleware;
use App\Http\Middleware\HttpsMiddleware;
use App\Http\Middleware\MaintenanceMode;
use App\Http\Middleware\MaintenanceModeMiddleware;
use App\Http\Middleware\PurchaseValidation;
use App\Http\Middleware\Sanitization;
use App\Http\Middleware\SecurityMiddleware;
use App\Http\Middleware\SoftwareVerification;
use App\Http\Middleware\TicketDrafMessage;
use App\Http\Middleware\UserRegisterMiddleware;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{

    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,
        \App\Http\Middleware\TrustProxies::class,
        \Fruitcake\Cors\HandleCors::class,
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array<string, array<int, class-string|string>>
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\Http\Middleware\LanguageMiddleware::class,
            HttpsMiddleware::class,
            SoftwareVerification::class,
            PurchaseValidation::class
        ], 
        'api' => [
            // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:refresh',
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array<string, class-string|string>
     */
    protected $routeMiddleware = [

        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'admin' => \App\Http\Middleware\IfNotCheckAdmin::class,
        'admin.guest' => \App\Http\Middleware\IfCheckAdmin::class,
        'checkUserStatus' => \App\Http\Middleware\CheckUserStatus::class,
        'maintanance' => \App\Http\Middleware\MaintenanceMode::class,
        'demo.mode' => \App\Http\Middleware\DemoMode::class,
        'agent'=> AgentMiddleware::class,
        'user.register'=> UserRegisterMiddleware::class,
        'sanitizer' => Sanitization::class,
        'maintenance.mode' => MaintenanceModeMiddleware::class,
        'dos.security' => SecurityMiddleware::class,

     
    ];
}
