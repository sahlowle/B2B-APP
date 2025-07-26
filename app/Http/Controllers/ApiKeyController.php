<?php

namespace App\Http\Controllers;

use App\Models\ApiKey;
use App\Models\Preference;
use Illuminate\Http\Request;

class ApiKeyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $apiKeys = \DB::table('api_keys')->get();
        $list_menu = 'api_keys';

        return view('admin.api_keys.index', compact('apiKeys', 'list_menu'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:191|unique:api_keys,name',
        ]);

        $apiKey = new ApiKey();
        $apiKey->name = $request->name;
        $apiKey->status = $request->status;
        $apiKey->access_token = strtoupper(\Str::random(40));
        $apiKey->save();

        return redirect()->route('api-keys.index')->with('success', __('This is your new personal access token. Please note that this token will only be displayed once. Ensure that you have securely copied and saved it.') . '<br><br><strong class="text-muted">' . __('Token') . ': ' . $apiKey->access_token . '</strong>');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:191|unique:api_keys,name,' . $id,
        ]);

        $apiKey = ApiKey::findOrFail($id);
        $apiKey->name = $request->name;
        $apiKey->status = $request->status;
        $apiKey->save();

        return redirect()->route('api-keys.index')->with('success', __('The :x has been saved successfully.', ['x' => 'API Key']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $apiKey = ApiKey::findOrFail($id);
        $apiKey->delete();

        return redirect()->route('api-keys.index')->with('success', __('The :x has been successfully deleted.', ['x' => 'API Key']));
    }

    /**
     * Update settings
     *
     * @return \Illuminate\Routing\Redirector
     */
    public function settings(Request $request)
    {
        if ($request->isMethod('get')) {
            $list_menu = 'api_settings';

            return view('admin.api_keys.settings', compact('list_menu'));
        }

        $filteredData = collect($request->only(['enable_api', 'access_token_required']))
            ->map(function ($value, $key) {
                return [
                    'category' => 'api_settings',
                    'field' => $key,
                    'value' => $value,
                ];
            })
            ->values()
            ->all();

        Preference::upsert($filteredData, ['field', 'category']);
        Preference::forgetCache();

        return redirect()->route('api-settings')->with('success', __('The :x has been successfully saved.', ['x' => 'Settings']));
    }
}
