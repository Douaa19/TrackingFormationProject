<?php

namespace App\Http\Controllers\User;

use App\Enums\NotifyStatus;
use App\Enums\StatusEnum;
use App\Enums\TicketStatus as EnumsTicketStatus;
use App\Http\Controllers\Admin\AgentController;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CustomNotifications;
use App\Models\Department;
use App\Models\SupportTicket;
use App\Models\TicketStatus;
use App\Rules\General\FileExtentionCheckRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{

    /**
     * use dashboard
     */
    public function dashboard(Request $request) :View
    {

        $title = "User dashboard";
        $data  = $this->getDashboardData($request);
        return view('user.dashboard', compact('title','data'));
    }

    public function envatoPurchaseList(): View
    {
        $title = "Envato Purchases";
        $user = auth()->user();

        $groupedPurchases =   collect($user->envato_purchases)
                                    ->groupBy('envato_item_id')
                                    ->map(function ($group) {
                                        $latestPurchase = $group->sortByDesc('sold_at')->first();
                                        $latestPurchase->quantity = $group->count();
                                        return $latestPurchase;
                                    })
                                    ->values();

        $productPurchases = Department::latest()->lazyById(chunkSize: 100,column: 'id')
                                        ->whereIn(key: 'envato_item_id',
                                                values: $groupedPurchases->pluck('envato_item_id')  ->toArray())
                                        ->map(callback: function(Department $department) use( $groupedPurchases): Department{
                                            $latestPurchase = ($groupedPurchases->where('envato_item_id',$department->envato_item_id)->first());
                                            if($latestPurchase) $department->latest_purchase  = $latestPurchase;
                                            return $department;
                                        })->all();


        return view('user.envato.purchase.list', compact('title', 'user', 'groupedPurchases','productPurchases'));
    }

    public function envatoPurchaseDetails($envatoItemId): View
    {
        $title = "Product Purchases";
        $user = auth()->user();
        $department = Department::where('envato_item_id',$envatoItemId)->firstOrfail();

        $purchases = collect($user->envato_purchases)
                           ->where('envato_item_id', $envatoItemId)
                           ->values();



        return view('user.envato.purchase.details', compact('title', 'user', 'purchases','department'));
    }

    private function groupPurchases($purchases)
    {
        return collect($purchases)
                    ->groupBy('envato_item_id')
                    ->map(function ($group) {
                        $latestPurchase = $group->sortByDesc('sold_at')->first();
                        $latestPurchase->quantity = $group->count();
                        return $latestPurchase;
                    })
                    ->values();
    }


    /**
     * get dashboard data
     */

     public function getDashboardData($request =  null) :array{
        $data['ticket_status_counter'] =  TicketStatus::withCount(['tickets'=> function($q) use($request){
                return $q->where('user_id',auth_user('web')->id);
            }])->whereIn('id',[EnumsTicketStatus::PENDING->value,EnumsTicketStatus::PROCESSING->value ,EnumsTicketStatus::CLOSED->value,EnumsTicketStatus::SOLVED->value])
            ->lazyById(100,'id')
            ->map(function(TicketStatus $status){
            $counter_key = match ($status->id) {
                        EnumsTicketStatus::SOLVED->value => 'total_solved_tickets',
                        EnumsTicketStatus::CLOSED->value => 'total_closed_tickets',
                        EnumsTicketStatus::PROCESSING->value => 'total_processign_tickets',
                        default => 'total_pending_tickets',
            };
            $icon = match ($status->id) {
                        EnumsTicketStatus::SOLVED->value => '<i class="ri-chat-check-line display-6 link-success"></i>',
                        EnumsTicketStatus::CLOSED->value => '<i class="ri-chat-delete-line display-6 link-danger"></i>',
                        EnumsTicketStatus::PROCESSING->value => '<i class="ri-message-3-line display-6 link-primary"></i>',
                        default => '<i class="ri-message-2-line display-6 link-warning"></i>',
            };
            return (object)[
                'id'            => $status->id,
                'name'          => $status->name,
                'counter_key'   => $counter_key,
                'icon'          => $icon,
                'total_ticket'  => $status->tickets_count,
            ];
            })->all();

        $data['ticket_by_category']       = Category::withCount(['tickets as tickets_count' => function($q){
            return $q->where('user_id',auth_user('web')->id);
        }])
        ->orderBy('tickets_count','desc')
        ->having("tickets_count" ,">", 0)
        ->pluck("tickets_count",'name',)
        ->mapWithKeys(function ($count, $name) {

            return [limit_words(get_translation($name),15) => $count];
        })
        ->toArray();

        $data['ticket_by_year']           = sortByMonth( SupportTicket::where('user_id',auth_user('web')->id)->selectRaw("MONTHNAME(created_at) as months, count(*) as total")
        ->whereYear('created_at', '=',date("Y"))
        ->groupBy('months')
        ->pluck('total', 'months')
        ->toArray());

        $data['latest_ticket']            =  SupportTicket::with(['user'])->where('user_id',auth_user('web')->id)->filter($request)->latest()->take(5)->get();

        $data['user'] = auth_user('web');

        $data['traningsAndTypes'] = [
            'planned_training' => []
        ];

        return $data;

    }


    public function profile() :View
    {
        $title   = "User Profile";
        $user    = auth()->user();
        return view('user.profile', compact('title', 'user'));
    }


   /**
     * update user profile.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function profileUpdate(Request $request) :\Illuminate\Http\RedirectResponse
    {
        $user = auth_user('web');
        $request->validate([
            'name'    => 'required|max:255',
            'email'   => 'required|max:255|unique:users,email,'. $user->id,
            'image'   => ["image",new FileExtentionCheckRule(json_decode(site_settings('mime_types'),true))],
            'address' =>  Rule::requiredIf(site_settings("auto_ticket_assignment") == '1' && site_settings('geo_location') == 'map_base'),

        ],[
            'name.required'   => translate('Name Feild Is Required'),
            'email.required'  => translate('Email Feild Is Required'),
            'email.unique'    => translate('Email Must Be Unique'),
        ]);

        $address_data    = (new AgentController())->get_address($request);
        $user->name      = $request->name;
        $user->phone     = $request->phone;
        $user->email     = $request->email;
        $user->address   =  json_encode($address_data);
        $user->longitude =  isset($address_data['lon']) ?  $address_data['lon'] : null;
        $user->latitude	 =  isset($address_data['lat']) ?  $address_data['lat'] : null;
        if($request->hasFile('image')){
            try{
                $removefile  = $user->image ?: null;
                $user->image = storeImage($request->file('image'), getFilePaths()['profile']['user']['path'], null, $removefile);
            }catch (\Exception $exp){
                return back()->with('error',translate('File Upload Error: Insufficient Permissions Detected. Please Review Directory Access Permissions and Attempt the Upload Again'));

            }
        }

        $user->save();
        return back()->with('success',translate('Your profile has been updated.'));
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
            'current_password'          => 'required',
            'password'                  => 'required|confirmed|min:5',
        ],
        [
            'current_password.required' => translate('Your Current Password is Required'),
            'password'                  => translate('Password Feild Is Required'),
            'password.confirmed'        => translate('Confirm Password Does not Match'),
            'password.min'              => translate('Minimum 5 digit or character is required'),
        ]);
        $user = auth_user('web');
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', translate("Your Current Password does not match !!"));
        }
        $user->password = Hash::make($request->password);
        $user->save();
        return back()->with('success', translate("Password changed successfully"));
    }



    /**
     * get user notifications settings
     *
     * @return View
     */
    public function notificationSettings() :View {
        $title = "User Notifications Settings";
        return view('user.notification_settings', compact('title'));
    }

    /**
     * Update notifiation settings
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateNotificationSettings(Request $request) :\Illuminate\Http\RedirectResponse {

        $user_notifications = user_notification();
        if($request->user_notificatoon){
            $request_data = $request->user_notificatoon;
            foreach($user_notifications  as $key=>$setting){
                if(isset($request_data[$key])){
                    foreach($setting as  $sub_key=>$val){
                        if(isset($request_data[$key][$sub_key])){
                            $setting[$sub_key] =  $request_data[$key][$sub_key];
                        }
                    }
                    $user_notifications[$key] = $setting;
                }
            }
        }
        auth_user('web')->notification_settings =  json_encode( $user_notifications);
        auth_user('web')->save();
        return back()->with('success',translate('Notifications Settings Updated'));
    }

    /**
     * read a notifications
     */

    public function readNotification(Request $request) :string{

        $user_notification = CustomNotifications::where("id",$request->id)
        ->where("notify_id",auth_user('web')->id)
        ->where('notification_for',NotifyStatus::USER)->first();
        $status  = false;
        $message = translate('Notification Not Found');
        if( $user_notification ){
            $user_notification->is_read =  (StatusEnum::true)->status();
            $user_notification->save();
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

        $title  = "All Notifications";
        $layout = "user.layouts.master";
        CustomNotifications::where("notify_id",auth_user('web')->id)
        ->where('is_read' ,(StatusEnum::false)->status())
        ->where('notification_for',NotifyStatus::USER)->update([
            "is_read" =>  (StatusEnum::true)->status()
        ]);

        $notifications =  CustomNotifications::where("notify_id",auth_user('web')->id)
        ->where('is_read' ,(StatusEnum::true)->status())
        ->where('notification_for',NotifyStatus::USER)->latest()->paginate(paginateNumber());

        return view('notification',compact('title','notifications','layout'));
     }

     /**
      * delete a specific notification
      */
     public function deleteNotification(int | string $id) :\Illuminate\Http\RedirectResponse {

        $notification =  CustomNotifications::where('id',$id)
        ->where("notify_id",auth_user('web')->id)
        ->where('notification_for',NotifyStatus::USER)
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







}
