<?php

return [
    'name' => 'Moyasar',

    'alias' => 'moyasar',

    'logo' => 'Modules/Moyasar/Resources/assets/moyasar.jpg',

    // Moyasar addon settings

    'options' => [
        ['label' => __('Settings'), 'type' => 'modal', 'url' => 'moyasar.edit'],
        ['label' => __('Moyasr Documentation'), 'target' => '_blank', 'url' => 'https://docs.moyasar.com'],
    ],

    /**
     * Moyasar data validation
     */
    'validation' => [
        'rules' => [
            'publishableKey' => 'required',
            'clientSecret' => 'required',
            'sandbox' => 'required',
        ],
        'attributes' => [
            'publishableKey' => __('Publishable Key'),
            'clientSecret' => __('Client Secret'),
            'sandbox' => __('Please specify sandbox enabled/disabled.'),
        ],
    ],
    'fields' => [
        'publishableKey' => [
            'label' => __('Publishable Key'),
            'type' => 'text',
            'required' => true,
        ],
        'clientSecret' => [
            'label' => __('Client Secret Key'),
            'type' => 'text',
            'required' => true,
        ],
        'instruction' => [
            'label' => __('Instruction'),
            'type' => 'textarea',
        ],
        'sandbox' => [
            'label' => __('Sandbox'),
            'type' => 'select',
            'required' => true,
            'options' => [
                'Enabled' => 1,
                'Disabled' =>  0,
            ],
        ],
        'status' => [
            'label' => __('Status'),
            'type' => 'select',
            'required' => true,
            'options' => [
                'Active' => 1,
                'Inactive' =>  0,
            ],
        ],
    ],

    'store_route' => 'moyasar.store',

];
