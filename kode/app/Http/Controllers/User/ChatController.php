<?php

namespace App\Http\Controllers\User;

use App\Enums\NotifyStatus;
use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Services\TicketService;
use App\Http\Utility\SendNotification;
use App\Jobs\SendEmailJob;
use App\Jobs\SendSmsJob;
use App\Models\Admin;
use App\Models\Chat;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Pusher\Pusher;


class ChatController extends Controller
{

    /**
     * Displays the chat page with the list of active users.
     *
     */
    public function chat() :\Illuminate\View\View | RedirectResponse{

        $title  = 'User Chat list';
        if(site_settings('chat_module') == (StatusEnum::false)->status())  return back()->with('error',translate('Chat Module Is Disable For Now'));
        $agents = Admin::active()->get();
        return view('user.chat.list',compact('agents','title'));
    }

    /**
     * Returns the chat messages between the authenticated user and the user with the given ID.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function agentChat(Request $request) :string{

        if(!$request->agent_id || !(Admin::where('id',$request->agent_id)->active()->exists()))  return json_encode([
            'status'  => false,
            'message' => translate("Agent Not Found")
        ]);

        $blocked         = false;
        $agent           = Admin::where('id',$request->agent_id)->first();

        $block_list_user =  $agent->blocked_user 
                                  ? json_decode( $agent->blocked_user,true) 
                                  : [] ;

        if(in_array(auth_user('web')->id,  $block_list_user)){
            $blocked     = true;
        }
        Chat::with(['agent','user'])->where('user_id',auth_user('web')->id)
                                ->where('admin_id', $agent->id)
                                ->where('deleted_by_user',(StatusEnum::false)->status())
                                ->lazyById(1000,'id')->each
                                ->update([
                                    "seen"       => (StatusEnum::true)->status()
                                ]);
        
        $chat_messages = Chat::with(['agent','user'])
                                ->where('user_id',auth_user('web')->id)
                                ->where('admin_id', $agent->id)
                                ->where('deleted_by_admin',(StatusEnum::false)->status())
                                ->get();


            try {
                $pusher_settings  =  json_decode(site_settings('pusher_settings'),true);
                $options = array(
                    'cluster'     => $pusher_settings['app_cluster'],
                    'useTLS'      => true,
                );
                $pusher = new Pusher(
                    $pusher_settings['app_key'], $pusher_settings['app_secret'], $pusher_settings['app_id'], $options
                );
                $push_data = [
                    'user_seen'     => true,
                    'counter'       => false,
                    'muted'         => true,
                    'admin_seen_id' => $agent->id,
                    'user_seen_by'  => auth_user('web')->id
                ]; 
                $pusher->trigger($pusher_settings['chanel'], $pusher_settings['event'], $push_data);
            } catch (\Throwable $th) {
                
            }

        
        return json_encode([
                'is_blocked'       => $blocked,
                'status'           => true,
                "chat_html"        => view('user.chat.message', compact('chat_messages'))->render(),
                "chat_header_html" => view('user.chat.chat_header', compact('chat_messages',"agent"))->render(),
                'agent_id'         => $agent->id
        ]);

    }


    /**
     * send messages between the authenticated user and the user with the given ID.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function sendMessage(Request $request)  :string{

        $request->validate([
            'agent_id'          => 'required|exists:admins,id',
        ],[
            'agent_id.required' => translate('No Agent Found !!'),
            'agent_id.exists'   => translate('No Agent Found !!'),
        ]);

        if(!$request->message){
            return json_encode([

                'status'  => false,
                'message' => translate("Message Cannot Be Empty")
            ]);
        }
        $agent = Admin::where('id',$request->agent_id)
                        ->active()
                        ->first();

        $block_list_user = $agent->blocked_user ? json_decode( $agent ->blocked_user,true): [] ;
        $muted_user      = $agent->muted_user ? json_decode( $agent->muted_user,true): [] ;


    
        $muted       = true;

        if(in_array(auth_user('web')->id,  $block_list_user)){
            return json_encode([
                'status'    => false,
                'message'   => translate("You Are Blocked !! By this Agent")
            ]);
        }
        if(!in_array(auth_user('web')->id,  $muted_user))    $muted       = false;

 


        
        $pusher_settings        =  json_decode(site_settings('pusher_settings'),true);
        $options = array(
            'cluster'           => $pusher_settings['app_cluster'],
            'useTLS'            => true,
        );
        $pusher = new Pusher(
            $pusher_settings['app_key'], $pusher_settings['app_secret'], $pusher_settings['app_id'], $options
        );

        $push_data = [
            'counter'           => true,
            'muted'             => $muted,
            'receiver'          => $request->agent_id,
            'user_id'           => auth_user('web')->id,
            'agent_id'          => $request->agent_id,
            'message_for'       => 'admin',
        ]; 


        if(!$muted)  $push_data ['play_audio_for_chat'] = true;


        $chat                   = new Chat();
        $chat->user_id          = auth_user('web')->id;
        $chat->admin_id         = $request->agent_id;
        $chat->deleted_by_user  = (StatusEnum::false)->status();
        $chat->deleted_by_admin = (StatusEnum::false)->status();
        $chat->sender           = (StatusEnum::false)->status();
        $chat->seen             = (StatusEnum::false)->status();
        $chat->seen_by_agent    = (StatusEnum::false)->status();

        $chat->message          = $request->message;
        $chat->save();



         try {
            $notification    = (new TicketService())->notifyAgent(agent : $agent , message :  translate("You Have A New Message From ").auth_user('web')->name,subKey :'new_chat',routeName : route('admin.chat.list'),templateCode : 'USER_CHAT' ,  mailCode :[
                "name" => auth_user('web')->name,
                "link" => route('admin.chat.list'),
            ]);
    
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



         $chat_messages = Chat::with(['agent','user'])
                                ->where('user_id',auth_user('web')->id)
                                ->where('admin_id', $agent->id)
                                ->where('deleted_by_admin',(StatusEnum::false)->status())
                                ->get();


        return json_encode([
            'status'=> true,
            'message' => translate("Message Sent"),
            "chat_html"        => view('user.chat.message', compact('chat_messages'))->render(),
        ]);
    }


    /**
     * notify agent if there is a new convo
     */

