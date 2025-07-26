<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 20-06-2022
 */

namespace Modules\GeoLocale\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class GeoLocaleController extends Controller
{
    /**
     * Country List
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('geolocale::index');
    }

    /**
     * Import GeoLocale Data
     *
     * @return \Illuminate\Http\RedirectResponse || \Illuminate\Contracts\View\View
     */
    public function import(Request $request)
    {
        if ($request->method() == 'GET') {
            return view('geolocale::import');
        }
        
        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');

            ini_set('memory_limit', '512M');
            DB::disableQueryLog();

            $response = Http::get(moduleConfig('geolocale.dummy_github_url'));

            DB::unprepared($response->body());
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        } catch (\Exception $exception) {
            return redirect()->route('geolocale.index')->withError($exception->getMessage());
        }

        return redirect()->route('geolocale.index')->withSuccess(__('GeoLocale Data Imported Successfully.'));
    }
}
