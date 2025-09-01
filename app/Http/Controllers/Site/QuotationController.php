<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Modules\GeoLocale\Entities\Country;

class QuotationController extends Controller
{
    public function create()
    {
        $data['categories'] = Category::parents();

        // return dd(Country::first());

        $countries = Country::orderBy('name', 'asc')->get();
        
        $data['countries'] = $countries;
        $data['calling_code'] = $countries->pluck('callingcode');

        return view('site.quotations.create', $data);
    }

    public function store(Request $request)
    {

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'country' => 'required',
            'country_code' => 'required',
            'phone_number' => 'required',
            'email' => 'required|email',
            'category' => 'required',
            'notes' => 'nullable',
            'pdf_file' => 'required|file|mimes:pdf|max:10240',
        ]);

        // $quotation = Quotation::create($request->all());

        return redirect()->route('site.index')->with('success', __('Quotation submitted successfully'));
    }
}
