<?php

namespace App\Http\Controllers\Migrate;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class MigrateCategoryController extends Controller
{
    public function getMainCategories()
    {
        return response()->json([
            'status' => true,
            'data' => Category::query()->whereNull('parent_id')->get()
        ]);
    }
}
