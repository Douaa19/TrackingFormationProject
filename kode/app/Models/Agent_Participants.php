<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent_Participants extends Model
{
    use HasFactory;

    protected $fillable = ['agent_id', 'user_id'];

    public function user()
    {
        return $this->hasOne(User::class);
    }

}
