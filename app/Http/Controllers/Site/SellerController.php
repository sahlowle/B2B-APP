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

    public function index()
    {
        $vendors = \App\Models\Vendor::with(['shop', 'reviews'])
            ->where('status', 'Active')
            ->whereHas('shop')
            ->paginate(24);
            
        // Calculate stats for the hero section
        $totalShops = $vendors->total();
        $totalProducts = \App\Models\Product::where('status', 'Active')->count();
        $avgRating = \App\Models\Review::avg('rating') ?? 0;

        $main_title = trans('Saudi Factories');
        $title = trans('Exports Valley') . ' ' . trans('Saudi Exports Services');
        $seo = [
            'main_title' => $main_title,
            'title' => $title,
            'meta_title' => $main_title .' '.$title,
            'meta_description' => trans('All Saudi factory products available at Exports Valley are included in the Saudi Exports Directory, offering ready-made export solutions, reliable quality, and opportunities to access diverse global markets.'),
            'image' => asset('public/frontend/img/logo.png'),
       ];

        return view('site.shop.all-shops', compact('vendors', 'totalShops', 'totalProducts', 'avgRating', 'seo'));
    }

    /**
     * Shop
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function showVendor(Request $request, $alias = null)
    {
        $alias = $request->route('alias');
        $shop = \Modules\Shop\Http\Models\Shop::firstWhere('alias', $alias);

        $data['shop'] = $shop;

        if (is_null($alias) || ! isActive('Shop') || empty($data['shop']) || ! Vendor::isVendorExist($data['shop']->vendor_id)
            || (request('homepage') && (! auth()->user() || (! isSuperAdmin())
            || (auth()->user()->role()->type == 'vendor' && auth()->user()->vendor()->vendor_id != $data['shop']->vendor_id)))) {
            abort(404);
        }

        // $shop->visit();

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
