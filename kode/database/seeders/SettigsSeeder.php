<?php

namespace Database\Seeders;

use App\Enums\StatusEnum;
use App\Models\Settings;
use Illuminate\Database\Seeder;

class SettigsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $settings  = [

            'ticket_security' => StatusEnum::false->status(),
            'force_ssl'       => StatusEnum::false->status(),

            'social_login' => ([
                'azure_oauth' => [
                    'client_id'     => '@@',
                    'client_secret' => '@@',
                    'status'        => '1',
                ],
                'envato_oauth' => [
                    'personal_token' => '@@',
                    'client_id'      => '@@',
                    'client_secret'  => '@@',
                    'status'         => '1',
                ],
            ]),
            'maintenance_mode'        => StatusEnum::false->status(),
            "maintenance_title"       => "The site is currently down for maintenance.",
            "maintenance_description" => "We apologize for any inconveniences caused. We've almost done. ",
        ];


        $existingSettings =   Settings::pluck("key")->toArray();

        foreach($settings as $key => $value){
            if(in_array($key, $existingSettings)){

                if($key == 'social_login'){
                    $setting =  Settings::where('key',$key)->first();
                    $credential = json_decode($setting->value,true);
                    $value     =  array_merge($credential,$value);
                }
            
                Settings::updateOrInsert(
                    ['key'    => $key],
                    ['value'  => $value]
                );
            }
        }

        optimize_clear();

    }
}
