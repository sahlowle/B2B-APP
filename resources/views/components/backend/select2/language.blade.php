@php
    $languages = \App\Models\Language::getAll()->where('status', 'Active');
    $languageFlags = $languages->mapWithKeys(function ($language) {
        return [$language->short_name => url('public/datta-able/fonts/flag/flags/4x3/' . getSVGFlag($language->short_name) . '.svg')];
    })
@endphp

@props(['activeShortName'])

<select {{ $attributes->merge(['class' => 'form-control select2-hide-search-custom']) }}>
    @foreach ($languages as $language)
        <option @selected($language->short_name == $activeShortName) value="{{ $language->short_name }}">{{ $language->name }}</option>
    @endforeach
</select>

<script>
    var flags = @json($languageFlags);
</script>
<script src="{{ asset('public/dist/js/custom/language-flag.min.js') }}"></script>
