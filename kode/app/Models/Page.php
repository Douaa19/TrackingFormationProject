<?php

namespace App\Models;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;
    protected $guarded = [];


    //active pages
    public function scopeActive($q){
        return $q->where('status',(StatusEnum::true)->status());
    }
    

}
