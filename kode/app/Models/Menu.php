<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\StatusEnum;

class Menu extends Model
{
    use HasFactory;
    protected $guarded = [];


    //active pages
    public function scopeActive($q){
        return $q->where('status',(StatusEnum::true)->status());
    }
}
