<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AgentRequest;
use App\Models\Admin;
use App\Models\Category;
use App\Models\Chat;
use App\Models\User as ModelsUser;
use Pusher\Pusher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
class AgentController extends Controller
{


    public function __construct()
    {
        $this->middleware(function($request,$next){

            if(auth_user()->agent == (StatusEnum::true)->status()){
                abort(403,unauthorized_message());
            }
            return $next($request);
        });
    }

    /**
     * Agent List
     *
     * @return View
     */
    public function index() :View {

        return view('admin.agent.index',[

            'title' => "Manage Agent",
            'agents'=> Admin::with(['response'])
                            ->withCount(['response','tickets'])
                            ->latest()
                            ->get()
        ]);

    }

    /**
     * Create A new Agent
     *
     * @return View
     */
    public function create() :View {

        return view('admin.agent.create',[

            'title'      => "Create Agent",
            'categories' => Category::active()
              ->where("ticket_display_flag",StatusEnum::true->status())->get()
        ]);

    }

    /**
     * Store a New Agent
     *
     * @param AgentRequest $request
     * @return RedirectResponse
     */
    public function store(AgentRequest $request) :RedirectResponse {

        $address_data         =   $this->get_address($request);
        $agent                =   new Admin();
        $agent->name          =   $request->name;
        $agent->username      =   $request->username;
        $agent->email         =   $request->email;
        $agent->phone         =   $request->phone;
        $agent->password      =   Hash::make($request->password);
        $agent->agent = $request->type == 0 ? (StatusEnum::true)->status() : ($request->type == 1 ? (StatusEnum::false)->status() : 2);
        $agent->status = (StatusEnum::true)->status();
        if(in_array($request->type, [1,2])) {
            $agent->permissions = json_encode(@$request->permissions ?? []);
            $agent->categories = json_encode(@$request->categories ?? []);
        } else {
            $agent->permissions = null;
            $agent->categories = null;
        }

        $agent->address       =  json_encode($address_data);
        $agent->longitude	  =  isset($address_data['lon']) ?  $address_data['lon'] : null;
        $agent->latitude	  =  isset($address_data['lat']) ?  $address_data['lat'] : null;
        if($request->hasFile('image')){
            try{
                $removefile   = $agent->image ?: null;
                $agent->image = storeImage($request->file('image'), getFilePaths()['profile']['admin']['path'], null, $removefile);
            }catch (\Exception $exp){
                return back()->with('error', translate("Unable to upload file. Check directory permissions"));
            }
        }
        $agent->save();

        return back()->with('success', translate('Agent Creted Successfully'));
    }

    /**
     * get address by ip or map
     */

     public function get_address($request) : array{


        try {
            $ip                            = request()->ip();
            $url                           = "http://ip-api.com/json/$ip";
            $address_data                  = json_decode(file_get_contents($url),true);
            $userAgent                     = $request->header('User-Agent');
            $address_data ['browser_name'] = browser_name($userAgent);
            $address_data ['device_name']  = get_divice_type($userAgent);
            if(site_settings("auto_ticket_assignment") == StatusEnum::true->status() && site_settings('geo_location') == 'map_base'){
                $address_data              = [];
                $address_data ['address']  = $request->address;
                $address_data ['lat']      = $request->latitude;
                $address_data ['lon']      = $request->longitude;
            }
            return $address_data;
        } catch (\Throwable $th) {
            return [];
        }



     }

    /**
     * Agent Edit
     *
     * @param int $id
     * @return View
     */
     public function edit(int | string $id) :View {

        return view('admin.agent.edit',[

            'title'      => "Agent Update",
            'agent'      => Admin::where('id',$id)->first(),
            'categories' => Category::active()
             ->where("ticket_display_flag",StatusEnum::true->status())->get()
        ]);
    }

    /**
     * Store a New Agent
     *
     * @param AgentRequest $request
     * @return RedirectResponse
     */
    public function update(AgentRequest $request) :RedirectResponse {

        $address_data = $this->get_address($request);
        $agent        = Admin::agent()->where('id',$request->id)->first();
        if(!$agent){
            return back()->with('error', translate('Agent Doesnot Exists'));
        }
        $agent->name     =  $request->name;
        $agent->username = $request->username;

        $agent->email        = $request->email;
        $agent->phone        = $request->phone;
        $agent->super_agent  = $request->type;
        $agent->agent        = $request->type  == 0 ? (StatusEnum::true)->status() : (StatusEnum::false)->status() ;
        $agent->permissions  =  json_encode(@$request->permissions ?? []);
        $agent->address      =  json_encode($address_data);
        $agent->longitude	 =  isset($address_data['lon']) ?  $address_data['lon'] : null;
        $agent->latitude	 =  isset($address_data['lat']) ?  $address_data['lat'] : null;
        $agent->categories   =  json_encode(@$request->categories ?? []);

        if($request->hasFile('image')){
            try{
                $removefile   = $agent->image ?: null;
                $agent->image = storeImage($request->file('image'), getFilePaths()['profile']['admin']['path'], null, $removefile);
            }catch (\Exception $exp){
                return back()->with('error', translate("Unable to upload file. Check directory permissions"));
            }
        }
        $agent->save();
        return back()->with('success', translate('Agent Updated Successfully'));

    }


