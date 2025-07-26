<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MultiCurrencyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if (isset($this->id)) {
            return [
                'currency_id' => ['required', 'exists:currencies,id', 'unique:multi_currencies,currency_id,' . $this->id],
            ];
        }

        return [
            'currency_id' => 'required|exists:currencies,id|unique:multi_currencies,currency_id',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'currency_id.unique' => __('The currency has already been created.'),
        ];
    }
}
