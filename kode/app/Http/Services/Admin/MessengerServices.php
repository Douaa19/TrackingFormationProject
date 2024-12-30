<?php

namespace App\Http\Services\Admin;

use App\Enums\NotifyStatus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Enums\StatusEnum;
use App\Http\Utility\SendNotification;
use App\Jobs\SendEmailJob;
use App\Jobs\SendSmsJob;
use App\Models\Admin;
use App\Models\FloatingChat;
use App\Models\Chat;
use App\Models\User;
use Pusher\Pusher;

class MessengerServices extends Controller
{



    /**
     * get user message
     *
     * @param Request $request
     */
    public function getMessage(Request $request) :string {

        $userColumn  = $request->anonymous ? 'floating_id' : 'user_id';
        $userModel   = $request->anonymous ? FloatingChat::class : User::class;
        $id          = $request->anonymous ? $request->anonymous : $request->user_id;
        
        $user        = $userModel::find($id);


        if (!$user) {
            return json_encode([
                
                'status'  => false,
                'message' => translate("User Not Found")
            ]);
        }

        $blocked  = false;
        $muted    = true;

        if(!$request->anonymous){

            $block_list_user  =  auth_user()->blocked_user ? json_decode( auth_user()->blocked_user,true): [] ;

            if(in_array($user->id,  $block_list_user)){

                $blocked      = true;
            }

            $muted_agent      = $user->muted_agent ? json_decode( $user->muted_agent,true): [] ;

            if(!in_array(auth_user()->id,  $muted_agent)){

                $muted = false;
            }

        }
        else{

            if($user->is_closed == StatusEnum::true->status()){
                $blocked        = true;
            }
        }


        Chat::where('admin_id', auth_user()->id)
            ->where($userColumn, $user->id)
            ->lazyById('1000','id')
            ->each
            ->update([
                "seen_by_agent" => StatusEnum::true->status()
        ]);

        $chat_messages = Chat::with(['agent', 'user', 'floating'])
             ->when(($request->anonymous && $user->assign_to) || !$request->anonymous ,function($q){
                return $q->where('admin_id', auth_user()->id);
             })
            ->where($userColumn, $user->id)
            ->where('deleted_by_admin', StatusEnum::false->status())
            ->get();
            
        $anonymous =  $request->anonymous ? $user->id : null ;

        return json_encode([
            
            'anonymous'        => $anonymous ,
            'is_blocked'       => $blocked,
            'status'           => true,
            "chat_html"        => view('admin.chat.message', compact('chat_messages','anonymous'))->render(),
            "chat_header_html" => view('admin.chat.chat_header', compact('chat_messages', "user",'anonymous'))->render(),
            'user_id'          => $user->id
        ]);
         
 
    }



