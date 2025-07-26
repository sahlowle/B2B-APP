<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 06-05-2024
 */

namespace App\Http\Controllers;

use App\Models\Preference;
use Illuminate\Http\Request;

class AddressSettingController extends Controller
{
    /**
     * Show the Address Setting page.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        if ($request->isMethod('get')) {
            $data['list_menu'] = 'address';

            return view('admin.address_settings.index', $data);
        }

        $keys = [
            'address_first_name_visible',
            'address_first_name_required',
            'address_last_name_visible',
            'address_last_name_required',
            'address_company_name_visible',
            'address_company_name_required',
            'address_phone_visible',
            'address_phone_required',
            'address_email_address_visible',
            'address_email_address_required',
            'address_street_address_1_visible',
            'address_street_address_1_required',
            'address_street_address_2_visible',
            'address_street_address_2_required',
            'address_country_visible',
            'address_country_required',
            'address_state_visible',
            'address_state_required',
            'address_city_visible',
            'address_city_required',
            'address_zip_visible',
            'address_zip_required',
            'address_type_of_place_visible',
            'address_type_of_place_required',
        ];

        $filteredData = $request->only($keys);

        $formatData = [];

        foreach ($filteredData as $key => $value) {
            $formatData[] = [
                'category' => 'address',
                'field' => $key,
                'value' => $value,
            ];
        }

        Preference::upsert($formatData, ['field', 'category']);
        Preference::forgetCache();

        return back()->withSuccess(__('Address Settings updated successfully.'));
    }
}
