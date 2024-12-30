<?php

namespace App\Http\Middleware;

use App\Enums\StatusEnum;
use App\Models\Visitor;
use Closure;
use Illuminate\Http\Request;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Route;

class SecurityMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {


        try {
            /** dos security check  */
            if(site_settings('dos_prevent') == StatusEnum::true->status() && !session()->has('dos_captcha') && session()->has('security_captcha')){
                session()->put('requested_route',Route::currentRouteName());
                return ($request->expectsJson() || $request->isXmlHttpRequest()) ? response()->json(response_status('Unauthorized ip or country','error'), 403) : redirect()->route('dos.security');
            }
            else{
                /** ip and country block check */
                $ipinfo         = get_ip_info();
                $ipAddress      = get_real_ip();
                $ip             = Visitor::insertOrupdtae($ipAddress,$ipinfo);
                if($ip->is_blocked == StatusEnum::true->status() && !request()->routeIs('admin.*')){
                    return ($request->expectsJson() || $request->isXmlHttpRequest()) ? response()->json(response_status('Unauthorized ip or country','error'), 403) : redirect()->route('error',t2k("Unauthorized","-"));
                }
            }
    
        return $next($request);
       
    } catch (\Exception $ex) {
        
    }
    return $next($request);




    }
}
