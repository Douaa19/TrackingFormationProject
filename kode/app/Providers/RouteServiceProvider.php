<?php

namespace App\Providers;

use App\Enums\StatusEnum;
use App\Models\Visitor;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/user/dashboard';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        
        Route::middleware(['web'])->group(base_path('routes/install.php'));
        Route::middleware(['web'])->group(base_path('routes/admin.php'));
        Route::middleware('api')->prefix('api')->group(base_path('routes/api.php'));
        Route::middleware(['web'])->group(base_path('routes/web.php'));
        Route::middleware(['web'])->group(base_path('routes/auth.php'));


        try {
            if(DB::connection()->getDatabaseName()){
                $this->configureRateLimiting();
            }
        } catch (\Throwable $th) {
          
        }
     



    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {


        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });

        try {
            RateLimiter::for('refresh', function(Request $request){
                if(Schema::hasTable('settings')){
                    if(site_settings('dos_prevent') == StatusEnum::true->status()){

                        $key          = 'dos.'.get_real_ip(); 
                        $maxAttempt   = (int) site_settings(
                                                    key:"dos_attempts",
                                                    default :10
                                                );
                        $sec          = (int) site_settings( 
                                                            key:"dos_attempts_in_second",
                                                            default:10,
                                                            );
                        if(RateLimiter::tooManyAttempts($key,$maxAttempt)){

                            $ipinfo         = get_ip_info();
                            $ipAddress      = get_real_ip();
                            $ip             = Visitor::insertOrupdtae($ipAddress,$ipinfo);
                            if(site_settings("dos_security") == 'block_ip'){
                                $ip->is_blocked = StatusEnum::true->status();
                                $ip->save();
                            }
                            else{
                                session()->forget('dos_captcha');
                                session()->put("security_captcha",true);
                            }
                            
                        }
                        else{
                            RateLimiter::hit($key,$sec);
                        }
                    }
                }
            });

        } catch (\Throwable $th) {

        }

    }
}