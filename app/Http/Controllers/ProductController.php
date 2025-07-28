<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 * @contributor Md Abdur Rahaman Zihad <[zihad.techvill@gmail.com]>
 *
 * @created 02-10-2021
 *
 * @updated 15-06-2022
 */

namespace App\Http\Controllers;

use App\DataTables\ProductDataTable;
use App\Http\Resources\AjaxSelectSearchResource;
use App\Http\Resources\ProductDetailResource;
use App\Models\{Attribute, Brand, Category, Language, Product, ProductCategory, ProductMeta, Tag, Vendor};
use App\Services\Actions\Facades\ProductActionFacade as ProductAction;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;
use Modules\Shipping\Entities\ShippingClass;
use Modules\Tax\Entities\TaxClass;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Product List
     *
     * @return mixed
     */
    public function index(ProductDataTable $dataTable)
    {
        if ($this->ncpc()) {
            Session::flush();

            return view('errors.installer-error', ['message' => __('This product is facing license validation issue.') . '<br>' . __('Please verify your purchase code from :x.', ['x' => '<a class="warning" href="' . route('purchase-code-check', ['bypass' => 'purchase_code']) . '">' . __('here') . '</a>'])]);
        }

        $data['productBrands'] = Brand::whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('products')
                ->whereColumn('products.brand_id', 'brands.id');
        })->select('id', 'name')->get();

        $data['productCategories'] = Category::whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('product_categories')
                ->whereColumn('product_categories.category_id', 'categories.id');
        })->select('id', 'name')->get();

        $data['vendors'] = Vendor::whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('products')
                ->whereColumn('products.vendor_id', 'vendors.id');
        })->select('id', 'name')->get();

        return $dataTable->render('admin.products.index', $data);
    }

    public function createProduct(Request $request)
    {
        if ($request->isMethod('get')) {
            $data['brands'] = Brand::getAll()->where('status', 'Active');
            $data['vendors'] = Vendor::getAll()->where('status', 'Active');
            $data['categories'] = Category::getAll()->whereNull('parent_id')->where('status', 'Active');
            $data['attributeList'] = Attribute::getAll()->unique('name');
            $data['languages'] = Language::getAll()->where('status', 'Active');
            if (isActive('Shipping')) {
                $data['shippings'] = ShippingClass::getAll();
            }
            $data['taxes'] = TaxClass::getAll();
            $data['tags'] = [];

            return view('admin.products.product', $data);
        }

        $product = Product::create([
            'name' => isset($request->name) ? [
                request()->input('lang', config('app.locale')) => $request->name,
            ] : [
                request()->input('lang', config('app.locale')) => 'Untitled product',
            ],
            'status' => 'Draft',
        ]);
        (new ProductCategory())->store([
            'product_id' => $product->id,
            'category_id' => 1,
        ]);
        $request->request->add([
            'permalink' => $product->getTranslated('name', request()->input('lang', config('app.locale'))),
            'code' => $product->code,
        ]);
        $response = ProductAction::execute('updatePermalink', $request);

        if ($request->action) {
            $response = ProductAction::execute($request->action, $request);
            if (! $response instanceof JsonResponse) {
                return $response;
            }
        }

        $data = json_decode($response->getContent(), true);
        $product = Product::where('id', $product->id)->first();

        $data['response']['url'] = route('products.edit-action', ['code' => $product->code]);
        $data['response']['permalink'] = $product->getTranslated('slug', request()->input('lang', config('app.locale')));
        $data['response']['previewUrl'] = route('site.productDetails', ['slug' => $product->getTranslated('slug', request()->input('lang', config('app.locale')))]);
        $data['response']['name'] = $product->getTranslated('name', request()->input('lang', config('app.locale')));

        $response->setContent(json_encode($data));

        return $response;
    }

    public function editProductAction(Request $request)
    {
        /**
         * Action names
         * 1. update_product_basic_info
         * 2. add_new_attribute
         * 3. get_attributes
         * 4. add_product_variation
         * 5. save-_product_variation
         * 6. get_attribute_form
         * 7. load_product_variations
         * 8. load_attribute_options
         * 9. update_tags
         */
        if (! $request->action) {
            return $this->unprocessableResponse([], __('Action name required.'));
        }

        return ProductAction::execute($request->action, $request);
    }

    /**
     * Product edit
     */
    public function edit(Request $request)
    {

        $product = ProductAction::editModeOn()->execute('getProductWithAttributeAndVariations', $request);

        if ($product instanceof JsonResponse || $product == null) {
            $this->setSessionValue(['status' => 'fail', 'message' => __('Product not found.')]);

            return redirect()->route('product.index');
        }

        $upsaleId = $product->getUpSaleIds();
        $crossSaleId = $product->getCrossSaleIds();
        $relatedProductIds = $product->getRelatedProductIds();
        $groupedId = $product->getGroupedProductIds();

        $relatedIds = array_unique(array_merge(
            $upsaleId,
            $crossSaleId,
            $relatedProductIds,
            $groupedId
        ));

        $productsCollection = Product::whereIn('id', $relatedIds)->get();
        $data['productUpsells'] = $productsCollection->whereIn('id', $upsaleId)->pluck('name', 'id')->toArray();
        $data['productCrossSells'] = $productsCollection->whereIn('id', $crossSaleId)->pluck('name', 'id')->toArray();
        $data['productRelatedProducts'] = $productsCollection->whereIn('id', $relatedProductIds)->pluck('name', 'id')->toArray();
        $data['groupedProducts'] = $productsCollection->whereIn('id', $groupedId)->pluck('name', 'id')->toArray();
        $data['attributeList'] = Attribute::getAll()->unique('name');
        $data['languages'] = Language::getAll()->where('status', 'Active');

        $data['product'] = $product;

        // Old codes
        $data['vendors'] = Vendor::getAll()->where('status', 'Active');
        $data['taxes'] = TaxClass::getAll();

        $data['brands'] = Brand::getAll()->where('status', 'Active');
        if (isActive('Shipping')) {
            $data['shippings'] = ShippingClass::getAll();
        }

        // product tag
        $data['tags'] = $product->tags()->pluck('name', 'id')->toArray();

        // Category options
        $category = Category::getAll()->where('id', optional($product->productCategory)->category_id)->first();

        $parent[] = ! empty($category) ? $category->name : null;

        $parentId[] = ! empty($category) ? $category->id : null;

        while (1) {
            if (! empty($category->category)) {
                $category = $category->category;
                $parent[] = $category->name;
                $parentId[] = $category->id;
            } else {
                break;
            }
        }

        if (is_array($parent) && count($parent) > 0) {
            $parent = array_reverse($parent);
            $parentId = array_reverse($parentId);
            $parent = implode(' / ', $parent);
        }

        $data['parentCategory'] = $parent;
        $data['parentCategoryId'] = $parentId;
        $data['categories'] = Category::getAll()->whereNull('parent_id')->where('status', 'Active');

        return view('admin.products.product', $data);
    }

    /**
     * Find products with search key
     *
     * @return json
     */
    public function findProductAjaxQuery(Request $request)
    {
        $qString = $request->q;

        $productCode = $request->code;

        $result = Product::select('id', 'name')
            ->where(
                function ($query) use ($qString) {
                    $query->whereBeginsWith('name', $qString)
                        ->orWhereLike('name', $qString)
                        ->orWhereBeginsWith('slug', $qString)
                        ->orWhereLike('slug', $qString);
                }
            )
            ->published()
            ->isAvailable()
            ->notVariation()
            ->limit(Product::getLimit());

        if ($productCode) {
            $result->where('code', '!=', $productCode);
        }

        if (isset($request->vendor_id) && ! empty($request->vendor_id)) {
            $result->where('vendor_id', $request->vendor_id);
        }
        $result = $result->get();

        return AjaxSelectSearchResource::collection($result);
    }

    public function findTagsAjaxQuery(Request $request)
    {
        $result = Tag::whereLike('name', $request->q)->limit(Product::getLimit())->get();

        return AjaxSelectSearchResource::collection($result);
    }

    public function productJson(Request $request)
    {
        $product = ProductAction::execute('getProductWithAttributeAndVariations', $request);

        return new ProductDetailResource($product);
    }

    public function deleteProduct(Request $request)
    {
        $product  = Product::whereCode($request->code)->first();
        if (! $product) {
            Session::flash('fail', __('Something went wrong. Product not found.'));

            return back();
        }
        $product->delete();
        (new ProductCategory())->remove($product->id);
        Session::flash('success', __('Product has been trashed.'));

        return redirect()->route('product.index');
    }

    public function forceDeleteProduct(Request $request)
    {
        $product  = Product::withTrashed()->whereCode($request->code)->first();
        if (! $product) {
            Session::flash('fail', __('Something went wrong. Product not found.'));

            return back();
        }
        $productIds = Product::withTrashed()->where('parent_id', $product->id)->get()->pluck('id')->toArray();
        if (count($productIds) > 0) {
            Product::withTrashed()->whereIn('id', $productIds)->delete();
        }
        array_push($productIds, $product->id);
        $product->forceDelete();
        ProductMeta::whereIn('product_id', $productIds)->delete();
        Session::flash('success', __('Product deleted permanently.'));

        return redirect()->route('product.index');
    }

    public function ncpc()
    {
        return false;
        if (! g_e_v()) {
            return true;
        }
        if (! g_c_v()) {
            try {
                $d_ = g_d();
                $e_ = g_e_v();
                $e_ = explode('.', $e_);
                $c_ = md5($d_ . $e_[1]);
                if ($e_[0] == $c_) {
                    p_c_v();

                    return false;
                }

                return true;
            } catch (\Exception $e) {
                return true;
            }
        }

        return false;
    }

    /**
     * find downloadable products
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function findDownloadProducts(Request $request)
    {
        $products = Product::published()->isAvailable()->whereLike('name', $request->q)->whereHas('metadata', function ($query) {
            $query->where('key', 'meta_downloadable')->where('value', 1);
        })->limit(10)->get();

        return AjaxSelectSearchResource::collection($products);
    }

    /**
     * duplicate product
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function duplicate(Request $request)
    {
        $rootProduct = Product::where('code', $request->code)->first();

        if (! empty($rootProduct)) {

            try {
                DB::beginTransaction();

                session()->put('root_product', $rootProduct);

                $product = Product::create([
                    'name' => $rootProduct->name,
                    'sku' => $rootProduct->sku,
                    'status' => $rootProduct->status,
                    'description' => $rootProduct->description,
                    'summary' => $rootProduct->summary,
                    'vendor_id' => $rootProduct->vendor_id,
                    'shop_id' => $rootProduct->shop_id,
                    'brand_id' => $rootProduct->brand_id,
                    'regular_price' => $rootProduct->regular_price,
                    'sale_price' => $rootProduct->sale_price,
                    'sale_from' => $rootProduct->sale_from,
                    'sale_to' => $rootProduct->sale_to,
                    'available_from' => $rootProduct->available_from,
                    'available_to' => $rootProduct->available_to,
                    'featured' => $rootProduct->featured,
                    'manage_stocks' => $rootProduct->manage_stocks ?? 0,
                    'total_stocks' => $rootProduct->total_stocks ?? 0,
                    'type' => $rootProduct->type,
                    'menu_order' => $rootProduct->menu_order,
                ]);

                (new ProductCategory())->store([
                    'product_id' => $product->id,
                    'category_id' => $rootProduct->productCategory->category_id,
                ]);

                $request['permalink'] = $product->name;
                $request['code'] = $product->code;

                ProductAction::execute('updatePermalink', $request);

                ProductAction::execute('duplicateProduct', $request);
                DB::commit();
                Session::flash('success', __('Product has been duplicated successfully.'));

                return back();
            } catch (Exception $e) {
                DB::rollBack();
                Session::flash('fail', $e->getMessage());

                return back();
            }
        }

        Session::flash('fail', __('Something went wrong. Product not found.'));

        return back();

    }
}
