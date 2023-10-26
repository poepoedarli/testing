<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

use Closure;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        if (Session()->has('applocale') AND array_key_exists(Session()->get('applocale'), config('app.available_locales'))) {
            App::setLocale(Session()->get('applocale'));
        }
        else {
            App::setLocale(config('app.fallback_locale'));
        }
        
        return $next($request);
    }
}