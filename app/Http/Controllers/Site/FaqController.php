<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class FaqController extends Controller
{
    public function index(): View
    {

        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->longText('question');
            $table->longText('answer');
            $table->integer('order')->default(0);
            $table->timestamps();
        });

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
