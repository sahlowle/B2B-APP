<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 27-02-2024
 */

namespace App\Services;

use App\Models\CustomField;
use App\Models\CustomFieldMeta;
use App\Models\CustomFieldValue;
use App\Models\Role;

class CustomFieldService
{
    /**
     * Reference table
     */
    private $fieldTo = null;

    /**
     * Store Custom Field
     */
    public function storeField($data): ?int
    {
        $this->fieldTo = $data['field_to'];

        return CustomField::insertGetId($data);
    }

    /**
     * Store Custom Field
     */
    public function updateField($data, $id): bool
    {
        $this->fieldTo = $data['field_to'];

        return CustomField::where('id', $id)->update($data);
    }

    /**
     * Store Custom Field Value
     *
     * @param  array  $data  field values
     * @param  int  $id  related id
     */
    public static function storeFieldValue(?array $data, int $id): bool
    {
        if (is_null($data)) {
            return false;
        }

        $values = array_map(function ($value) use ($id) {
            if (! isset($value['value']) || is_null($value['value'])) {
                $value['value'] = '';
            }

            if (is_array($value['value'])) {
                $value['value'] = json_encode($value['value']);
            }

            return array_merge($value, ['rel_id' => $id]);
        }, $data);

        return CustomFieldValue::upsert($values, ['rel_id', 'field_id', 'field_to']);
    }

    /**
     * Store Custom Field Meta
     */
    public function storeFieldMeta(array $data, int $id): bool
    {
        $validatedMeta = $this->validateMeta($data);

        $meta = [];
        foreach ($validatedMeta as $key => $value) {
            $meta[] = [
                'custom_field_id' => $id,
                'key' => $key,
                'value' => is_array($value) ? json_encode($value) : $value,
            ];
        }

        return CustomFieldMeta::upsert($meta, ['custom_field_id', 'key']);
    }

    /**
     * Validate meta
     */
    private function validateMeta(array $data): array
    {
        $defaultMeta = $this->fieldBelongsTo()[$this->fieldTo]['options']
            + $this->fieldBelongsTo()[$this->fieldTo]['visibility'];

        return array_reduce(array_keys($data), function ($result, $key) use ($data, $defaultMeta) {
            $metaKey = "meta[$key]";
            $isDisabled = $defaultMeta[$metaKey]['is_disabled'] ?? false;

            $result[$key] = $isDisabled ? $defaultMeta[$metaKey]['default_value'] : $data[$key];

            return $result;
        }, []);
    }

