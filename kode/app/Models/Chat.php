<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    protected $guarded = [];

    /** get chat user  */
    public function user(){

        return $this->belongsTo(User::class,'user_id','id');
    }

    /** get chat agent  */
    public function agent(){
        
        return $this->belongsTo(Admin::class,'admin_id','id');
    }


     /** get floating chat user  */
     public function floating(){
        return $this->belongsTo(FloatingChat::class,'floating_id','id');
     }


}
