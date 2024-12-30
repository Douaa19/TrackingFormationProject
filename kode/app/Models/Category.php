<?php

namespace App\Models;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $guarded = [];

    // protected $casts = [
    //     'name'   => 'object',
    // ];



    public function tickets(){
        return $this->hasMany(SupportTicket::class,"category_id",'id')->latest();
    }

    public function articles(){
        return $this->hasMany(Article::class,"category_id",'id')->latest();
    }

    public function faq(){
        return $this->hasMany(Faq::class,"category_id",'id')->where('status',StatusEnum::true->status())->latest();
    }
    
    public function scopeActive($q){
        return $q->where('status',StatusEnum::true->status());
    }

    public function scopeAgent($q ,$agentId = null){

        return $q->when(auth_user()->agent == StatusEnum::true->status() || $agentId   ,function($query) use($agentId) {
            return $query->whereHas('tickets', function($q) use($agentId) {
                $q->whereHas("agents", function($q) use($agentId) {
                    $agentId = $agentId ?  $agentId  : auth_user()->id ;
                    $q->where('agent_id', $agentId);
                });
            });
        });
    }


    public function scopeFilter($q,$request){
        
        return $q->when($request->filter && $request->filter != 'all',function($query) use($request){
            
            $date = \Carbon\Carbon::today()->subDays(pastDate($request->filter));
            return $query->where('created_at','>=',$date);
        })
        ->when($request->name , function($query) use($request) {

            return  $query->whereRaw("JSON_CONTAINS(name->'$.*', '\"$request->name\"')");
        });


       
    }

}
