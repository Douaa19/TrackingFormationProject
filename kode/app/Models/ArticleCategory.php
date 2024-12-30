<?php

namespace App\Models;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleCategory extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function articles(){

        return $this->hasMany(Article::class,"article_category_id",'id')->latest();
    }


    public function scopeActive($q){

        return $q->where('status',StatusEnum::true->status());
    }



    public function scopeFilter($q,$request){
        
        return $q->when($request->name , function($query) use($request) {
            return  $query->where("name" ,"like" , "%".$request->name."%");
        });
    }


}
