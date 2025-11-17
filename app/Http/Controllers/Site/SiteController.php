<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 08-11-2021
 */

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductDetailResource;
use App\Models\{Brand, Category, CustomField, File, Language, Order, OrderMeta, Product, Review, Search};
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Modules\Blog\Http\Models\{
    Blog
};
use Modules\CMS\Entities\Page as HomePage;
use Modules\CMS\Http\Models\{
    Page
};
use App\Services\Actions\Facades\ProductActionFacade as ProductAction;
use App\Services\SearchService;
use Modules\CMS\Entities\Component;
use Modules\CMS\Service\HomepageService;
use Modules\Coupon\Http\Models\Coupon;

class SiteController extends Controller
{
    /**
     * Homepage
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('landing.new');
    }

    public function allCategoriesAjax(Request $request)
    {
        $query = Category::query();

        $languages = Language::where('status', 'Active')->get()->pluck('short_name')->toArray();

        if ($request->filled('q')) {
            foreach ($languages as $language) {
                $query->orWhere('name->'.$language, 'like', '%'.$request->q.'%');
            }
        }

        return response()->json($query->take(3)->get()->map(function ($category) {
            return [
                'id' => $category->id,
                'text' => $category->name,
            ];
        }));
    }

    /**
     * Product Details
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function productDetails(Request $request)
    {
        $product = ProductAction::execute('getProductWithAttributeAndVariations', $request);

        if (! $product) {
            abort(404);
        }

        $data = (new ProductDetailResource($product))->toArray(null);

        if (
            ! empty($data) && $data['status'] == 'Published' && $product->availability() ||
            ! empty($data) && ! empty($data['vendor_id']) && $data['vendor_id'] == session()->get('vendorId') ||
            ! empty($data) && isset(Auth::user()->id) && isset(Auth::user()->role()->type) && Auth::user()->role()->type == 'admin'
        ) {
            if (isset($product->vendor) && $product->vendor->status != 'Active') {
                abort(404);
            }

            $product->recentView();
            $product->updateViewCount();

            if (isActive('Affiliate')) {
                \Modules\Affiliate\Entities\Referral::userClickUpdate($product->id);
            }

            $this->displayCustomFieldValues();

            return view('site.product.view', compact('data', 'product'));
        }

        abort(404);
    }

    /**
     * Hook to display custom field values on product details page
     *
     * @return void
     */
    private function displayCustomFieldValues()
    {
        $customFields = CustomField::with('meta', 'customFieldValues')
            ->where(['status' => 1, 'field_to' => 'products'])->get();

        foreach ($customFields as $field) {
            if (! $field->metaPluck('product_details')) {
                return;
            }

            $hook = $field->meta->where('key', 'product_details_hook')->first();

            if ($hook) {
                add_action($hook->value, function ($data) use ($field) {
                    $value = $field->customFieldValues()->where('rel_id', $data['product']->id)->first()?->value;
                    $html = $this->parseCustomFieldValue($value, $field);
                    if ($html) {
                        echo "<br><p><strong>$field->name</strong>: $html</p>";
                    }
                });
            }
        }
    }

    /**
     * Parse custom field value
     *
     * @param  string  $value  field value
     * @param  object  $field  custom field object
     * @return string parsed html
     */
    private function parseCustomFieldValue($value, $field)
    {
        if (is_string($value) && (substr($value, 0, 1) === '[') && (substr($value, -1) === ']')) {
            $arrayValue = json_decode($value, true);
            $html = '<ul>';

            foreach ($arrayValue as $element) {
                $html .= "<li>$element</li>";
            }

            $html .= '</ul>';
        } else {
            $html = $value;
        }

        if ($field->type == 'colorpicker') {
            $html = "<span style='background-color: $html; width: 100px; height: 16px; display: inline-block'></span>";
        }

        return $html;
    }

