<?php

namespace Ilnurshax\Era\Validation\Rules;

use Illuminate\Contracts\Validation\Rule;

class Password implements Rule
{

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return preg_match('/^(?=.*\d)(?=.*[a-zA-Z])[0-9a-zA-Z]+$/', $value) > 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.password');
    }
}
