<?php
namespace App\Http\Controllers\Admin;

use App\Enums\NotifyStatus;
use App\Enums\StatusEnum;
use App\Enums\TicketStatus as EnumsTicketStatus;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Article;
use App\Models\Category;
use App\Models\CustomNotifications;
use App\Models\Subscriber;
use App\Models\SupportMessage;
use App\Models\SupportTicket;
use App\Models\TicketStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\View\View;
use App\Rules\General\FileExtentionCheckRule;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class AdminController extends Controller
{

    /**
     * Display the admin dashboard.
     */
    public function index(Request $request) :View
    {


        $title   = "Dashboard";
        $data    = $this->getDashboardData($request);
        return view('admin.dashboard', compact('title','data'));
    }

    /**
     * get dashboard data
     */

     public function getDashboardData($request =  null) :array{


        $currentYear = date("Y");


        $data['total_user']        = User::filter($request)->count();
        $data['total_categories']  = Category::filter($request)->count();
        $data['total_article']     = Article::filter($request)->count();
        $data['total_subscribers'] = Subscriber::filter($request)->count();
        $data['total_agent']       = Admin::where('agent',(StatusEnum::true)->status())
        ->filter($request)
        ->count();


        /** total ticket */

        $totalTickets = SupportTicket::agent()
                                ->whereYear('created_at', $currentYear)
                                ->filter($request)
                                ->count();

        $prevTickets = SupportTicket::agent()
                                ->whereYear('created_at', $currentYear-1)
                                ->filter($request)
                                ->count();
        $data['total_tickets'] = $totalTickets;

        $ticketIncrese = round($totalTickets-$prevTickets) ;

        $data['total_tickets_increase'] = ($prevTickets > 0)
                        ? round(($ticketIncrese /  $prevTickets ) * 100, 2)
                        : 0;



        /** pending ticket */

        $totalPendingTickets = SupportTicket::agent()
                                    ->pending()
                                    ->whereYear('created_at', $currentYear)
                                    ->filter($request)
                                    ->count();

        $prevPendingTickets = SupportTicket::agent()
                                            ->pending()
                                            ->whereYear('created_at', $currentYear-1)
                                            ->filter($request)
                                            ->count();

        $data['total_pending_tickets'] = $totalPendingTickets;

        $ticketIncrese = round($totalPendingTickets-$prevPendingTickets) ;

        $data['total_pending_tickets_increase'] = ($prevPendingTickets > 0)
                                                            ? round(($ticketIncrese /  $prevPendingTickets ) * 100, 2)
                                                            : 0;



         /** solved ticket */

         $totalSolvedTickets = SupportTicket::agent()
                                    ->solved()
                                    ->whereYear('created_at', $currentYear)
                                    ->filter($request)
                                    ->count();
 
         $prevSolvedTickets = SupportTicket::agent()
                                    ->solved()
                                    ->whereYear('created_at', $currentYear-1)
                                    ->filter($request)
                                    ->count();
 
         $data['total_solved_tickets'] = $totalSolvedTickets;
 
         $ticketIncrese = round($totalSolvedTickets-$prevSolvedTickets) ;
 
         $data['total_solved_tickets_increase'] = ($prevSolvedTickets > 0)
                                                            ? round(($ticketIncrese /  $prevSolvedTickets ) * 100, 2)
                                                            : 0;



         $data['total_opened_tickets'] = SupportTicket::agent()
                                                        ->opend()
                                                        ->whereYear('created_at', $currentYear)
                                                        ->filter($request)
                                                        ->count();



        /** closed ticket */

        $totalClosedTickets = SupportTicket::agent()
                                    ->closed()
                                    ->whereYear('created_at', $currentYear)
                                    ->filter($request)
                                    ->count();

        $prevClosedTickets = SupportTicket::agent()
                                    ->closed()
                                    ->whereYear('created_at', $currentYear-1)
                                    ->filter($request)
                                    ->count();

        $data['total_closed_tickets'] = $totalClosedTickets;




        $data['ticket_status_counter'] =  TicketStatus::withCount(['tickets'=> function($q) use($currentYear ,$request){          
                                                        return $q->agent()
                                                                ->whereYear('created_at', $currentYear)
                                                                ->filter($request);
        }])->whereIn('id',[EnumsTicketStatus::PENDING->value,EnumsTicketStatus::SOLVED->value ,EnumsTicketStatus::CLOSED->value])
           ->lazyById(100,'id')
           ->map(function(TicketStatus $status) use($currentYear){

                $url = match ($status->id) {
                    EnumsTicketStatus::SOLVED->value => route("admin.ticket.solved"),
                    EnumsTicketStatus::CLOSED->value => route("admin.ticket.closed"),
                    default => route("admin.ticket.pending"),
                };

                $counter_key = match ($status->id) {
                    EnumsTicketStatus::SOLVED->value => 'total_solved_tickets',
                    EnumsTicketStatus::CLOSED->value => 'total_closed_tickets',
                    default => 'total_pending_tickets',
                };

                $increase_key = match ($status->id) {
                    EnumsTicketStatus::SOLVED->value => 'total_solved_tickets_increase',
                    EnumsTicketStatus::CLOSED->value => 'total_closed_tickets_increase',
                    default => 'total_pending_tickets_increase',
                };

                return (object)[
                    'id'            => $status->id,
                    'count'         => $status->tickets_count,
                    'name'          => $status->name,
                    'url'           => $url,
                    'current_year'  => $currentYear,
                    'counter_key'   => $counter_key,
                    'increase_key'  => $increase_key,
                ];
        })->all();

       

        $ticketIncrese = round($totalClosedTickets-$prevClosedTickets) ;

        $data['total_closed_tickets_increase'] = ($prevClosedTickets > 0)
                    ? round(($ticketIncrese /  $prevClosedTickets ) * 100, 2)
                    : 0;
   


        $data['ticket_by_category']  = Category::withCount(['tickets as tickets_count' => function($q) use($request){
 
               $q->agent()->filter($request);
            
        }])
        ->having('tickets_count', '>', 0) 
        ->orderBy('tickets_count','desc')
        ->pluck("tickets_count",'name',)
        ->mapWithKeys(function ($count, $name) {
            $name = limit_words(get_translation($name),15) ;
            return [$name => $count];
        })
        ->toArray();

        $data['ticket_by_user']  = User::withCount(['tickets as tickets_count' => function($q)  use($request){
            $q->agent()->filter($request);
        }])
                                                ->having('tickets_count', '>', 0) 
                                                ->orderBy('tickets_count','desc')
                                                ->pluck("tickets_count",'name',)
                                                ->toArray();

   
        $data['latest_ticket'] = SupportTicket::agent()
                                                ->latest("created_at")
                                                ->with('messages')
                                                ->filter($request)
                                                ->take(5)
                                                ->get();

        $data['latest_pending_ticket'] =  SupportTicket::agent()
                                                ->filter($request)
                                                ->latest()
                                                ->pending()
                                                ->take(10)
                                                ->get();





        $data['latest_messages'] =  SupportMessage::with('admin')->agent()
                                                ->filter($request)
                                                ->latest()
                                                ->take(10)
                                                ->get();




        $ticketsByYear = sortByMonth( SupportTicket::agent()
                                                ->filter($request)
                                                ->selectRaw("MONTHNAME(created_at) as months, count(*) as total")
                                                ->whereYear('created_at', '=',date("Y"))
                                                ->groupBy('months')
                                                ->pluck('total', 'months')
                                                ->toArray());




        $openedTicket = sortByMonth( SupportTicket::agent()
                                                ->filter($request)
                                                ->opend()
                                                ->selectRaw("MONTHNAME(created_at) as months, count(*) as total")
                                                ->whereYear('created_at', '=',date("Y"))
                                                ->groupBy('months')
                                                ->pluck('total', 'months')
                                                ->toArray());
        



        $closedByYear = sortByMonth( SupportTicket::agent()
                                                ->filter($request)
                                                ->closed()
                                                ->selectRaw("MONTHNAME(created_at) as months, count(*) as total")
                                                ->whereYear('created_at', '=',date("Y"))
                                                ->groupBy('months')
                                                ->pluck('total', 'months')
                                                ->toArray());




        $ticketTypes = [
            "tickets"  => $ticketsByYear,
            "open"     => $openedTicket,
            "closed"   => $closedByYear,

        ];



        $data['ticket_mix_graph'] = $this->formatCounter($ticketTypes);


        return $data;

     }



     public function formatCounter(array $ticketTypes) : array{


        $maxCount     = 0;
        $maxCountType = null;
        
        foreach ($ticketTypes as $type => $data) {
            if (count($data) > $maxCount) {
                $maxCount     = count($data);
                $maxCountType = $type;
            }
        }
        
        $graphLabels  = array_keys(Arr::get($ticketTypes,$maxCountType,[]));
        
        foreach ($ticketTypes as &$typeData) {
            
            $typeData = array_merge(array_fill_keys($graphLabels, 0), $typeData);
        }
        
        unset($typeData);
    

        $ticketTypes["label"] = $graphLabels;

        return $ticketTypes;
        

     

     }




   /**
     * Display the admin profile.
     *
     */
    public function profile() :\Illuminate\Contracts\View\View
    {
        $title = "Admin Profile";
        $admin = auth_user();
        return view('admin.profile', compact('title', 'admin'));
    }

    /**
     * update admin profile.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function profileUpdate(Request $request) :\Illuminate\Http\RedirectResponse
    {
        $admin = auth_user();
        $request->validate([
            'name'       => 'required|max:255',
            'username'   => 'required|max:255|unique:admins,username,'. $admin ->id,
            'email'      => 'required|max:255|unique:admins,email,'. $admin->id,
            'image'      => ["image",new FileExtentionCheckRule(json_decode(site_settings('mime_types'),true))],
            'address'    =>  Rule::requiredIf(site_settings("auto_ticket_assignment") == '1' && site_settings('geo_location') == 'map_base'),

        ],[
            'name.required'      => translate('Name Feild Is Required'),
            'username.required'  => translate('User Name Feild Is Required'),
            'username.unique'    => translate('User Name Must Be Unique'),
            'email.required'     => translate('Email Feild Is Required'),
        ]);

        $address_data         = (new AgentController())->get_address($request);
        $admin->name          = $request->name;
        $admin->username      = $request->username;
        $admin->phone         = $request->phone;
        $admin->email         = $request->email;
        $admin->address       =  json_encode($address_data);
        $admin->longitude	  =  isset($address_data['lon']) ?  $address_data['lon'] : null;
        $admin->latitude	  =  isset($address_data['lat']) ?  $address_data['lat'] : null;
        if($request->hasFile('image')){
            try{
                $removefile   = $admin->image ?: null;
                $admin->image = storeImage($request->file('image'), getFilePaths()['profile']['admin']['path'], null, $removefile);
            }catch (\Exception $exp){

                return back()->with('error',translate('File Upload Error: Insufficient Permissions Detected. Please Review Directory Access Permissions and Attempt the Upload Again'));
            }
        }

        $admin->save();
        return back()->with('success',translate('Your profile has been updated.'));
    }



    /**
     * Display the admin profile.
     *
     */
    public function password() :\Illuminate\Contracts\View\View
    {
        $title = "Update Password";
        $admin = auth_user();
        return view('admin.password', compact('title', 'admin'));
    }


    /**
     * update admin password.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function passwordUpdate(Request $request) :\Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|confirmed|min:5',
        ],
        [
            'current_password.required'   => translate('Your Current Password is Required'),
            'password'                    => translate('Password Feild Is Required'),
            'password.confirmed'          => translate('Confirm Password Does not Match'),
            'password.min'                => translate('Minimum 5 digit or character is required'),
        ]);
        $admin = auth_user();
        if (!Hash::check($request->current_password, $admin->password)) {
            return back()->with('error', translate("Your Current Password does not match !!"));
        }
        $admin->password = Hash::make($request->password);
        $admin->save();
        return back()->with('success', translate("Password changed successfully"));
    }


    /**
     * get admin notifications settings
     *
     * @return View
     */
    public function notificationSettings() :View {

        $admin_type = "Admin";
        if(auth_user()->agent == (StatusEnum::true)->status()){
            $admin_type       = "agent";
        }
        $title =  $admin_type." Notifications Settings";
        return view('admin.setting.notification_settings', compact('title'));
    }

    /**
     * Update notifiation settings
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateNotificationSettings(Request $request) :\Illuminate\Http\RedirectResponse {

        $admin_notifications     = admin_notification();
        if(auth_user()->agent    == (StatusEnum::true)->status()){
            $admin_notifications = agent_notification();
        }
        if($request->admin_notifications){
            $request_data = $request->admin_notifications;
            foreach($admin_notifications  as $key=>$setting){
                if(isset($request_data[$key])){
                    foreach($setting as  $sub_key=>$val){
                        if(isset($request_data[$key][$sub_key])){
                            $setting[$sub_key] =  $request_data[$key][$sub_key];
                        }
                    }
                    $admin_notifications[$key] = $setting;
                }
            }
        }
        auth_user()->notification_settings =  json_encode( $admin_notifications);
        auth_user()->save();   
        return back()->with('success',translate('Notifications Settings Updated'));

    }

    /**
     * read a notifications
     */

    public function readNotification(Request $request) :string{

        $admin_notification = CustomNotifications::where("id", $request->id)
                                    ->where("notify_id", auth_user()->id)
                                    ->first();
        $status = false;
        
        $message = translate('Notification Not Found');

        if( $admin_notification ){

            $admin_notification->is_read =  (StatusEnum::true)->status();
            $admin_notification->save();
            $status  = true;
            $message = translate('Notification Readed');
        }

        return json_encode([
            "status"  => $status,
            "message" => $message
        ]);

    }

    /**
     * view all notifications
     */

     public function notification(Request $request) :View{

        $title   = "All Notifications";
        $layout  = "admin.layouts.master";
        CustomNotifications::where("notify_id",auth_user()->id)
        ->where('is_read' ,(StatusEnum::false)->status())
        ->where(function ($query) {
            if (auth_user()->agent == StatusEnum::true->status()) {
                $query->where('notification_for', NotifyStatus::AGENT);
            } else {
                $query->where('notification_for', NotifyStatus::SUPER_ADMIN);
            }
        })
        ->update([
            "is_read" =>  (StatusEnum::true)->status()
        ]);
        
        $notifications =  CustomNotifications::where("notify_id",auth_user()->id)
        ->where('is_read' ,(StatusEnum::true)->status())
        ->where(function ($query) {
            if (auth_user()->agent == StatusEnum::true->status()) {
                $query->where('notification_for', NotifyStatus::AGENT);
            } else {
                $query->where('notification_for', NotifyStatus::SUPER_ADMIN);
            }
        })->latest()->paginate(paginateNumber());

        return view('notification',compact('title','notifications','layout'));
     }

     /**
      * delete a specific notification
      */
     public function deleteNotification(int | string $id) :\Illuminate\Http\RedirectResponse {

        $notification =  CustomNotifications::where('id',$id)
        ->where("notify_id",auth_user()->id)
        ->where(function ($query) {
            if (auth_user()->agent == StatusEnum::true->status()) {
                $query->where('notification_for', NotifyStatus::AGENT);
            } else {
                $query->where('notification_for', NotifyStatus::SUPER_ADMIN);
            }
        })
        ->first();
        $status      = 'error';
        $message     = translate('Notification Not Found');
        if($notification){
            $status  = 'success';
            $message = translate('Notification Deleted');
            $notification->delete();
        }
        return back()->with($status,$message);
     }


    /**
     * Clear all notifications
     *
     * @return  RedirectResponse
     */
    public function clearNotitfication() :RedirectResponse { 


        CustomNotifications::where("notify_id",auth_user()->id)
        ->where(function ($query) {
            if (auth_user()->agent == StatusEnum::true->status()) {
                $query->where('notification_for', NotifyStatus::AGENT);
            } else {
                $query->where('notification_for', NotifyStatus::SUPER_ADMIN);
            }
        })->lazyById(200, $column = 'id')
        ->each->delete();

        return back()->with('success',translate('All notification cleared'));
  
    }




}
