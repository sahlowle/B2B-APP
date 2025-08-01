<?php

namespace App\Http\Requests\Site;

use Illuminate\Foundation\Http\FormRequest;

class OrderStoreRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'selected_tab' => 'required|in:new,old',
            'address_id' => 'nullable|exists:addresses,id',
        ];
    }
}
