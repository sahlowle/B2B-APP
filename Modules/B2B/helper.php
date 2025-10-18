<?php

add_action('product_editor_data_tabs', function ($items) {

    $product = $items['product'];
    $demo = config('martvill.is_demo') ? '<span class="badge badge-primary padding_3">'.__('Addon').'</span>' : '';
    $b2b = ['tabs' => [
        'B2B' => [
            'tab' => '<li class="nav-item conditional-dom not-external-dom not-grouped-dom">
                            <a class="nav-link" id="tabs-9" data-bs-toggle="tab" href="#tabs-b2b" role="tab" aria-controls="tabs-b2b" aria-selected="false">'.__('Quantity Discount').' '.$demo.'</a>
                        </li>',
            'tab_content' => 'b2b::admin.b2b-tab',
            'position' => 61,
            'visibility' => true,
        ],
    ]];

    $items = array_merge($items['tabs'], $b2b['tabs']);

    $items = ['tabs' => $items, 'product' => $product];

    return $items;

});

add_action('before_signle_product_summary_add_to_cart', function ($items) {
    echo '<div id="b2b_table">'.
                view('b2b::site.product-details', $items)
        .'</div>';
});
