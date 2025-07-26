<?php

namespace App\Http\Requests\Admin;

use App\Services\CustomFieldService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class UpdateCustomFieldRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Custom Fields
     */
    private function fields()
    {
        $fields = CustomFieldService::fieldBelongsTo();

        return implode(',', array_keys($fields));
    }

    /**
     * Custom field input types
     */
    private function inputTypes()
    {
        $types = CustomFieldService::inputTypes();

        return implode(',', array_keys($types));

    }

    /**
     * Check Status
     */
    private function checkStatus()
    {
        $fields = CustomFieldService::fieldBelongsTo();

        $status = $fields[$this->field_to]['options']['status'] ?? null;

        if (! $status || $status['is_disabled']) {
            return $status['default_value'] ?? 0;
        }

        return $this->status;
    }

    /**
     * Validate the custom field rules
     *
     * @return bool
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    private function validateRule()
    {
        if (! $this->rules) {
            return true;
        }

        try {
            $validator = Validator::make(['field' => 'value'], ['field' => $this->rules]);

            return $validator->passes();
        } catch (\Exception $e) {
            throw ValidationException::withMessages(['rules' => __('Invalid custom field rules: :x', ['x' => $this->rules])]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'field_to' => 'required|max:191|in:' . $this->fields(),
            'name' => 'required|max:191',
            'type' => 'required|max:191|in:' . $this->inputTypes(),
            'options' => ['nullable', 'max:191', 'regex:/^[a-zA-Z0-9,]+$/'],
            'default_value' => 'nullable|max:191',
            'order' => 'nullable|numeric|max:9999999',
            'column' => 'required|numeric|max:12',
            'rules' => 'nullable|max:191',
            'status' => 'required|boolean',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->validateRule();

        $this->merge([
            'status' => $this->checkStatus(),
        ]);
    }
}