    /**
     * send message
     *
     * @param Request $request
     * @return string
     */
    public function sendMessage(Request $request) :string {

        $userColumn  = $request->anonymous ? 'floating_id' : 'user_id';
        $userModel   = $request->anonymous ? FloatingChat::class : User::class;
        $id          = $request->anonymous ? $request->anonymous : $request->user_id;
        $user        = $userModel::find($id);
        $muted       = true;
        $anonymous   =  $request->anonymous ? true : false;
        
        $block_list_user =  auth_user()->blocked_user ? json_decode( auth_user()->blocked_user,true): [] ;

        if(!$request->anonymous){

            if(in_array($request->user_id,  $block_list_user)){

                return json_encode([
                    'status'   => false,
                    'message'  => translate("User Is Blocked Now!! Unblock Then Try To Send Message")
                ]);
            }
    
            $muted_agent     = $user->muted_agent ? json_decode( $user->muted_agent,true): [] ;
          
            if(!in_array(auth_user()->id,  $muted_agent))    $muted       = false;

        }
     



        $pusher_settings   =  json_decode(site_settings('pusher_settings'),true);
        $pusher            =  $this->configPusher($pusher_settings);

        $push_data = [

            'counter'      => true,
            'muted'        => $muted,
            'receiver'     => $user->id,
            'message_for'  => 'user',
            'user_id'      => !$anonymous ?  $user->id  : null,
            'anonymous_id' => $anonymous ?  $user->id  : null,
            'agent_id'     => auth_user()->id,
        ];  

        $chat                    = new Chat();
        $chat->$userColumn       = $user->id ;
        $chat->admin_id          = auth_user()->id;
        $chat->deleted_by_user   = (StatusEnum::false)->status();
        $chat->deleted_by_admin  = (StatusEnum::false)->status();
        $chat->sender            = (StatusEnum::true)->status();
        $chat->seen              = (StatusEnum::false)->status();
        $chat->seen_by_agent     = (StatusEnum::false)->status();
        $chat->message           = $request->message;
        $chat->save();


        if($anonymous){
            $user->assign_to     = auth_user()->id;
            $user->save();

            Chat::where('floating_id',$user->id)->whereNull('admin_id')
            ->update([
                "admin_id" => $user->assign_to
            ]);

        }


        try {
            $notification  = $this->notify_user($user);
            if($notification){
    
                $push_data ['notifications_data'] = [
                    'data'             => json_decode($notification->data,true),
                    'notification_for' => $notification->notification_for,
                    'notify_id'        => $notification->notify_id,
                    'for'              => "new_chat",
                ] ; 
            }
        
            $pusher->trigger($pusher_settings['chanel'], $pusher_settings['event'], $push_data);
        } catch (\Throwable $th) {

        }

        $chat_messages = Chat::with(['agent', 'user', 'floating'])
                                ->when(($request->anonymous && $user->assign_to) || !$request->anonymous ,function($q){
                                   return $q->where('admin_id', auth_user()->id);
                                })
                            ->where($userColumn, $user->id)
                            ->where('deleted_by_admin', StatusEnum::false->status())
                            ->get();
          
                            
        $anonymous =  $request->anonymous ? $user->id : null ;
      
        return json_encode([
            'status'     => true,
            "chat_html"  => view('admin.chat.message', compact('chat_messages','anonymous'))->render(),
            'message'    => translate("Message Sent")
        ]);


    }



    /**
     * delete a  message
     *
     * @param Request $request
     * @return string
     */
    public function deleteMessage(Request $request)  :string {
        

        $userModel   = $request->anonymous_id ? FloatingChat::class : User::class;
        $userColumn  = $request->anonymous_id ? 'floating_id' : 'user_id';
        $id          = $request->anonymous_id ? $request->anonymous_id : $request->user_id;
        $user        = $userModel::find($id);

        $anonymous   =  $request->anonymous_id ? true : false;

        if(!$user ){
        
            return json_encode([

                'status'  => false,
                'message' => translate("User Not Found")
            ]);
        }

        $chat = Chat::where('id',$request->message_id)
        ->first();

        if($chat){

            $chat->deleted_by_admin   =  (StatusEnum::true)->status();
            $chat->deleted_by_user    =  (StatusEnum::true)->status();
            $chat->save();
            $pusher_settings          =  json_decode(site_settings('pusher_settings'),true);   
            $pusher                   =  $this->configPusher($pusher_settings);
            $muted_agent              =  $user->muted_agent ? json_decode( $user->muted_agent,true): [] ;


            try {
                $push_data = [

                    'muted'        => true,
                    'receiver'     => !$anonymous ? $user->id : null,
                    'user_id'      => !$anonymous ? $user->id : null,
                    'agent_id'     => auth_user()->id,
                    'anonymous_id' => $anonymous ?  $user->id  : null,
                ]; 
    
                $pusher->trigger($pusher_settings['chanel'], $pusher_settings['event'], $push_data);
            } catch (\Throwable $th) {
              
            }

            $chat_messages = Chat::with(['agent', 'user', 'floating'])
                    ->when(($request->anonymous && $user->assign_to) || !$request->anonymous ,function($q){
                        return $q->where('admin_id', auth_user()->id);
                    })
                ->where($userColumn, $user->id)
                ->where('deleted_by_admin', StatusEnum::false->status())
                ->get();

        
            $anonymous =  $request->anonymous ? $user->id : null ;
            
            return json_encode([
                "chat_html"  => view('admin.chat.message', compact('chat_messages','anonymous'))->render(),
                'status'   => true,
                'message'  => translate("Message Deleted"),
                'user_id'  => $user->id 
            ]);
        }




        return json_encode([
            'status'  => false,
            'message' => translate("Message Not Found")
        ]);

    }