    /**
     * Blog all list
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function allBlogs()
    {
        $data['blogs'] = Blog::whereHas('blogCategory', function ($query) {
            $query->where('status', 'Active');
        })->where(['status' => 'Active'])->archiveFilter(request(['year']))->paginate(10);

        if (empty($data['blogs'])) {
            return redirect()->back();
        }

        return view('site.blog.index', $data);
    }

    /**
     * search blog list
     *
     * @return array
     */
    public function blogSearch(Request $request)
    {
        $value = $request->search;
        $data['blogs'] = Blog::whereHas('blogCategory', function ($query) {
            $query->where('status', 'Active');
        })->WhereLike('title', $value)
            ->orWhereLike('description', $value)->activePost()->paginate(10);

        if (empty($data['blogs'])) {
            return redirect()->back();
        }

        return view('site.blog.index', $data);
    }

    /**
     * Blog Details
     */
    public function blogDetails($slug)
    {
        $query = Blog::with('user:id,name')->whereHas('blogCategory', function ($query) {
            $query->where('status', 'Active');
        })->activePost();
        $data['blog'] = $data['query'] = $query->where('slug', $slug)->first();

        if (empty($data['blog'])) {
            return redirect()->back();
        }

        $blogKey = 'blog_' . $data['blog']->id;
        if (! Session::has($blogKey)) {
            $data['blog']->increment('total_views');
            Session::put($blogKey, 1);
        }

        return view('site.blog.view', $data);
    }

    /**
     * Blog Category
     */
    public function blogCategory($id)
    {
        $data['blogs'] = Blog::whereHas('blogCategory', function ($query) {
            $query->where('status', 'Active');
        })->where(['category_id' => $id, 'status' => 'Active'])->paginate(10);

        if (empty($data['blogs'])) {
            return redirect()->back();
        }

        return view('site.blog.index', $data);
    }

    /**
     * Pages
     */
    public function page($slug)
    {
        $data['page'] = Page::all()->where('slug', $slug)->where('status', 'Active')->first();
        if ($data['page']) {
            if ($data['page']->type == 'home') {
                return view('site.index', compact('slug'));
            }

            return view('site.page.index', $data);
        }

        abort(404);
    }

    /**
     * Review Store
     *
     * @return array
     */
    public function reviewStore(Request $request)
    {
        $response = ['status' => 0, 'message' => __('Oops! Something went wrong, please try again.')];
        $request['user_id'] = Auth::user()->id ?? null;
        if (Review::where('user_id', $request['user_id'])->where('product_id', $request->product_id)->count() > 0) {
            $response['message'] = __('You have already done your review.');

            return $response;
        }

        if (preference('review_left') == 1 && ! auth()->user()->isPurchaseProduct($request->product_id)) {
            $response['message'] = __('To give a review you need to purchase the product first.');

            return $response;
        }

        $request['status'] = 'Active';
        $request['is_public'] = 1;
        $validator = Review::storeValidation($request->all());
        if ($validator->fails()) {
            $response['status'] = 0;
            $response['message'] = $validator->errors()->first();

            return $response;
        }
        $id = (new Review())->store($request->only('comments', 'user_id', 'status', 'is_public', 'rating', 'product_id'));
        if (! empty($id)) {
            $response['status'] = 1;
            $response['message'] = __('Thanks for the review. It will be published soon.');

            return $response;
        }

        return $response;
    }

    /**
     * Review fetch
     *
     * @return render view
     */
    public function fetch(Request $request)
    {
        if ($request->ajax()) {
            $product = Product::find($request->product_id);

            return view('site.product.review', compact('product'))->render();
        }
    }

    /**
     * Edit review
     *
     * @return view
     */
    public function updateReview(Request $request)
    {
        $response = ['status' => 0, 'message' => __('Oops! Something went wrong, please try again.')];

        $validator = Review::userUpdateValidation($request->all());
        if ($validator->fails()) {
            $response['message'] = $validator->errors()->first();

            return $response;
        }
        if ((new Review())->updateReview($request->only('comments', 'rating'), $request->id)) {
            $response['status'] = 1;
            $response['message'] = __('Thanks for the review. It will be published soon.');

            return $response;
        }

        return $response;
    }

    /**
     * delete review image
     *
     * @param  $file
     * @return response
     */
    public function deleteReview(Request $request)
    {
        $fileExplode = explode(DIRECTORY_SEPARATOR, $request->path);
        $fileName = $fileExplode[count($fileExplode) - 2] . DIRECTORY_SEPARATOR . end($fileExplode);
        if (File::where('file_name', $fileName)->delete()) {
            if (isFileExist('/public/uploads/' . $fileName)) {
                \Storage::disk()->delete('/public/uploads/' . $fileName);
            }

            return response()->json('success');
        }

        return response()->json('error');
    }

