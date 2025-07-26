<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\{
    CheckValidPhone,
    CheckValidEmail
};

class StoreAddressRequest extends FormRequest
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
     * Custom Rules
     */
    private function customRules(): array
    {
        return [
            'first_name' => preference('address_first_name_required', 1) ? 'required|max:191' : 'nullable|max:191',
            'last_name' => preference('address_last_name_required', 0) ? 'required|max:191' : 'nullable|max:191',
            'phone' => preference('address_phone_required', 1) ? 'required' : 'nullable',
            'email' => preference('address_email_address_required', 0) ? 'required' : 'nullable',
            'company_name' => preference('address_company_name_required', 0) ? 'required|max:191' : 'nullable|max:191',
            'type_of_place' => preference('address_type_of_place_required', 1) ? 'required|in:home,office' : 'nullable|in:home,office',
            'address_1' => preference('address_street_address_1_required', 1) ? 'required|max:191' : 'nullable|max:191',
            'address_2' => preference('address_street_address_2_required', 0) ? 'required|max:191' : 'nullable|max:191',
            'city' => preference('address_city_required', 1) ? 'required|max:191' : 'nullable|max:191',
            'zip' => preference('address_zip_required', 0) ? 'required|max:191' : 'nullable|max:191',
            'country' => preference('address_country_required', 1) ? 'required|max:191' : 'nullable|max:191',
            'state' => preference('address_state_required', 1) ? 'required|max:191' : 'nullable|max:191',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = self::customRules();

        if (isset($this->selected_tab) && $this->selected_tab == 'old') {
            return [];
        }

        return [
            'user_id' => 'nullable|numeric',
            'first_name' => $rules['first_name'],
            'last_name' => $rules['last_name'],
            'phone' => [$rules['phone'], 'min:7', 'max:15', new CheckValidPhone()],
            'email' => [$rules['email'], new CheckValidEmail()],
            'company_name' => $rules['company_name'],
            'type_of_place' => $rules['type_of_place'],
            'address_1' => $rules['address_1'],
            'address_2' => $rules['address_2'],
            'city' => $rules['city'],
            'zip' => $rules['zip'],
            'country' => $rules['country'],
            'state' => $rules['state'],
            'is_default' => 'required|in:0,1',
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
            'is_default.in' => __('Default value must be either 0 or 1'),
            'type_of_place.in' => __('Type of place must be either home or office.'),
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'user_id' => $this->user_id ?? auth()->user()->id ?? null,
            'is_default' => $this->is_default ?? isset($this->default_future) && $this->default_future == 'on' ? 1 : 0,
            'phone' => $this->dial_code . $this->phone,
        ]);
    }
}