    public function blockUser(Request $request) :string {


        $userColumn  = $request->anonymous ? 'floating_id' : 'user_id';
        $userModel   = $request->anonymous ? FloatingChat::class : User::class;
        $id          =  $request->anonymous ? $request->anonymous :  $request->user_id ;
        $user        = $userModel::find($id);
        $anonymous   = $request->anonymous ? true : false;

        $message     = translate('User Blocked');
        $status      = false;



        if(!$anonymous){

            $block_list_user       =  auth_user()->blocked_user ? json_decode( auth_user()->blocked_user,true): [] ;

            if(in_array($user->id,  $block_list_user)){
                
                $message           = translate('User Unblocked');
                $status            = true;
                $block_list_user   = array_values(array_filter($block_list_user, function($id) use ($user) {
                    return $id !== $user->id;
                }));
            }
    
            else{
                array_push($block_list_user, $user->id);
            }
            auth_user()->blocked_user =  json_encode($block_list_user);
            auth_user()->save();

        }else{

            if($user->is_closed   == StatusEnum::true->status()){
                $message           = translate('User Unblocked');
                $status            = true;
                $user->is_closed  =  StatusEnum::false->status();
            }
            else{

                $user->is_closed  =  StatusEnum::true->status();
            }

            $user->save();

        }

        
        try {
            $pusher_settings          =  json_decode(site_settings('pusher_settings'),true);
            $pusher                   =  $this->configPusher($pusher_settings);
            $push_data = [
    
                'blocked_notify'  => true,
                'receiver'        => $user->id ,
                'user_id'         => !$anonymous ?$user->id : null,
                'anonymous_id'    => $anonymous ?  $user->id  : null,
                'agent_id'        => auth_user()->id,
            ]; 
    
            $pusher->trigger($pusher_settings['chanel'], $pusher_settings['event'], $push_data);
    
        } catch (\Throwable $th) {
   
        }


        return json_encode([
            "status"    => $status,
            "message"   => $message,
        ]);


    }




    public function muteUser(Request $request) :string{

        $anonymous   = null ;

        $muted_list  =  auth_user()->muted_user	 ? json_decode( auth_user()->muted_user	,true): [] ;
        $user        = User::where('id',$request->user_id)
        ->first();
        $message     = translate('User Muted');
        $status      = false;
        if(in_array($request->user_id,  $muted_list)){
            $message = translate('User Unmuted');
            $status  = true;
            $muted_list = array_values(array_filter($muted_list, function($id) use ($request) {
                return $id !== $request->user_id;
            }));
        }
        else{
            array_push($muted_list, $request->user_id);
        }
        auth_user()->muted_user = json_encode($muted_list);
        auth_user()->save();
        
        $chat_messages = Chat::with(['agent','user'])
        ->where('user_id', $user->id)
        ->where('admin_id',auth_user()->id)
        ->where('deleted_by_admin',(StatusEnum::false)->status())
        ->get();


        return json_encode([

            "chat_header_html"  => view('admin.chat.chat_header', compact('chat_messages',"user",'anonymous'))->render(),
            "status"            => $status,
            "message"           => $message,
        ]);

    }



    public function deleteConversation(Request $request)  :array {


        $response ['status']  =  'error';
        $response ['message'] =  translate('Invalid Conversation');

        $userColumn  = $request->anonymous ? 'floating_id' : 'user_id';
        $id          = $request->anonymous ? $request->anonymous  : $request->user_id;

        $messages = Chat::where('admin_id',auth_user()->id)
                            ->where($userColumn,$id)
                            ->get();
        
        
        if(count( $messages) != 0){

            $response ['status']  =  'success';
            $response ['message'] =  translate('Conversation Deleted');

            foreach( $messages as $message){

                $message->deleted_by_admin =  (StatusEnum::true)->status();
                $message->save();
            }
        }
        
        
        return $response;

    }


