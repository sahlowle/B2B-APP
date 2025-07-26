@props([
    'route',
    'id',
    'label' => __('Trash'),
    'icon' => true,
    'iconClass' => '',
    'textClass' => 'btn-link text-danger',
    'method' => 'POST'
])

<form method="post" action="{{ $route }}" id="delete-data-{{ $id }}" accept-charset="UTF-8" class="display_inline">
    @csrf
    {{ method_field($method) }}

    @if($icon)
        <a title="{{ $label }}" class="action-icon confirm-delete {{ $iconClass }}" type="button" data-id="{{ $id }}" data-delete="data" data-label="Delete" data-bs-toggle="modal" data-bs-target="#confirmDelete">
            <i class="feather icon-trash"></i>
        </a>
    @else
        <span title="{{ $label }}" class="{{ $textClass }} cursor-pointer confirm-delete" type="button" data-id="{{ $id }}" data-delete="data" data-label="Delete" data-bs-toggle="modal" data-bs-target="#confirmDelete">
            {{ $label }}
        </span>
    @endif
</form>