     public function  notify_agent($agent,$notificationFor){

        $counter =  Chat::where('user_id',auth_user('web')->id)->where("admin_id",$agent->id)->count();
        $notificatios_settings = $agent->notification_settings ? json_decode($agent->notification_settings,true) : [];
        $notification = null;

        if($counter  == 1){

            $code = [
                "name" => auth_user('web')->name,
                "link" => route('admin.chat.list'),
            ];

            if(site_settings("database_notifications") == (StatusEnum::true)->status()){

                $data = [
                    'name'     => auth_user('web')->name,
                    'route'    => route('admin.chat.list'),
                    'messsage' => translate("You Have A New Message From ").auth_user('web')->name
                ];

                $notification = SendNotification::database_notifications($data,$agent,auth_user('web')->id,$notificationFor);
            }

            if(site_settings("email_notifications") == (StatusEnum::true)->status()  &&  isset( $notificatios_settings['email']['new_chat']) && $notificatios_settings['email']['new_chat'] == (StatusEnum::true)->status()){
                SendEmailJob::dispatch($agent,'USER_CHAT',$code);
            }

            if(site_settings("sms_notifications") == (StatusEnum::true)->status() &&  isset( $notificatios_settings['sms']['new_chat']) && $notificatios_settings['sms']['new_chat'] == (StatusEnum::true)->status()){
                SendSmsJob::dispatch($agent,"USER_CHAT",$code);
            }


        
        }

        return $notification;
    }




    /**
     * delete messages between the authenticated user and the user with the given ID.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function deleteMessage(Request $request) :string{

        $agent  =  Admin::where('id',$request->agent_id)->active()->first();
        if(!$request->agent_id || !$agent ){
            return json_encode([
                'status'=> false,
                'message' => translate("Agent Not Found")
            ]);
        }
        
        $chat = Chat::where('id',$request->message_id)->where('user_id',auth_user('web')->id)->where('admin_id',$request->agent_id)->first();
        if($chat){
            if($chat->deleted_by_admin == (StatusEnum::true)->status() ){
                $chat->delete();
            }
            else{
                $chat->deleted_by_user =  (StatusEnum::true)->status();
                $chat->save();
            }
            return json_encode([
                'status'   => true,
                'message'  => translate("Message Deleted"),
                'agent_id' => $agent->id 
            ]);
        }

        return json_encode([
            'status'  => false,
            'message' => translate("Message Not Found")
        ]);
    }

    /**
     * delete conversation.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteConversation(Request $request){

        $messages = Chat::where('user_id',auth_user('web')->id)->where('admin_id',$request->agent_id)->get();
        if(count( $messages) == 0){
            return back()->with('error',translate('Invalid Conversation'));
        }
        foreach( $messages as $message){
            if($message->deleted_by_admin == (StatusEnum::true)->status() ){
                $message->delete();
            }
            else{
                $message->deleted_by_user =  (StatusEnum::true)->status();
                $message->save();
            }
        }

        return back()->with('success',translate('Conversation Deleted'));
    }


    /**
     * mute a agent.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function muteAgent(Request $request){

        $request->validate([
            'agent_id'          => 'required|exists:admins,id',
        ],[
            'agent_id.required' => translate('No Agent Found !!'),
            'agent_id.exists'   => translate('No Agent Found !!'),
        ]);
        $muted_list   =  auth_user('web')->muted_agent	 ? json_decode( auth_user('web')->muted_agent	,true): [] ;
        $agent        =  Admin::where('id',$request->agent_id)
                             ->active()->first();
        $message      = translate('Agent Muted');
        $status       = false;
        if(in_array($request->agent_id,  $muted_list)){
            $message  = translate('Agent Unmuted');
            $status   = true;
            $muted_list = array_values(array_filter($muted_list, function($id) use ($request) {
                return $id !== $request->agent_id;
            }));

        }
        else{
            array_push($muted_list, $request->agent_id);
        }
        auth_user("web")->muted_agent = json_encode($muted_list);
        auth_user("web")->save();

        $chat_messages = Chat::with(['agent','user'])->where('user_id',auth_user('web')->id)->where('admin_id', $agent->id)->where('deleted_by_user',(StatusEnum::false)->status())->get();
        return json_encode([
            "chat_header_html" => view('user.chat.chat_header', compact('chat_messages',"agent"))->render(),
            "status"           => $status,
            "message"         => $message,
        ]);
  
    }


}
