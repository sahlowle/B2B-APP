<input
    {{ $attributes->merge([
        'class' => 'form-control inputFieldDesign',
        'id' => 'dataTableSearch',
        'placeholder' => __('Enter :x characters to search', ['x' => preference('dt_minimum_search_length', 3)]),
        'type' => 'text',
        'name' => 'search',
    ]) }}>
    
