<?php

namespace App\Models;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FloatingChat extends Model
{
    use HasFactory;

    protected $guarded = [];



    public function unread ($agent_id){

        return Chat::where('floating_id',$this->id)
        ->where(function($q) use($agent_id){
            return $q->where('admin_id',$agent_id)
            ->orWhereNull('admin_id');
        })
        ->where('sender',(StatusEnum::false)->status())
        ->where('seen_by_agent',(StatusEnum::false)->status())
        ->count();
    }

}
