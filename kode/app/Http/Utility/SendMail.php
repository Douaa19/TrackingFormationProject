<?php
namespace App\Http\Utility;

use App\Enums\StatusEnum;
use App\Models\MailConfiguration;
use Illuminate\Support\Facades\Mail;

use App\Models\EmailTemplates;
use Illuminate\Support\Arr;

class SendMail
{
    
    
    public static function MailNotification($userInfo, $emailTemplate =  null, $code = [] ,$messages = null)
    {
      
    	$mailConfiguration = MailConfiguration::where('id', site_settings('email_gateway_id'))->where('status', (StatusEnum::true)->status())->first();
    	if(!$mailConfiguration){
    		return;
    	}
       
        if(!$messages){
            $emailTemplate = EmailTemplates::where('slug', $emailTemplate)->first();

            $messages = str_replace("{{username}}", @$userInfo->username ? $userInfo->username : $userInfo->name , site_settings('default_mail_template'));
            $messages = str_replace("{{message}}", @$emailTemplate->body, $messages);
            $messages = str_replace("{{site_name}}", @site_settings('site_name'), $messages);
            $messages = str_replace("{{logo}}", @getImageUrl(getFilePaths()['site_logo']['path']."/".site_settings('site_logo_lg')), $messages);

            $ticketNumber = Arr::get($code ,'ticket_number',null );
            foreach ($code as $key => $value) {
                $messages = str_replace('{{' . $key . '}}', $value, $messages);
            }
        }

        $subject =  @$emailTemplate ?  @$emailTemplate->subject : $userInfo->subject; 
       
    	if($mailConfiguration->name === "PHP MAIL"){
    		self::SendPHPmail(site_settings('email'),  site_settings('site_name'), $userInfo->email, $subject, $messages ,@$ticketNumber);
    	}
        elseif($mailConfiguration->name === "SMTP"){
    		self::SendSMTPMail($mailConfiguration->driver_information->from->address, $userInfo->email,  site_settings('site_name'), $subject, $messages,@$ticketNumber);
    	}
        elseif($mailConfiguration->name === "SendGrid Api"){
            self::SendGrid($mailConfiguration->driver_information->from->address,  site_settings('site_name'), $userInfo->email, $subject, $messages, @$mailConfiguration->driver_information->app_key ,@$ticketNumber);
        }
    }

    public static function SendPHPmail($emailFrom, $sitename, $emailTo, $subject, $messages ,$ticketNumber =  null)
    {
        $headers = "From: $sitename <$emailFrom> \r\n";
        $headers .= "Reply-To: $sitename <$emailFrom> \r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=utf-8\r\n";
        if ($ticketNumber !== null) {
            $subject .= " to ticket-number:$ticketNumber";
        }
        
        try {
            @mail($emailTo, $subject, $messages, $headers); 
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public static function SendSMTPMail($emailFrom, $emailTo, $fromName, $subject, $messages , $ticketNumber =  null)
    {  

        try{ 
            Mail::send([], [], function ($message) use ($messages, $emailFrom, $fromName, $emailTo, $subject ,$ticketNumber) {

                    if ($ticketNumber !== null) {
                        $subject .= " to ticket-number:$ticketNumber";
                    }
                    $message->to($emailTo) 
                    ->subject($subject)
                    ->from($emailFrom,$fromName)
                    ->setBody($messages, 'text/html','utf-8');
                   
            });
            return true;

        }catch (\Exception $e){  
            return false;
        } 
    } 

    public static function SendGrid($emailFrom,$fromName, $emailTo, $subject, $messages, $credentials ,$ticketNumber =  null)
    { 
        try{

            if ($ticketNumber !== null) {
                $subject .= " to ticket-number:$ticketNumber";
            }
            $email = new \SendGrid\Mail\Mail();
            $email->setFrom($emailFrom, $fromName);
            $email->setSubject($subject);
            $email->addTo($emailTo);
            $email->addContent("text/html", $messages);

     
            $sendgrid = new \SendGrid($credentials);
            $response = $sendgrid->send($email);
            return true;
        }catch(\Exception $e){
            return false;
        }
    }
}