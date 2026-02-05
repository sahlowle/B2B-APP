<?php

namespace App\Http\Controllers\Migrate;

use App\Http\Controllers\Controller;
use App\Http\Resources\VendorDetailResource;
use App\Models\Vendor;

class MigrateVendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::with('shop')->get();

        return response()->json([
            'status' => true,
            'data' => VendorDetailResource::collection($vendors)
        ]);
    }
}
