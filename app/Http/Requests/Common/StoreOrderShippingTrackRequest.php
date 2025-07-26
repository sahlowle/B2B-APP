<?php

namespace App\Http\Requests\Common;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class StoreOrderShippingTrackRequest extends FormRequest
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
     * @return array The validation rules.
     */
    public function rules(): array
    {
        return [
            'shipping_provider_id' => 'required|integer',
            'order_id' => 'required|exists:orders,id',
            'tracking_link' => 'required|url',
            'tracking_no' => 'required|string',
            'order_shipped_date' => 'nullable|date',
            'provider_name' => 'required|string',
            'track_type' => 'required|string|in:product,order',
            'product_id' => 'nullable|exists:products,id',
        ];
    }

    /**
     * Validate the given data against the rules.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public static function validateData(array $data)
    {
        $request = new self();

        return Validator::make($data, $request->rules());
    }
}
