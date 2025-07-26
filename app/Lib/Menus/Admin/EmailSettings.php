<?php

/**
 * @author TechVillage <mailto:support@techvill.org>
 *
 * @contributor Md. Mostafijur Rahman <[mailto:mostafijur.techvill@gmail.com]>
 *
 * @created 12-10-2023
 */

namespace App\Lib\Menus\Admin;

class EmailSettings
{
    /**
     * Get menu items
     */
    public static function get(): array
    {
        $items = [
            [
                'label' => __('Setup'),
                'name' => 'email_setup',
                'href' => route('emailConfigurations.index'),
                'position' => '10',
                'visibility' => auth()->user()?->hasPermission('App\Http\Controllers\EmailConfigurationController@index'),
            ],
            [
                'label' => __('Templates'),
                'name' => 'email_template',
                'href' => route('emailTemplates.index'),
                'position' => '20',
                'visibility' => auth()->user()?->hasPermission('App\Http\Controllers\MailTemplateController@index'),
            ],
        ];

        $items = apply_filters('admin_sidebar_configuration_email_settings_menu', $items);

        // Sort items based on position, placing items without a position at the beginning
        usort($items, function ($a, $b) {
            $positionA = isset($a['position']) ? $a['position'] : -1;
            $positionB = isset($b['position']) ? $b['position'] : -1;

            return $positionA <=> $positionB;
        });

        return $items;
    }
}