    /**
     * Review filter
     *
     * @return render view
     */
    public function filterReview(Request $request)
    {
        if ($request->ajax()) {

            $product = Product::find($request->product_id);

            return view('site.product.review', compact('product'))->render();
        }
    }

    /** products by brand
     *
     * @param  $slug
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function brandProducts($id)
    {
        $brand = Brand::getAll()->where('id', $id)->first();
        if (! empty($brand)) {
            $data['brand'] = $brand;

            return view('site.filter.index', $data);
        }

        return redirect()->back();
    }

    /**
     * product search
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function search(Request $request)
    {
        $data['page_title'] = __('Products');

        if (! empty($request->all())) {
            return view('site.filter.index', $data);
        } else {
            return redirect()->back();
        }
    }

    /**
     * get searchable data
     *
     * @return array
     */
    public function getSearchData(Request $request, SearchService $search)
    {
        if (! filled($request->search)) {
            return [
                'status' => 0,
                'message' => __('No Data Found'),
            ];
        }

        $popularCategory = $search->getPopularCategories($request->search);
        $popularCategoryRefactor = [];

        foreach ($popularCategory as $key => $category) {
            $key = checkJsonValidation($key);

            $popularCategoryRefactor[$key] = $category;
        }

        return [
            'status' => 1,
            'searchData' => json_encode([
                'popularSuggestion' => $search->getPopularSuggestion($request->search),
                'popularCategories' => $popularCategoryRefactor,
                'products' => $search->getProducts($request->search),
                'shops' => $search->getShops($request->search),
            ]),
        ];
    }

    /**
     * Product Quick view
     *
     * @return string|void
     */
    public function quickView(Request $request, $code)
    {
        $request['code'] = $request->route('id'); 
        $product = ProductAction::execute('getProductWithAttributeAndVariations', $request);

        if (! $product) {
            abort(404);
        }

        $data = (new ProductDetailResource($product))->toArray(null);
        $data['quickViewProduct'] = $product;

        if ($request->ajax()) {
            return view('site.layouts.includes.product-view', $data)->render();
        }

        abort(404);
    }

    /**
     * Coupon
     *
     * @return render view
     */
    public function coupon()
    {
        $data = Coupon::getCoupons(true, true);

        return view('site.coupon', $data);
    }

    public function getComponentProduct(Request $request)
    {
        if (! $request->get('component')) {
            return $this->notFoundResponse([], __('Invalid component'));
        }
        $data['displayPrice'] = preference('display_price_in_shop');
        $data['component'] = Component::whereId($request->get('component'))
            ->with(['layout:id,file', 'properties', 'page:id,layout'])->first();
        $data['homeService'] = new HomepageService();

        // $html = $data;
        $html = view('cms::templates.blocks.sub.' . $data['component']->layout->file . '-data', $data)->render();

        return $this->successResponse(['html' => $html]);
    }

    /**
     * get shipping
     *
     * @return array
     */
    public function getShipping(Request $request)
    {
        $address = [
            'country' => $request->country,
            'state' => $request->state,
            'city' => $request->city,
            'post_code' => null,
        ];

        return Product::getMaxShipping($request->product_id, $address);
    }

