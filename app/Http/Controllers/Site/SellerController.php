<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 19-01-2022
 */

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    /**
     * Shop
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index($alias = null)
    {
        $data['shop'] = \Modules\Shop\Http\Models\Shop::firstWhere('alias', $alias);

        if (is_null($alias) || ! isActive('Shop') || empty($data['shop']) || ! Vendor::isVendorExist($data['shop']->vendor_id)
            || (request('homepage') && (! auth()->user() || (! isSuperAdmin())
            || (auth()->user()->role()->type == 'vendor' && auth()->user()->vendor()->vendor_id != $data['shop']->vendor_id)))) {
            abort(404);
        }

        return view('site.shop.index', $data);
    }

    public function vendorProfile($alias = null)
    {
        $data['shop'] = \Modules\Shop\Http\Models\Shop::firstWhere('alias', $alias);

        if (is_null($alias) || ! isActive('Shop') || empty($data['shop']) || ! Vendor::isVendorExist($data['shop']->vendor_id)) {
            abort(404);
        }

        return view('site.shop.vendor-profile', $data);
    }

    /**
     * Review filter
     *
     * @return render view
     */
    public function searchReview(Request $request)
    {
        if ($request->ajax()) {
            $html = view('site.shop.review')->render();

            return $this->successResponse(['data' => $html]);
        }
        abort(403);
    }
}
