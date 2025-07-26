@props([
    'groups' => [],
    'column' => null,
    'table' => null,
    'groupClass' => null,
    'vendorId' => null
])

<div class="d-block mt-1 {{ $groupClass ?? '' }}" data-table="{{ $table ?? '' }}" data-vendor_id="{{ $vendorId ?? '' }}">
    @forelse ($groups as $key => $value)
        <span
            class="@if (!empty($column)) group-filter @endif @if ($loop->first) active @endif"
            data-filter-key="{{ $column }}" data-filter-value="{{ $key }}">
            {{ ucfirst(strtolower($key)) }} <span class="text-muted">({{ $value }})</span>
        </span>
        @if (!$loop->last)
            |
        @endif
    @empty
        @if (!empty($groupClass))
            <span>{{ __('Loading') . '...' }}</span>
        @endif
    @endforelse
</div>
