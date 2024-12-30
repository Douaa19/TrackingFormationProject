<?php

namespace App\Models;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Priority extends Model
{
    use HasFactory;



    protected $guarded = [];

    /** get ticket */
    public function ticket(){

        return $this->hasMany(SupportTicket::class,'priority_id','id');
    }


    public function scopeActive($q){
        return $q->where('status',StatusEnum::true->status());
    }
    public function scopeDefault($q){
        return $q->where('is_default',StatusEnum::true->status());
    }


    protected $casts = [
        
        'response_time' => 'object',
        'resolve_time'  => 'object'
    ];

}
