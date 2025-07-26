<?php

namespace Modules\Shipping\Http\Requests;

use App\Rules\CheckValidFile;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreShippingProviderRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:120|unique:shipping_providers,name',
            'country_id' => 'required|exists:geolocale_countries,id',
            'tracking_base_url' => 'required|url',
            'tracking_url_method' => 'required|in:Get,Post',
            'status' => 'required|in:Active,Inactive',
            'attachment'  => ['nullable', new CheckValidFile(getFileExtensions(2))],
            'file_id.*' => 'nullable|integer',
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

    /**
     * Handle a failed validation attempt.
     *
     * @param  mixed  $validator
     * @return void
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            redirect()->route('shipping.index', ['menu' => 'provider'])
                ->withErrors($validator)
        );
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'file_id' => 'Logo',
        ];
    }
}
