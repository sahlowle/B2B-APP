<?php

namespace Modules\Subscription\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Subscription\Rules\DecimalValidator;

class PackageSubscriptionStoreRequest extends FormRequest
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
            'user_id' => 'nullable|exists:users,id',
            'package_id' => 'required|exists:packages,id',
            'activation_date' => 'required',
            'billing_date' => 'nullable',
            'next_billing_date' => 'nullable',
            'billing_price' => ['required', new DecimalValidator],
            'billing_cycle' => 'required|in:days,weekly,monthly,yearly,lifetime',
            'amount_billed' => ['required', new DecimalValidator],
            'amount_received' => ['required', new DecimalValidator],
            'amount_due' => ['required', new DecimalValidator],
            'is_customized' => 'required|boolean',
            'renewable' => 'required|boolean',
            'payment_status' => 'required|in:Paid,Unpaid',
            'status' => 'required|in:Active,Pending,Inactive,Expired,Paused,Cancel',
        ];
    }
}
