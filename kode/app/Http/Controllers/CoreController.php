<?php

namespace App\Http\Controllers;

use App\Enums\PriorityStatus;
use App\Enums\StatusEnum;
use App\Enums\TicketStatus;
use App\Http\Controllers\Controller;
use App\Http\Services\TicketService;
use App\Http\Triggers\TriggerAction;
use App\Http\Utility\SendMail;
use App\Jobs\SendEmailJob;
use App\Models\Admin;
use App\Models\IncommingMailGateway;
use App\Models\Language;
use App\Models\Priority;
use App\Models\Settings;
use App\Models\SupportMessage;
use App\Models\SupportTicket;
use App\Models\TicketStatus as ModelsTicketStatus;
use App\Models\TicketTrigger;
use App\Models\User;
use Carbon\Carbon;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Support\Facades\Session;
use Gregwar\Captcha\PhraseBuilder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Closure;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use \Webklex\IMAP\Facades\Client;
use Illuminate\Support\Str;
use  App\Models\TicketStatus as SupportTicketStatus;
class CoreController extends Controller
{
      public $ticketService;

      public function __construct(){
        $this->ticketService = new TicketService();
      }
    
      /**chnage language method */
      public function languageChange(string $code ){
        
        $response = [
            'status' => "success",
            'message' => 'Language Switched Successfully'
        ];

        if(!Language::where('code', $code)->exists()){
            $code = 'en';
        }
        optimize_clear();
        session()->put('locale', $code);
        app()->setLocale($code);

        // Handle AJAX requests
        if(request()->ajax()) {
            $response['code'] = $code;
            return response()->json($response);
        }

        return back()->with("success", translate('Language Switched Successfully'));
      }

      public function defaultImageCreate(string $size = null){

          $width            = explode('x',$size)[0];
          $height           = explode('x',$size)[1];
          $image            = imagecreate($width, $height);
          $fontFile         = realpath('assets/font') . DIRECTORY_SEPARATOR . 'RobotoMono-Regular.ttf';
          if($width > 100 && $height > 100){
              $fontSize     = 30;
          }else{
              $fontSize     = 5;
          }
          $text = $width . 'X' . $height;
          $backgroundcolor  = imagecolorallocate($image, 237, 241, 250);
          $textcolor        = imagecolorallocate($image, 107, 111, 130);
          imagefill($image, 0, 0, $textcolor);
          $textsize         = imagettfbbox($fontSize, 0, $fontFile, $text);
          $textWidth        = abs($textsize[4] - $textsize[0]);
          $textHeight       = abs($textsize[5] - $textsize[1]);
          $xx = ($width - $textWidth) / 2;
          $yy = ($height + $textHeight) / 2;
          header('Content-Type: image/jpeg');
          imagettftext($image, $fontSize, 0, $xx, $yy, $backgroundcolor , $fontFile, $text);
          imagejpeg($image);
          imagedestroy($image);
      }


      
     /**
     * genarate default cpatcha code
     *
     * @return void
     */
    public function defaultCaptcha(int | string $randCode){
        
        $phrase   = new PhraseBuilder;
        $code     = $phrase->build(4);
        $builder  = new CaptchaBuilder($code, $phrase);
        $builder->setBackgroundColor(220, 210, 230);
        $builder->setMaxAngle(25);
        $builder->setMaxBehindLines(0);
        $builder->setMaxFrontLines(0);
        $builder->build($width = 100, $height = 40, $font = null);
        $phrase   = $builder->getPhrase();

        if(Session::has('gcaptcha_code')) {
            Session::forget('gcaptcha_code');
        }
        Session::put('gcaptcha_code', $phrase);
        header("Cache-Control: no-cache, must-revalidate");
        header("Content-Type:image/jpeg");
        $builder->output();
    }


