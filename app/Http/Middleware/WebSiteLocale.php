<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class WebSiteLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {  
        $locale = app('laravellocalization')->getCurrentLocale();

        if($locale == 'ar') {
            Session::put('language_direction', 'rtl');
        } else {
            Session::put('language_direction', 'ltr');
        }

        Session::put('locale', $locale);

        // 5. Set the application's locale for the current request.
        App::setLocale($locale);

        // URL::defaults(['locale' => $locale]);

        return $next($request);
    }
}
