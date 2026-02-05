<?php

namespace App\Http\Controllers\Migrate;

use App\Http\Controllers\Controller;
use App\Http\Resources\VendorDetailResource;
use App\Models\Vendor;

class MigrateVendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::query()
            ->with('shop')
            ->where('name', 'not like', '%zara%')
            ->orWhere('email', 'not like', '%zara%')
            ->orWhere('name', 'not like', '%test%')
            ->orWhere('email', 'not like', '%test%')
            ->get();

        return response()->json([
            'status' => true,
            'count' => $vendors->count(),
            'data' => VendorDetailResource::collection($vendors)
        ]);
    }
}
