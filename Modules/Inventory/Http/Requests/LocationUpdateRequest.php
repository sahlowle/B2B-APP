<?php

namespace Modules\Inventory\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LocationUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'slug' => ['required','unique:locations,slug,' . request()->id],
            'parent_id' => 'nullable|exists:locations,id',
            'vendor_id' => 'required|exists:vendors,id',
            'status' => 'required|in:Active,Inactive',
            'is_default' => 'required|in:0,1',
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