    public function cron(){


        // EMAIL TO TICKET
        if(site_settings(key:'email_to_ticket',default:0) == 1){
            $this->emailToTickets();
        }

        if(site_settings('auto_best_agent') == StatusEnum::true->status()){

            $agents = Admin::with(["response","tickets"])
                        ->withCount(["response","tickets"])
                        ->agent()
                        ->active()
                        ->get();

            foreach($agents->chunk(paginateNumber()) as $chunksAgents){

                foreach($chunksAgents as $agent){
   

                    if($agent->response_count > 0){

                        $reponseTimeReq  = (int) site_settings('avg_response_time');
                        $avgResponseTime = (int) round($agent->response->avg("response_time")*60);

                        if($agent->response_count >= site_settings('number_of_tickets')  && $avgResponseTime <=  $reponseTimeReq){
                            
                            $agent->best_agent = StatusEnum::true->status();
                            $agent->save();

                        }

                    }
             
                }
            }
        }

        if(site_settings('ticket_auto_close') ==  StatusEnum::true->status()){
            $this->_ticketAutoClose();
        }

        // FIRE TIMEFRAME TRIGGER
        $this->timeframeTrigger();


        if(site_settings(key:'envato_verification',default:0) == 1 && 
          site_settings(key:'envato_support_verification',default:0) == 1){
            $this->envatoSupportValidation();
        }
        // ENVATO VERIFICATION




 
   
        Settings::updateOrInsert(
            ['key'    => "last_cron_run"],
            ['value'  => Carbon::now()]
        );


    }


    public function envatoSupportValidation() : Void {

        SupportTicket::with(['messages'])->whereNotNull('envato_payload')
                                         ->whereNotNull('is_support_expired')
                                         ->where('is_support_expired' , 0)
                                         ->lazy()
                                         ->each(function( SupportTicket $ticket)  {
                                            if($ticket->envato_payload){

                                                $supportUntill = @$ticket->envato_payload->supported_until;
                                                if($supportUntill){
                                                    $supported_until   = Carbon::parse($supportUntill);
                                                    if (!$supported_until->isFuture()){
                                                        $ticketStatus = SupportTicketStatus::where("id",site_settings(key:'ticket_support_expire_status',default:-1))->first();
                                                        $ticket->is_support_expired = 1;
                                                        if($ticketStatus) $ticket->status = $ticketStatus->id;
                                                        $ticket->saveQuietly();

                                                          SendMail::MailNotification(userInfo :(object)[
                                                            'name'    => $ticket->name,
                                                            'email'   => $ticket->email,
                                                            'subject' => 'Support expired'
                                                        ],code : [] , messages :site_settings('envato_expired_email'));
                                                                    
                                                    }

                                                }

                                            }
                       
         
                                         });

    }


    public function emailToTickets() :void {



        $gateways = IncommingMailGateway::active()->get();


     
        foreach( $gateways  as $gateway){

                try {

                    $client = Client::make([
                        'host'          =>  $gateway->credentials->host,
                        'port'          =>  $gateway->credentials->port,
                        'encryption'    =>  $gateway->credentials->encryption,
                        'validate_cert' =>  true,
                        'username'      =>  $gateway->credentials->username,
                        'password'      =>  $gateway->credentials->password,
                        'protocol'      =>  $gateway->credentials->protocol,
                    ]);
                    $client->connect();
                    $defaultPriority         = Priority::default()->first();
                    $defaultStatus           = ModelsTicketStatus::default()->first();

                    $floders                 = $client->getFolders();

                    $emailKeywords = @$gateway->match_keywords ?? [];
                    foreach($floders as $folder){
                        $page =  1;

                        do {

                            foreach($folder->messages()->unseen()->limit(10,  $page)->get() as $message){

                                $body          = $message->getHTMLBody(true);
                                $ticketBody    = strip_tags($body);
                                $subject       = $message->getSubject();

                                $ticketId      = $this->getTicketId($subject);

                                if($ticketId){
                                    $this->ticketReply($ticketId ,$message,$defaultStatus);
                                }else{
                                    if(!Str::contains( $ticketBody,@$emailKeywords?? []) && !Str::contains( $subject,@$emailKeywords?? []) ){
                                        continue;
                                    }
                                    if(SupportTicket::where('mail_id',$message->uid)->exists()) continue;
    
                                    $this->createTicket($message ,$message->getHTMLBody(true) , $defaultPriority ,$defaultStatus ,$gateway);
                                }

                            }
                            $page++;

                            usleep( 250000 );

                        } while ($folder->messages()->unseen()->limit(10,   $page)->get()->count() > 0 );

                
                    }
            
                } catch (\Exception $ex) {
                }
        }


    }


