<?php

namespace App\Http\Triggers;

use App\Enums\StatusEnum;
use App\Enums\TicketStatus;
use App\Http\Controllers\Controller;
use App\Models\AgentTicket;
use App\Models\SupportMessage;
use App\Models\SupportTicket;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Http\Services\TicketService;
use App\Http\Utility\SendMail;
use App\Http\Utility\SendSMS;
use App\Jobs\SendEmailJob;
use App\Jobs\SendSmsJob;
use App\Models\Admin;
use App\Models\TicketTrigger;
use Carbon\Carbon;

class Conditions extends Controller
{


    public $ticketService;
    public Admin $superadmin;

    public function __construct()
    {
        $this->ticketService =  new TicketService();
        $this->superadmin    =  Admin::where('agent',(StatusEnum::false)->status())->first();

    }
    // ticket conditions 
    public function subject(array $originalTicket , SupportTicket $ticket , string  $operator, string | int $value) : bool{

        return $this->compare(strip_tags($ticket->subject) ,$value,$operator) ;

    }
    public function body(array $originalTicket , SupportTicket $ticket , string  $operator, string | int $value) : bool{
       
        return $this->compare(strip_tags($ticket->message) ,$value,$operator) ;
    }
    public function status(array $originalTicket , SupportTicket $ticket , string  $operator, string | int $value) : bool{

        return $this->compare($ticket->status,$value,$operator) || $this->isMet($originalTicket ,$ticket,$operator,$value ,"status") ;
    }
    public function category(array $originalTicket , SupportTicket $ticket , string  $operator, string | int $value) : bool{
    
        return $this->compare($ticket->category_id ,$value,$operator) || $this->isMet($originalTicket ,$ticket,$operator,$value ,"category_id") ;
        
    }
    public function uploads( array $originalTicket , SupportTicket $ticket , string  $operator, string | int $value) : bool{

 
        $files = 0;
        $ticket->messages()->whereNull('admin_id')->lazy()->each(function(SupportMessage $message) use (&$files){
            $files += count(@json_decode( $message->file,true) ?? []);
        });
    
        return $this->compare( $files ,$value,$operator) ;


    }
    public function assignee( array $originalTicket , SupportTicket $ticket , string  $operator, string | int $value) : bool{
     
        $assignee = @($ticket->agents()->pluck('agent_id')->toArray()) ?? [];

        return in_array($value,$assignee) 
                    ? $this->compare($value ,$value,$operator) 
                    : false;

    }
    public function mail(array $originalTicket , SupportTicket $ticket , string  $operator, string | int $value) : bool{

        return $this->compare($ticket->email ,$value,$operator) ;
    }

    //customer condition
    public function email(array $originalTicket , SupportTicket $ticket , string  $operator, string | int $value) : bool{
    
        return  $ticket->user 
                      ? $this->compare($ticket->user->email ,$value,$operator) 
                      : false;
    }
    public function name(array $originalTicket , SupportTicket $ticket , string  $operator, string | int $value) : bool{
        return $this->compare($ticket->name ,$value,$operator) ;
    }



    // time frame
    public function hours_since_last_user_reply(array $originalTicket , SupportTicket $ticket , string  $operator, string | int $value) : bool{
        
        $hours = (int) $value;
        $lastMessage = $ticket->messages()
                            ->latest()
                            ->whereNull('admin_id')
                            ->first();

        return       $lastMessage ?  $lastMessage->created_at->lte(Carbon::now()->subHours($hours)) : false;
    }


    public function hours_since_last_reply(array $originalTicket , SupportTicket $ticket , string  $operator, string | int $value) : bool{
        
        $hours = (int) $value;
        $lastMessage = $ticket->messages()->latest()->first();
        return       $lastMessage ?  $lastMessage->created_at->lte(Carbon::now()->subHours($hours)) : false;
    }
    public function hours_since_last_activity(  array $originalTicket , SupportTicket $ticket , string  $operator, string | int $value) : bool{
        
        $hours = (int) $value;
        return $ticket->updated_at->lte(Carbon::now()->subHours($hours));
    }
    public function hours_since_closed(array $originalTicket , SupportTicket $ticket , string  $operator, string | int $value) : bool{

        if($ticket->status == TicketStatus::CLOSED){
            $hours = (int) $value;
            return $ticket->updated_at->lte(Carbon::now()->subHours($hours));
        }
        return false;

    }
    public function hours_since_created(array $originalTicket , SupportTicket $ticket , string  $operator, string | int $value) : bool{
        $hours = (int) $value;
        return $ticket->created_at->lte(Carbon::now()->subHours($hours));
    }

   


    /**
     * Compare string haystack and needle using specified operator.
     *
     * @param string $operator
     *
     * @return bool
     */
    public function compare(mixed $haystack, mixed $needle, string $operator) : bool
    {
        return match ($operator) {
            'contains'          => Str::contains($haystack, $needle),
            'not_contains'      => !Str::contains($haystack, $needle),
            'starts_with'       => Str::startsWith($haystack, $needle),
            'ends_with'         => Str::endsWith($haystack, $needle),
            'equals'            => $haystack == $needle,
            'not_equals',       => $haystack != $needle,
            'more'              => (int) $haystack >  (int)$needle,
            'less'              => (int) $haystack < (int) $needle,
            'matches_regex'     => (bool) preg_match("/$needle/", $haystack),
            default => false,
        };
    }