    public function assignAgent(Request $request) : array{

        $response ['status']   =  'success';
     

        $agent                 = Admin::where('id',$request->id)
                                            ->agent()
                                            ->active()
                                            ->firstOrFail();


        $response ['message']  =  translate('Successfully Assigned To ').$agent->name;
        
        $user                  = FloatingChat::where('id',$request->anonymous_id)
                                              ->firstOrfail();



        $user->assign_to       =  $agent->id;

        $user->save();


        Chat::where('floating_id', $user->id)
        ->where('admin_id',auth_user()->id)
        ->update([
             "seen_by_agent" => StatusEnum::false->status(),
             "admin_id"      =>  $agent->id
        ]);

        $notificatios_settings = $agent->notification_settings ? json_decode($agent->notification_settings,true) : [];

        $code = [

            "name" => $agent->name,
            "link" => route('admin.chat.list'),
        ];

        if(site_settings("database_notifications") == (StatusEnum::true)->status()){

            $data = [
                'name'     => $agent->name,
                'route'    => route('admin.chat.list'),
                'messsage' => translate("You Have A New Assign Chat")
            ];

            $notification = SendNotification::database_notifications($data,$agent,auth_user()->id,NotifyStatus::AGENT);
        }

        if(site_settings("email_notifications") == (StatusEnum::true)->status()  &&  isset( $notificatios_settings['email']['new_chat']) && $notificatios_settings['email']['new_chat'] == (StatusEnum::true)->status()){

            SendEmailJob::dispatch($agent,'USER_CHAT',$code);
        }

        if(site_settings("sms_notifications") == (StatusEnum::true)->status() &&  isset( $notificatios_settings['sms']['new_chat']) && $notificatios_settings['sms']['new_chat'] == (StatusEnum::true)->status()){

            SendSmsJob::dispatch($agent,"USER_CHAT",$code);
        }

        return $response;





    }



    /**
     * notify user for a new chat 
     */

     public function notify_user($user){


        $user_chats =  Chat::where('user_id',$user->id)
        ->where("admin_id",auth_user()->id)
        ->count();

        $notificatios_settings = $user->notification_settings ? json_decode($user->notification_settings,true) : [];
        $notification          = null;

        if($user_chats  == 1){
            $code = [
                "name" => auth_user()->name,
                "link" => route('user.chat.list'),
            ];
            if(site_settings("database_notifications") == (StatusEnum::true)->status()){
                $data = [
                    'route'    => route('user.chat.list'),
                    'messsage' => translate("You Have A New Message From ").auth_user()->name
                ];

                $notification  = SendNotification::database_notifications($data,$user,auth_user()->id,NotifyStatus::USER);
            }

            if(site_settings("email_notifications") == (StatusEnum::true)->status()  && isset( $notificatios_settings['email']['new_chat']) && $notificatios_settings['email']['new_chat'] == (StatusEnum::true)->status()){
                SendEmailJob::dispatch($user,'USER_CHAT',$code);
            }

            if(site_settings("sms_notifications") == (StatusEnum::true)->status() && isset( $notificatios_settings['sms']['new_chat']) &&  $notificatios_settings['sms']['new_chat'] == (StatusEnum::true)->status()){
                SendSmsJob::dispatch($user,"USER_CHAT",$code);
            }
        }

        return $notification;

     }



     
    /**
     * pusher config
     *
     * @param array $pusher_settingss
     */
    public function configPusher(array $pusher_settings) :object{

        $options = array(
            'cluster'  => $pusher_settings['app_cluster'],
            'useTLS'   => true,
        );

        return new Pusher(
            $pusher_settings['app_key'], $pusher_settings['app_secret'], $pusher_settings['app_id'], $options
        );

    }


}