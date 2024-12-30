<?php

namespace App\Models;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CannedReply extends Model
{
    use HasFactory;
    protected $guarded = [];


    protected $casts = [
       'share_with'   => 'array',
    ];

    /** get creator name */
    public function admin(){
        return $this->belongsTo(Admin::class,'admin_id','id');
    }
    /** get creator name */
    public function user(){
        return $this->belongsTo(Admin::class,'user_id','id');
    }

    /** active reply */
    public function scopeActive($q){
        return $q->where('status',StatusEnum::true->status());
    }


    

}
