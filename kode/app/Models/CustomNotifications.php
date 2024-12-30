<?php

namespace App\Models;

use App\Enums\NotifyStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomNotifications extends Model
{
    use HasFactory;

    protected $guarded = [];
    

    public function admin()
    {
        return $this->belongsTo(Admin::class,'notify_by','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'notify_by','id');
    }


}