    public function getTicketId(string $subject) :mixed{

        $pattern = '/ticket-number:([^\s]+)/';
        return preg_match($pattern, $subject, $matches) ? @$matches[1] : null;
    }

    public function storFiles(mixed $attachments) :array{

        $ticket_files = [];

        try {
   
            if( $attachments){
                $attachments->each(function ($file) use (&$ticket_files ) {
                 
                    $name = uniqid() . time() . '.' . $file->getExtension();

                    $file->save((getFilePaths()['ticket']['path']), $name );
                    $ticket_files[] = $name;
                });

                return $ticket_files;
            }
    

        } catch (\Throwable $th) {

        }

        return $ticket_files;

    }


    public function ticketReply(string | int $ticketId ,mixed $message ,$defaultStatus) :mixed{

        
        $ticket = SupportTicket::with(['agents'])
                     ->where('ticket_number',$ticketId)
                     ->first();
                     
        if(!$ticket)  return false;

        $ticket->user_last_reply =  Carbon::now();
        $ticket->status          =  $defaultStatus ? $defaultStatus->id :TicketStatus::PENDING->value;
        $ticket->saveQuietly();


        if(SupportMessage::where('mail_id',$message->uid)->exists())  return false;

        $ticket_files   = $this->storFiles($message->getAttachments());

        $body           = $message->getHTMLBody(true);
        $trimBody       = ($body);
       
        $supportMessage                    = new SupportMessage();
        $supportMessage->support_ticket_id = $ticket->id;
        $supportMessage->mail_id           = $message->uid;
        $supportMessage->admin_id          = null;

        $supportMessage->message           = $trimBody;

        $supportMessage->file              = json_encode($ticket_files);
        $supportMessage->save();

        $route         = route('admin.ticket.view',$ticket->ticket_number);
        $notifyMessage = translate('Hello Dear !!!'). $ticket->name . " Just Replied To a Conversations";

        $mailCode = [
            "role"          => 'User',
            "name"          => $ticket->name ,
            "ticket_number" => $ticket->ticket_number,
            "link"          => $route
        ];


        #NOTIFY SUPERADMIN
        $this->ticketService->notifyAgent($ticket,null, $notifyMessage ,"user_reply_admin" ,$route ,"TICKET_REPLY",
        $mailCode);

        #NOTIFY ALL SUPER AGENT
        $superAgents = Admin::active()->superagent()->get();

        foreach($superAgents as $agent){
            $this->ticketService->notifyAgent($ticket,$agent, $notifyMessage ,"user_reply_admin" ,$route ,"TICKET_REPLY",
            $mailCode);
        }
        
        #NOTIFY ALL AGENT WITH THE TICKETS
        $agents = $ticket->agents;
        foreach($agents as $agent){
            $this->ticketService->notifyAgent($ticket,$agent, $notifyMessage ,"user_reply_agent" ,$route ,"TICKET_REPLY",
            $mailCode);
        }

        

        return $supportMessage;

    }


