<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'message',
        'status'
    ];

    public function user(){
        
    	return $this->belongsTo(User::class, 'user_id');
    }
}
