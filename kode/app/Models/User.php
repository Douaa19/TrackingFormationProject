<?php

namespace App\Models;

use App\Enums\NotifyStatus;
use App\Enums\StatusEnum;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded  = [
      
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'envato_purchases'  => 'object'
    ];

    public function purchaseDepartment($envatoItemId)
    {
        return Department::where('envato_item_id', $envatoItemId)->first();
    }


    public function scopeUnverified($query)
    {
        return $query->where('verified', (StatusEnum::false)->status());
    }

    public function scopeActive($query)
    {
        return $query->where('status', (StatusEnum::true)->status());
    }

    public function scopeBanned($query)
    {
        return $query->where('status', (StatusEnum::false)->status());
    }

    public function chat()
    {
        return $this->hasMany(Chat::class,"user_id",'id')->latest();

    }

    public function unread ($agent_id){
        return Chat::where('admin_id',$agent_id)->where('user_id',$this->id)->where('sender',(StatusEnum::false)->status())->where('seen_by_agent',(StatusEnum::false)->status())->count();
    }


    public function unreadNotifications() {
        return $this->hasMany(CustomNotifications::class,'notify_id','id')
                             ->with(['admin'])
                            ->where("notification_for",NotifyStatus::USER)
                            ->where("is_read",(StatusEnum::false)->status())
                            ->latest();
    }



    public function tickets(){
        return $this->hasMany(SupportTicket::class,"user_id",'id')->latest();
    }


    public function scopeFilter($q,$request){
        
        return $q->when($request->filter && $request->filter != 'all',function($query) use($request){
            $date = \Carbon\Carbon::today()->subDays(pastDate($request->filter));
            return $query->where('created_at','>=',$date);
        });
    }


  
}
