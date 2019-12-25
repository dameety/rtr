<?php

namespace App\Rules;

use App\Enums\OrderStatus;
use Illuminate\Contracts\Validation\Rule;

class ValidOrderStatus implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return OrderStatus::hasValue($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The selected order status is invalid.';
    }
}
