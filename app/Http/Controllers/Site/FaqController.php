<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Contracts\View\View;
use Spatie\SchemaOrg\Schema;

class FaqController extends Controller
{
    public function index(): View
    {

        $faqs = Faq::query()
            ->paginate(24);

            $data['seo'] = [
            'title' => trans('Frequently Asked Questions') . ' - ' . trans('Exports Valley') . ' ' . trans('Saudi Exports'),
            'meta_title' => trans('Frequently Asked Questions') . ' - ' . trans('Exports Valley') . '' . trans('Saudi Exports'),
            'meta_description' => trans("Frequently Asked Questions about Exports Valley"),
            'image' => asset('public/frontend/img/logo.png'),
       ];

        return view('site.faqs.index', compact('faqs'));
    }
}
