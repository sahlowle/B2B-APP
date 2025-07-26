<?php

namespace App\Services\Order;

class Section
{
    /**
     * Generate product type selectors for the Add Product form.
     *
     * @return array
     */
    public function getSections()
    {
        $sections = [
            'general' => [
                'is_main' => true,
                'position' => '10',
                'visibility' => true,
                'content' => 'admin.orders.view_sections.general',
                'vendor_content' => 'vendor.orders.view_sections.general',
            ],
            'order-info' => [
                'is_main' => true,
                'position' => '10',
                'visibility' => true,
                'content' => 'admin.orders.view_sections.order-info',
                'vendor_content' => 'vendor.orders.view_sections.order-info',
            ],
            'calculation' => [
                'is_main' => true,
                'position' => '20',
                'visibility' => true,
                'content' => 'admin.orders.view_sections.calculation',
                'vendor_content' => 'vendor.orders.view_sections.calculation',
            ],
            'downloadable' => [
                'is_main' => true,
                'position' => '30',
                'visibility' => true,
                'content' => 'admin.orders.view_sections.downloadable',
                'vendor_content' => 'vendor.orders.view_sections.downloadable',
            ],
            'custom-field' => [
                'is_main' => true,
                'position' => '35',
                'visibility' => true,
                'content' => 'admin.orders.view_sections.custom-field',
                'vendor_content' => 'vendor.orders.view_sections.custom-field',
            ],
            'action' => [
                'is_main' => false,
                'position' => '40',
                'visibility' => true,
                'content' => 'admin.orders.view_sections.action',
                'vendor_content' => 'vendor.orders.view_sections.action',
            ],
            'delivery-time' => [
                'is_main' => false,
                'position' => '50',
                'visibility' => true,
                'content' => 'admin.orders.view_sections.delivery-time',
                'vendor_content' => 'vendor.orders.view_sections.delivery-time',
            ],
            'status-history' => [
                'is_main' => false,
                'position' => '60',
                'visibility' => true,
                'content' => 'admin.orders.view_sections.status-history',
                'vendor_content' => 'vendor.orders.view_sections.status-history',
            ],
            'note' => [
                'is_main' => false,
                'position' => '70',
                'visibility' => true,
                'content' => 'admin.orders.view_sections.note',
                'vendor_content' => 'vendor.orders.view_sections.note',
            ],
            'invoice' => [
                'is_main' => false,
                'position' => '80',
                'visibility' => true,
                'content' => 'admin.orders.view_sections.invoice',
                'vendor_content' => 'vendor.orders.view_sections.invoice',
            ],
            'track-code' => [
                'is_main' => false,
                'position' => '90',
                'visibility' => true,
                'content' => 'admin.orders.view_sections.track-code',
                'vendor_content' => 'vendor.orders.view_sections.track-code',
            ],
            'customer-note' => [
                'is_main' => false,
                'position' => '95',
                'visibility' => true,
                'content' => 'admin.orders.view_sections.customer-note',
                'vendor_content' => 'vendor.orders.view_sections.customer-note',
            ],
            'shipment-track' => [
                'is_main' => false,
                'position' => '100',
                'visibility' => true,
                'content' => 'admin.orders.view_sections.shipment-tracking',
                'vendor_content' => 'vendor.orders.view_sections.shipment-tracking',
            ],
        ];

        $sections = apply_filters('order_view_sections', $sections);

        // Sort items based on position, placing items without a position at the beginning
        uasort($sections, function ($a, $b) {
            return ($a['position'] ?? -1) <=> ($b['position'] ?? -1);
        });

        return $sections;
    }
}
