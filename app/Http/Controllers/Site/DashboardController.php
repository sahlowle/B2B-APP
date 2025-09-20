<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 21-11-2021
 */

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Modules\CMS\Http\Models\ThemeOption;

class DashboardController extends Controller
{
    public function index()
    {
        return view('site.myaccount.overview');
    }

    /**
     * Change Language function
     *
     * @return true or false
     */
    public function switchLanguage(Request $request)
    {
        if($request->filled('lang')){
            
            $locale = $request->lang;

            session()->put('locale', $locale);

            // Cache::put('user-lang', $locale);

            App::setLocale($locale);

           return response()->json(['success' => true, 'message' => 'Language switched successfully.']);
        }
        
        return response()->json(['success' => false, 'message' => 'Invalid request.']);
    }

    public function switchLanguageForGet(Request $request)
    {
        if($request->filled('lang')){
            
            $locale = $request->lang;

            session()->put('locale', $locale);

            // Cache::put('user-lang', $locale);

            App::setLocale($locale);
        }
   

        return redirect()->back();
    }

    /**
     * change currency
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function switchCurrency(Request $request)
    {
        if ($request->currency_id) {
            if (! empty(Auth::user()->id) && isset(Auth::guard('user')->user()->id)) {
                Cache::put(config('cache.prefix') . '-user-multi_currency-' . Auth::guard('user')->user()->id, $request->currency_id, 5 * 365 * 86400);

                return response()->json([
                    'status' => 1,
                ]);
            } else {
                Cache::put(config('cache.prefix') . '-guest-multi_currency-' . request()->server('HTTP_USER_AGENT'), $request->currency_id, 5 * 365 * 86400);

                return response()->json([
                    'status' => 1,
                ]);
            }
        }

        return response()->json([
            'status' => 'info',
            'message' => __('Please select a currency first.'),
        ]);
    }
}