    public function createTicket(mixed $message ,string $ticketBody ,mixed $defaultPriority ,$defaultStatus ,$gateway) :void{

        $email      = $message->getFrom()[0]->mail;
        $name       = $message->getFrom()[0]->personal;

        $user       = User::where('email',$email)->first();

        $ticket_files            = [];
        $ticket                  =  new SupportTicket();
        $ticket->user_id         =  $user ? $user->id : null;
        $ticket->mail_id         =  $message->uid;
        $ticket->category_id     =  null ;
        $ticket->subject         =  $message->getSubject();
        $ticket->name            =  $name  ;
        $ticket->email           =  $email ;
        $ticket->status          =  $defaultStatus ? $defaultStatus->id :TicketStatus::PENDING->value;
        $ticket->priority_id     =  $defaultPriority?->id;
        $ticket->department_id   =  @$gateway->department_id;
        $ticket->priority        =  PriorityStatus::MEDIUM;
        $ticket->ticket_data     =  json_encode([]);
        $ticket->message         =  $ticketBody;
        $ticket->user_last_reply =  Carbon::now();
        $ticket->save();

        $ticket->ticket_number   =  $this->ticketService->getTicketNumber($ticket->id);
        $ticket->saveQuietly();



        $ticket_files            = [];
        $ticket_files   = $this->storFiles($message->getAttachments());

        $supportMessage          =  $this->ticketService->ticketMessage($ticket, $ticket_files , [] );
        $response                =  $this->ticketService->assignTickets($ticket,$supportMessage);

        $message                 =  translate("You Have a New Unassigned Ticket");
        if($response){
            $message             =  translate("You Have a New Assigned Ticket");
        }

        $this->ticketService->notifyAgent($ticket,null,$message,'new_ticket' ,route("admin.ticket.view",$ticket->ticket_number));

        #NOTIFY ALL SUPER AGENT
        $superAgents = Admin::active()->superagent()->get();
        foreach($superAgents as $agent){
             $this->ticketService
                     ->notifyAgent($ticket,$agent,$message,'new_ticket' ,route("admin.ticket.view",$ticket->ticket_number));
        }

        
        

        $code = [
            'ticket_number'     => $ticket->ticket_number ,
            'link'              => route('ticket.reply',  $ticket->ticket_number)
        ];
        SendEmailJob::dispatch($ticket, "SUPPORT_TICKET_REPLY" ,$code);
    }


    /**
     * Fire Timeframe Trigger
     *
     * @return void
     */
    public function timeframeTrigger() :void{


        try {

            $triggers = TicketTrigger::latest()->active()->get();

            SupportTicket::with(['messages'])->lazy()->each(function( SupportTicket $ticket) use ( $triggers)  {
                  $this->runAgainstTicket($ticket, $triggers);
            });

        } catch (\Throwable $th) {
         
        }

    
    }


    /**
     * Run Triggers Against Every Ticket
     *
     * @param SupportTicket $ticket
     * @param Collection $triggers
     * @return void
     */
    public function runAgainstTicket(SupportTicket $ticket , Collection $triggers) :void{


        $action = (new TriggerAction($ticket,$ticket->getOriginal()));
        $triggers->each(function (TicketTrigger $trigger) use (  $action ){
            $action->triggerAction($trigger,true);
        });

    }



    
    /**
     * Ticket auto close function
     * 
     */
     public function _ticketAutoClose(){

        $status        = site_settings(key:'ticket_close_status',default:-1);

        $tickets       = SupportTicket::with(['messages'])->where('status',$status)->get();
        $autoCloseDay  = (int) site_settings(key:'ticket_close_days',default:1);

        foreach($tickets as $ticket){

            $lastResponse = $ticket->created_at;
            if($ticket->messages->count() > 0){
                $latestCustomerReply = $ticket->messages
                                              ->whereNull("admin_id")
                                              ->sortByDesc('created_at')
                                              ->first();
                if($latestCustomerReply){
                    $lastResponse = $latestCustomerReply->created_at;
                }
            }
        

            $currentDate        = Carbon::now();
            $lastResponseDate   = Carbon::parse($lastResponse);
            $daysDifference     = $currentDate->diffInDays($lastResponseDate);

            if($daysDifference >= $autoCloseDay){
                $ticket->status = TicketStatus::CLOSED->value; //ticket status checked
                $ticket->saveQuietly();
                $code = [
                    'ticket_number' => $ticket->ticket_number ,
                    'link'          => route('ticket.reply',$ticket->ticket_number)
                ];
                SendEmailJob::dispatch($ticket, "SUPPORT_TICKET_AUTO_CLOSED" ,$code);
            }

        }

     }


