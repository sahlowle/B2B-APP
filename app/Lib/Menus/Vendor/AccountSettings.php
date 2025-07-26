<?php

/**
 * @author TechVillage <mailto:support@techvill.org>
 *
 * @contributor Md. Mostafijur Rahman <[mailto:mostafijur.techvill@gmail.com]>
 *
 * @created 02-11-2023
 */

namespace App\Lib\Menus\Vendor;

use App\Models\Role;

class AccountSettings
{
    /**
     * Get menu items
     */
    public static function get(): array
    {
        $items = [
            [
                'label' => __('Staff'),
                'name' => 'staff',
                'href' => route('vendor.staffs.index'),
                'position' => '10',
                'visibility' => auth()->user()?->hasPermission('App\Http\Controllers\Vendor\StaffController@index'),
            ],
            [
                'label' => __('Roles'),
                'name' => 'role',
                'href' => route('vendor.roles.index'),
                'position' => '20',
                'visibility' => auth()->user()?->hasPermission('App\Http\Controllers\Vendor\RoleController@index'),
            ],
            [
                'label' => __('Permissions'),
                'name' => 'permission',
                'href' => route('vendor.permission.index'),
                'position' => '30',
                'visibility' => auth()->user()?->hasPermission('App\Http\Controllers\Vendor\PermissionController@index')
                                && Role::getAll()->where('vendor_id', session('vendorId') ?: auth()->user()->vendor()->vendor_id)->count(),
            ],
        ];

        $items = apply_filters('vendor_sidebar_configuration_account_settings_menu', $items);

        // Sort items based on position, placing items without a position at the beginning
        usort($items, function ($a, $b) {
            $positionA = isset($a['position']) ? $a['position'] : -1;
            $positionB = isset($b['position']) ? $b['position'] : -1;

            return $positionA <=> $positionB;
        });

        return $items;
    }
}
