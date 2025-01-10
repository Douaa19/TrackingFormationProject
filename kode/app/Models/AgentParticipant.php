<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentParticipant extends Model
{
    use HasFactory;

    protected $table = 'agent_participant';
    protected $fillable = ['id_agent', 'id_participant'];
}
