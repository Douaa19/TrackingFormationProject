<?php

namespace App\Models;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportMessage extends Model
{
    use HasFactory;
    protected $casts = [
        'editor_files' => 'array'
    ];
    protected $guarded = [];
    
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }


    public function scopeAgent($q,$agentId = null){

        return $q->when((auth_user()->agent == StatusEnum::true->status() || $agentId )  ,function($query) use($agentId) {
            return $query->whereNotNull('admin_id')
            ->where("admin_id",auth_user()->id);
        });
    }


    public function scopeFilter($q,$request){
        
        return $q->when($request->filter && $request->filter != 'all',function($query) use($request){
            $date = \Carbon\Carbon::today()->subDays(pastDate($request->filter));
            return $query->where('created_at','>=',$date);
        });
    }


    

}
