<?php

namespace App\Models;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $guarded = [];



    public function category(){

        return $this->belongsTo(ArticleCategory::class,"article_category_id",'id')->latest();
    }

    public function items(){

        return $this->belongsTo(Category::class,"category_id",'id')->latest();
    }

    public function scopeActive($q){
        
        return $q->where('status',StatusEnum::true->status());
    }

    public function scopeFilter($q,$request){
        
        return $q->when($request->filter && $request->filter != 'all',function($query) use($request){
            $date = \Carbon\Carbon::today()->subDays(pastDate($request->filter));
            return $query->where('created_at','>=',$date);
        })->when($request->search_value , function($query) use($request) {
            return  $query->where("name" ,"like" , "%".$request->search_value."%")
            ->orWhereHas("category" , function($q) use($request){
                 return  $q->where("name" ,"like" , "%".$request->search_value."%");
            })->orWhereHas("items" , function($q) use($request){
                return  $q->whereRaw("JSON_CONTAINS(name->'$.*', '\"$request->search_value\"')");
           });
        });
    }


    
}
