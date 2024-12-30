<?php
namespace App\Http\Utility;

use App\Enums\StatusEnum;
use Twilio\Rest\Client;

use App\Models\EmailTemplates;
use Infobip\Api\SendSmsApi;
use Infobip\Configuration;
use Infobip\Model\SmsAdvancedTextualRequest;
use Infobip\Model\SmsDestination;
use Infobip\Model\SmsTextualMessage;
use App\Models\SmsGateway;
use GuzzleHttp\Client as GazzleClient;
use Exception;

class SendSMS{




	public static function SmsNotification($userInfo, $smsTemplate =  null, $code = [] ,$messages = null)
    {
      
    	$smsConfiguration = SmsGateway::where('id', site_settings('sms_gateway_id'))->where('status', (StatusEnum::true)->status())->first();
    	if(!$smsConfiguration){
    		return;
    	}


		if(!$messages){

			$smsTemplate = EmailTemplates::where('slug', $smsTemplate)->first();
			$messages = str_replace("{{username}}", @$userInfo->username ? $userInfo->username : $userInfo->name , site_settings('default_mail_template'));
			$messages = str_replace("{{message}}", @$smsTemplate->sms_body, $messages);
			foreach ($code as $key => $value) {
				$messages = str_replace('{{' . $key . '}}', $value, $messages);
			}
	
		}
       
    
    	if($smsConfiguration->gateway_code === "101NEX"){
    		self::nexmo($smsConfiguration->credential,  @$userInfo->phone, $messages);
    	}
        elseif($smsConfiguration->gateway_code === "102TWI"){
    		self::twilio($smsConfiguration->credential,  @$userInfo->phone, $messages);
    	}
        elseif($smsConfiguration->gateway_code === "103BIRD"){
            self::messageBird($smsConfiguration->credential,  @$userInfo->phone, $messages);
        }
        elseif($smsConfiguration->gateway_code === "104INFO"){
            self::infobip($smsConfiguration->credential,  @$userInfo->phone, $messages);
        }
    }



	public static function nexmo($credential,$to,$message)
	{
		try {
			$basic = new \Vonage\Client\Credentials\Basic($credential->api_key, $credential->api_secret);
			$client = new \Vonage\Client($basic);
			$response = $client->sms()->send(
		    	new \Vonage\SMS\Message\SMS($to, $credential->sender_id, $message)
			);

		} 
		catch (\Exception $e){
			
	    }
		
	}

	public static function twilio($credential,$to,$message)
	{

        try{
            $twilioNumber = $credential->from_number;
            $client = new Client($credential->account_sid, $credential->auth_token);
            $create = $client->messages->create('+'.$to, [
                'from' => $twilioNumber,
                'body' => $message
            ]);

        }catch (\Exception $e) {

	        
        }
	}

	public static function messageBird($credential,$to,$message)
	{
	
		try {
			$MessageBird 		 = new \MessageBird\Client($credential->access_key);
			$Message 			 = new \MessageBird\Objects\Message();
			$Message->originator = $credential->sender_id;
			$Message->recipients = array($to);
			$Message->body 		 = $message;
			$MessageBird->messages->create($Message);

	
		} catch (\Exception $e) {

		}
	}


	public static function infobip($credential,$to,$message)
	{

		try {
			$BASE_URL = $credential->infobip_base_url;
			$API_KEY = $credential->infobip_api_key;
			$SENDER = $credential->sender_id;
			$RECIPIENT = $to ;
			$MESSAGE_TEXT = strip_tags($message);

			$configuration = (new Configuration())
				->setHost($BASE_URL)
				->setApiKeyPrefix('Authorization', 'App')
				->setApiKey('Authorization', $API_KEY);
			$client = new GazzleClient();
			$sendSmsApi = new SendSMSApi($client, $configuration);
			$destination = (new SmsDestination())->setTo($RECIPIENT);
			$message = (new SmsTextualMessage())
				->setFrom($SENDER)
				->setText($MESSAGE_TEXT)
				->setDestinations([$destination]);
			$request = (new SmsAdvancedTextualRequest())->setMessages([$message]);
			$smsResponse = $sendSmsApi->sendSmsMessage($request);
	
			return $smsResponse;

		} catch (\Throwable $e) {

		}
	}



}
