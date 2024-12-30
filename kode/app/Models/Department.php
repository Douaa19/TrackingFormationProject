<?php

namespace App\Models;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    use HasFactory;

    protected $guarded = [];


    protected $casts = [
        'envato_payload' => 'object'
    ];


    public function tickets() : HasMany
    {
        return $this->hasMany(SupportTicket::class, 'department_id','id');
    }

    public function knowledgeBases() : HasMany
    {
        return $this->hasMany(KnowledgeBase::class, 'department_id','id');
    }


    public function parentKnowledgeBases() : HasMany
    {
        return $this->hasMany(KnowledgeBase::class, 'department_id','id')->whereNull('parent_id');
    }

    
    public function scopeActive($q){

        return $q->where('status',StatusEnum::true->status());
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'envato_item_id', 'id');
    }


}
