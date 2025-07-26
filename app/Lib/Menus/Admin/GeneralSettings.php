<?php

/**
 * @author TechVillage <mailto:support@techvill.org>
 *
 * @contributor Md. Mostafijur Rahman <[mailto:mostafijur.techvill@gmail.com]>
 *
 * @created 12-10-2023
 */

namespace App\Lib\Menus\Admin;

class GeneralSettings
{
    /**
     * Get menu items
     */
    public static function get(): array
    {
        $items = [
            [
                'label' => __('System Setup'),
                'name' => 'system_setup',
                'href' => route('companyDetails.setting'),
                'position' => '10',
                'visibility' => auth()->user()?->hasPermission('App\Http\Controllers\CompanySettingController@index'),
            ], [
                'label' => __('Preference'),
                'name' => 'preference',
                'href' => route('preferences.index'),
                'position' => '20',
                'visibility' => auth()->user()?->hasPermission('App\Http\Controllers\PreferenceController@index'),
            ], [
                'label' => __('Maintenance Mode'),
                'name' => 'maintenance',
                'href' => route('maintenance.enable'),
                'position' => '30',
                'visibility' => auth()->user()?->hasPermission('App\Http\Controllers\MaintenanceModeController@enable'),
            ], [
                'label' => __('Language'),
                'name' => 'language',
                'href' => route('language.index'),
                'position' => '40',
                'visibility' => auth()->user()?->hasPermission('App\Http\Controllers\LanguageController@index'),
            ], [
                'label' => __('Address'),
                'name' => 'address',
                'href' => route('address.setting.index'),
                'position' => '50',
                'visibility' => auth()->user()?->hasPermission('App\Http\Controllers\AddressSettingController@index'),
            ], [
                'label' => __('API Keys'),
                'name' => 'api_keys',
                'href' => route('api-keys.index'),
                'position' => '60',
                'visibility' => auth()->user()?->hasPermission('App\Http\Controllers\ApiKeyController@index'),
            ], [
                'label' => __('API Settings'),
                'name' => 'api_settings',
                'href' => route('api-settings'),
                'position' => '70',
                'visibility' => auth()->user()?->hasPermission('App\Http\Controllers\ApiKeyController@settings'),
            ], [
                'label' => __('Data Table'),
                'name' => 'data_table',
                'href' => route('datatables.index'),
                'position' => '80',
                'visibility' => auth()->user()?->hasPermission('App\Http\Controllers\DataTableController@index'),
            ],
        ];

        $items = apply_filters('admin_sidebar_configuration_general_settings_menu', $items);

        // Sort items based on position, placing items without a position at the beginning
        usort($items, function ($a, $b) {
            $positionA = isset($a['position']) ? $a['position'] : -1;
            $positionB = isset($b['position']) ? $b['position'] : -1;

            return $positionA <=> $positionB;
        });

        return $items;
    }
}
