<?php

namespace App\Http\Controllers;

use App\Enums\StatusEnum;
use App\Enums\TicketStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\TicketStoreRequest;
use App\Http\Services\TicketService;
use App\Jobs\SendEmailJob;
use App\Models\Category;
use App\Models\Department;
use App\Models\Priority;
use App\Models\SupportTicket;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

class GuestTicketController extends Controller
{

    public $ticketService;
    public function __construct(TicketService $ticketService)
    {
      $this->ticketService = $ticketService;
    }

    /**
     * create a new ticket
     *
     * @return View
     */
    public function create($purchase_code = null, $item_id = null) :View |RedirectResponse{

       if(site_settings(key:'guest_ticket',default:1) || auth_user('web')) {
          $title         = "Create Ticket";
          $categories    = Category::where('status',(StatusEnum::true)->
          status())
                          ->active()
                          ->where("ticket_display_flag",StatusEnum::true->status())
                          ->get();

          $user          = auth_user('web');

          $groupedPurchases = null;
          if($user){

            $groupedPurchases =   collect($user->envato_purchases)
                                  ->groupBy('envato_item_id')
                                  ->map(function ($group) {
                                      $latestPurchase = $group->sortByDesc('sold_at')->first();
                                      $latestPurchase->quantity = $group->count();
                                      return $latestPurchase;
                                  })
                                  ->values();

          }


          $departments   = Department::active()
                               ->lazyById(chunkSize: 100,column: 'id')
                               ->when(value  : (@$user &&  @$groupedPurchases) || @$item_id, 
                                     callback : function (\Illuminate\Support\LazyCollection $query) use( $item_id ,$groupedPurchases,$purchase_code ,$user): \Illuminate\Support\LazyCollection {
                                return $query->map(callback: function (Department $department) use($groupedPurchases ,$item_id ,$purchase_code ,$user): Department {

                                  $purchases =  $item_id && $purchase_code 
                                                  ? collect(value: $user->envato_purchases) 
                                                  : @$groupedPurchases;

                                  $latestPurchase = $purchases->when(
                                                                  value    : $item_id == $department->envato_item_id && $purchase_code , 
                                                                  callback : fn(object $purchase): object => $purchase->where('purchase_code',$purchase_code),
                                                                  default  : fn(object $purchase): object => $purchase->where('envato_item_id', $department->envato_item_id)
                                                              )->first();
                                  if($latestPurchase) $department->latest_purchase  = $latestPurchase; 
                                  return $department;
              
                                });
                              })
                               ->all();

             
                    


          $priorites     = Priority::active()->get();
          



          
          $ticket_fields = json_decode(site_settings('ticket_settings'),true);
          $purchaseCode = $purchase_code;
          $selectedItemId = $item_id;
          return view('ticket',compact('ticket_fields','categories','title','priorites','departments', 'purchaseCode', 'selectedItemId',));
       }

       return redirect()->route('login')->with('error',translate("Login required to create a ticket. Get started on resolving your issue with just a quick login! 🚀"));
    }


