<?php

namespace App\Http\Controllers\Api;

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 04-04-2022
 */
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\GeoLocale\Entities\Country;

class CountryController extends Controller
{
    /**
     * Country List
     *
     * @return json $data
     */
    public function index(Request $request)
    {
        return $this->response(Country::get());
    }
}
