<?php
namespace App\Http\Utility;

use App\Enums\StatusEnum;
use App\Models\CustomNotifications;
use App\Models\MailConfiguration;
use Illuminate\Support\Facades\Mail;
use GuzzleHttp\Client;
use App\Models\EmailTemplates;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Validation\Rules\Enum;

class SendNotification
{

       

       /**
        * send database notifications
        */
       public static function  database_notifications(array $data,$user,$notifyBy, $notify){

              $customNotifications                   = new CustomNotifications();
              $customNotifications->notify_id        = $user->id;
              $customNotifications->notify_by        = $notifyBy;
              $customNotifications->data             = json_encode($data);
              $customNotifications->is_read          = (StatusEnum::false)->status();
              $customNotifications->notification_for =  $notify;
              $customNotifications->save();
              return  $customNotifications;
       }

       public static function slack_notifications($admin,$data ,$type = 'Ticket Notifications'){

            $webhookUrl =  site_settings("slack_web_hook_url");
            $client = new Client();
            $dateTime = "*  ".getDateTime(Carbon::now())."* ".  " | ".  translate($type);
            $payload = [
                "blocks" => array(
                    array(
                        "type" => "header",
                        "text" => array(
                            "type" => "plain_text",
                            "text" => ":bell:  ".  translate('New Notifications')  ." :bell:"
                        )
                    ),
                    array(
                        "type" => "context",
                        "elements" => array(
                            array(
                                "text" => $dateTime,
                                "type" => "mrkdwn"
                            )
                        )
                    ),
                    array(
                        "type" => "divider"
                    ),
                    array(
                        "type" => "section",
                        "text" => array(
                            "type" => "mrkdwn",
                            "text" => translate($type)
                        )
                    ),
                    array(
                        "type" => "section",
                        "text" => array(
                            "type" => "mrkdwn",
                            "text" => $data['messsage']
                        ),
                        "accessory" => array(
                            "type" => "button",
                            "text" => array(
                                "type" => "plain_text",
                                "text" => $data['ticket_id'],
                                "emoji" => true
                            ),
                            "url"=> $data['route'],
                            "style" => "primary",
                        )
                    ),
                
                ),
                "username" => site_settings("site_name")
         
            ];

            if(site_settings("slack_channel")){
                $payload['channel'] = site_settings("slack_channel");
            }

            try {
                $client->request('POST', $webhookUrl, [
                    'json' => $payload,
                ]);
            } catch (\Exception $e) {
                // Handle the exception
            }
    
       }

}