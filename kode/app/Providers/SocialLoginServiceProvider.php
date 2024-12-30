<?php

namespace App\Providers;

use App\Enums\StatusEnum;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Config;
class SocialLoginServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        try {

            $oauthCreds = json_decode(site_settings('social_login'),true);
            if ($oauthCreds) {
                foreach( $oauthCreds as $key => $creds){
                    if($creds['status'] == (StatusEnum::true)->status()){
                        $medium = str_replace("_oauth","",$key);
                        $config_arr = array(
                            'client_id'     => $creds['client_id'],
                            'client_secret' => $creds['client_secret'],
                            'redirect'      => url('login/'.$medium.'/callback'),
                        );
                        Config::set('services.'.$medium, $config_arr);
                    }
                }
            }


        }catch(\Exception $exception){

        }
    }
}
