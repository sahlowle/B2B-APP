<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 14-12-2021
 */

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Exception;
use App\Filters\ProductSearchFilter;
use App\Filters\ProductVariationSearchFilter;
use App\Http\Resources\{
    ProductFilterResource,
    ProductSearchResource
};
use App\Models\{Product, Search, UserSearch};

class ProductController extends Controller
{
    /**
     * Search Product
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function search(Request $request)
    {
        if (! isset($request->from) || $request->from != 'web') {
            abort(404);
        }

        $rowPerPage = isset($request->showing) && ! empty($request->showing) && is_numeric($request->showing) ? $request->showing : 12;

        $products = Product::query();

        if (isset($request->related_ids)) {
            $decodeRelatedIds = json_decode(urldecode($request->related_ids));

            if (is_array($decodeRelatedIds) && count($decodeRelatedIds) > 0) {
                $products = $products->whereIn('id', $decodeRelatedIds);
            }
        }

        $products = $products->filter(ProductSearchFilter::class);

        if (isset($request->price_range) || isset($request->b2b)) {
            $variationProducts = Product::where('type', 'Variation')->published()->whereHas('parentDetail', function ($q) {
                return $q->published();
            })->with(['category', 'brand']);

            $variationProducts = $variationProducts->filter(ProductVariationSearchFilter::class);
            $variationProducts = $variationProducts->get()->pluck('parent_id')->toArray();

            $products->orWhereIn('id', $variationProducts);
        }
        $products->whereNull('parent_id');
        $products->isActiveVendor();
        $products->isAvailable();
        $productResource = new ProductFilterResource($products);
        $userId = null;

        if (isset(auth()->guard('api')->user()->id)) {
            $userId = auth()->guard('api')->user()->id;
        } elseif (isset($request->user_id)) {
            $userId = $request->user_id;
        }
        $request['user_id'] = $userId;

        if (isset($request->keyword) && ! empty($request->keyword)) {
            try {
                DB::beginTransaction();
                $searchId = (new Search())->store(['name' => $request->keyword]);
                (new UserSearch())->store(['search_id' => $searchId, 'user_id' => $userId != 0 ? $userId : null, 'browser_agent' => getUniqueAddress()]);
                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();
            }
        }

        $response = $this->response([
            'data' => ProductSearchResource::collection($productResource->query()->paginate($rowPerPage)),
            'filterable' => $productResource->getFilters(),
            'filter_applied' => $productResource->getAppliedFilters(),
            'category_path' => $productResource->categoryPath,
            'pagination' => $this->toArray($productResource->query()->paginate($rowPerPage)),
        ]);

        $data['response'] = $response->getData();

        return view('site.filter.result', $data);
    }
}