    public function aiContent(Request $request) : array{

       $apiKey  =  site_settings('open_ai_key');

        if(!$request->input('custom_prompt')){
            return [
                "status"  => false,
                "message" => 'Prompt Field is Required'
            ];
        }

        try {

            if(site_settings("open_ai")  == StatusEnum::false->status()){
                return [
                    "status"  => false,
                    "message" => translate("AI Module is Currently of Now"),
                ];
            }

            $prompt = '';
    
            $option = Arr::get(get_ai_option(),$request->input('ai_option'),null);
            $tone   = Arr::get(get_ai_tone(),$request->input('ai_tone'),null);
           
    
            $prompt .= strip_tags($request->input('custom_prompt'))."\n".  Arr::get(@$tone?? [] ,'prompt') . Arr::get(@$option ?? [] ,'prompt');

            if($request->input("language")){
                $prompt = strip_tags($request->input('custom_prompt'))."\n".'Write the Abovbe message in ' . $request->input("language") . ' language and Do not write translations.';
            }

            $client      = \OpenAI::client($apiKey);
    
            $result = $client->chat()->create([
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    [
                        "role"     => "user",
                        "content"  =>  $prompt 
                    ]
                ],
            ]);
    
            if(isset($result['choices'][0]['message']['content'])){
                $realContent                   = $result['choices'][0]['message']['content'];
    
                return [
                    "status"  => true,
                    "message" => strip_tags(str_replace(["\r\n", "\r", "\n"] ,"<br>",$realContent))
                ];
            }
    
            return [
                "status"  => false,
                "message" => 'No Result Found!!'
            ];
    
        } catch (\Exception $ex) {
            return [
                "status"  => false,
                "message" => strip_tags($ex->getMessage())
            ];
        }



    }
    


        /**
         * generate ai reply for ticket
         * 
         */
      public  function aiResult($request){

        $apiKey      =  site_settings('open_ai_key');

        $client      = \OpenAI::client($apiKey);

        $max_results = (int) $request->number_of_result;
        $max_tokens  = (int) $request->max_result_length;
      
        return  $client->completions()->create([

            'model'        => 'text-davinci-003',
            "temperature"  => (float)$request->ai_creativity_level,
            'prompt'       => $request->question,
            'max_tokens'   => $max_tokens,
            'n'            => $max_results,

        ]);

     }



     public  function maintenanceMode() :View | RedirectResponse{

        if(site_settings('maintenance_mode') == (StatusEnum::false)->status() ){
            return redirect()->route('home');
        }
        $title = 'Maintenance Mode';
        return view('maintenance_mode' ,compact('title'));

     }



     
    public function security() :View{

        if(site_settings('dos_prevent') == StatusEnum::true->status() && !session()->has('dos_captcha')){

            return view('dos_security',[
                "title"    =>  translate('Too many request')
            ]);
        }
        abort(403);
    }


    public function securityVerify(Request $request) :RedirectResponse{

    
        $request->validate([
            "captcha" =>   ['required' , function (string $attribute, mixed $value, Closure $fail) {
                if (strtolower($value) != strtolower(session()->get('gcaptcha_code'))) {
                    $fail(translate("Invalid captcha code"));
                }
            }]
        ]);

        session()->forget('gcaptcha_code');
        session()->forget('security_captcha');
        session()->put('dos_captcha',$request->input("captcha"));

        $route = 'home';
        if(session()->has('requested_route')){
            $route = session()->get('requested_route');
        }

        return redirect()->route($route);
    }

    
  
}
