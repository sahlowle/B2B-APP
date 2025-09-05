<?php

namespace App\Http\Middleware;

use App\Cart\Cart;
use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use App\Models\Language;

class Locale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $defaultLang = preference('dflt_lang');

        $language = Cache::remember('default-language-from-db', 3600, function () {
            return Language::where(['is_default' => '1', 'status' => 'Active'])->get();
        });

        if($language->isNotEmpty()){
            $defaultLang = $language->first()->short_name;
            $direction = $language->first()->direction;
        } else {
            $defaultLang = 'en';
            $direction = 'ltr';
        }

        if(Cache::get('user-lang')){
            $defaultLang = Cache::get('user-lang');
            $direction = Language::where(['short_name' => $defaultLang, 'status' => 'Active'])->first()->direction;
            session()->put('locale', $defaultLang);
        }


        App::setLocale($defaultLang);
        Cache::put(config('cache.prefix') . '-language-direction', $direction, 600);

    

        return $next($request);
    }
}
