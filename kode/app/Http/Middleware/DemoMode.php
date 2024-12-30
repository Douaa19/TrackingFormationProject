<?php

namespace App\Http\Middleware;

use App\Enums\StatusEnum;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class DemoMode
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


        $ignoreRouteList = [
            'admin.agent.update',
            'admin.user.update',
             'admin.chat.send.message',
            // 'admin.setting.status.update',
        ];
        
        try {
            if(env('APP_MODE') == 'demo'){ 
                if(!in_array(Route::currentRouteName(),$ignoreRouteList)){
                    if(
                        request()->routeIs("admin.setting.plugin.store") ||
                        request()->routeIs("admin.setting.store") ||
                        request()->routeIs("admin.setting.ticket.store") ||
                        request()->routeIs("*.update*")  ||
                        request()->routeIs("*.destroy*") ||
                        request()->routeIs("*.delete*") ||
                        request()->routeIs("*.mark*") || 
                        request()->routeIs("*.send*") ||
                        request()->routeIs("admin.setting.logo.store") ||
                        request()->routeIs("admin.setting.logo.store") ||
                        request()->routeIs("admin.language.make.default") 
                    ){
                         if ($request->expectsJson() || $request->isXmlHttpRequest()) {
                            return response()->json(response_status('This Function Is Not Available For Website Demo Mode','error'), 403);
                        }
                        return back()->with('error', translate('This Function Is Not Available For Website Demo Mode'));
                    }
                }
            }

        } catch (\Exception $ex) {
            //throw $th;
        }
        
        return $next($request);
    }
}
