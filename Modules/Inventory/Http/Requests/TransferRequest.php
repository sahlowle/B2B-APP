<?php

namespace Modules\Inventory\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransferRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'vendor_id' => 'required|exists:vendors,id',
            'from_location_id' => 'required|exists:locations,id',
            'to_location_id' => 'required|exists:locations,id',
            'product_id' => 'required|array',
            'product_id.*' => 'required|distinct',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
