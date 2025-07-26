<?php

add_action('product_editor_data_tabs', function ($items) {

    $product = $items['product'];
    $demo = config('martvill.is_demo') ? '<span class="badge badge-primary padding_3">' . __('Addon') . '</span>' : '';
    $style = isset($product->manage_stocks) && $product->manage_stocks == 1 ? '' : 'style="display:none;"';
    $stock = ['tabs' => [
        'stock' => [
            'tab' => '<li class="nav-item on_impact conditional-dom ' . (preference('manage_stock', 0) != 1 ? 'not-simple-dom' : '') . ' not-variable-dom not-grouped-dom not-external-dom" data-name="stock" ' . $style . '>
                            <a class="nav-link" id="tabs-12" data-bs-toggle="tab" href="#tabs-stock" role="tab" aria-controls="tabs-stock" aria-selected="false">' . __('Stock') . ' ' . $demo . '</a>
                        </li>',
            'tab_content' => 'inventory::layouts.stock_tab',
            'position' => 71,
            'visibility' => true,
        ],
    ]];

    $items = array_merge($items['tabs'], $stock['tabs']);

    $items = ['tabs' => $items, 'product' => $product];

    return $items;

});

function stockKeyword(): array
{
    return ['purchase', 'stock_in_initial', 'adjust', 'order', 'refund', 'unavailable', 'available', 'transfer'];
}
