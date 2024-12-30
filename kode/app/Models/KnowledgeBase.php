<?php

namespace App\Models;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KnowledgeBase extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id','id');
    }


    public function childs(): HasMany
    {
        return $this->hasMany(KnowledgeBase::class, 'parent_id')->with('childs');
    }

    public function scopeActive($q){

        return $q->where('status',StatusEnum::true->status());
    }
}
