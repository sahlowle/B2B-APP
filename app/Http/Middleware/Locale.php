<?php

namespace App\Http\Middleware;

use App\Cart\Cart;
use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class Locale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $locale = null;

        // 1. The highest priority is the user's choice, stored in their session.
        if (Session::has('locale')) {
            $locale = Session::get('locale');
        } else {
            // 2. If the user hasn't chosen a language, find the application's default.
            // This is a good use of cache, as the site's default language is the same for everyone.
            $defaultLanguage = Cache::remember('app_default_language', 3600, function () {
                return Language::where('is_default', '1')->where('status', 'Active')->first();
            });

            // 3. Use the default from the database, or fallback to 'en' if none is set.
            $locale = $defaultLanguage ? $defaultLanguage->short_name : 'en';
            
            // 4. Store this default locale in the session for subsequent requests.
            Session::put('locale', $locale);
        }

        // 5. Set the application's locale for the current request.
        App::setLocale($locale);

        return $next($request);
    }
}
