<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function scopeFilter($q,$request){
        
        return $q->when($request->filter && $request->filter != 'all',function($query) use($request){
            $date = \Carbon\Carbon::today()->subDays(pastDate($request->filter));
            return $query->where('created_at','>=',$date);
        });
    }

}