    /**
     * Create A new Ticket
     *
     * @param TicketStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
     public function store(TicketStoreRequest $request) :\Illuminate\Http\RedirectResponse {




        if(isset($request->ticket_data["attachments"][0])){
             $message  =   ticket_file_validation($request->ticket_data["attachments"][0]);
             if($message)  return  back()->with('error',$message); 
        }

      
        $user = auth_user('web');

        if($user) {

            $ticketData = $request->input('ticket_data', []);
            $ticketData['name']   = $user->name;
            $ticketData['email']  = $user->email;
            $request->merge([
                "ticket_data" => $ticketData,
            ]);
        }

        if(site_settings('duplicate_ticket_prevent') == StatusEnum::true->status()){
            $ticket = $this->_getDuplicateTicket($request->except('_token')['ticket_data']);
            if($ticket){
              return redirect()->route('ticket.reply',$ticket->ticket_number)->with('error',translate('Previous ticket exists; avoid duplicates. Await resolution for the existing open ticket in this category'));
            }
        }

        $ticket = $this->ticketService->storeTicket($request->except('_token')['ticket_data']);


        if ($ticket instanceof \Illuminate\Http\RedirectResponse) return  $ticket;
        
        

        return redirect()->back()->with('ticket_created',
           '<h5 class="mb-2">'. translate('Ticket Successfully Created '). '</h5>'.
          "</b><p class='text-black'>" .translate('Notification: Please Review Your Email') ."</p>".
          "<p class='text-black'>".
             translate("Ticket Issued: Your TicketId Is ") ."<b class='text-primary'>".$ticket->ticket_number ."</b>
          </p>".
          '
          <div class="mt-3">

          <a class="Btn secondary-btn btn--sm w-50 btn-icon-hover d-flex align-items-center justify-content-center" href="' . route('ticket.reply', $ticket->ticket_number).'"><span>' . translate('Your Ticket') . '</span><i class="bi bi-arrow-right-short fs-20"></i>  </a>
           </div>' );

     }



     /**
      * Get Duplicate Ticket
      *
      * @param array $request
      * @return mixed
      */
     private function _getDuplicateTicket(array $request) :mixed {

          $email           =  $request['email'] ;
          $userId          =  auth_user('web')? auth_user('web')->id : null ;
          $categoryId      =  $request['category'] ;
          $departmentId            = Arr::get($request , 'department_id',null);


          $duplicateStatus = site_settings(key:'ticket_duplicate_status',default:null);
          $statusArr = [];
          if($duplicateStatus){
            $statusArr = json_decode($duplicateStatus,true);
          }

          $ticket = SupportTicket::withoutGlobalScope('autoload')
                    ->when($userId, function($query) use ($userId ,$email ) {
                      $query->where('user_id', $userId);
                    }, function ($q) use ($email) {
                      $q->where('email',$email);
                    }) 
                    ->when($departmentId  ,function(Builder $query) use($departmentId){
                      return  $query->where('department_id', $departmentId);
                    })
                    ->where("category_id",$categoryId)
                    ->whereIn('status', $statusArr)->first();
                  

          return $ticket ?? null;
        


     }


     /**
      * Reply to specific ticket
      *
      * @param string $ticketId
      * @return View | RedirectResponse
      */
      public function reply(string $ticketId) :View | RedirectResponse {


        $title     = 'Reply Ticket';
        $ticket    = SupportTicket::withoutGlobalScope('autoload')
                                      ->with(['messages'])
                                      ->where('ticket_number',$ticketId)
                                      ->firstOrFail();


        if( $ticket->user_id ) return redirect()->route('user.ticket.view', $ticket->ticket_number);
        
        if(site_settings(key:'ticket_search_otp',default:0) == (int)StatusEnum::true->status()) {
           $ticketVerification =  session()->get('ticket_verification');
           if(!$ticketVerification ||  $ticketVerification != $ticket->ticket_number ) return  $this->sendOTP($ticket);
        }

      
        $messages = $ticket->messages()
                      ->whereNotNull('admin_id')
                      ->where('seen', StatusEnum::false->status())
                      ->lazyById(200, $column = 'id')
                      ->each->update(['seen' => StatusEnum::true->status()]);

        return view('reply',compact('ticket','title'));

      }


      /**
       * Ticket Search
       *
       * @param Request $request
       * @return mixed
       */
      public function search(Request $request) :mixed {

        $view    = "search_ticket";
        $title   = 'Search Ticket';

        if($request && $request->isMethod('post')){

            $request->validate([
              'ticket_number'          => "required",
              'email'                  => "required",
            ],[
              "ticket_number.required" =>translate('Please Enter Your Ticket Number'),
              "email.required"         =>translate('Please Enter Your Email'),
            ]);

            $title  = 'Reply Ticket';
            $ticket = SupportTicket::withoutGlobalScope('autoload')->with(['messages'])
                            ->where('ticket_number',$request->ticket_number)
                            ->where('email',$request->email)
                            ->first();

            
          return match (true) {
              !$ticket                                                                            => back()->with('error', translate('Ticket Not Found')),
              $ticket->user_id                                                                    => redirect()->route('user.ticket.view', $ticket->ticket_number),
              site_settings(key:'ticket_search_otp',default:0) == (int)StatusEnum::true->status() => $this->sendOTP($ticket),
              default                                                                             => \redirect()->route("ticket.reply",$ticket->ticket_number)
          };
        }

        return view("search_ticket" ,compact('title'));
      }
      