    /**
     * Update A Agent Status
     *
     * @param int $id
     * @param Enum $status
     * @return JsonResponse
     */
    public function statusUpdate(Request $request) :JsonResponse | RedirectResponse {


        $modelInfo = [

            'table'  => (new Admin())->getTable(),
            'key'    => "id",
            'values' => StatusEnum::toArray()
        ];

        $response['status']   = false;
        $response['message']  = translate('Agent Doesnot Exists');

        validateModelStatus($request,$modelInfo);

        $agent =  Admin::agent()->where('id',$request->data['id'])->first();
        if($agent){

            $agent->status        = $request->data['status'];
            $agent->save();
            $response['status']   = true;
            $response['message']  = translate('Status Updated Successfully');
        }

        return response()->json($response);
    }



    /**
     * Update A Agent Status
     *
     * @param int $id
     * @param Enum $status
     * @return JsonResponse
     */
    public function popularStatusUpdate(Request $request) :JsonResponse | RedirectResponse {


        $modelInfo = [

            'table'  => (new Admin())->getTable(),
            'key'    => "id",
            'values' => StatusEnum::toArray()
        ];


        $response['status']   = false;
        $response['message']  = translate('Agent Doesnot Exists');

        validateModelStatus($request,$modelInfo);

        $agent =  Admin::agent()->where('id',$request->data['id'])->first();

        if($agent){

            $agent->best_agent    = $request->data['status'];
            $agent->save();
            $response['status']   = true;
            $response['message']  = translate('Status Updated Successfully');

        }

        return response()->json($response);
    }






    /**
     * Delete a New Agent
     *
     * @param int $id
     *
     */
    public function delete(int | string $id) :RedirectResponse {

        $agent =  Admin::with(['response','tickets'])
                 ->withCount("group")
                 ->agent()->where('id',$id)->firstOrfail();


        if($agent->group_count > 0){
            return back()->with('error', translate('Can Not Deleted!! This Agent Has lots of Related Data!!'));
        }
        try {
            remove_file(getFilePaths()['profile']['admin']['path'], $agent->image);
        } catch (\Throwable $th) {

        }

        $agent->response()->delete();
        $agent->tickets()->delete();
        $agent->delete();
        return back()->with('success', translate('Agent Deleted Successfully'));
    }

    /**
     * agent login
     */
     public function login(int | string $id) :RedirectResponse {

        $message  = translate('Agent Not Found');
        $agent    =  Admin::agent()->where('id',$id)->first();

        if($agent){
            if($agent->status == (StatusEnum::true)->status()){

                Auth::guard('admin')->loginUsingId($agent->id);
                return redirect()->route('admin.dashboard')->with('success',translate('SuccessFully Login As a Agent'));
            }
            $message = translate('Active Agent Status Then Try Again');
        }
        return back()->with('error',  $message);
    }

    /**
     * agent chat report
     */

     public function chatReport(int | string $id) {

        $users = ModelsUser::active()->get();

        $agent =  Admin::agent()->where('id',$id)->firstOrfail();

        return view('admin.agent.chat_list',compact('agent','users'));
     }


