<?php

namespace App\Http\Services;

use App\Enums\NotifyStatus;
use App\Enums\PriorityStatus;
use App\Enums\StatusEnum;
use App\Enums\TicketReply;
use App\Enums\TicketStatus;
use App\Http\Controllers\Controller;
use App\Http\Utility\SendNotification;
use App\Jobs\SendEmailJob;
use App\Jobs\SendSmsJob;
use App\Models\Admin;
use App\Models\AgentResponse;
use App\Models\AgentTicket;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Department;
use App\Models\FloatingChat;
use App\Models\Group;
use App\Models\Priority;
use App\Models\Subscriber;
use App\Models\SupportMessage;
use App\Models\SupportTicket;
use App\Models\TicketStatus as ModelsTicketStatus;
use App\Models\User;
use App\Traits\EnvatoManager;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Pusher\Pusher;
use Pdf;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class TicketService extends Controller
{


    use EnvatoManager;


    /**
     * Store a new ticket
     *
     * @param array $request_data
     * @return SupportTicket
     */
    public function storeTicket(array $request_data) : SupportTicket | RedirectResponse
    {


        return  DB::transaction(function() use ($request_data) {

            $defaultPriority         = Priority::default()->first();
            $defaultStatus           = ModelsTicketStatus::default()->first();

            $departmentId            = Arr::get($request_data , 'department_id',null);


            if($departmentId){
                $department = Department::where('id',$departmentId)->first();

                if(!$department) return back()->with('error',translate('Invalid department'));
            }
       


            $buypassPurchase            = Arr::get($request_data , 'buypass_purchase',false);


            #ENVATO VERIFICATION
            if(site_settings(key:'envato_verification',default:0) == 1 && 
              @$department && 
              @$department->envato_payload && 
              !$buypassPurchase){

                $purchaseKey = Arr::get($request_data , 'envato_purchase_key',null);
                if(!$purchaseKey) return back()->with('error',translate('Envato purchase key field is required'));
                    $envato_personal_token = json_decode(site_settings('social_login'), true)['envato_oauth']['personal_token'] ?? null;
                    $accessToken       = @$envato_personal_token;
                    $envato_payload    = $this->verifyPurchase($purchaseKey ,$accessToken);

                    $status            = Arr::get($envato_payload, 'status' ,false);
                    $errorMessage      = Arr::get($envato_payload, 'message' ,false);
        
                    if(!$status)  return back()->with("error", $errorMessage);

          
                    #VERIFY SUPPORT
                    if(site_settings(key:'envato_support_verification',default:0) == 1){

                        $supported_until = Arr::get($envato_payload,'supported_until');
                        
                        if($supported_until){
                            $supported_until   = Carbon::parse($supported_until);
                            $expiredDate       = $supported_until->format('l, F j, Y \a\t g:i A');
                            $isSupportExpired  = 0;
                            if (!$supported_until->isFuture()){
                                $isSupportExpired = 1;
                                return back()->with('error',"We regret to inform you that your support plan expired on {$expiredDate}. Please renew your support to continue receiving updates and assistance.");
                            }

                        }

                    }
            }

            $userId  = auth_user('web')
                                ? auth_user('web')->id
                                : null;
            if(request()->routeIs('admin.ticket.store'))  $userId  =  Arr::get($request_data ,'user_id', null) ;

            $messageBody =  build_dom_document( $request_data['description']);

            
            $ticket_files            = [];
            $ticket                  =  new SupportTicket();

            $ticket->user_id         =  $userId ;
            $ticket->category_id     =  @$request_data['category'] ;
            $ticket->subject         =  @$request_data['subject'] ;
            $ticket->name            =  @$request_data['name'];
            $ticket->email           =  @$request_data['email'] ;
            $ticket->status          =  $defaultStatus ? $defaultStatus->id :TicketStatus::PENDING->value;
            $ticket->priority_id     =  Arr::get($request_data,'priority',@$defaultPriority?->id);
            $ticket->priority        =  PriorityStatus::MEDIUM;
            $ticket->ticket_data     =  json_encode(Arr::except($request_data, ['category','priority','name','email','subject','description','attachments','user_id','department_id','buypass_purchase']));
            $ticket->message         =  Arr::get($messageBody , 'html',null);
     
            $ticket->department_id   =  Arr::get($request_data , 'department_id',null);
            $ticket->save();
            $ticket->ticket_number   =  $this->getTicketNumber($ticket->id);
            $ticket->envato_payload  =  @$envato_payload;
            $ticket->is_support_expired  =  @$isSupportExpired;
            $ticket->saveQuietly();
            $ticket_files            = [];

            try {
                if(isset($request_data['attachments'][0])){
                    $ticket_files    =  $this->storeFiles( $request_data['attachments']);
                }
            } catch (\Throwable $th) {

            }


            # store supportmessage

            $supportMessage =  $this->createSupportMessage($ticket, [
                'body'      => $messageBody,
                'files'     => json_encode($ticket_files)
            ]);

            $response                =  $this->assignTickets($ticket,$supportMessage);

            $message                 =  translate("You Have a New Unassigned Ticket");
            if($response){
                $message             =  translate("You Have a New Assigned Ticket");
            }

            $this->notifyAgent($ticket,null,$message,'new_ticket' ,route("admin.ticket.view",$ticket->ticket_number));

            #NOTIFY ALL SUPER AGENT
            $superAgents = Admin::active()->superagent()->get();
            foreach($superAgents as $agent){
                    $this->notifyAgent($ticket,$agent,$message,'new_ticket' ,route("admin.ticket.view",$ticket->ticket_number));
            }

            $code = [
                'ticket_number'     => $ticket->ticket_number ,
                'link'              => route('ticket.reply',  $ticket->ticket_number)
            ];
            SendEmailJob::dispatch($ticket, "SUPPORT_TICKET_REPLY" ,$code);

            return $ticket;
        });

    }


    public function getTicketNumber(int $ticketId):string{

        $prefix    = site_settings('ticket_prefix');

        $hasSuffix = site_settings(key :'ticket_suffix',default:1);

        $suffix = $hasSuffix == StatusEnum::false->status() 
                        ?  $ticketId
                        : generateTicketNumber();

        return $prefix ? $prefix.$suffix : $suffix;


    }

    /**
     * assgin tickets to agents
     */
     public function assignTickets($ticket,$supportMessage){

        $agents = Admin::with(['tickets'])
                                ->agent()
                                ->active()
                                ->get();

        $agents = $agents->filter(function ($agent) use ($ticket) {
            return in_array((string)@$ticket->category_id, (array)json_decode($agent->categories, true));
        });

        $status = false;

        $groupBaseTicketAssignEnabled = site_settings('group_base_ticket_assign') == (StatusEnum::true)->status();
        $autoTicketAssignmentEnabled  = site_settings('auto_ticket_assignment')   == (StatusEnum::true)->status();

        if ($groupBaseTicketAssignEnabled) {
            $group = Group::with("members")->where("priority_id", $ticket->priority_id)->first();
            $assignTo = $group ? $group->members : $agents;
            $this->manualTicketAssignment($assignTo, $ticket , "Ticket Assigned By Priority Group");
            $status = true;
        } elseif (count($agents) > 0) {

            if($autoTicketAssignmentEnabled){
                $response = $this->autoTicketAssignment($agents, $ticket);

                if (!$response) {
                    $this->manualTicketAssignment($agents, $ticket);
                }
            }
            else{
                $this->manualTicketAssignment($agents, $ticket);
            }

            $status = true;
        }

        return $status;
     }


      public function manualTicketAssignment($agents,$ticket ,$shortNotes = "Ticket Assigned Manually [BY CATEGORY]"){


          $bestAgents  = $agents->where('best_agent',StatusEnum::true->status());

          if($bestAgents->count() > 0) $agents    = $bestAgents ;


          foreach($agents->chunk(paginateNumber()) as $chunkAgents){

            foreach($chunkAgents as $agent) {
    

                if($this->ticketPermissions($agent)){

                    $data =
                    [
                        "agent_id"    => $agent->id ,
                        "ticket_id"   => $ticket->id,
                        "short_notes" => $shortNotes
                    ];

                    $agent->tickets()->attach([$data]);
                    $this->notifyAgent($ticket,$agent,null,"new_ticket",route("admin.ticket.view",$ticket->ticket_number));

                }
            }

         }
      }

      /**
       *  get ticket permissions
       */

       public function ticketPermissions($agent){

           $permissions =  json_decode($agent->permissions,true) ? json_decode($agent->permissions,true) :[] ;
            if(in_array("manage_tickets",$permissions)){

                return true;
            }
            return false;
       }


     /**
      * auto ticket assignments
      */
      public function autoTicketAssignment($agents,$ticket){

            $status = false;
            $lat    =  null;
            $lon    =  null;

             try {
                if($ticket->user){
                    $lat = $ticket->user->latitude;
                    $lon = $ticket->user->longitude;
                }
                else{
                    $address = get_ip_info();
                    if(isset($address['lon']) &&  isset($address['lat'])){
                        $lat = $address['lat'];
                        $lon = $address['lon'];
                    }
                }
                if($lat && $lon){
                    $agent      = $this->nearestAgent($lat,$lon,$agents);

                    if($this->ticketPermissions($agent)){
                        $status = true;
                        $data   =
                        [
                            "agent_id"    => $agent->id ,
                            "ticket_id"   => $ticket->id,
                            "short_notes" => "Ticket Assigned Automatically [BY lOCATION]"
                        ];
                        $agent->tickets()->attach([$data]);
                        $this->notifyAgent($ticket,$agent,null,'new_ticket',route("admin.ticket.view",$ticket->ticket_number) );
                     }
                }
             } catch (\Throwable $th) {
                $status = false;
             }
             return $status ;
      }



      /**
       * notify agent
       */
       public function notifyAgent($ticket = null ,$agent = null,$message = null,$subKey ="new_ticket",$routeName = null, $templateCode = "SUPPORT_TICKET_REPLY",$mailCode = null){

            $routeName           = $routeName ?? route('admin.ticket.list');
            $message             = $message ?? translate("Agent!! You Have Newly Assigned Ticket, From ") . $ticket->name ;
            $superAdmin          = Admin::where('agent',(StatusEnum::false)->status())->first();
            $agent               = $agent?? $superAdmin ;
            $notification        =  null;
            $mutedTicket         = (array) $agent->muted_ticket ;
            $agentNotifications  = $agent->notification_settings
                                     ? json_decode($agent->notification_settings ,true)
                                    :[];

                             

            $mailCode            = $mailCode ?? [
                                                    'ticket_number' => @$ticket->ticket_number ,
                                                    'link'          =>  $routeName
                                                ];


            $data = [
                'route'    => $routeName ,
                'messsage' => $message
            ];

            $customTicketNotifications = ['user_reply_agent','agent_ticket_reply','user_reply_admin'];

            if(site_settings("database_notifications") == (StatusEnum::true)->status()){


                $notify       = $agent->agent ==  StatusEnum::false->status()
                                                    ? NotifyStatus::SUPER_ADMIN
                                                    : NotifyStatus::AGENT;

                $notification = SendNotification::database_notifications($data,$agent,$superAdmin->id, $notify);


                $notifications = [
                    'counter'          => false,
                    'data'             => json_decode($notification->data,true),
                    'notification_for' => $notification->notification_for,
                    'notify_id'        => $notification->notify_id
                ];

                $pushEvent = false;

                $browserNotifications = true;

                $ticketBrowserNotification   = @$ticket->notification_settings->browser;
                if(in_array($subKey,$customTicketNotifications) && $ticketBrowserNotification == (StatusEnum::false)->status()){
                    $browserNotifications = false;
                }


                if(isset($agentNotifications['browser'][$subKey])
                    && @$agentNotifications['browser'][$subKey] == (StatusEnum::true)->status() && $browserNotifications ){
                    @$notifications['for']             = $subKey;
                    @$pushEvent                        = true;
                }

                if(!in_array(@$ticket->id , (array)@$mutedTicket )){
                    $pushEvent                        = true;
                    $notifications['play_audio']      = true;
                }

                if($pushEvent){

                   $push_data ['notifications_data'] =  $notifications ;

                    try {
                        $this->triggerPusher($push_data);
                    } catch (\Exception $e) {

                    }
                }

            }

            /** send mail notifications  to agent */
            if(isset($agentNotifications['email'][$subKey]) && $agentNotifications['email'][$subKey] == (StatusEnum::true)->status()){

                $emailNotifications = true;

                if($ticket){
                    $ticketEmailNotification   = @$ticket->notification_settings->email;
                    if(in_array($subKey,$customTicketNotifications) && $ticketEmailNotification == (StatusEnum::false)->status()){
                        $emailNotifications = false;
                    }
                }

                if( $emailNotifications){
                    SendEmailJob::dispatch($agent, $templateCode ,$mailCode);
                }

            }

            /** send sms notifications to agent */
            if(isset($agentNotifications['sms'][$subKey]) && $agentNotifications['sms'][$subKey] == (StatusEnum::true)->status()){

                $smsNotifications = true;

                if($ticket){
                    $ticketSmsNotification   = @$ticket->notification_settings->sms;
                    if(in_array($subKey,$customTicketNotifications) && $ticketSmsNotification == (StatusEnum::false)->status()){
                        $smsNotifications = false;
                    }
                }

                if($smsNotifications){
                    SendSmsJob::dispatch($agent, $templateCode ,$mailCode);
                }
            }

            if($agent->agent ==  StatusEnum::false->status()

                && isset($agentNotifications['slack'][$subKey])
                && $agentNotifications['slack'][$subKey] == (StatusEnum::true)->status()){

                $data['ticket_id'] = @$ticket->ticket_number;

                $slackNotifications = true;

                $ticketSlackNotification   = @$ticket->notification_settings->slack;
                if(in_array($subKey,$customTicketNotifications) && $ticketSlackNotification == (StatusEnum::false)->status()){
                    $slackNotifications = false;
                }

                if($slackNotifications){
                    SendNotification::slack_notifications($agent, $data);
                }
            }

           return $notification ;

       }


      public function nearestAgent($latitude,$longitude,$agents){

            return $agents->sortBy(function ($agent) use ($latitude,$longitude) {
                return calculate_distance($latitude, $longitude , $agent->latitude, $agent->longitude);
           })->first();
      }



    public function notifyAdmin($ticket){


        if(site_settings("database_notifications") == (StatusEnum::true)->status()){

            $superAdmin    = Admin::where('agent',(StatusEnum::false)->status())->first();

            $notify        = NotifyStatus::SUPER_ADMIN;

            $data = [
                'route'    => route('admin.ticket.view',$ticket->ticket_number) ,
                'messsage' => auth_user()->name . " requested to mark this ticket as Solved"
            ];

            $notification  = SendNotification::database_notifications($data,$superAdmin,auth_user()->id , $notify);


            #NOTIFY ALL SUPER AGENT
            $superAgents = Admin::active()->superagent()->get();
            foreach($superAgents as $agent){
                $notification  = SendNotification::database_notifications($data,$agent,auth_user()->id , $notify);
            }
            
        }


    }


    /**
     * store  ticket message
     */
     public function ticketMessage($ticket,$ticket_file,$editor_files ){

        $supportMessage                    = new SupportMessage();
        $supportMessage->support_ticket_id = $ticket->id;
        $supportMessage->message           = $ticket->message;
        $supportMessage->editor_files      = json_encode($editor_files);
        $supportMessage->file              = json_encode($ticket_file);
        $supportMessage->save();
        return $supportMessage;
     }

    /**
     * store ticket files
     */
     public function storeFiles($files ,$path = null):array
     {
        if(!$path){
            $path = getFilePaths()['ticket']['path'];
        }

        $storedFiles = [];
        
        foreach($files as $file){
            array_push($storedFiles,upload_new_file($file, getFilePaths()['ticket']['path']));
        }
        return $storedFiles ;
     }


     /**
      * config and trigger pusher
      */
    public function triggerPusher($data){

        $pusher_settings =  json_decode(site_settings('pusher_settings'),true);

        $options = array(
            'cluster' => $pusher_settings['app_cluster'],
            'useTLS'  => true,
        );
        $pusher =  new Pusher(
            $pusher_settings['app_key'], $pusher_settings['app_secret'], $pusher_settings['app_id'], $options
        );

        $pusher->trigger($pusher_settings['chanel'], $pusher_settings['event'], $data);


    }

  


 
     /**
      * Export ticket data to pdf & csv file 
      *
      * @param string $extension
      * @param Builder $exportableData
      * @param string|null $view
      * @return \Illuminate\Http\Response | BinaryFileResponse | null
      */ 
     public function exportData(string $extension,Builder $exportableData,? string $view = null) : \Illuminate\Http\Response | BinaryFileResponse | null {

            $headers = [
                'ticket_number',
                'name',
                'subject',
                'created_at',
            ];

 
            switch ($extension) {
                case $extension == 'pdf' ;

                        $data = [
                            'ticket_data' => $exportableData->cursor(),
                            'title'       => translate('Download Pdf')
                        ];
                        
                        $pdf = \PDF::loadView($view, $data);
        
                        return $pdf->download('ticket.pdf');
                    
                    break;
                
                case $extension == 'csv' ;

                        $tempFile = tempnam(sys_get_temp_dir(), 'ticket_');

                        $handle   = fopen($tempFile, 'w');

                        foreach ([$headers] as $contact) {
                            fputcsv($handle, $contact);
                        }

                        $exportableData->select($headers)
                            ->chunk(200, function ($contact) use ($handle) {
                                foreach ($contact->toArray() as $contact) {
                                    fputcsv($handle, $contact);
                                }
                            });

                        fclose($handle);

                        $header = [
                            'Content-Description'   => 'File Transfer',
                            'Content-Type'          => 'application/octet-stream',
                            'Content-Disposition'   => 'attachment; filename=ticket.csv',
                        ];

                        $response                   = response()->download($tempFile, 'ticket.csv', $header);


                        register_shutdown_function(function () use ($tempFile) {
                            if (file_exists($tempFile)) {
                                unlink($tempFile);
                            }
                        });

                        return $response;


                   break;
                default:
            
                    return null; 
                 break;
                
            }

     }

     /**
      * notify user
      */

      public function notifyUser($user,$message,$subkey,$template,$mailCode ,$route){

           $notificatios_settings = $user->notification_settings ? json_decode($user->notification_settings,true) : [];
            if(site_settings("database_notifications") == (StatusEnum::true)->status()){
                $data = [
                    'route'    => $route,
                    'messsage' => $message
                ];
                $notification = SendNotification::database_notifications($data,$user,auth_user()->id,NotifyStatus::USER);

                /** trigger pusher with data if browser notification is on for agent */
                if(isset($notificatios_settings['browser'][$subkey]) && $notificatios_settings['browser'][$subkey] == (StatusEnum::true)->status()){
                    $push_data ['notifications_data'] = [
                        'counter'          => false,
                        'data'             => json_decode($notification->data,true),
                        'notification_for' => $notification->notification_for,
                        'notify_id'        => $notification->notify_id,
                        'for'              => $subkey,
                    ] ;
                    try {
                        $this->triggerPusher($push_data);
                    } catch (\Exception $e) {

                    }
                }
            }

            if(site_settings("email_notifications") == (StatusEnum::true)->status()  && isset( $notificatios_settings['email'][$subkey]) && $notificatios_settings['email'][$subkey] == (StatusEnum::true)->status()){
                SendEmailJob::dispatch($user,$template,$mailCode);
            }

            if(site_settings("sms_notifications") == (StatusEnum::true)->status() && isset( $notificatios_settings['sms'][$subkey]) &&  $notificatios_settings['sms'][$subkey] == (StatusEnum::true)->status()){
                SendSmsJob::dispatch($user,$template,$mailCode);
            }
      }






    /**
     * Ticket bulk action
     *
     * @param Request $request
     * @return string
     */
    public function bulckAction(Request  $request) : string {

        if($request->input('status')){

            $message = translate('Status Updated Successfully');

            SupportTicket::withoutGlobalScope('autoload')
            ->whereIn('id',$request->input("ticket_id"))->lazyById(100,'id')->each(function(SupportTicket $ticket) use ($request) {

                if($request->input('status') == TicketStatus::SOLVED->value){

                    if ((auth_user()->agent == StatusEnum::true->status()) && ($ticket->solved_request == SupportTicket::REJECTED || !$ticket->solved_request)) {
                        $ticket->solved_request    = SupportTicket::REQUESTED;
                        $ticket->solved_request_at = Carbon::now();
                        $ticket->requested_by      = auth_user()->id;
                        $this->notifyAdmin($ticket);

                    } else {
                        $ticket->solved_at = $ticket->solved_at ? $ticket->solved_at : Carbon::now() ;
                    }
                }

                $ticket->status =  $request->input('status');
                $ticket->save();
              
            });
        
        }
        elseif($request->input('assign')){

            $this->assignTicket($request);
            $message = translate('Ticket Assigned Successfully');
        }
        else{

            $this->deleteTicket($request->ticket_id);
            $message = translate('Ticket Deleted Successfully');
        }


        return $message;


    }



    /**assign tickets to admin/agent */
    public function assignTicket($request){


        $admins   = Admin::with(['tickets'])
                        ->whereIn('id',$request->assign)
                        ->get();


        $tickets = SupportTicket::whereIn("id" ,$request->ticket_id )->get();


        $sortNotes = "Ticket Assigned BY SuperAdmin";
        $message   = translate("You Have a New Assigned Ticket By").auth_user()->name;
        $assignBy  = auth_user()->id;

        AgentTicket::whereIn('ticket_id',$request->ticket_id)->delete();

        $subKey = "admin_assign_ticket";


        foreach($tickets  as $uniqueticket){

            if($request->priority_id ){
                $uniqueticket->priority_id = $request->priority_id;
                $uniqueticket->save();
            }

            foreach($admins as $admin){


                if($admin->id == auth_user()->id){
                    $sortNotes = "Ticket Assigned By Me";
                    $assignBy  = null;
                }

                if(auth_user()->agent == StatusEnum::true->status() || auth_user()->super_agent == 1){
                    $subKey    = "agent_assign_ticket";
                    $sortNotes = "Ticket Assigned By Agent";
                }


                $route = route("admin.ticket.view",$uniqueticket->ticket_number);


                AgentTicket::create([
                    "agent_id"    => $admin->id ,
                    "ticket_id"   => $uniqueticket->id,
                    "short_notes" => $request->short_note ? $request->short_note : $sortNotes ,
                    "assigned_by" => $assignBy ,
                ]);
    
                if($admin->id != auth_user()->id){
                    $mailCode = [
                        "role"           => auth_user()->agent == StatusEnum::true->status() ? 'Agent' : "SuperAdmin",
                        "name"           => auth_user()->name,
                        "ticket_number"  => $uniqueticket->ticket_number,
                        "link"           => ($route)
                    ];
                    $this->notifyAgent(null,$admin, $message ,$subKey ,$route ,"SUPPORT_TICKET_ASSIGN",
                    $mailCode);
                }
    
                if(auth_user()->agent ==  StatusEnum::true->status()){
    
                    $message = "Hello Superadmin ! Agent " . auth_user()->name. " just Assign A ticket To Agent " .$admin->name;
                    $mailCode = [
                        "name"           => auth_user()->name,
                        "assigned_to"    => $admin->name,
                        "ticket_number"  => $uniqueticket->ticket_number,
                        "link"           => ($route)
                    ];
    
                    $this->notifyAgent($uniqueticket,null, $message ,$subKey ,$route ,"SUPPORT_TICKET_ASSIGN_BY_AGENT",
                    $mailCode);

                    #NOTIFY ALL SUPER AGENT
                    $superAgents = Admin::active()->superagent()->get();
    
                    foreach($superAgents as $agent){
                                $this->notifyAgent($uniqueticket,$agent, $message ,$subKey ,$route ,"SUPPORT_TICKET_ASSIGN_BY_AGENT",
                            $mailCode);
                    }
    
                    
                }
           


            }
          

        }



    }



   

    

    /**
     * Delete tickets
     *
     * @param array $ticketIds
     * @return void
     */
    public function deleteTicket(array $ticketIds) : void {
        
            # UNLINK TICKET & MESSAGE FILES  
            $tickets = SupportTicket::withoutGlobalScope('autoload')
                        ->whereIn('id',$ticketIds)
                        ->lazyById(50,'id')
                        ->each(function(SupportTicket $ticket){
                            $ticket->messages()->lazyById(50,'id')->each(function(SupportMessage $message) {
                                $ticketFiles  = json_decode($message->file,true);
                                $this->unlinkFile($ticketFiles 
                                                    ? $ticketFiles 
                                                    :[] , getFilePaths()['ticket']['path']);

                                $this->unlinkFile((array)@$message->editor_files ?? [] , getFilePaths()['text_editor']['path']);

                            });
                            $ticket->agents()->detach();
                            
            });



            # Delete suppot message
            do {
                $messsages = DB::table('support_messages')
                                        ->whereIn('support_ticket_id', $ticketIds)
                                        ->join('support_tickets', 'support_messages.support_ticket_id', '=', 'support_tickets.id')
                                        ->limit(100)
                                        ->delete();
    
            
            } while ($messsages < 0); 

            # Delete support message
            do {

                $tickets = DB::table('support_tickets')
                                        ->whereIn('id', $ticketIds)
                                        ->limit(100)
                                        ->delete();
    
            
            } while ($tickets < 0); 

    }




    /**
     * Unlink ticket files
     *
     * @param array $files
     * @param string $location
     * @return void
     */
    public function unlinkFile(array $files ,string $location) : void{
        collect($files)->map( fn($file) => remove_file($location ,$file) );
  
    }



    /**
     * Get ticket list data
     *
     * @param Request $request
     * @return array
     */
    public function getTicketList(Request $request) :array {

        $tickets  = SupportTicket::withoutGlobalScope('autoload')
                        ->with(['ticketStatus','department','linkedPriority','messages','unreadMessages','agents','oldMessages','messages.admin','user'])
                        ->withCount(['unreadMessages'])
                                                ->filter($request)
                                                ->agent(request()->route('id'))
                                                ->orderBy('user_last_reply','desc')
                                                ->paginate(paginateNumber());

        $status          = count($tickets)  == 0 
                                            ? false 
                                            : true;

        $categories     = Category::agent( $request->agent_id)
                                ->withCount(['tickets as tickets_count' => function($q) use($request){
                                    $q = $q->when(!$request->category_id || $request->department_id , function($query) use ($request){
                                        $query->filter($request,false);
                                    });

                                    if(auth_user()->agent == StatusEnum::true->status() || $request->agent_id){
                                        return $q->agent($request->agent_id);
                                    }
                                    return $q;
                                }])
                                ->having("tickets_count" ,">", 0)
                                ->where("ticket_display_flag",StatusEnum::true->status())->latest()
                                ->get();



        $department_active = $request->input('department_id',null);
        $category_active   = $request->input('category_id',null);


        $departmentCounter    =  SupportTicket::withoutGlobalScope('autoload')->whereHas('department')->with(['department'])->agent($request->agent_id)
                                        ->groupBy('department_id')
                                        ->select('department_id', DB::raw('count(*) as count'))
                                        ->lazyById(100,'id')->map(function(SupportTicket $ticket){
                                            return (object)([
                                                'id'           => $ticket->department->id,
                                                'name'         => $ticket->department->name,
                                                'imageURL'     => getImageUrl(getFilePaths()['department']['path']."/". $ticket->department->image , getFilePaths()['department']['size']) ,
                                                'total_ticket' => $ticket->count,
                                                'active_class' => request()->input('department_id') == $ticket->department->id 
                                                                    ?'active' :""
                                            ]);
                                        })->all();
                                        
       $tag             = $request->input('tag');

        $tagsCounter = (object)[
                           'unassigned' =>  SupportTicket::withoutGlobalScope('autoload')->filter($request)
                                                         ->agent($request->agent_id)
                                                        
                                                         ->whereDoesntHave('agents')
                                                         ->lazyById('100','id')
                                                         ->count(),
                           'assigned'   =>  SupportTicket::withoutGlobalScope('autoload')->filter($request)->agent($request->agent_id)
                                                         ->whereHas('agents', function($q) {
                                                            $q->where('agent_id','!=', auth_user()->id);
                                                        })
                                                        ->lazyById('100','id')
                                                        ->count(),
                           'mine'       =>  SupportTicket::withoutGlobalScope('autoload')->filter($request)->agent($request->agent_id)
                                                         ->whereHas('agents', function($q) {
                                                            $q->where('agent_id', auth_user()->id);
                                                        })
                                                        ->lazyById('100','id')
                                                        ->count()

                        ];


        $totalTicket = SupportTicket::withoutGlobalScope('autoload')
                                            ->filter($request)
                                            ->lazyById('100','id')
                                            ->count();

        return ([
            'status'              => $status,
            "ticket_html"         => view('admin.ticket.list', compact('tickets'))->render(),

            "categories_html"     => view('admin.ticket.categories', compact('categories','tickets','category_active'))->render(),
            "tag_html"            => view('admin.ticket.tags', compact('tagsCounter','tag'))->render(),
            "department_html"     => view('admin.ticket.department', compact('departmentCounter','totalTicket','department_active'))->render(),
        ]);
    }


    







    /**
     * Get ticket message
     *
     * @param Request $request
     * @param SupportTicket $ticket
     * @param boolean $is_user
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getTicketMesssages(Request $request , SupportTicket $ticket , bool $is_user = false ) :  \Illuminate\Pagination\LengthAwarePaginator {


        return  SupportMessage::with(['admin'])->where('support_ticket_id',$ticket->id)
                           ->latest()
                            ->when($is_user , function($q){
                                return $q->where("is_draft",StatusEnum::false->status())
                                         ->where("is_note",StatusEnum::false->status());
                            })
                            ->paginate(15, ['*'], 'page', $request->input("page"));

    }




    

    /**
     * Delete a specific ticket message
     */
    public function messageDestory(SupportMessage $message ) : bool {


        $ticketFiles  = json_decode($message->file,true);

        # UNLINK TIKCET FILES
        $this->unlinkFile($ticketFiles ? $ticketFiles :[] , getFilePaths()['ticket']['path']);
        # UNLINK TEXT EDITOR FILES
        $this->unlinkFile(@$message->editor_files ?? [] , getFilePaths()['text_editor']['path']);

        $message->delete();


        return true;
    }



    

    /**
     * Merge two ticket 
     *
     * @param Request $request
     * @return SupportTicket
     */
    public function merge(Request $request) : SupportTicket{


        $parentTicket = SupportTicket::withoutGlobalScope('autoload')
                            ->findOrfail($request->input('parent_ticket_id'));

        $childTicket  = SupportTicket::withoutGlobalScope('autoload')
                            ->findOrfail($request->input('ticket_id'));



        #CONVERT CHILD MESSAGE TO PARENT MESSAGE

        SupportMessage::where("support_ticket_id",$childTicket->id)
                                ->lazyById(200, $column = 'id')
                                ->each->update(['support_ticket_id' =>$parentTicket->id ,'created_at' => Carbon::now()]);
        $childTicket->delete();


        return $parentTicket;


    }




    /**
     * Store draft message
     *
     * @param Request $request
     * @return bool
     */
    public function storeDraftMessage(Request $request) : bool {


        $ticket = SupportTicket::withoutGlobalScope('autoload')
                                ->where('id',$request->input('ticket_id'))
                                ->first();

        if($ticket && strip_tags($request->input('draft'),'<img>')){


            $supportMessage = SupportMessage::firstOrCreate(
                                    ['id'                => $request->input("draft_id")],
                                    ['support_ticket_id' => $ticket->id]
                                );

            $supportMessage  = $this->createSupportMessage($ticket, [
                                    "is_draft"  => StatusEnum::true->status(),
                                    "admin_id"  => auth_user()->id,
                                    'body'      => build_dom_document( $request->input('draft'))
                                ] ,$supportMessage);

            return true;


        }


        return false;
      

    }




    
    /**
     * Mute & Unmute a ticket
     *
     * @param Request $request
     * 
     * @return bool
     */
    public function muteTicket(int | string $ticket_number) : bool {

      
        $status          = false;
        $admin           = auth_user();

        $ticket          = SupportTicket::withoutGlobalScope('autoload')
                                        ->where('ticket_number',$ticket_number)
                                        ->firstOrfail();

        $mutedTicket = (array) $admin->muted_ticket;

        switch (true) {
            case (in_array($ticket->id, $mutedTicket)):
                    $mutedTicket = array_values(array_filter($mutedTicket, function($id) use ($ticket) {
                        return $id !== $ticket->id;
                    }));
                break;
            default:
                $status      = true;
                array_push($mutedTicket, $ticket->id);
                break;
        }


        $admin->muted_ticket = $mutedTicket;
        $admin->save();


        return $status ;




    }


    




    /**
     * Add ticket note 
     *
     * @param Request $request
     * @return SupportTicket
     */
    public function addNote(Request $request) : SupportTicket{

      
        $ticket    = SupportTicket::withoutGlobalScope('autoload')
                                      ->findOrFail($request->input("id"));

       
        
        #CREATE SUPPORT MESSAGE

        $message  = $this->createSupportMessage($ticket, [
                        "is_note"  => StatusEnum::true->status(),
                        "admin_id" => auth_user()->id,
                        'body'     => build_dom_document( $request->input('note'))
                    ]);

       
    
        return  $ticket ; 


    }





    /**
     * Create a new support message
     *
     * @param SupportTicket $ticket 
     * @param array $body
     * @param SupportMessage | null $message
     * @return SupportMessage
     */
    public function createSupportMessage(SupportTicket $ticket , array $body , ? SupportMessage $message = null) : SupportMessage {

        $supportMessage                       = $message ?? new SupportMessage();
        $supportMessage->support_ticket_id    = $ticket->id;
        $supportMessage->is_note              = Arr::get($body ,'is_note' ,StatusEnum::false->status());
        $supportMessage->is_draft             = Arr::get($body ,'is_draft' ,StatusEnum::false->status());
        $supportMessage->admin_id             = Arr::get($body ,'admin_id');
        $supportMessage->message              = Arr::get($body ,'body.html');
        $supportMessage->editor_files         = Arr::get($body ,'body.files',[]);
        $supportMessage->file                 = Arr::get($body ,'files',json_encode([]));
        $supportMessage->save();
        
   
        # UPDATE LAST REPLY
        $ticket->user_last_reply = Carbon::now();
        $ticket->saveQuietly();

        return  $supportMessage  ;



    }





    /**
     * Bulk ticket store
     *
     * @param Request $request
     * @return boolean
     */
    public function  bulkTicketStore(Request $request) : bool{


        try {
           
            $emails = [];

            // Fetch emails from different sources
            $emails = collect([
                Contact::whereIn("id", $request->input('contact', []))->pluck('email', 'id')->toArray(),
                Subscriber::whereIn("id", $request->input('subscriber', []))->pluck('email', 'id')->toArray(),
                FloatingChat::whereIn("id", $request->input('anonymous', []))->pluck('email', 'id')->toArray(),
                array_combine($request->input('custom_email', []), $request->input('custom_email', []))
            ]);


            // Process emails from User model
            User::whereIn("id", $request->input('user_id', []))->get(['id', 'email'])->each(function ($user) use ($request) {
                $ticketData = $request->input('ticket_data', []);
                $ticketData['name'] = $user->email;
                $ticketData['email'] = $user->email;
                $ticketData['user_id'] = $user->id;
                $ticketData['buypass_purchase'] = true;



                
                $request->merge(["ticket_data" => $ticketData]);

                $this->storeTicket($request->except('_token')['ticket_data']);
            });

            // Process emails from other sources
            $emails->flatten()->each(function ($email) use ($request) {
                $ticketData = $request->input('ticket_data', []);
                $ticketData['name'] = $email;
                $ticketData['email'] = $email;
                
                $ticketData['buypass_purchase'] = true;
                $request->merge(["ticket_data" => $ticketData]);
                $this->storeTicket($request->except('_token')['ticket_data']);
            });

            return true;

        } catch (\Throwable $th) {
            return false;
        }

    }


    

    /**
     * Update ticket notification settings
     *
     * @param Request $request
     * @return SupportTicket
     */
    public function updateTicketNotification(Request $request) : SupportTicket{


        $ticket         = SupportTicket::withoutGlobalScope('autoload')
                                ->where('id',$request->input('id'))
                                ->firstOrfail();

        $notifications  = (array)$ticket->notification_settings;

        $keyToUpdate    = $request->input('key');
        $newValue       = $request->input('status');
        

        switch (true) {
            case Arr::has($notifications, $keyToUpdate):
                $notifications[$keyToUpdate] = $newValue;
                break;
            default:
                $notifications = Arr::add($notifications, $keyToUpdate, $newValue);
                break;
        }


        $ticket->notification_settings =  $notifications;
        $ticket->saveQuietly();


        return $ticket ;
        


    }



    /**
     * Update ticket status & priority 
     *
     * @param Request $request
     * @return array
     */
    public function updateStatus(Request $request) :array {


        try {

            $ticket                  =  SupportTicket::withoutGlobalScope('autoload')
                                                    ->where('id',$request->input('id'))
                                                    ->firstOrfail();
            $ticket->{$request->input('key')} =  $request->input('status');

            if ($request->input('key') == "status" &&  $request->input('status') == TicketStatus::SOLVED->value) {

                switch (true) {
                    case (auth_user()->agent == StatusEnum::true->status() && ($ticket->solved_request == SupportTicket::REJECTED || !$ticket->solved_request)):
                        $ticket->solved_request    = SupportTicket::REQUESTED;
                        $ticket->solved_request_at = Carbon::now();
                        $ticket->requested_by      = auth_user()->id;
                        $this->notifyAdmin($ticket);
                        break;
                
                    default:
                        $ticket->solved_at = $ticket->solved_at ? $ticket->solved_at : Carbon::now();
                        break;
                }

            }

            $ticket->save();
            $status  = 'success';
            $message = translate('Status Updated');

        } catch (\Throwable $ex) {
              return [
                    'status'  => false,
                    'message' => $ex->getMessage(),
                ];
        }

        return [
            'status'         => true,
            'message'        => $message,
            'ticket'         => $ticket,
            "ticket_header"  => view('admin.ticket.partials.ticket_header',compact('ticket'))->render(),
            "reply_card"     => view('admin.ticket.partials.reply_card', compact('ticket'))->render(),
        ];

    }




    /**
     * Update ticket message status
     *
     * @param SupportTicket $ticket
     * @return void
     */
    public function makeTicketMessageSeen(SupportTicket $ticket) :void{


        do {
                DB::table('support_messages')
                                    ->where('support_ticket_id', $ticket->id)
                                    ->whereNull('admin_id')
                                    ->where('seen', StatusEnum::false->status())
                                    ->join('support_tickets', 'support_messages.support_ticket_id', '=', 'support_tickets.id')
                                    ->limit(100)
                                    ->update(['seen' => StatusEnum::true->status()]);

    
        } while( 
                DB::table('support_messages')
                    ->where('support_ticket_id', $ticket->id)
                    ->whereNull('admin_id')
                    ->where('seen', StatusEnum::false->status())
                    ->join('support_tickets', 'support_messages.support_ticket_id', '=', 'support_tickets.id')->count() != 0
            );

     }



     /**
      * Store admin reply
      *
      * @param Request $request
      * @return array
      */
     public function replyByAdmin(Request $request) : array  {


        
        $ticket = SupportTicket::with(['user','messages'])
                                    ->withoutGlobalScope('autoload')
                                    ->withCount('user')
                                    ->where('id',$request->input('ticket_id'))
                                    ->first();

        #UPDATE TICKET STATUS
        if($request->input('status') ){

            if($request->input('status')== TicketStatus::SOLVED->value){
                switch (true) {
                    case (auth_user()->agent == StatusEnum::true->status() && ($ticket->solved_request == SupportTicket::REJECTED || !$ticket->solved_request)):
                        $ticket->solved_request    = SupportTicket::REQUESTED;
                        $ticket->solved_request_at = Carbon::now();
                        $ticket->requested_by      = auth_user()->id;
                        $this->notifyAdmin($ticket);
                        break;
                
                    default:
                        $ticket->solved_at = $ticket->solved_at ? $ticket->solved_at : Carbon::now();
                        break;
                }
            }

            $ticket->status = $request->input('status') ;
            $ticket->save();
        
        }

        #STORE FILES
        $ticket_files = [];
        if($request->has('files')){

            try {
                $ticket_files = $this->storeFiles($request['files']);
            } catch (\Throwable $th) {
               
            }
            
        }


        #STORE MESSAGE
        $supportMessage = SupportMessage::firstOrCreate(
            ['id'                => $request->input("draft_message_id")],
            ['support_ticket_id' => $ticket->id]
        );

        $supportMessage  = $this->createSupportMessage($ticket, [
                    "is_draft"  => StatusEnum::false->status(),
                    "admin_id"  => auth_user()->id,
                    'body'      => build_dom_document( $request->input('message')),
                    'files'     => json_encode($ticket_files)
                ] ,$supportMessage);


        $status                             = 'success';
        $message                            = translate("Replied Successfully");


        # CALCULATE AGENT RESPONSE TIME
        if(auth_user()->agent == StatusEnum::true->status() || auth_user()->super_agent == StatusEnum::true->status()){

            $this->storeResponseTime($ticket,$supportMessage);

            $superAdmin = Admin::where('agent',StatusEnum::false->status())
                               ->first();

            // AgentTicket::where('agent_id',"!=",$superAdmin->id)
            //         ->where(function($q) use($request) {
            //                 $q->where('agent_id',"!=",auth_user()->id)->where('ticket_id', $request->input('ticket_id'));
            //         })->delete();
            
            $route = route('admin.ticket.view',$ticket->ticket_number);

            $notifyMessage = translate('Hello Dear!!! ').auth_user()->name. " Just Replied To a Ticket";
            $mailCode = [
                "role"           => 'Agent',
                "name"           => auth_user()->name,
                "ticket_number"  => $ticket->ticket_number,
                "link"           => $route
            ];

            $this->notifyAgent($ticket,null, $notifyMessage ,"agent_ticket_reply" ,$route ,"TICKET_REPLY",
            $mailCode);


            #NOTIFY ALL SUPER AGENT
            $superAgents = Admin::active()
                             ->superagent()
                             ->where('id','!=', auth_user()->id)
                             ->get();
            foreach($superAgents as $agent){
                $this->notifyAgent($ticket,$agent, $notifyMessage ,"agent_ticket_reply" ,$route ,"TICKET_REPLY",
                $mailCode);
            }

            
        }
        
        # NOTIFY USER
        switch (true) {
            case $ticket->user_count > 0:
                $route = route('user.ticket.view', $ticket->ticket_number);
                $notifyMessage = translate('Hello Dear!!! ') . auth_user()->name . "  Just Replied To a Ticket";
                $mailCode = [
                    "role"          => auth_user()->agent == StatusEnum::true->status() ? "Agent" : "SuperAdmin",
                    "name"          => auth_user()->name,
                    "ticket_number" => $ticket->ticket_number,
                    "link"          => $route
                ];
                $this->notifyUser($ticket->user, $notifyMessage, "ticket_reply", 'TICKET_REPLY', $mailCode, $route);
                break;
        
            case $ticket->user_count <= 0:
                $code = [
                    "role"          => auth_user()->agent == StatusEnum::true->status() ? "Agent" : "SuperAdmin",
                    "name"          => auth_user()->name,
                    'ticket_number' => $ticket->ticket_number,
                    'link'          => route('ticket.reply', $ticket->ticket_number)
                ];
                SendEmailJob::dispatch($ticket, "TICKET_REPLY", $code);
                break;
        
            default:
                // Handle default case if needed
                break;
        }

    
        # RETURN ACTION 
  
        switch ($request->input("redirect_to")) {
            case TicketReply::TICKET_LIST->value:
                $url = route('admin.ticket.list');
                break;
        
            case TicketReply::NEXT_TICKET->value:

                $nextTicket = SupportTicket::withoutGlobalScope('autoload')
                                    ->agent()
                                    ->where("id", '!=', $ticket->id)
                                    ->latest()
                                    ->first();
                $url = $nextTicket ? 
                          route('admin.ticket.view', $nextTicket->ticket_number)
                          : route('admin.ticket.list');

                break;
        
            default:

                break;
        }


        return [
            'status'                => $status,
            'message'               => $message,
            'ticket_id'             => $ticket->id,
            'url'                   => @$url ? @$url :false ,
            "reply_card"            => view('admin.ticket.partials.reply_card', compact('ticket'))->render(),
            "ticket_header"         => view('admin.ticket.partials.ticket_header', compact('ticket'))->render(),

        ];



     }


    /**
     * Store Response time
     *
     * @param SupportTicket $ticket
     * @param SupportMessage $supportMessage
     * @return void
     */
    public function storeResponseTime(SupportTicket $ticket, SupportMessage $supportMessage) : void{

     
        $messageCounts   = SupportMessage::where("support_ticket_id",$ticket->id)
                                            ->where("admin_id",auth_user()->id)
                                            ->count();

       if($messageCounts == 1){

            $createdAt                = Carbon::parse($ticket->created_at); 
            $now                      = Carbon::parse($supportMessage->created_at);
            $secondsDifference        = $now->diffInSeconds($createdAt);
            
            $hoursDifference          = floor($secondsDifference / 3600); 
            $minutesDifference        = round(($secondsDifference % 3600) / 60, 2); 
            
            $timeDifference           = $hoursDifference + ($minutesDifference / 100);

            $response                 = new AgentResponse();
            $response->agent_id       = auth_user()->id;
            $response->ticket_id      = $ticket->id;
            $response->response_time  = $timeDifference;
            $response->save();
       }


    }






}
