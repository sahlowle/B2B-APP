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
        $langData = preference('dflt_lang');
        $userId = (int) Cart::userId();


        if (! empty($userId)  && isset($userId) && Cache::get(config('cache.prefix') . '-user-language-' . $userId)) {
            $langData = Cache::get(config('cache.prefix') . '-user-language-' . $userId);
        }

        if (auth()->guest() && empty($userId) && $userId == 0) {
            $langData = Cache::get(config('cache.prefix') . '-guest-language-' . request()->server('HTTP_USER_AGENT'));
        }

        $language = Language::where(['short_name' => $langData, 'status' => 'Active'])->get();

        if (empty($language) || count($language) == 0) {

            $language = Language::where(['is_default' => '1', 'status' => 'Active'])->get();
            $langData = $language->first()->short_name;
        }

        if (! empty($language) && count($language) > 0) {

            App::setLocale($langData);
            $direction = ! empty($language[0]['direction']) ? $language[0]['direction'] : 'ltr';
            Cache::put(config('cache.prefix') . '-language-direction', $direction, 600);
        } else {

            $langData = 'en';
            App::setLocale($langData);
            Cache::put(config('cache.prefix') . '-language-direction', 'ltr', 600);
        }

        return $next($request);
    }
}
