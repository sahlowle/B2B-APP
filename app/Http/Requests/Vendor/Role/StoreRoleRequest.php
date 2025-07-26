<?php

namespace App\Http\Requests\Vendor\Role;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'max:50'],
            'slug' => ['required', 'unique:roles,slug'],
            'description' => ['nullable', 'max:200'],
            'type' => ['required', 'in:vendor'],
            'vendor_id' => ['required', 'exists:vendors,id'],
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'slug' => $this->vendor_id . '-' . $this->slug,
        ]);
    }
}
