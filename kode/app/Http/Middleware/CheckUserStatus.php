<?php

namespace App\Http\Middleware;

use App\Enums\StatusEnum;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserStatus
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->status == (StatusEnum::false)->status() &&  Auth::user()->verified == (StatusEnum::false)->status()) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')->with('error',translate("Your account is Banned  or Your Email Is Not Verfied"));
        }
        return $next($request);
    
    }

}
