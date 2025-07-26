<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Review;

class ReviewController extends Controller
{
    /**
     * Review
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('site.myaccount.review');
    }

    /**
     * Delete
     *
     * @param  int  $id
     * @return \Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $response = $this->messageArray(__('Invalid Request'), 'fail');
        $result = $this->checkExistence($id, 'reviews');
        if ($result['status'] === true) {
            $response = (new Review())->remove($id);
        } else {
            $response['message'] = $result['message'];
        }
        $this->setSessionValue($response);

        return redirect()->back();
    }
}
