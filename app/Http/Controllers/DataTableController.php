<?php

namespace App\Http\Controllers;

use App\Models\Preference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataTableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $list_menu = 'data_table';

        return view('admin.data_table.index', compact('list_menu'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $filteredData = collect($request->only(['dt_minimum_search_length', 'dt_search_delay']))
            ->map(function ($value, $key) {
                return [
                    'category' => 'data_table',
                    'field' => $key,
                    'value' => $value,
                ];
            })
            ->values()
            ->all();

        Preference::upsert($filteredData, ['field', 'category']);
        Preference::forgetCache();

        return redirect()->back()->with('success', __('The :x has been successfully saved.', ['x' => 'Settings']));
    }

    /**
     * Display a listing of the resource.
     *
     * @param  string  $tableName
     * @return array
     */
    public function status(Request $request, $tableName)
    {
        $statusCounts = DB::table($tableName)
            ->selectRaw('status, COUNT(id) as count');

        if (isset($request->vendor_id)) {
            $statusCounts->where('vendor_id', $request->vendor_id);
        }

        $statusCounts = $statusCounts->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        return response()->json(['All' => array_sum($statusCounts)] + $statusCounts);
    }
}
