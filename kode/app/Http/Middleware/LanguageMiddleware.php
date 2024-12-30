<?php

namespace App\Http\Middleware;

use App\Enums\StatusEnum;
use Closure;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use PhpParser\Node\Stmt\TryCatch;

class LanguageMiddleware
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
            if(session()->has('locale')){
                $locale = session()->get('locale');
            }
            else{
                $locale = (Language::where('is_default',(StatusEnum::true)->status())->first())->code;
            }
            App::setLocale($locale);
            session()->put('locale', $locale); 
        } catch (\Exception $ex) {
            
        }
        return $next($request); 
    }

  
}
