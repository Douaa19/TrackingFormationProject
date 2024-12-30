<?php

namespace App\Http\Middleware;

use App\Enums\StatusEnum;
use Closure;
use Illuminate\Http\Request;

class MaintenanceModeMiddleware
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
            if(!request()->routeIs('admin.setting.*') && site_settings('maintenance_mode') == (StatusEnum::true)->status() ){
                return redirect()->route('maintenance.mode');
            }
            return $next($request);

        } catch (\Exception $ex) {
            
        }
        return $next($request);
    }
}
