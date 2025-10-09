<?php

namespace Modules\Subscription\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Subscription\Rules\DecimalValidator;

class PackageStoreRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'name' => 'required|max:100',
            'code' => 'nullable|min:3|max:45|unique:packages,code',
            'short_description' => 'nullable|max:191',
            'sale_price.*' => ['nullable', new DecimalValidator],
            'discount_price.*' => ['nullable', 'lte:sale_price.*', new DecimalValidator],
            'billing_cycle' => 'required',
            'meta.*.duration' => 'nullable|numeric|between:1,365',
            'sort_order' => 'nullable|numeric|between:0,10000',
            'trial_day' => 'nullable|numeric|between:1,365',
            'usage_limit' => 'nullable|numeric|between:1,365',
            'renewable' => 'required|boolean',
            'is_private' => 'required|in:0,1',
            'status' => 'required|in:Active,Pending,Inactive,Expired,Paused,Cancel',
        ];
    }
    
    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'sale_price.lifetime' => __('Lifetime sale price'),
            'sale_price.yearly' => __('Yearly sale price'),
            'sale_price.monthly' => __('Monthly sale price'),
            'sale_price.weekly' => __('Weekly sale price'),
            'sale_price.days' => __('Day sale price'),
            
            'discount_price.lifetime' => __('Lifetime discount price'),
            'discount_price.yearly' => __('Yearly discount price'),
            'discount_price.monthly' => __('Monthly discount price'),
            'discount_price.weekly' => __('Weekly discount price'),
            'discount_price.days' => __('Day discount price'),
            'meta.*.duration' => __('Duration')
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'discount_price.days.lte' => __('The :x discount price field must be less than or equal to sale price.', ['x' => __('Days')]),
            'discount_price.weekly.lte' => __('The :x discount price field must be less than or equal to sale price.', ['x' => __('Weekly')]),
            'discount_price.monthly.lte' => __('The :x discount price field must be less than or equal to sale price.', ['x' => __('Monthly')]),
            'discount_price.yearly.lte' => __('The :x discount price field must be less than or equal to sale price.', ['x' => __('Yearly')]),
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $data = [];

        foreach ($this->sale_price as $key => $value) {
            $data["sale_price"][$key] = validateNumbers($value);
            $data["discount_price"][$key] = $this->discount_price[$key] ? validateNumbers($this->discount_price[$key]) : null;
        }
        $data['billing_cycle'] = in_array('1', $this->billing_cycle) ? $this->billing_cycle : '';

        $this->merge($data);
    }
}
