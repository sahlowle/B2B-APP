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
use App\Http\Resources\VendorResource;
use App\Models\Category;
use App\Models\Vendor;
use Illuminate\Http\Request;

class HSCodeController extends Controller
{
    /**
     * Country List
     *
     * @return json $data
     */
    public function index(Request $request)
    {
        $request->validate([
            'hs_code' => ['required','string','max:20'],
        ]);

        $data = Category::select('id', 'name','hs_code')
            ->active()
            ->where('hs_code', 'LIKE', "%$request->hs_code%")
            ->take(5)->get();

        return $this->response($data, 200,'HS Code List');
    }


    public function getFactories(Request $request)
    {
        $request->validate([
            'hs_code' => ['required','string','max:20','exists:categories,hs_code'],
        ]);

        $category = Category::select('id', 'name','hs_code')
            ->active()
            ->where('hs_code', $request->hs_code)->firstOrFail();

        $vendors = \App\Models\Vendor::with(['shop'])
            ->where('status', 'Active')
            ->whereHas('shop')
            ->whereHas('categories', function ($query) use ($category) {
                $query->where('category_id', $category->id);
            })
            ->paginate(10);

        $vendors = VendorResource::collection($vendors);

        return $this->paginatedResponse($vendors, 'Factories List');
    }
}
