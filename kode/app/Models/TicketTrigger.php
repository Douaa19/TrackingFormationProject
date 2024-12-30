<?php

namespace App\Models;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class TicketTrigger extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'all_condition' => 'object',
        'any_condition' => 'object',
        'actions'       => 'object',
    ];


    public function scopeActive(Builder $q) : Builder {
        return $q->where('status', StatusEnum::true->status());
    }


}
