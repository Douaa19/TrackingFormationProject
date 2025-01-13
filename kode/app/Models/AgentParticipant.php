<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentParticipant extends Model
{
    use HasFactory;

    protected $table = 'agent_participant';
    protected $fillable = ['agent_id', 'participant_id'];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function agent()
    {
        return $this->belongsTo(Admin::class, 'id_agent');
    }
}
