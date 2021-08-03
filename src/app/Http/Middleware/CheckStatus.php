<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckStatus {

    public function handle($request, Closure $next) {
        $response = $next($request);
        if(Auth::check() && !Auth::user()->status){
            Auth::logout();
            return redirect()->route('login')->with('email', __('lang.blocked'));
        }
        return $response;
        }

}
