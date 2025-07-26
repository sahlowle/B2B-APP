<?php

namespace Modules\CMS\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthLayoutRequest extends FormRequest
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
     * Get the templates that apply to the request.
     *
     * @return array
     */
    private function templates()
    {
        $authSettingJson = preference('auth_settings', []) ?: defaultAuthSettings();

        return array_keys(json_decode($authSettingJson, true));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'file_id' => 'nullable|array|exists:files,id',
            'template' => 'required|in:' . implode(',', $this->templates()),
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'file_id' => __('Image'),
        ];
    }
}