      public function sendOTP(SupportTicket $ticket) :RedirectResponse{

        $ticket->otp = generateOTP();
        $ticket->saveQuietly();

        SendEmailJob::dispatch($ticket, "TICKET_ACCESS_CODE",[
         'code' => $ticket->otp ]);

        session()->put('ticket_number',$ticket->ticket_number);
        return \redirect()->route("ticket.otp.verification")->with('success',translate('An OTP has been sent to your email for ticket verification. Please verify your identity to proceed.'));

      }


      /**
       * Get Ticket Reply view
       *
       * @param SupportTicket $ticket
       * @return RedirectResponse
       */
      public function getReplyView(SupportTicket $ticket) :RedirectResponse{

         return \redirect()->route("ticket.reply",$ticket->ticket_number);
      }

      public function otpVerification(Request $request) :mixed {

        if(site_settings(key:'ticket_search_otp',default:0) == (int)StatusEnum::false->status()) abort(404);
         $title   = translate('Ticket Verification ');
          if($request && $request->isMethod('post')){

            $request->validate([
                  'otp' => 'required|exists:support_tickets'
            ],[
              'otp.required' => translate('OTP Field is Required'),
              'otp.exists' => translate('Invalid OTP')
            ]);


            $ticket = SupportTicket::withoutGlobalScope('autoload')->with(['messages'])
                                      ->where('ticket_number',session()->get('ticket_number'))
                                      ->where('otp',$request->input('otp'))
                                      ->first();

            if($ticket){
                  session()->forget('ticket_number');
                  session()->put('ticket_verification', $ticket->ticket_number);
                  return \redirect()->route("ticket.reply",$ticket->ticket_number);
            }

            return back()->with('error', translate('Ticket Not Found')) ;
          }
        return view("ticket_verification" ,compact('title'));
      }

      

    
    public function solveRequest(string | int $ticketId , bool  $status) : RedirectResponse {


      $ticket                 = SupportTicket::withoutGlobalScope('autoload')
                                  ->where('id', $ticketId)
                                  ->firstOrfail();
 

      $solved_request         =  $status 
                                  ? SupportTicket::ACCEPTED
                                  : SupportTicket::REJECTED;
      $ticket->solved_request  = $solved_request ;


      match ($status) {
        true     => $ticket->solved_at = Carbon::now(),
        default  => $ticket->status    = TicketStatus::PROCESSING->value, // checked
      };
     
   
      $ticket->saveQuietly();

      return back()->with("success",translate("Thanks!! For Your Response"));

    }




    /**
     * Get a specific ticket messages
     *
     * @param Request $request
     * @return array
     */
    public function messages(Request $request) :array{

        $request->validate([
            'page' => ['required','numeric'],
            'id'   => ['required','exists:support_tickets,id']
        ]);

        $ticket = SupportTicket::withoutGlobalScope('autoload')->where("id",$request->input("id"))
                                  ->first();
        if(!$ticket) return ['status' => false , 'message' => translate('Ticket not found')];

        $messages =  ($this->ticketService->getTicketMesssages($request ,$ticket , true));

        return ([
            'ticket'                   => $ticket,
            'status'                   => true, 
            'next_page'                => $messages->hasMorePages(),
            "messages_html"            => view('ticket_message', compact('messages','ticket'))->render(),
        ]);


   }


    /**
     * Close a specific ticket
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function ticketClose(int $id) :RedirectResponse{



       if(site_settings(key:'user_ticket_close',default:0) == 0) abort(403);

        $ticket = SupportTicket::withoutGlobalScope('autoload')->where("id",$id)
                                  ->firstOrFail();

        
        if($ticket->user_id && !auth_user('web')) return back()->with("error",translate("You need to login first"));


        $ticket->status = TicketStatus::CLOSED->value;

        $ticket->save();

        return back()->with("error",translate("Ticket is closed"));

   }



    /**
     * Close a specific ticket
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function ticketOpen(int $id) :RedirectResponse{



      if(site_settings(key:'user_ticket_open',default:0) == 0) abort(403);

       $ticket = SupportTicket::withoutGlobalScope('autoload')->where("id",$id)
                                 ->firstOrFail();

       
       if($ticket->user_id && !auth_user('web'))  return back()->with("error",translate("You need to login first"));


       $ticket->status = TicketStatus::OPEN->value;

       $ticket->save();

       return back()->with("success",translate("Ticket Re-opend"));

  }



}
