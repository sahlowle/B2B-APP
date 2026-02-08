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
        ->with('shop', 'user.user', 'allCategories')
        ->where(function($query) {
            $query->where('name', 'not like', '%zara%')
                  ->where('email', 'not like', '%zara%');
        })
        ->where(function($query) {
            $query->where('name', 'not like', '%test%')
                  ->where('email', 'not like', '%test%');
        })
        ->whereNotIn('id', [1, 2, 3, 21,22,23])
        ->get();

        return response()->json([
            'status' => true,
            'count' => $vendors->count(),
            'data' => VendorDetailResource::collection($vendors)
        ]);
    }
}
