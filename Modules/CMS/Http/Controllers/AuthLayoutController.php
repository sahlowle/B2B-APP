<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 13-05-2024
 */

namespace Modules\CMS\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\File as ModelsFile;
use App\Models\Preference;
use Illuminate\Support\Facades\File;
use Modules\CMS\Http\Requests\AuthLayoutRequest;

class AuthLayoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        // Define the path to the directory
        $directory = resource_path('views/admin/auth/login_templates');

        // Get the list of subdirectories
        $subdirectories = File::directories($directory);

        $authSettingJson = preference('auth_settings', []) ?: defaultAuthSettings();
        $authSettings = json_decode($authSettingJson, true);

        $templates = collect($subdirectories)->map(function ($item) {
            return basename($item);
        });

        return view('cms::auth-layout.index', compact('templates', 'authSettings'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return array
     */
    public function store(AuthLayoutRequest $request)
    {
        // Store Image if exist
        if ($request->has('file_id')) {
            $destinationPath = resource_path('views/admin/auth/login_templates/' . $request->template);

            if (! File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            $file = ModelsFile::find($request->file_id[0]);

            if ($file && File::exists(public_path('uploads/' . $file->file_name))) {
                File::copy(public_path('uploads/' . $file->file_name), $destinationPath . '/' . $file->original_file_name);

                $request['file'] = $file->original_file_name;
            }
        }

        // Update the auth setting
        $authSettingJson = preference('auth_settings', []) ?: defaultAuthSettings();
        $authSettings = json_decode($authSettingJson, true);

        foreach ($authSettings[$request->template]['data'] as $key => $value) {
            if ($request->has($key)) {
                $authSettings[$request->template]['data'][$key] = $request->$key;
            }
        }

        // Activate layout
        if ($request->has('template')) {
            Preference::updateOrInsert(
                ['category' => 'auth_layout', 'field' => 'auth_template_name'],
                ['value' => $request->template]
            );
            Preference::updateOrInsert(
                ['category' => 'preference', 'field' => 'auth_settings'],
                ['value' => json_encode($authSettings)]
            );

            Preference::forgetCache();
        }

        return back()->withSuccess(__('The :x has been saved successfully.', ['x' => __('Auth Layout')]));
    }
}
