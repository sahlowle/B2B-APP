<?php

namespace App\Http\Controllers\Migrate;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MigrateCategoryController extends Controller
{
    public function getMainCategories()
    {
        return response()->json([
            'status' => true,
            'data' => DB::table('categories')->whereNull('parent_id')->get()
        ]);
    }
}
