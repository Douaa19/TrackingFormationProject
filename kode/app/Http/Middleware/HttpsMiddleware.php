<?php

namespace App\Http\Middleware;

use App\Enums\StatusEnum;
use Closure;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

class HttpsMiddleware
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

            if(site_settings('force_ssl') == (StatusEnum::true)->status() &&  $request->secure()){
                \URL::forceScheme('https');
            }

            return $next($request);

        } catch (\Throwable $th) {

        }

        
        return $next($request);
    }
}
