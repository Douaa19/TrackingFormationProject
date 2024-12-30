<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AgentMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next,$permissions)
    {

        $flag = true;
        try {
     
            if(!check_agent($permissions)){
                $flag =false;
            }
            
        } catch (\Exception $ex) {
           
        }

        if( $flag) return $next($request);
        if(request()->routeIs("admin.dashboard")) return redirect()->route('admin.profile.index');

         abort(403,unauthorized_message()); 
       
    }
}