    /**
     * download file
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download(Request $request)
    {
        try {
            \DB::beginTransaction();
            $fileArray = explode(',', $request->file);
            $isDownloadable = false;
            $fileName = \Str::random(10);
            $orderMeta = OrderMeta::where('order_id', $fileArray[1] ?? null)->where('key', 'download_data')->first();

            if (! empty($orderMeta)) {
                $downloadArray = [];

                foreach ($orderMeta->value as $download) {
                    $downloadTimes = $download['download_times'];

                    if (isset($fileArray[0]) && $download['id'] == $fileArray[0] && $download['is_accessible'] == 1) {
                        if ($orderMeta->order->checkValidFile($download)) {
                            $downloadTimes  = $downloadTimes + 1;
                            $isDownloadable = true;
                            $fileName = $download['f_name'];
                        }
                    }

                    $downloadArray[] = [
                        'id' => $download['id'],
                        'download_limit' => $download['download_limit'],
                        'download_expiry' => $download['download_expiry'],
                        'link' => $download['link'],
                        'download_times' => $downloadTimes,
                        'is_accessible' => $download['is_accessible'],
                        'vendor_id' => $download['vendor_id'],
                        'name' => $download['name'],
                        'f_name' => $download['f_name'],
                    ];
                }

                if ($isDownloadable) {
                    OrderMeta::updateOrCreate(
                        ['order_id' => $fileArray[1], 'key' => 'download_data'],
                        ['type' => 'string', 'value' => $downloadArray]
                    );
                    $link = Crypt::decrypt($request->link);
                    $ext = pathinfo($link, PATHINFO_EXTENSION);
                    $fileName = str_contains($fileName, '.') ? substr($fileName, 0, strpos($fileName, '.')) : $fileName;
                    $fileName =  $fileName . '.' . $ext;
                    $tempImage = tempnam(sys_get_temp_dir(), $fileName);
                    $headers = @get_headers($link);

                    if ($headers && strpos($headers[0], '200') === false) {
                        \DB::rollBack();

                        return back()->withErrors(['error' => __('File not found.')]);
                    }

                    copy($link, $tempImage);
                    \DB::commit();

                    return response()->download($tempImage, $fileName);
                }
            }
        } catch (DecryptException $e) {
            \DB::rollBack();
            abort(404);
        }

        abort(404);
    }

    /**
     * All Categories
     *
     * @return render view
     */
    public function allCategories()
    {
        $homeService = new \Modules\CMS\Service\HomepageService();
        $data['page'] = $homeService->home();

        $data['categories'] = Category::whereNull('parent_id')->where('is_global', 1)->with('availableMainCategory')->get();

        return view('site.categories', $data);
    }

    /**
     * order payment from payment link
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|void
     */
    public function orderPayment($reference)
    {
        $orderReference = techDecrypt($reference);
        $order = Order::where('reference', $orderReference)->first();

        if (! empty($order) && $order->isPayable()) {
            return redirect(route('site.order.payment.guest', ['reference' => $orderReference]));
        }

        abort(404);
    }

    /**
     * load web categories
     *
     * @return render view
     */
    public function loadWebCategories()
    {
        return view('site.layouts.includes.web-categories')->render();
    }

    /**
     * load mobile categories
     *
     * @return render view
     */
    public function loadMobileCategories()
    {
        return view('site.layouts.includes.mobile-categories')->render();
    }

    /**
     * load login modal
     *
     * @return render view
     */
    public function loadLoginModal()
    {
        return view('site.layouts.includes.login-modal')->render();
    }

    /**
     * load same shop
     *
     * @return render view
     */
    public function loadSameShop($id)
    {
        $product = Product::find($id);
        $sameShop = \App\Models\Product::where('vendor_id', $product->vendor_id)->where('id', '!=', $product->id)->isAvailable()->notVariation()->published()->limit(6)->get();

        return view('site.layouts.section.product-details.same-shop', compact('product', 'sameShop'))->render();
    }

    /**
     * load related products
     *
     * @return render view
     */
    public function loadRelatedProducts($id)
    {
        $product = Product::find($id);
        $relatedIds = $product->getRelatedProductIds();
        $relatedProducts = \App\Models\Product::whereIn('id', $relatedIds)->isAvailable()->notVariation()->published()->limit(3)->get();

        return view('site.layouts.section.product-details.related-products', compact('product', 'relatedIds', 'relatedProducts'))->render();
    }

    /**
     * load upsale products
     *
     * @return render view
     */
    public function loadUpSaleProducts($id)
    {
        $product = Product::find($id);
        $relatedIds = $product->getUpSaleIds();
        $upSaleProducts = \App\Models\Product::whereIn('id', $relatedIds)->isAvailable()->notVariation()->published()->limit(3)->get();

        return view('site.layouts.section.product-details.upsale-products', compact('product', 'relatedIds', 'upSaleProducts'))->render();
    }
}
