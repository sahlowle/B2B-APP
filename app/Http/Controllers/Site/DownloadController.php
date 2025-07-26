<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;

class DownloadController extends Controller
{
    /**
     * view downloadable orders
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('site.myaccount.download');
    }
}
