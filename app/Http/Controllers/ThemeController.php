<?php

namespace App\Http\Controllers;

use App\Models\Preference;

class ThemeController extends Controller
{
    /**
     * Themes
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.theme.index');
    }

    public function active($slug)
    {
        Preference::upsert(['category' => 'theme', 'field' => 'active_theme', 'value' => $slug], ['field', 'category']);
        Preference::forgetCache();

        return back()->withSuccess(__('The theme activated successfully.'));
    }
}
