<?php

namespace Modules\Subscription\Rules;

use Illuminate\Contracts\Validation\Rule;

class DecimalValidator implements Rule
{
    private $before;

    private $after;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($before = 8, $after = 8)
    {
        $this->before = $before;

        $this->after = $after;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return preg_match('/^[0-9]{1,' . $this->before . '}(\.[0-9]{1,' . $this->after . '})?$/', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('The :attribute field is invalid.');
    }
}
