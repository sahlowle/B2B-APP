<?php

namespace App\Http\Requests\Vendor\Staff;

use App\Rules\CheckValidEmail;
use App\Rules\CheckValidFile;
use Illuminate\Foundation\Http\FormRequest;

class UpdateStaffRequest extends FormRequest
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
            'name'      => ['required', 'min:3', 'max:191'],
            'email'     => ['required', 'max:191', 'unique:users,email,' . $this->id, new CheckValidEmail],
            'phone'     => ['nullable', 'max:45', 'regex:/^[0-9\-\,]*$/'],
            'status'    => ['required', 'in:Pending,Active,Inactive,Deleted'],
            'role_ids'  => ['required'],
            'image'     => ['nullable', new CheckValidFile(getFileExtensions(2)), 'max:' . preference('file_size') * 1024],
        ];
    }

    /**
     * Handle a passed validation attempt.
     */
    protected function passedValidation(): void
    {
        $this->merge([
            'data' => [
                'userData' => $this->only('name', 'email', 'status'),
                'userMetaData' => $this->only('designation', 'description')
            ],
            'email' => validateEmail($this->email) ? strtolower($this->email) : null,
        ]);
    }
}
