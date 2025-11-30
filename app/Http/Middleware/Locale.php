<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use App\Models\Language;

class Locale
{
    public function handle(Request $request, Closure $next)
    {
        // 1. Determine the locale. Priority is Session > App Config Default.
        $locale = Session::get('admin_locale', config('app.admin_locale'));

        // 2. Get all active languages and cache them. 
        // We fetch the language details to get the direction ('rtl' or 'ltr').
        // Cache::forget('active_languages_list');
        $activeLanguages = Cache::remember('active_languages_list', 60*60*24, function () {
            // Use keyBy() to make it easy to look up a language by its short name.
            return Language::where('status', 'Active')->get()->keyBy('short_name');
        });
        
        // 3. Verify the determined locale is actually an active language.
        // If not, fall back to the application's default locale.
        if (! $activeLanguages->has($locale)) {
            $locale = config('app.fallback_locale', 'en');
        }

        // dd($locale);
        // 4. Set the application's locale for the current request.
        App::setLocale($locale);

        // 5. Get the language details from our cached collection.
        $language = $activeLanguages->get($locale);
        $direction = $language ? $language->direction : 'ltr'; // Default to 'ltr' if something is wrong.
        
        // 6. Store the chosen locale and its direction in the session for subsequent requests.
        // This is now done once, avoiding duplication.
        Session::put('admin_locale', $locale);
        Session::put('language_direction', $direction);

        return $next($request);
    }
}
