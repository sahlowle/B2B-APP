<?php

namespace App\Http\Requests\Vendor\Staff;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\{
    CheckValidEmail,
    CheckValidFile,
    StrengthPassword
};
use Illuminate\Support\Facades\Hash;

class StoreStaffRequest extends FormRequest
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
            'name'        => ['required', 'min:3'],
            'email'       => ['required', 'unique:users,email', new CheckValidEmail()],
            'password'    => ['required', new StrengthPassword()],
            'status'      => ['required', 'in:Pending,Active,Inactive,Deleted'],
            'role_ids'    => ['required'],
            'attachment'  => [new CheckValidFile(getFileExtensions(2))],
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
            'role_ids.required' => __('The role is required'),
        ];
    }

    /**
     * Handle a passed validation attempt.
     */
    protected function passedValidation(): void
    {
        $this->merge([
            'password' => Hash::make($this->password),
            'email' => validateEmail($this->email) ? strtolower($this->email) : null,
        ]);
    }
}