     /**
     * Compare string haystack and needle using specified operator.
     *
     * @param string $operator
     *
     * @return bool
     */
    public function isMet(array $originalTicket , SupportTicket $ticket , string  $operator, string | int $value , ? string $key ) : bool {

        return match ($operator) {
            'is' => $this->compare(
                $ticket->{$key},
                $value,
                'equals',
            ),
            'not' => $this->compare(
                $ticket->{$key},
                $value,
                'not_equals',
            ),
            'changed' => $this->keyStatusChanged($ticket, $originalTicket ,$key),
            'not_changed' => !$this->keyStatusChanged($ticket, $originalTicket ,$key),
            'changed_to' => $this->keyStatusChanged($ticket, $originalTicket ,$key) &&
                $this->compare(
                    $ticket->{$key},
                    $value,
                    'equals',
                ),
            'not_changed_to' => $this->keyStatusChanged($ticket, $originalTicket ,$key) &&
                $this->compare(
                    $ticket->{$key},
                    $value,
                    'not_equals',
                ),
            'changed_from' => $this->keyStatusChanged($ticket, $originalTicket ,$key) &&
                $this->compare(
                    Arr::get($originalTicket ,$key ,null),
                    $value,
                    'equals',
                ),
            'not_changed_from' => $this->keyStatusChanged($ticket, $originalTicket ,$key) &&
                $this->compare(
                    Arr::get($originalTicket ,$key ,null),
                    $value,
                    'not_equals',
                ),
            default => false,
        };
    }



    public function keyStatusChanged(SupportTicket $updatedTicket, array $originalTicket , string $key)
    {
        return $originalTicket &&
            $this->compare(
                $updatedTicket->{$key},
                Arr::get($originalTicket ,$key ,null),
                'not_equals',
            );
    }



     
    // trigger action

    public function move_to_category(SupportTicket $supportTicket , mixed $values ) : bool{

        foreach(@$values?? [] as $value){
            $supportTicket->category_id =  (int) $value; 
            $supportTicket->saveQuietly();
        }

        return true;

        
    }
    public function send_email_to_user(SupportTicket $supportTicket , mixed $values ) : bool{

        if($values && $values->subject){
            foreach($values->message as $index => $message){
                SendMail::MailNotification(userInfo :(object)[
                    'name'    => $supportTicket->name,
                    'email'   => $supportTicket->email,
                    'subject' => Arr::get($values->subject,$index)
                ],code : [] , messages :$message);
            }

            return true;
        }

        return false;
    }
    public function send_email_to_agent(SupportTicket $supportTicket , mixed $values ) : bool{
   
        foreach($values->message as $index => $message){
            $agent  = Admin::agent()->where('id',Arr::get($values->agents,$index))->first();
            if($agent){
                SendMail::MailNotification(userInfo :(object)[
                    'name'    => $agent->name,
                    'email'   => $agent->email,
                    'subject' => Arr::get($values->subject,$index)
                ],code : [] , messages :$message);
            }
        }


        return true;
    }
    public function send_sms_to_agent(SupportTicket $supportTicket , mixed $values ) : bool{

        foreach($values->message as $index => $message){
            $agent  = Admin::agent()->where('id',Arr::get($values->agents,$index))->first();
            if($agent){
                SendSMS::SmsNotification(userInfo :(object)[
                    'name'    => $agent->name,
                    'phone'   => $agent->phone,
                ],code : [] , messages :$message);
            }
        }
        return true;

    }
    public function add_note_to_ticket(SupportTicket $supportTicket , mixed $values ) :bool{

        if($values && $this->superadmin){

            foreach(@$values?? [] as $value){
                SupportMessage::create([
                   'support_ticket_id' => $supportTicket->id,
                   'admin_id'          => @$this->superadmin->id,
                   'message'           => $value,
                   'is_note'           => StatusEnum::true->status(),
                ]);
             }

             return true;
        }

        return false;
       
    }


    public function add_reply_to_ticket(SupportTicket $supportTicket , mixed $values ) :bool{


        if($values && $this->superadmin){
         
            foreach(@$values?? [] as $value){

                $supportMessage = new SupportMessage();
                $supportMessage->support_ticket_id = $supportTicket->id;
                $supportMessage->admin_id =  @$this->superadmin->id;
                $supportMessage->message =  $value;
                $supportMessage->saveQuietly();
            }

            return true;
        }

        return false;

    }


    public function change_status( SupportTicket $supportTicket , mixed $values ) : bool {
        
        foreach(@$values?? [] as $value){
            $supportTicket->status =  (int) $value; 
            $supportTicket->saveQuietly();
        }
        return true;

    }
    public function assign_to_agent(SupportTicket $supportTicket , mixed $values ) : bool {

        foreach(@$values?? [] as $value){
            AgentTicket::create([
                'ticket_id'    => $supportTicket->id,
                'agent_id'     => $value,
                'short_notes'  => "Ticket Assigned BY Trigger",
            ]);
        }
        return true;
    }


    public function delete_ticket(SupportTicket $supportTicket , mixed $values ,TicketTrigger $trigger) :bool{

        $this->ticketService->deleteTicket((array)$supportTicket->id);
        
        return true;
    }




}