    /**
     * Returns the chat messages between the authenticated user and the user with the given ID.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function userChat(Request $request) : string {

        if(!$request->user_id || !(ModelsUser::where('id',$request->user_id)->active()->exists())){
            return json_encode([
                'status'=> false,
                'message' => translate("User Not Found")
            ]);
        }
        $user            = ModelsUser::where('id',$request->user_id)->first();
        $agent           = Admin::agent()->where('id',$request->agent_id)->first();
        $blocked         = false;
        $block_list_user =   $agent->blocked_user ? json_decode( $agent->blocked_user,true): [] ;
        if(in_array($user->id,  $block_list_user)){
            $blocked = true;
        }
        $chat_messages = Chat::with(['agent','user'])->where('admin_id',$agent->id)->where('user_id', $user->id)->get();
        return json_encode([
            'is_blocked'       => $blocked,
            'status'           => true,
            "chat_html"        => view('admin.chat.message', compact('chat_messages'))->render(),
            "chat_header_html" => view('admin.agent.chat_header', compact('chat_messages',"user","agent"))->render(),
            'user_id'          => $user->id
        ]);

    }


    /**
     * delete messages between the authenticated user and the user with the given ID.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function deleteMessage(Request $request) :string{

        $user  =  ModelsUser::where('id',$request->user_id)->active()->first();
        $agent = Admin::agent()->where('id',$request->agent_id)->first();

        if(!$request->user_id || !$user ){
            return json_encode([
                'status'  => false,
                'message' => translate("User Not Found")
            ]);
        }

        $chat = Chat::where('id',$request->message_id)
        ->where('admin_id',$agent->id)
        ->where('user_id',  $user->id)
        ->first();

        if($chat){

            $chat->delete();
            $pusher_settings =  json_decode(site_settings('pusher_settings'),true);
            $options = array(
                'cluster' => $pusher_settings['app_cluster'],
                'useTLS'  => true,
            );

            $pusher = new Pusher(
                $pusher_settings['app_key'], $pusher_settings['app_secret'], $pusher_settings['app_id'], $options
            );
            $muted_agent = $user->muted_agent ? json_decode( $user->muted_agent,true): [] ;
            $muted       = false;
            if(in_array($agent->id,  $muted_agent)){
                $muted = true;
            }
            $push_data = [
                'muted'    => $muted,
                'receiver' => $user->id,
                'user_id'  => $user->id,
                'agent_id' => $agent->id,
            ];
            $pusher->trigger($pusher_settings['chanel'], $pusher_settings['event'], $push_data);
            return json_encode([
                'status'   => true,
                'message'  => translate("Message Deleted"),
                'agent_id' => $agent->id,
                'user_id'  => $user->id
            ]);
        }

        return json_encode([
            'status'  => false,
            'message' => translate("Message Not Found")
        ]);
    }


    /**
     * block a user.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function blockUser(Request $request) :string{

        $request->validate([
            'user_id'          => 'required|exists:users,id',
        ],[
            'user_id.required' => translate('No User Found !!'),
            'user_id.exists'   => translate('No User Found !!'),
        ]);


        $agent           = Admin::agent()->where('id',$request->agent_id)->first();
        $block_list_user =   $agent->blocked_user ? json_decode( $agent->blocked_user,true): [] ;

        $message = translate('User Blocked');
        $status  = false;
        if(in_array($request->user_id,  $block_list_user)){
            $message  = translate('User Unblocked');
            $status   = true;
            $block_list_user = array_values(array_filter($block_list_user, function($id) use ($request) {
                return $id !== $request->user_id;
            }));
        }

        else{
            array_push($block_list_user, $request->user_id);
        }
        $agent->blocked_user = json_encode($block_list_user);
        $agent->save();
        $pusher_settings     =  json_decode(site_settings('pusher_settings'),true);

        $options = array(
            'cluster' => $pusher_settings['app_cluster'],
            'useTLS' => true,
        );

        $pusher = new Pusher(
            $pusher_settings['app_key'], $pusher_settings['app_secret'], $pusher_settings['app_id'], $options
        );
        $push_data = [
            'blocked_notify' => true,
            'receiver'       => $request->user_id,
            'user_id'        => $request->user_id,
            'agent_id'       => $agent->id,
        ];
        $pusher->trigger($pusher_settings['chanel'], $pusher_settings['event'], $push_data);

        return json_encode([
            "user_id"    => $request->user_id,
            "status"     => $status,
            "message"    => $message,
        ]);

    }

    /**
     * delete conversation.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteConversation(Request $request) :\Illuminate\Http\RedirectResponse{

        $messages = Chat::where('admin_id',$request->agent_id)
        ->where('user_id',$request->user_id)
        ->delete();
        $pusher_settings  =  json_decode(site_settings('pusher_settings'),true);
        $options = array(
            'cluster' => $pusher_settings['app_cluster'],
            'useTLS'  => true,
        );
        $pusher = new Pusher(
            $pusher_settings['app_key'], $pusher_settings['app_secret'], $pusher_settings['app_id'], $options
        );
        $push_data = [
            'blocked_notify' => true,
            'receiver'       => $request->user_id,
            'user_id'        => $request->user_id,
            'agent_id'       =>  $request->agent_id,
        ];
        $pusher->trigger($pusher_settings['chanel'], $pusher_settings['event'], $push_data);

        return back()->with('success',translate('Conversation Deleted'));
    }





    /**
     * Update password
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function passwordUpdate(Request $request): RedirectResponse{

        $request->validate([
            'id'       => 'required|exists:admins,id',
            'password' => 'required|confirmed|min:5'
        ]
        ,[
            'id.required'        => translate('Invalid user'),
            'id.exists'          => translate('Invalid user'),
            'password'           => translate('Password Feild Is Required'),
            'password.confirmed' => translate('Confirm Password Does not Match'),
            'password.min'       => translate('Minimum 5 digit or character is required'),
        ]);

        $agent             = Admin::agent()->findOrfail($request->input('id'));
        $agent->password   = Hash::make($request->password);
        $agent->save();
        return back()->with("success", translate('Password updated'));
    }


}
