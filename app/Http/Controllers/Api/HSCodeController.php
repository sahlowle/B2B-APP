<?php

namespace App\Http\Controllers\Api;

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 04-04-2022
 */
use App\Http\Controllers\Controller;
use App\Http\Resources\VendorResource;
use App\Models\Category;
use App\Models\Quotation;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\GeoLocale\Entities\Country;

class HSCodeController extends Controller
{
    /**
     * Country List
     *
     * @return json $data
     */
    public function index(Request $request)
    {
        $request->validate([
            'hs_code' => ['required','string','max:20']
        ]);

        $data = Category::select('id', 'name','hs_code')
            ->active()
            ->where('hs_code', 'LIKE', "%$request->hs_code%")
            ->take(5)->get();

        return $this->response($data, 200,'HS Code List');
    }


    public function getFactories(Request $request)
    {
        $request->validate([
            'hs_code' => ['required','string','max:20','exists:categories,hs_code'],
            'page' => ['required','numeric','min:1'],
        ]);

        $category = Category::select('id', 'name','hs_code')
            ->active()
            ->where('hs_code', $request->hs_code)->firstOrFail();

        $vendors = \App\Models\Vendor::with(['shop'])
            ->where('status', 'Active')
            ->whereHas('shop')
            ->whereHas('categories', function ($query) use ($category) {
                $query->where('category_id', $category->id);
            })
            ->paginate(10);

        $vendors = VendorResource::collection($vendors);

        return $this->paginatedResponse($vendors, 'Factories List');
    }

    public function storeRFQs(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|max:100',
            'last_name' => 'required',
            'country_name' => 'required|exists:geolocale_countries,name',
            'phone_number' => 'required|min:9|max:15',
            'email' => 'required|email:rfc,dns',
            'category_id' => 'required|exists:categories,id',
            'notes' => 'nullable',
            'pdf_file' => 'required|file|mimes:pdf|max:10240',
        ]);
  
        DB::transaction(function () use ($request, $data) {

            $quotation = Quotation::create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'country_id' => Country::where('name', $data['country_name'])->first()->id,
                'phone_number' => $data['phone_number'],
                'email' => $data['email'],
                'category_id' => $data['category_id'],
                'notes' => $request->notes,
                'pdf_file' => null,
            ]);

            if ($request->hasFile('pdf_file')) {
                $quotation->uploadFiles(['isUploaded' => false, 'isSavedInObjectFiles' => true, 'isOriginalNameRequired' => true, 'thumbnail' => false]);
                
                $quotation->pdf_file = $quotation->fileUrl();
                $quotation->save();
            }

        });

        return $this->response( message:'RFQs created successfully');
    }
}
