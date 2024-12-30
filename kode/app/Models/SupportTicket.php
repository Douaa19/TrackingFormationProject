<?php

namespace App\Models;

use App\Enums\StatusEnum;
use App\Enums\TicketStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Triggers\TriggerAction;
use App\Models\TicketStatus as SupportTicketStatus;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SupportTicket extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    protected $casts = [
        'notification_settings' => 'object',
        'locked_trigger'        => 'array',
        'envato_payload'        => 'object',
    ];


    public const ACCEPTED = "1" ,  REJECTED = "2" ,REQUESTED  = "0";

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'requested_by','id');
    }

    protected static function booted(){
        
        static::created(function (Model $model) {
           (new TriggerAction($model,$model->getOriginal()))->fireTrigger();
        });
        static::updated(function (Model $model) {
            (new TriggerAction($model,$model->getOriginal()))->fireTrigger();
        });

        static::addGlobalScope('autoload', function (Builder $builder) {
            $builder->with(['ticketStatus','department']);
        });

    }


    public function linkedPriority()
    {
        return $this->belongsTo(Priority::class, 'priority_id','id');
    }



    public function messages()
    {
        return $this->hasMany(SupportMessage::class, 'support_ticket_id')->latest();
    }

    public function unreadMessages() : HasMany
    {
        return $this->messages()->when(request()->routeIs('admin.*') ,
                  fn(Builder $q) => $q->whereNull('admin_id')->where('seen', StatusEnum::false->status()), fn(Builder $q) => $q->whereNotNull('admin_id')->where('seen', StatusEnum::false->status()) );
    }




    public function oldMessages()
    {
        return $this->hasMany(SupportMessage::class, 'support_ticket_id');
    }


    public function ticketStatus()
    {
        return $this->belongsTo(SupportTicketStatus::class, 'status','id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id','id');
    }


    




    public function scopeFilter($q,$request,$status = true){
        
        return $q->when($request->category_id,function($query) use($request){
            return $query->where('category_id',$request->category_id);
        })->when($request->status && $status, function($query) use($request,$status){
            return $query->where('status',$request->status);
        })->when($request->tag , function($query) use($request) {

            if($request->tag == "mine"){
                
                $result = $query->whereHas('agents', function($q) {
                    $q->where('agent_id', auth_user()->id);
                });
            }
            elseif($request->tag == "assign"){

                $result = $query->whereHas('agents', function($q) {
                    $q->where('agent_id', '!=', auth_user()->id);
                });
            }
            else{
                $result = $query->whereDoesntHave('agents');
            }
            return $result;

        })->when($request->search,function($query) use($request){
            return $query->where('ticket_number',$request->search)
            ->orwhere('name',$request->search);
        })->when($request->filter && $request->filter != 'all',function($query) use($request){
            $date = \Carbon\Carbon::today()->subDays($this->pastDate($request->filter));
            return $query->where('created_at','>=',$date);
        })->when($request->agent_id , function($query)  use($request){
            return $query->whereHas('agents', function($q) use($request) {
                $q->where('agent_id', $request->agent_id);
            });
        })->when($request->date_range,function($query) use($request){

            $dateRangeString = $request->date_range; 
            if (strpos($dateRangeString, ' to ') !== false) {
                list($start_date, $end_date) = explode(" to ", $dateRangeString);
            } else {
                $start_date  = $dateRangeString;
                $end_date    = $dateRangeString;
            }
            return $query->where(function ($query) use ($start_date, $end_date) {
                
                $query->whereBetween('created_at', [$start_date, $end_date])
                    ->orWhereDate('created_at', $start_date)
                    ->orWhereDate('created_at', $end_date);
            });
           
        })->when($request->priority,function($query) use($request){

            return $query->where('priority_id',$request->priority);
           
        })->when($request->department_id,function($query) use($request){

            return $query->where('department_id',$request->department_id);
           
        });;
    }
    


    public function pastDate($day){

        switch ($day) {
        case "yesterday":
            $number  = 1;
            break;
        case "last_7_days":
            $number  = 7;
            break;
        case "last_30_days":
            $number  = 30;
            break;

        default:
            $number = 0;
        }
        return $number;
    }

   
    public function scopeAgent($q,$agentId = null){

        return $q->when((auth_user()->agent == StatusEnum::true->status() || $agentId )  ,function($query) use($agentId) {
            return $query->whereHas('agents', function($q) use($agentId){
                $q->where('agent_id',$agentId? $agentId :auth_user()->id );
            });
        });
    }

    public function scopePending($q){
        return $q->where('status', TicketStatus::PENDING);
    }

    /** get solved ticket */
    public function scopeSolved($q){
        return $q->where('status', TicketStatus::SOLVED);
    }

    /** get closed ticket */
    public function scopeClosed($q){
        return $q->where('status', TicketStatus::CLOSED);
    }
    
    /** get peocessed ticket */
    public function scopeProcessing($q){
        return $q->where('status', TicketStatus::PROCESSING);
    }

    /** get hold ticket */
    public function scopeHold($q){
        return $q->where('status', TicketStatus::HOLD);
    }

    /** get hold ticket */
    public function scopeOpend($q){
        return $q->where('status', TicketStatus::OPEN);
    }
    

  
    /**
     * admin , ticket relation
     */
    public function agents(){
        return $this->belongsToMany(Admin::class, 'agent_tickets','ticket_id','agent_id')->withPivot(['short_notes']);
    }

    /** get ticket category */

    public function category(){
        return $this->belongsTo(Category::class,"category_id" , "id")->latest();
    }



}
