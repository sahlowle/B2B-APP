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
        $locale = $request->route('locale');

        $supported_locales = Cache::remember('app_supported_locales', now()->addHours(24), function () {
            return Language::where('status', 'Active')->pluck('short_name')->toArray();
        });


        if (!in_array($locale, $supported_locales)) {
            abort(404);
        }


        if (is_null($locale)) {
            $defaultLanguage = Cache::remember('app_default_language', 3600, function () {
                return Language::where('is_default', '1')->where('status', 'Active')->first();
            });

            // 3. Use the default from the database, or fallback to 'en' if none is set.
            $locale = $defaultLanguage ? $defaultLanguage->short_name : 'en';

            Session::put('locale', $locale);
        }

        if($locale == 'ar') {
            Session::put('language_direction', 'rtl');
        } else {
            Session::put('language_direction', 'ltr');
        }

        Session::put('locale', $locale);

        // 5. Set the application's locale for the current request.
        App::setLocale($locale);

        
        $parameters = Route::current()->parameters();
        
        URL::defaults(['locale' => $locale]);
        // dd($parameters);

        return $next($request);
    }
}
