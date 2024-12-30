<?php

namespace App\Models;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IncommingMailGateway extends Model
{
    use HasFactory;


    protected $guarded = [];

    protected $casts = [
        'credentials'    => 'object',
        'match_keywords' => 'array'
    ];

    public function product(): BelongsTo {
        return $this->belongsTo(Department::class, 'department_id','id');
    }

    public function scopeActive($q){

        return $q->where('status',StatusEnum::true->status());
    }


}