    /**
     * Custom Field Input types
     */
    public static function inputTypes(): array
    {
        $items = [
            'input' => [
                'tag' => 'input', 'type' => 'text', 'title' => 'Input', 'need_option' => false,
                'default' => ['tag' => 'input', 'type' => 'text'],
                'position' => '10',
            ],
            'hidden' => [
                'tag' => 'input', 'type' => 'hidden', 'title' => 'Hidden', 'need_option' => false,
                'default' => ['tag' => 'input', 'type' => 'text'],
                'position' => '15',
            ],
            'number' => [
                'tag' => 'input', 'type' => 'number', 'title' => 'Number', 'need_option' => false,
                'default' => ['tag' => 'input', 'type' => 'text'],
                'position' => '20',
            ],
            'textarea' => [
                'tag' => 'textarea', 'type' => '', 'title' => 'Textarea', 'need_option' => false,
                'default' => ['tag' => 'textarea', 'type' => ''],
                'position' => '30',
            ],
            'select' => [
                'tag' => 'select', 'type' => '', 'title' => 'Select', 'need_option' => true,
                'option_note' => 'Populate the field by separating the options with commas. For example: apple,orange,banana.',
                'default' => ['tag' => 'input', 'type' => 'text'],
                'position' => '40',
            ],
            'multiselect' => [
                'tag' => 'select', 'type' => '', 'attribute' => 'multiselect', 'title' => 'Multi Select', 'need_option' => true,
                'option_note' => 'Populate the field by separating the options with commas. For example: apple,orange,banana.',
                'default' => ['tag' => 'input', 'type' => 'text'],
                'position' => '50',
            ],
            'checkbox' => [
                'tag' => 'input', 'type' => 'checkbox',  'title' => 'Checkbox', 'need_option' => true,
                'option_note' => 'Populate the field by separating the options with commas. For example: apple,orange,banana.',
                'default' => ['tag' => 'input', 'type' => 'text'],
                'position' => '60',
            ],
            'datepicker' => [
                'tag' => 'input', 'type' => 'text', 'title' => 'Date Picker', 'need_option' => false,
                'default' => ['tag' => 'input', 'type' => 'text'],
                'position' => '70',
            ],
            'colorpicker' => [
                'tag' => 'input', 'type' => 'text', 'title' => 'Color Picker', 'need_option' => false,
                'default' => ['tag' => 'input', 'type' => 'text'],
                'position' => '80',
            ],
            'hyperlink' => [
                'tag' => 'input', 'type' => 'text', 'title' => 'Hyperlink', 'need_option' => false,
                'default' => ['tag' => 'input', 'type' => 'text'],
                'position' => '90',
            ],
        ];

        $items = apply_filters('custom_field_input_types', $items);

        // Sort items based on position, placing items without a position at the beginning
        uasort($items, function ($a, $b) {
            $positionA = isset($a['position']) ? $a['position'] : -1;
            $positionB = isset($b['position']) ? $b['position'] : -1;

            return $positionA <=> $positionB;
        });

        return $items;
    }

    /**
     * Field Belongs To
     */
    public static function fieldBelongsTo(): array
    {
        $roles = Role::whereNull('vendor_id')->pluck('name', 'slug')->toArray();

        $items = [
            'users' => [
                'title' => 'Users',
                'position' => '10',
                'options' => [
                    'status' => ['title' => 'Active', 'is_disabled' => false, 'default_value' => true],
                ],
                'accessibility' => [
                    'roles' => $roles,
                ],
                'visibility' => [
                    'meta[data_table]' => [
                        'title' => 'Show on Data Table',
                        'is_disabled' => false,
                        'default_value' => true,
                    ],
                    'meta[create_form]' => [
                        'title' => 'Show on Create Form',
                        'is_disabled' => false,
                        'default_value' => true,
                    ],
                    'meta[edit_form]' => [
                        'title' => 'Show on Edit Form',
                        'is_disabled' => false,
                        'default_value' => true,
                    ],
                ],
            ],
            'products' => [
                'title' => 'Products',
                'position' => '20',
                'options' => [
                    'status' => ['title' => 'Active', 'is_disabled' => false, 'default_value' => true],
                ],
                'accessibility' => [
                    'roles' => $roles,
                ],
                'visibility' => [
                    'meta[data_table]' => [
                        'title' => 'Show on Data Table',
                        'is_disabled' => false,
                        'default_value' => true,
                    ],
                    'meta[create_form]' => [
                        'title' => 'Show on Create Form',
                        'is_disabled' => false,
                        'default_value' => true,
                    ],
                    'meta[edit_form]' => [
                        'title' => 'Show on Edit Form',
                        'is_disabled' => false,
                        'default_value' => true,
                    ],
                    'meta[product_details]' => [
                        'title' => 'Show on Product Details',
                        'is_disabled' => false,
                        'default_value' => true,
                    ],
                ],
                'location' => [
                    'meta[product_details_hook]' => [
                        'title' => 'Product Details',
                        'values' => self::doActionKeys('resources/views/site/product/view.blade.php'),
                    ],
                ],
            ],
            'orders' => [
                'title' => 'Checkout',
                'position' => '30',
                'options' => [
                    'status' => ['title' => 'Active', 'is_disabled' => false, 'default_value' => true],
                ],
                'accessibility' => [
                    'roles' => $roles,
                ],
                'visibility' => [
                    'meta[data_table]' => [
                        'title' => 'Show on Data Table',
                        'is_disabled' => false,
                        'default_value' => true,
                    ],
                    'meta[order_details]' => [
                        'title' => 'Show on Order Details',
                        'is_disabled' => false,
                        'default_value' => true,
                    ],
                    'meta[checkout]' => [
                        'title' => 'Show on Order Checkout',
                        'is_disabled' => false,
                        'default_value' => true,
                    ],
                ],
            ],
        ];

        $items = apply_filters('custom_field_belongs_to', $items);

        // Sort items based on position, placing items without a position at the beginning
        uasort($items, function ($a, $b) {
            $positionA = isset($a['position']) ? $a['position'] : -1;
            $positionB = isset($b['position']) ? $b['position'] : -1;

            return $positionA <=> $positionB;
        });

        return $items;
    }

