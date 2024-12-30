<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Enums\NotifyStatus;
use App\Enums\StatusEnum;
use App\Http\Services\Admin\MessengerServices;
use App\Http\Services\TicketService;
use App\Http\Utility\SendNotification;
use App\Jobs\SendEmailJob;
use App\Jobs\SendSmsJob;
use App\Models\Admin;
use App\Models\Chat;
use App\Models\FloatingChat;
use Illuminate\Http\Request;

class FloatingMessageController extends Controller
{

    public $messengerService;
    public function __construct(){

        if(site_settings('chat_module') == (StatusEnum::false)->status()){
            abort(403,unauthorized_message()); 
        }
        $this->messengerService = new MessengerServices();
    }
    
    /**
     * store floating message 
     *
     */
    public function sendMessage(Request $request) :array {
        

        $request->validate([
            'message' => "required|max:255",
        ],[
            'message.required' => translate('Please type something')
        ]);

        $cookieData   = json_decode($_COOKIE['floating_chat']);

        $user         = FloatingChat::where('id',$cookieData->id)->first();

        $response     = [
            'status'  => false,
            "message" => translate('Invalid Cookie!!')
        ];


        if(!$user){
            return $response ; 
        }


        if($user->is_closed == (StatusEnum::true)->status()){

            $response     = [

                'block'   => true,
                'status'  => false,
                "message" => translate('You are blocked by system agent!!')
            ];
        }


        if($cookieData && $user->is_closed == (StatusEnum::false)->status() ){

            $chat                   = new Chat();
            $chat->floating_id      = $user->id;
            $chat->admin_id         = $user->assign_to ? $user->assign_to : null ;
            $chat->deleted_by_user  = (StatusEnum::false)->status();
            $chat->deleted_by_admin = (StatusEnum::false)->status();
            $chat->sender           = (StatusEnum::false)->status();
    
            $chat->seen             = (StatusEnum::false)->status();
            $chat->seen_by_agent    = (StatusEnum::false)->status();
    
            $chat->message          = $request->input("message");
            $chat->save();

            $response     = [
                'status'  => true,
            ];
            
            if($user->assign_to){

                Chat::where('floating_id',$user->id)->whereNull('admin_id')
                ->update([
                    "admin_id" => $user->assign_to
                ]);

            }

            try {
            
                $pusher_settings          =  json_decode(site_settings('pusher_settings'),true);   
                $pusher                   =  $this->messengerService->configPusher($pusher_settings);
                
    
                $this->triggerPusher($chat,$pusher,$pusher_settings);
    
    
                if(!$user->assign_to){
    
                    $agents = Admin::active()->get();
    
                    $this->notify_agent($agents,$user);
    
                }

            } catch (\Throwable $th) {
          
            }

           
            
            
        }

        return $response ;

  
    }




    /**
     * notify agent if there is a new convo
     */

     public function  notify_agent($agents,$user){


        foreach($agents->chunk(paginateNumber()) as $chunkAgents){

            foreach($chunkAgents as $agent){

                $notification    = (new TicketService())->notifyAgent(agent : $agent , message :   translate("You Have A New Message From ").$user->email,subKey :'new_chat',routeName : route('admin.chat.list'),templateCode : 'USER_CHAT' ,  mailCode :[
                    "name" => $user->email,
                    "link" => route('admin.chat.list'),
                ]);

            }
        }

     }



    public function triggerPusher($chat,$pusher,$pusher_settings){

        
        $push_data = [
            'counter'                => true,
            'muted'                  => true,
            'receiver'               => $chat->admin_id,
            'user_id'                => null,
            'agent_id'               => $chat->admin_id ,
            'anonymous_id'           => $chat->floating_id,
            'anonymous_sender'       => $chat->floating_id,
        ]; 

        $pusher->trigger($pusher_settings['chanel'], $pusher_settings['event'], $push_data);

    }


     /**
     * Returns the chat messages between
     *
     * @param \Illuminate\Http\Request $request
     */
    public function getMessage(Request $request) :array{


        $cookieData   = json_decode($_COOKIE['floating_chat']);

        $response     = [
            'status'  => false,
            "message" => translate('Invalid Cookie!!')
        ];

        $user         = FloatingChat::where('id',$cookieData->id)->first();



        if(!$user){
            return $response ; 
        }



        if($user->is_closed == (StatusEnum::true)->status()){

            $response     = [

                'block'   => true,
                'status'  => false,
                "message" => translate('You are blocked by system agent!!')
            ];
        }


        if($cookieData && $user && $user->is_closed == (StatusEnum::false)->status()){


            Chat::where('floating_id',$cookieData->id)
            ->where('deleted_by_admin',(StatusEnum::false)
            ->status())->update([
                "seen" => (StatusEnum::true)
                ->status()
            ]);
    
            $messages =  Chat::where('floating_id',$cookieData->id)
                                ->where('deleted_by_admin',(StatusEnum::false)
                                ->status())
                                ->get();

            $response = [

                'status'     => true,
                "html"       => view('floating_chat', compact('messages'))->render(),
                
            ];
    
        }

        return  $response;

    }




    /**
     * set cookie
     *
     * @param Request $request
     * @return array
     */
    public function setCookie(Request $request) :array {

        $request->validate([
           'email' => ['required',"email"]
        ],[
            "email.required" => "Please enter your email",
            "email.email"    => "Please enter a valid email",
        ]);

        $user = FloatingChat::where("email",$request->input("email"))->first();
        
        if($user){

            $response         = [
                "old"         => true,
                'id'          => $user->id,
                "email"       =>  $user->email
            ];

            $message = Chat::where('floating_id',$user->id)
                                ->where('deleted_by_admin',(StatusEnum::false)
                                ->status())
                                ->latest()
                                ->first();

            if($message && $message->admin_id ){
                $response ['reciver_id'] =  $message->admin_id;
            }
   
        }
        else{

            $user = FloatingChat::Create(
                
                [  
                    
                    'email'      => $request->email,
                    'is_closed'  => StatusEnum::false->status()

                ],
     
            );

            $response         =  [
         
                'email'       => $user->email,
                'id'          => $user->id,
            ];
     
        }

        return $response;
         
    }

}
