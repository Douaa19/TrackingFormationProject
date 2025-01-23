<?php

namespace App\Models;

use App\Enums\NotifyStatus;
use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Admin extends Authenticatable
{
    use HasFactory;

    protected $casts = [
        'muted_ticket' => 'array',
    ];

    protected  $guarded  = [
        'name', 'email', 'image', 'username','address'
    ];

    public function scopeAgent($q){
        return $q->where('agent',(StatusEnum::true)->status())
                 ->orwhere('super_agent',(StatusEnum::true)->status());
    }


    public function scopeSuperagent($q){
        return $q->where('super_agent',(StatusEnum::true)->status());
    }


    public function group(){

        return $this->belongsToMany(Group::class, 'group_members','agent_id','group_id')->latest();

    }

    public function response(){

        return $this->hasMany(AgentResponse::class,'agent_id',"id");
    }

    public function scopeActive($q){

        return $q->where('status',(StatusEnum::true)->status());
    }


    public function unread ($user_id){


        return Chat::where('user_id',$user_id)
                    ->where('admin_id',$this->id)
                    ->where('sender',(StatusEnum::true)->status())
                    ->where('seen',(StatusEnum::false)->status())
                    ->count();
    }

    /**
     * admin , ticket relation
     *
     */
     public function tickets(){

        return $this->belongsToMany(SupportTicket::class, 'agent_tickets','agent_id','ticket_id')
                          ->withPivot(['short_notes']);
     }

   /**
    * Undocumented function
    *
    */
    public function unreadNotifications()
    {
        return $this->hasMany(CustomNotifications::class,'notify_id','id')
                    ->with(['admin','user'])
                    ->whereIn("notification_for",[NotifyStatus::AGENT , NotifyStatus::SUPER_ADMIN])
                    ->where("is_read",(StatusEnum::false)->status())
                    ->latest();
    }

    public function scopeFilter($q,$request){

        return $q->when($request->filter && $request->filter != 'all',function($query) use($request){
            $date = \Carbon\Carbon::today()->subDays(pastDate($request->filter));
            return $query->where('created_at','>=',$date);
        });
    }


}
