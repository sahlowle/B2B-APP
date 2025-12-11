<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Quotation;
use Illuminate\Http\Request;
use Modules\GeoLocale\Entities\Country;
use App\Models\File;
use App\Models\Vendor;
use App\Models\VendorCategory;
use App\Traits\HasCrmForm;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class QuotationController extends Controller
{

    use HasCrmForm;
    
    public function create()
    {
        $data['categories'] = Category::parents();

        // return dd(Country::first());

        $countries = Country::orderBy('name', 'asc')->get();
        
        $data['countries'] = $countries;
        $data['calling_code'] = $countries->pluck('callingcode');

        $data['seo'] = [
            'title' => trans('Create RFQs') . ' - ' . trans('Exports Valley') . ' ' . trans('Saudi Exports'),
            'meta_title' => trans('Create RFQs') . ' - ' . trans('Exports Valley') . '' . trans('Saudi Exports'),
            'meta_description' => trans("Create a price quote through Exports Valley to get reliable export offers from Saudi Arabia, connect with suppliers, compare prices, and start your journey to global markets."),
            'image' => asset('public/frontend/img/logo.png'),
       ];

        return view('site.quotations.create', $data);
    }

    public function store(Request $request)
    { 
        $data = $request->validate([
            'first_name' => 'required|max:100',
            'last_name' => 'required',
            'country' => 'required|exists:geolocale_countries,id',
            'phone_number' => 'required|min:9|max:15',
            'email' => 'required|email:rfc,dns',
            'category' => 'required|exists:categories,id',
            'notes' => 'nullable',
            'pdf_file' => 'required|file|mimes:pdf|max:10240',
        ]);
  
        $quotation = DB::transaction(function () use ($request, $data) {

            $quotation = Quotation::create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'country_id' => $data['country'],
                'phone_number' => $data['phone_number'],
                'email' => $data['email'],
                'category_id' => $data['category'],
                'notes' => $data['notes'],
                'pdf_file' => null,
            ]);

            if ($request->hasFile('pdf_file')) {
                $quotation->uploadFiles(['isUploaded' => false, 'isSavedInObjectFiles' => true, 'isOriginalNameRequired' => true, 'thumbnail' => false]);
                
                $quotation->pdf_file = $quotation->fileUrl();
                $quotation->save();
            }

            return $quotation;
        });


        $data['country'] = Country::find($data['country'])?->name;
        $data['category'] = Category::find($data['category'])?->hs_code;
        $data['pdf_file'] = $quotation->pdf_file;


        defer(function () use ($data,$quotation) {
            // run task in background
            $this->sendToForm('rfq', $data);
            $this->sendRfqToFactories($quotation);
        });
        
        

        return redirect()->route('site.index')->with('success', __('Quotation submitted successfully'));
    }

    public function storePdfFile(UploadedFile $file, $quotationId)
    {
        $path = createDirectory('public/uploads/quotations');

        $fileId = (new File())->store([$file], $path, 'Quotation', $quotationId, ['isUploaded' => false, 'isOriginalNameRequired' => true]);

        return $fileId[0];
    }


        public function sendRfqToFactories(Quotation $quotation)
        {
            $baseData = [
                'rfq_id' => $quotation->id,
                'hs_code' => $quotation->category->hs_code,
            ];

            Vendor::query()
                ->select('id','name','email','phone','status')
                ->where('status','Active')
                ->chunk(50, function ($vendors) use ($baseData) {

                    $rfq_with_factories_data = array_merge($baseData, [
                        'factories' => $vendors
                    ]);

                    $rfq_distributed_data = array_merge($baseData, [
                        'emails' => $vendors->pluck('email')
                    ]);

                    $this->sendToForm('rfq_with_factories',$rfq_with_factories_data);
                    $this->sendToForm('rfq_distributed',$rfq_distributed_data);
                });

            // VendorCategory::query()->whereRelation('vendor','status','Active')
            //     ->with('vendor:id,name,email,phone') // Only load needed fields
            //     ->where('category_id', $quotation->category_id)
            //     ->chunk(50, function ($vendorCategories) use ($baseData) {

            //         $rfq_with_factories_data = array_merge($baseData, [
            //             'factories' => $vendorCategories->pluck('vendor')
            //         ]);

            //         $rfq_distributed_data = array_merge($baseData, [
            //             'emails' => $vendorCategories->pluck('vendor.email')
            //         ]);

            //         $this->sendToForm('rfq_with_factories',$rfq_with_factories_data);
            //         $this->sendToForm('rfq_distributed',$rfq_distributed_data);
            //     });
        }
}