    /**
     * Extract the keys from @doAction directives in the given file
     *
     * @param  string  $path  The path to the file to scan
     * @return array The keys of the @doAction directives
     */
    private static function doActionKeys(string $path): array
    {
        $fileContent = file_get_contents($path);

        if (preg_match_all('/@doAction\(\'([^\']+)\'/', $fileContent, $matches)) {
            return $matches[1];
        }

        return [];
    }

    /**
     * Add columns to the datatable based on the custom fields registered for the given fieldTo
     *
     * @param  \Yajra\DataTables\DataTableAbstract  $dt  The datatable instance
     * @param  string  $fieldTo  The model class name the custom fields are registered for
     */
    public static function dataTableBody($dt, string $fieldTo)
    {
        CustomField::where(['field_to' => $fieldTo, 'status' => 1])->orderBy('order')->each(function ($field) use ($dt) {
            if ($field->shouldShowOnDataTable()) {
                $dt->editColumn($field->slug, function ($data) use ($field) {
                    return $data->customFieldValues()->whereHas('customField', function ($q) use ($field) {
                        $q->where('slug', $field->slug);
                    })->first()?->value;
                });
            }
        });
    }

    /**
     * Add columns to the datatable based on the custom fields registered for the given fieldTo
     *
     * @param  \Yajra\DataTables\Html\Builder  $builder  The datatable builder instance
     * @param  string  $fieldTo  The model class name the custom fields are registered for
     */
    public static function dataTableHeader($builder, string $fieldTo)
    {
        CustomField::where(['field_to' => $fieldTo, 'status' => 1])->orderBy('order')->each(function ($field) use ($builder) {
            if ($field->shouldShowOnDataTable()) {
                $builder->addColumn([
                    'data' => $field->slug,
                    'name' => 'customFieldValues.value',
                    'title' => $field->name,
                    'className' => 'align-middle',
                    'orderable' => false,
                ]);
            }
        });
    }

    /**
     * Generate custom field validation rules based on the custom fields registered for the given fieldTo
     *
     * @param  string  $fieldTo  The model class name the custom fields are registered for
     * @param  array  $customFields  The array of custom field ids and values
     * @return array The custom field rules indexed by field slug
     */
    public static function fieldRules($fieldTo, $customFields)
    {
        $fieldIds = array_column($customFields, 'field_id');

        return CustomField::whereIn('id', $fieldIds)->where(['field_to' => $fieldTo, 'status' => 1])->pluck('rules', 'slug')->filter()->toArray();
    }

    /**
     * Retrieve the custom field values indexed by field slug
     *
     * @param  string  $fieldTo  The model class name the custom fields are registered for
     * @param  array  $customFields  The array of custom field ids and values
     * @return array The custom field values indexed by field slug
     */
    public static function fieldValues($fieldTo, $customFields)
    {
        $fieldIds = array_column($customFields, 'field_id');
        $fieldValues = array_column($customFields, 'value');

        $fieldSlugs = CustomField::whereIn('id', $fieldIds)->where(['field_to' => $fieldTo, 'status' => 1])->pluck('slug')->toArray();

        return array_combine($fieldSlugs, $fieldValues);
    }
}
