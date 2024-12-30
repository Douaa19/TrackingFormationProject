<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Services\Admin\MessengerServices;
use Illuminate\Http\Request;
use App\Enums\StatusEnum;
use App\Models\Chat;
use App\Models\FloatingChat;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;



class AdminChatController extends Controller
{


    public $messageService ;


    public function __construct()
    {
        $this->middleware(function($request,$next){
          

            if(site_settings('chat_module') == (StatusEnum::false)->status()){

                abort(403,unauthorized_message()); 
            }
            return $next($request);
        });



        

        $this->messageService  = new MessengerServices();
    }

    /**
     * Displays the chat page with the list of active users.
     *
     * @return Illuminate\Contracts\View\View | RedirectResponse
     */
    public function chat() : \Illuminate\Contracts\View\View | RedirectResponse{
        
        $title = 'Chat list';

        if(site_settings('chat_module') == (StatusEnum::false)->status()) return back()->with('error',translate('Chat Module Is Disable For Now'));

        $chats = Chat::with(['user' => function ($query) {
            $query->active();
        },"floating"])
            ->whereNotNull('user_id')
            ->select('user_id') 
            ->distinct()
            ->where("admin_id", auth_user()->id)
            ->get();


        $anonymousChats = FloatingChat::whereNull('assign_to')
        ->orWhere('assign_to',auth_user()->id)
        ->get();

        $users = User::whereDoesntHave('chat', function ($query) {
            $query->where('chats.admin_id',auth_user()->id);
        })
        ->distinct()
        ->get();


        return view('admin.chat.list',compact('chats','title','users','anonymousChats'));
    }

    /**
     * Returns the chat messages between the authenticated user and the user with the given ID.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function userChat(Request $request) : string {

        return $this->messageService->getMessage($request);
      
    }

    


    /**
     * send messages between the authenticated user and the user with the given ID.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function sendMessage(Request $request) :string {

        $rules = [ "message" => "required|max:255",];

        $fieldToCheck         = $request->input("anonymous") ? 'anonymous' : 'user_id';
        $rules[$fieldToCheck] = 'required|exists:' . ($fieldToCheck === 'anonymous' ? 'floating_chats' : 'users') . ',id';

        $request->validate($rules,[
            'message.required' => "Message cannot be empty"
        ]);

        return $this->messageService->sendMessage($request);

    }


    


    /**
     * delete messages between the authenticated user and the user with the given ID.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function deleteMessage(Request $request) :string{


        $fieldToCheck         = $request->input("anonymous_id") ? 'anonymous_id' : 'user_id';
        $rules[$fieldToCheck] = 'required|exists:' . ($fieldToCheck === 'anonymous_id' ? 'floating_chats' : 'users') . ',id';

        $request->validate($rules,[
            $fieldToCheck."required" => "User is required",
            $fieldToCheck."exists"   => "User doesnot exists",
        ]);

        return $this->messageService->deleteMessage($request);
    }

    /**
     * delete conversation.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteConversation(Request $request) :\Illuminate\Http\RedirectResponse{


        $response =  $this->messageService->deleteConversation($request);

        return back()->with(Arr::get($response,"status","success"),Arr::get($response,"message","message"));
    }

    /**
     * block a user.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function blockUser(Request $request) :string{

        $fieldToCheck         = $request->input("anonymous") ? 'anonymous' : 'user_id';
        $rules[$fieldToCheck] = 'required|exists:' . ($fieldToCheck === 'anonymous' ? 'floating_chats' : 'users') . ',id';

        $request->validate($rules);

        return $this->messageService->blockUser($request);
 
    }


    /**
     * mute a user.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function muteUser(Request $request) :string{

        $request->validate([
            'user_id'           => 'required|exists:users,id',
        ],[
            'user_id.required'  => translate('No User Found !!'),
            'user_id.exists'    => translate('No User Found !!'),
        ]);


        return $this->messageService->muteUser($request);
  
    }



    /**
     * mute a user.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function assign(Request $request) :RedirectResponse { 


        $request->validate([
            "id"           => "required | exists:admins,id",
            "anonymous_id" => "required | exists:floating_chats,id",
        ]);

        $response          =  $this->messageService->assignAgent($request);
        
        return back()->with(Arr::get($response,"status","success"),Arr::get($response,"message","message"));


    }





}
