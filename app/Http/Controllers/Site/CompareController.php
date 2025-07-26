<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Compare;

class CompareController extends Controller
{
    /**
     * compare list
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('site.compare');
    }

    /**
     * compare store
     *
     * @return array
     */
    public function store(Request $request)
    {
        $response['status'] = 0;
        $response['message'] = __('Failed to added in compare list! try again.');
        $product = Product::where('id', $request->product_id)->first();
        if (! empty($product)) {
            $add = Compare::add($request->product_id);
            if ($add) {
                $response = [
                    'status' => 1,
                    'message' => __('Product successfully added in compare list.'),
                    'totalProduct' => Compare::totalProduct(),
                ];
            } else {
                $response = [
                    'status' => 0,
                    'message' => __('Already added. Try another one.'),
                    'totalProduct' => Compare::totalProduct(),
                ];
            }
        }

        return $response;
    }

    /**
     * Compare Destroy
     *
     * @return array
     */
    public function destroy(Request $request)
    {
        $response['status'] = 0;
        $response['message'] = __('Something went wrong, please try again.');
        if (Compare::destroy($request->product_id)) {
            $response = [
                'status' => 1,
                'message' => __('Deleted Successfully'),
                'totalProduct' => Compare::totalProduct(),
            ];
        }

        return $response;
    }
}
