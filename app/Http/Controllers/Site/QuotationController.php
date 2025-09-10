<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Quotation;
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
        $data = $request->validate([
            'first_name' => 'required|max:100',
            'last_name' => 'required',
            'country' => 'required|exists:geolocale_countries,id',
            'phone_number' => 'required|min:9|max:15',
            'email' => 'required|email',
            'category' => 'required|exists:categories,id',
            'notes' => 'nullable',
            'pdf_file' => 'required|file|mimes:pdf|max:10240',
        ]);

        Quotation::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'country_id' => $data['country'],
            'phone_number' => $data['phone_number'],
            'email' => $data['email'],
            'category_id' => $data['category'],
            'notes' => $data['notes'],
            'pdf_file' => $data['pdf_file'],
        ]);

        return redirect()->route('site.index')->with('success', __('Quotation submitted successfully'));
    }
}
