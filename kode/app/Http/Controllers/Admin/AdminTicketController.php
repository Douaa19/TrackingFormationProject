<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusEnum;
use App\Enums\TicketReply;
use App\Enums\TicketStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\TicketStoreRequest;
use App\Http\Services\TicketService;
use App\Jobs\SendEmailJob;
use App\Models\Admin;
use App\Models\AgentResponse;
use App\Models\AgentTicket;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Department;
use App\Models\FloatingChat;
use App\Models\Priority;
use App\Models\Subscriber;
use App\Models\SupportMessage;
use App\Models\SupportTicket;
use App\Models\TicketStatus as ModelsTicketStatus;
use App\Models\User;
use App\Rules\General\FileExtentionCheckRule;
use App\Rules\SanitizeHtml;
use App\Traits\EnvatoManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AdminTicketController extends Controller
{
    

    use EnvatoManager;

    public function __construct(private TicketService $ticketService) {


    }

 

    /**
     * Get ticket list view
     *
     * @param Request $request
     * @return view | string
     */
     public function index(Request $request): view | string {

        $title    = 'Ticket List';


         
        if($request->ajax()) return json_encode($this->ticketService->getTicketList($request));


        $ticketStatus = \App\Models\TicketStatus::active()->get();
        
        return view('admin.ticket.index',compact('title','ticketStatus'));
     }



     /**
      * Get a specific ticket message 
      *
      * @param Request $request
      * @return array
      */
     public function messages(Request $request) : array {


        $request->validate([
            'page' => ['required','numeric'],
            'id'   => ['required','exists:support_tickets,id']
        ]);

        $ticket = SupportTicket::withoutGlobalScope('autoload')
                                ->where("id",$request->input("id"))
                                ->firstOrfail();
        
        if(!$ticket) return ['status' => false , 'message' => translate('Ticket not found')];

        $this->ticketService->makeTicketMessageSeen($ticket);

        $messages =  ($this->ticketService->getTicketMesssages($request ,$ticket));


        return ([
            'ticket'                   => $ticket,
            'status'                   => true, 
            'next_page'                => $messages->hasMorePages(),
            "messages_html"            => view('admin.ticket.ticket_message', compact('messages','ticket'))->render(),
        ]);

     }
      

     /**
      * Edit a specific ticket
      * @param int | string $id 
      * @return View
      */
     
     public function edit(int | string $id): View {

        $title      = 'Edit Ticket';
        $ticket     = SupportTicket::with(['category', 'linkedPriority'])
                                ->where('id', $id)
                                ->firstOrfail();

        $categories = Category::where('status', (StatusEnum::true)->status())
                                ->active()
                                ->where("ticket_display_flag", StatusEnum::true->status())
                                ->get();


        $priorities      = Priority::active()->get();
        $departments     = Department::active()->get();
        $ticketStatuses  = ModelsTicketStatus::active()->get();

        return view('admin.ticket.edit', compact('title', 'ticket', 'priorities', 'departments', 'ticketStatuses', 'categories'));
    }

    /**
     * update a specific  ticket
     *
     * @param Request $request, int | string $id
     *
     * @return RedirectResponse
     */

    public function update(Request $request, int | string $id): RedirectResponse
    {

        $request->validate([
            'department_id' => 'required|int|exists:departments,id',
            'category_id'   => 'required|int|exists:categories,id',
            'priority_id'   => 'required|int|exists:priorities,id',
            'status'        => 'required|int|exists:ticket_statuses,id',
            'subject'       => 'required|string|max:255',

        ]);


         $ticket  =  SupportTicket::withOutGlobalScope('autoload')
                                ->findOrfail($id);


        $ticket->department_id =  $request->input('department_id');
        $ticket->category_id   =  $request->input('category_id');
        $ticket->priority_id   =  $request->input('priority_id');
        $ticket->status        =  $request->input('status');
        $ticket->saveQuietly();
    

        return back()->with("success",translate("Ticket updated successfully"));
    }




    /**
     * Summary of syncPurchase
     * @param int|string $ticket_number
     * @return \Illuminate\Http\RedirectResponse
     */
    public function syncPurchase(int | string $ticket_number) : RedirectResponse {

        $ticket  =  SupportTicket::with(['department'])->withOutGlobalScope('autoload')
                                        ->where('ticket_number',$ticket_number)
                                        ->firstOrfail();
        $envato_personal_token = json_decode(site_settings('social_login'), true)['envato_oauth']['personal_token'] ?? null;
        $purchaseKey =  $ticket->envato_payload->purchase_key;
        if(!$ticket->department) return back()->with('error', translate('Invalid envato product'));
        $accessToken = @$envato_personal_token;
        if(!$accessToken) return back()->with('error', translate('Invalid envato product, no personal access token found'));
        $envato_payload = $this->verifyPurchase($purchaseKey ,$accessToken);
        $status         = Arr::get($envato_payload, 'status' ,false);
        $errorMessage   = Arr::get($envato_payload, 'message' ,false);
        if(!$status)  return back()->with("error", $errorMessage);

         #VERIFY SUPPORT
         if(site_settings(key:'envato_support_verification',default:0) == 1) {
            $supported_until = Arr::get($envato_payload,'supported_until');
            
            if($supported_until){
                $supported_until   = Carbon::parse($supported_until);
                $isSupportExpired  = 0;
                if (!$supported_until->isFuture())  $isSupportExpired = 1;

            }

        }


        $ticket->envato_payload  =  @$envato_payload;
        $ticket->is_support_expired  =  @$isSupportExpired;
        $ticket->saveQuietly();

        return back()->with("success", translate('Purchase sync successfully'));

        
    }



   
    /**
     * Summary of verifyEnvatoPurchase
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verifyEnvatoPurchase(Request $request) : RedirectResponse {


        $request->validate([
            'purchase_key' => 'required',
            'id' => 'required',
        ]);

        $ticket  =  SupportTicket::with(['department'])->withOutGlobalScope('autoload')
                                        ->where('id',$request->input('id'))
                                        ->firstOrfail();


        $purchaseKey =  $request->input('purchase_key');

        if(!$ticket->department) return back()->with('error', translate('Invalid envato product'));
        $envato_personal_token = json_decode(site_settings('social_login'), true)['envato_oauth']['personal_token'] ?? null;
        $accessToken = @$envato_personal_token;

        if(!$accessToken) return back()->with('error', translate('Invalid envato product, no personal access token found'));
        

        $envato_payload    = $this->verifyPurchase($purchaseKey ,$accessToken);

        $status            = Arr::get($envato_payload, 'status' ,false);
        $errorMessage      = Arr::get($envato_payload, 'message' ,false);

        if(!$status)  return back()->with("error", $errorMessage);

         #VERIFY SUPPORT
         if(site_settings(key:'envato_support_verification',default:0) == 1){

            $supported_until = Arr::get($envato_payload,'supported_until');
            
            if($supported_until){
                $supported_until   = Carbon::parse($supported_until);
                $isSupportExpired  = 0;
                if (!$supported_until->isFuture())  $isSupportExpired = 1;

            }

        }


        $ticket->envato_payload  =  @$envato_payload;
        $ticket->is_support_expired  =  @$isSupportExpired;
        $ticket->saveQuietly();

        return back()->with("success", translate('Purchase verified successfully'));

        
    }

   


     /**
      * Ticket bulk action
      *
      * @param Request $request
      * @return RedirectResponse
      */
    public function mark(Request $request) : RedirectResponse {


        $bulkIds = $request->input('bulk_id') ? 
                        json_decode($request->input('bulk_id'), true)
                        :$request->input('ticket_id');

 
        $request->merge([
            "ticket_id" =>  $bulkIds
        ]); 

        $request->validate([
            'ticket_id'           => "required|array",
            'short_note'          => "nullable|max:100",
            'priority_id'         => "nullable|exists:priorities,id",
            'assign'              => "nullable|array",
            'assign.*'            => "nullable|exists:admins,id",
            'status'              => ["nullable",Rule::in(ModelsTicketStatus::pluck('id')->toArray())],
        ],[
            "ticket_id.required"  => translate('Ticket Id Feild Is Required'),
            "ticket_id.array"     => translate('Ticket Id Feild Must Be An Array'),
            "ticket_id.exists"    => translate('Invalid Tickets Selected'),
        ]);

        ## check for agent

        if(auth_user()->agent == StatusEnum::true->status()){
            if(!check_agent('assign_tickets')) abort(404);

            if($request->input('assign')){
                $assignIds = $request->input('assign');
                if(!in_array(auth_user()->id ,$assignIds)) return back()->with('error', translate('You cannot unassign yourself'));
            }
        }



        $message                  = $this->ticketService->bulckAction($request);
       
        if(auth_user()->agent == StatusEnum::true->status()){
            return redirect()->route("admin.ticket.list")->with('success', $message );
        }
        return back()->with('success', $message );
    }



 

    /**
     * Get ticket details view 
     *
     * @param string $id
     * @return View | RedirectResponse
     */
    public  function view(string $id) : View | RedirectResponse  {

        $title   = 'View Ticket';


        $ticket  = SupportTicket::withoutGlobalScope('autoload')
                               ->with(['agents','category' ,'messages','linkedPriority','admin','user','department','admin'])
                                ->agent()
                                ->where('ticket_number',$id)
                                ->first();
   
        if(!$ticket) return redirect()->route('admin.ticket.list')->with('error', trans('Ticket Not found')) ;

        $previousTickets = SupportTicket::withoutGlobalScope('autoload')->where('id','!=',$ticket->id)
                                ->when($ticket->user, function($query) use ($ticket) {    
                                    $query->where("user_id",$ticket->user_id);
                                }, function ($query) use ($ticket) {
                                    $query->where("email",$ticket->email);
                                })
                                ->agent()
                                ->latest()
                                ->take(5)
                                ->get();



        return view('admin.ticket.details',compact('title','ticket','previousTickets'));
    }



    

    /**
     * Get ticket modal view
     *
     * @param Request $request
     * @return array
     */
    public  function getModalView(Request $request) :array{

        $request->validate([
            'ticket_id'     => 'required|exists:support_tickets,ticket_number',
            'parent_ticket' => 'required|exists:support_tickets,ticket_number',
        ]);

        $ticket        = SupportTicket::with(['agents','category' ,'messages','linkedPriority','admin','user'])
                                        ->agent()
                                        ->where('ticket_number',$request->input('ticket_id'))
                                        ->first();

        $parentTicket  = SupportTicket::with(['agents','category' ,'messages','linkedPriority','admin','user'])
                                        ->agent()
                                        ->where('ticket_number',$request->input('parent_ticket'))
                                        ->first();

        if(empty($ticket) ||  empty($parentTicket)){
            return [
                'status'   => false,
                'message'  => 'No Ticket Found',
            ];
        }


        return ([
            'status'              => true,
            'ticketId'            => $ticket->id,
            "ticket_html"         => view('admin.ticket.modal_view', compact('ticket','parentTicket'))->render(),
        ]);




    }



    /**
     * Replied to a ticket
     *
     * @param Request $request
     * @return RedirectResponse | array
     */
    public  function reply(Request $request) :RedirectResponse | array{


        $request->validate([
            'message'            => ['required' , new SanitizeHtml()],
            'redirect_to'         =>  ["required",Rule::in(TicketReply::toArray())],
            'ticket_id'          => 'required | exists:support_tickets,id',
            'draft_message_id'   => 'nullable | exists:support_messages,id',
            'files'              => [ new FileExtentionCheckRule(json_decode(site_settings('mime_types'),true),'Ticket File')],
            'status'             =>  ["nullable",Rule::in(ModelsTicketStatus::pluck('id')->toArray())],
        ],[
            "message.required" => translate('Message Feild is Required'),
            "ticket_id.required" => translate('Ticket Id Feild Is Required'),
            "ticket_id.exists" => translate('Invalid Tickets Selected')
        ]);


        return $this->ticketService->replyByAdmin($request);

   

    }




   

    

   /**
    * update a ticket status
    */
    public function statusUpdate(Request $request) :RedirectResponse | array{

        $request->validate([
            'id'               => "required |exists:support_tickets,id",
            'status'           => "required",
            'key'              => "required",
        ],[
            'id.required'      => translate('Id Is Required'),
            'id.exists'        => translate('Select Id Is Invalid'),
            'status.required'  => translate('Status Is Required'),
            'key.required'     => translate('key Is Required'),
        ]);


        $response = $this->ticketService->updateStatus($request);

        return request()->ajax() 
                      ?  $response
                      :  back()->with( Arr::get($response ,'status') ? 'success' :"error", Arr::get($response ,'message'));

    
    }



  

    /**
     * Download a specific files form ticket message
     *
     * @param Request $request
     * @return BinaryFileResponse  | RedirectResponse
     */
    public function download(Request $request) : BinaryFileResponse  | RedirectResponse {

        $request->validate([
            'name'=>'required',
        ]);

        $url =  download_file(getFilePaths()['ticket']['path'],$request->input('name'));

        if(!$url){
            return back()->with('error',translate('File Not Found'));
        }

        return $url;

    }


   


    /**
     * Delete a file form ticket message 
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function deleteFile(Request $request) :RedirectResponse {
        
        $request->validate([
            'id'   => 'required|exists:support_messages,id',
            'name' => 'required',
        ]);

    
        $message      = translate("File Not Found");
        $status       = 'error';

        $message = SupportMessage::where('id',$request->input('id'))->firstOrfail();

        $files         = json_decode($message->file,true);
        
        $filteredFiles = array_filter($files, function ($item) use($request) {
            return $item !== $request->input('name');
        });
        
        $response = remove_file(getFilePaths()['ticket']['path'], $request->input('name'));

        if($response){
            $message->file =  json_encode($filteredFiles);
            $message->save();
            $message            = translate("Deleted Successfully");
            $status             = 'success';
        }

        return back()->with($status,$message);
    }



    
    public function export(string $extension) {

        $tickets   =  SupportTicket::agent()->latest();

        return $this->ticketService->exportData($extension,$tickets, $extension == 'pdf' ? 'export_pdf' :  null);
    }



 
    /**
     * Delete a specific ticket  
     * 
     * @param string | int $id
     * 
     * @return RedirectResponse
     */
    
    public function delete(int | string $id) :RedirectResponse{

        $this->ticketService->deleteTicket((array)$id);
        return redirect()->route('admin.ticket.list')->with('success',translate("Deleted Successfully"));
    }


    



    /**
     * Delete a specific ticket message 
     * 
     * @param string | int $id
     * 
     * @return RedirectResponse
     */
    public function deleteMessage(int | string $id) : RedirectResponse {

        $message = SupportMessage::where('id',$id)->firstOrfail();

        $response = $this->ticketService->messageDestory($message);

        return back()->with("success",translate('Message deleted'));
    }


    /**
     * Make a ticket mute and unmute
     * 
     * @param string | int $ticket_number
     */
     public function makeMute(int | string $ticket_number) :RedirectResponse |array{
        return ['status'  => $this->ticketService->muteTicket($ticket_number)];
     }



    /**
     * Ticket message update 
     * 
     * @param Request $request
     */
    public function updateMessage(Request $request) :RedirectResponse |array{


        $request->validate([
            'id'       => "required|exists:support_messages",
            'message'  => "required|string",
        ]);

        $messageBody =  build_dom_document( $request->input('message'));

   

        $supportMessage                     = SupportMessage::where("id",$request->input('id'))
                                                       ->firstOrfail();
        $originalMassge                     = $supportMessage->message;
        $supportMessage->message            = Arr::get($messageBody , 'html');
        $supportMessage->editor_files       = Arr::get($messageBody , 'files',[]);
        $supportMessage->original_message	= $originalMassge;
        $supportMessage->save();

        return  $request->ajax() 
                        ? ['status' => true , 'ticket_id' =>  $supportMessage->support_ticket_id ,"message" => translate("Message Updated")]
                        : back()->with('success', translate("Message Updated"));
        
       

    }



     /**
     * Ticket message update 
     * 
     * @param Request $request
     */
    public function saveDraft(Request $request) :array{

        $request->validate([
            'ticket_id'          => "required|exists:support_tickets,id",
            'draft'              => "required|string",
            'draft_id'           => 'nullable | exists:support_messages,id',

        ]);
        
        return ['status'=>  $this->ticketService->storeDraftMessage($request)];
        

    }



    /**
     * Ticket message update 
     * 
     * @param Request $request
     */
    public function updateNotification(Request $request) :JsonResponse {

        

        $status   = true;
        $message  = translate('Status Updated Successfully');

        try {
            $request->validate([
                'id'          => ["required","exists:support_tickets,id"],
                'key'         => ["required",Rule::in(['email','slack','browser','sms'])],
                'status'      => ['required',Rule::in(StatusEnum::toArray())],
            ]);

            $ticket   = $this->ticketService->updateTicketNotification($request);
    
        } catch (\Exception $ex) {

            $status   = false;
            $message  = strip_tags($ex->getMessage());
        }

     
        return response()->json([
            'status'  => $status,
            'message' => $message
        ]);


    }



    /**
     * Create view of ticket
     *
     * @return View
     */
    public function create() :View {


        $title         = "Create Ticket";
        $categories    = Category::active()
                                    ->where("ticket_display_flag",StatusEnum::true->status())
                                    ->get();
        $users         = User::all();

        $priorites     = Priority::active()->get();
        $subscribers   = Subscriber::get();
        $contacts      = Contact::get();
        $guestUsers    = FloatingChat::all();

        $departments    = Department::active()->get();

        $ticket_fields = json_decode(site_settings('ticket_settings'),true);

        return view('admin.ticket.create',compact('ticket_fields','categories','title','priorites','subscribers','contacts','guestUsers','users','departments'));
    }





    /**
     * Store bulk ticket
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request) :RedirectResponse {


        $rules = [
            'user_id'        => 'required_without_all:contact,subscriber,anonymous,custom_email|array',
            'contact'        => 'required_without_all:user_id,subscriber,anonymous,custom_email|array',
            'subscriber'     => 'required_without_all:user_id,contact,anonymous,custom_email|array',
            'anonymous'      => 'required_without_all:user_id,contact,subscriber,custom_email|array',
            'custom_email'   => 'required_without_all:user_id,contact,subscriber,anonymous|array',
            'custom_email.*' => 'email'
        ];


        $ticketRules =  (new TicketStoreRequest())->get_validation(request()->except(['_token']));

        $rules       =  array_merge($rules , Arr::get($ticketRules, 'rules' ,[]));


        $rules       =  array_diff_key($rules, array_flip( ['ticket_data.name','ticket_data.email']));

        $request->validate($rules,[
            'user_id.required_without_all' => "Please Select Some Email",
            'contact.required_without_all' => "Please Select Some Email",
            'subscriber.required_without_all' => "Please Select Some Email",
            'anonymous.required_without_all' => "Please Select Some Email",
            'custom_email.required_without_all' => "Please Select Some Email",
        ]);


        $this->ticketService->bulkTicketStore($request);

        return back()->with("success",translate('Ticket Created Successfuly'));




    }



    /**
     * Add ticket  note
     *
     * @param Request $request
     * @return RedirectResponse | array
     */
    public function addNote(Request $request) :RedirectResponse | array{

        $request->validate([
             'id'       => 'required|exists:support_tickets,id',
             'note'  => 'required'
        ]);

        $ticket = $this->ticketService->addNote($request);


        return  $request->ajax() 
                      ? ['status' => true , 'ticket_id' =>  $ticket->id ,"message" => translate("Note Added")]
                      : back()->with('success', translate("Note Added"));
    }






    /**
     * Merge two tickets
     *
     * @param Request $request
     * @return RedirectResponse | array
     */
    public function merge(Request $request) :RedirectResponse | array {


        $request->validate([
             'parent_ticket_id'       => 'required|exists:support_tickets,id',
             'ticket_id'              => 'required|exists:support_tickets,id'
        ]);


        $ticket = $this->ticketService->merge($request);

        return redirect()->route('admin.ticket.view', $ticket->ticket_number)->with('success',translate('Ticket Merged'));


    }
}
