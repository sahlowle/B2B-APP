<?php

namespace App\Http\Controllers\Migrate;

use App\Http\Controllers\Controller;
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

    public function getSubCategories($hs_code)
    {
        $category = DB::table('categories')->where('hs_code', $hs_code)->first();

        abort_if(!$category, 404, 'Category not found');

        return response()->json([
            'status' => true,
            'data' => DB::table('categories')->where('parent_id', $category->id)->get()
        ]);

    }
}
