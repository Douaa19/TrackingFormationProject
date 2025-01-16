<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Enums\StatusEnum;
use App\Enums\TicketStatus;
use App\Http\Services\TicketService;
use App\Models\Admin;
use App\Models\AgentParticipant;
use App\Models\Category;
use App\Models\SupportMessage;
use App\Models\SupportTicket;
use App\Models\TicketStatus as ModelsTicketStatus;
use App\Rules\General\FileExtentionCheckRule;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

use Illuminate\Support\Facades\DB;
class UserTicketController extends Controller
{
    

    public $ticketService;

    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;

    }

    /**
     * get ticket list
     */
     public function index(Request $request):Mixed{

        $title     = 'Ticket List';
        $tickets   = SupportTicket::with(['linkedPriority','category'])->where('user_id',auth_user('web')->id)
                                        ->withCount(['messages' => function($q){
                                            $q->whereNotNull('admin_id')
                                            ->where('seen',StatusEnum::false->status());
                                        }])->orderBy('user_last_reply','desc');

        $ticketStatus = \App\Models\TicketStatus::active()->get();

        if($request->ajax()){
           return ($this->processData($tickets,$request));
        }
        return view('user.ticket.index',compact('title','ticketStatus'));
     }


     public function messages(Request $request){


        $request->validate([
            'page' => ['required','numeric'],
            'id'   => ['required','exists:support_tickets,id']
        ]);

        $ticket = SupportTicket::withoutGlobalScope('autoload')
                                 ->where("id",$request->input("id"))
                                ->where('user_id',auth_user('web')->id)
                                ->first();
        if(!$ticket) return ['status' => false , 'message' => translate('Ticket not found')];

        $messages =  ($this->ticketService->getTicketMesssages($request ,$ticket , true));

        return ([
            'ticket'                   => $ticket,
            'status'                   => true, 
            'next_page'                => $messages->hasMorePages(),
            "messages_html"            => view('user.ticket.messages', compact('messages','ticket'))->render(),
        ]);


     }


   


    /** unlink ticket files */
    public function unlinkFile($files ,$location){
        foreach($files as $file){
            remove_file($location ,$file );
        }
    }


     /** proceess ticket data */
     public function processData($tickets,$request) :string{



        try {

            $ticketData       = $tickets;
            $status           = true;
    
            $categories       = Category::withCount(['tickets as tickets_count' => function($q){
                return $q->where('user_id',auth_user('web')->id);
            }])
                                    ->having("tickets_count" ,">", 0)
                                    ->where("ticket_display_flag",StatusEnum::true->status())
                                    ->latest()
                                    ->get();
                                
            $category_active  = $request->category_id ? $request->category_id : null;
            $tickets          = $tickets->filter($request)
                                        ->paginate(paginateNumber()) ;

    
                           
    
            return json_encode([

                "ticket_html"         => view('user.ticket.list', compact('tickets'))->render(),
                "categories_html"     => view('admin.ticket.categories', compact('categories','tickets','category_active'))->render(),
       
            ]);

        } catch (\Throwable $ex) {
           
        }

       
     }



     /**
      * view ticket details
      */
      public  function view(string $id) :View | RedirectResponse
      {

        $AdminId = AgentParticipant::where('user_id', auth_user('web')->id)->value('agent_id');

        
        $admin = Admin::where('id',$AdminId)->get();
       
        $title = 'View Ticket';

        $ticket = SupportTicket::with(['agents','category' ,'messages','linkedPriority'])
                                    ->where('user_id',auth_user('web')->id)
                                    ->where('ticket_number',$id)->firstOrfail();
        do {
            DB::table('support_messages')
                                ->where('support_ticket_id', $ticket->id)
                                ->whereNotNull('admin_id')
                                ->where('seen', StatusEnum::false->status())
                                ->join('support_tickets', 'support_messages.support_ticket_id', '=', 'support_tickets.id')
                                ->limit(100)
                                ->update(['seen' => StatusEnum::true->status()]);


        } while( 
                DB::table('support_messages')
                    ->where('support_ticket_id', $ticket->id)
                    ->whereNotNull('admin_id')
                    ->where('seen', StatusEnum::false->status())
                    ->join('support_tickets', 'support_messages.support_ticket_id', '=', 'support_tickets.id')->count() != 0
        );



 
        return view('user.ticket.details',compact('title','ticket','admin'));

      }

      /**
       * reply to a ticket 
       */
       public  function reply(Request $request) :RedirectResponse
       {
            $request->validate([
                'message'            => 'required',
                'ticket_id'          => 'required | exists:support_tickets,id',
                'files'              => [ new FileExtentionCheckRule(json_decode(site_settings('mime_types'),true),'Ticket File')]
            ],[
                "message.required"   => translate('Message Feild is Required'),
                "ticket_id.required" => translate('Ticket Id Feild Is Required'),
                "ticket_id.exists"   => translate('Invalid Tickets Selected'),
            ]);

            $ticket = SupportTicket::withoutGlobalScope('autoload')
                             ->with(['agents'])
                             ->where('id',$request->input('ticket_id'))
                             ->firstOrFail();

   
            $ticket_files = [];

    
            if($request->has('files')){
                try {
                    $ticket_files = $this->ticketService->storeFiles( $request['files']);
                } catch (\Exception $ex) {

                    return back()->with('error', strip_tags($ex->getMessage()));
                }
            }
           

            $supportMessage  = $this->ticketService->createSupportMessage($ticket, [
                                                    'body'      => build_dom_document( $request->input('message')),
                                                    'files'     => json_encode($ticket_files)
                                                ]);

            $defaultStatus           = ModelsTicketStatus::default()->first();
            $ticket->status = $defaultStatus ? $defaultStatus->id :TicketStatus::PENDING->value;
            $ticket->saveQuietly();

            $status  = 'success';
            $message = translate("Replied Successfully");
            
            $route   = route('admin.ticket.view',$ticket->ticket_number);
            $notifyMessage = translate('Hello Dear !!!'). $ticket->name . " Just Replied To a Conversations";

            $mailCode = [
                "role"          => 'User',
                "name"          => $ticket->name ,
                "ticket_number" => $ticket->ticket_number,
                "link"          => $route
            ];


            #NOTIFY SUPERADMIN
            $this->ticketService->notifyAgent($ticket,null, $notifyMessage ,"user_reply_admin" ,$route ,"TICKET_REPLY",
            $mailCode);

            #NOTIFY ALL SUPER AGENT
            $superAgents = Admin::active()->superagent()->get();

            foreach($superAgents as $agent){
                $this->ticketService->notifyAgent($ticket,$agent, $notifyMessage ,"user_reply_admin" ,$route ,"TICKET_REPLY",
                $mailCode);
            }


            #NOTIFY ALL AGENT WITH THE TICKETS
            $agents = $ticket->agents;

            foreach($agents as $agent){
                $this->ticketService->notifyAgent($ticket,$agent, $notifyMessage ,"user_reply_agent" ,$route ,"TICKET_REPLY",
                $mailCode);
            }

   

            return back()->with($status,$message);

       }




       /**
        * download a file 
        */
        public function download(Request $request) {

            $request->validate([
                'name'  => 'required',
            ]);
            $url        =  download_file(getFilePaths()['ticket']['path'],$request->name);
            if(!$url){
                return back()->with('error',translate('File Not Found'));
            }
            return $url;

        }



   
        /**
         * export tickets 
         */
        public function export($extension) {

            $ticketData   =  SupportTicket::where('user_id',auth_user('web')->id)->latest();
            $view         = null;
            if($extension == 'pdf'){
                $view     = "export_pdf";
            }
            return $this->ticketService->exportData($extension,$ticketData,$view );
        }


        /**
         * delete a specific ticket
         * 
         */
        public function delete(int | string $id) :RedirectResponse{
            
            if(site_settings(key:'user_ticket_delete',default:0) ==  0 ){
                abort(404);
            }

            $ticket = SupportTicket::withoutGlobalScope('autoload')->with(["messages",'agents'])
                                            ->withCount('messages')
                                            ->where('id',$id)
                                            ->where('user_id',auth_user('web')->id)
                                            ->firstOrfail();

            
            $ticket->messages()->lazyById(50,'id')->each(function(SupportMessage $message) {
                $ticketFiles  = json_decode($message->file,true);
                $this->unlinkFile($ticketFiles 
                                    ? $ticketFiles 
                                    :[] , getFilePaths()['ticket']['path']);

                $this->unlinkFile((array)@$message->editor_files ?? [] , getFilePaths()['text_editor']['path']);

            });



            do {
                $messsages = DB::table('support_messages')
                                        ->where('support_ticket_id',$ticket->id)
                                        ->join('support_tickets', 'support_messages.support_ticket_id', '=', 'support_tickets.id')
                                        ->limit(100)
                                        ->delete();
    
            
            } while ($messsages < 0); 

            $ticket->delete();

            return redirect()->route('user.ticket.list')->with('success', translate("Deleted Successfully"));
        }


      

}
