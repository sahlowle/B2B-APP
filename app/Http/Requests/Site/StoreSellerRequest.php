<?php

namespace App\Http\Requests\Site;

use App\Rules\CheckValidEmail;
use App\Rules\CheckValidFile;
use App\Rules\CheckValidPhone;
use App\Rules\StrengthPassword;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Modules\Shop\Http\Models\Shop;

class StoreSellerRequest extends FormRequest
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
            'name'      => ['required', 'min:3', 'max:191'],
            'email'     => ['required', 'email:rfc,dns','max:191', 'unique:users,email'],
            'password'  => ['required', 'max:20', 'confirmed'],
            'phone'     => ['required', 'min:9', 'max:9', new CheckValidPhone()],
            'logo'      => ['nullable', new CheckValidFile(getFileExtensions(3))],
            'city'      => ['required', 'max:100'],
            'post_code' => ['required', 'max:10'],
            'country'   => ['required', 'max:100', 'in:sa'],
            'state'     => ['nullable', 'max:100'],
            'shop_name' => ['required', 'max:100', 'unique:shops,name'],
            'commercial_registration_number' => ['required', 'max:191', 'unique:shops,commercial_registration_number'],
            'address'   => ['required', 'max:191'],
            'categories' => ['required', 'array'],
            'gCaptcha' => isRecaptchaActive() ? 'required|captcha' : 'nullable',
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
            'email' => __('Email Address'),
            'name' => __('First and last name'),
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $otp = random_int(1111, 9999);
    
        $status = preference('vendor_default_signup_status') ?? 'Pending';
        
        $this->merge([
            'name' => $this->f_name . ' ' . $this->l_name,
            'user_status' => 'Pending',
            'status' => $status,
            'activation_code' => Str::random(10),
            'activation_otp' => $otp,
            'gCaptcha' => $this['g-recaptcha-response'],
        ]);
    }
}
