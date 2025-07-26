<?php

namespace App\Models;

use App\Services\CustomFieldService;

class CustomField extends Model
{
    /**
     * Relation with CustomFieldValue model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function customFieldValues()
    {
        return $this->hasMany(CustomFieldValue::class, 'field_id');
    }

    /**
     * Relation with CustomFieldMeta model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function meta()
    {
        return $this->hasMany(CustomFieldMeta::class, 'custom_field_id');
    }

    /**
     * Get the meta data of the custom field by its key or all meta data as collection.
     *
     * @param  string|null  $key  Key of the meta data. If not provided, returns all meta data.
     * @return array|string|null
     */
    public function metaPluck($key = null)
    {
        $meta = $this->meta->pluck('value', 'key');

        if ($key) {
            return $meta->get($key);
        }

        return $meta;
    }

    /**
     * Scope a query to only include active records.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $column
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query, $column = 'status')
    {
        return $query->where($column, 1);
    }

    /**
     * Get the type of the custom field input.
     *
     * @return mixed
     */
    public function typeOption($option)
    {
        return CustomFieldService::inputTypes()[$this->type][$option] ?? null;
    }

    /**
     * Determine if the custom field should be displayed in a data table.
     */
    public function shouldShowOnDataTable(): bool
    {
        $accessibility = json_decode($this->metaPluck(auth()->user()->roles->first()?->slug ?? ''), true) ?: [];

        return $this->metaPluck('data_table') == '1' && (($accessibility['write'] ?? false) || ($accessibility['read'] ?? false));
    }

    /**
     * Determine if the custom field is required.
     */
    public function isRequired(): bool
    {
        return strpos($this->rules, 'required') !== false;
    }
}
