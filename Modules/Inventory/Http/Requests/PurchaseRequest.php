<?php

namespace Modules\Inventory\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
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
            'supplier_id' => 'required|exists:suppliers,id',
            'location_id' => 'required|exists:locations,id',
            'currency_id' => 'required|exists:currencies,id',
            'product_id' => 'required|array',
            'product_id.*' => 'required|distinct',
            'product_cost.*' => 'required|min:0',
            'product_qty.*' => 'required|min:0',
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
