<?php

namespace Ilnurshax\Era\Validation\Rules;

use Illuminate\Contracts\Validation\Rule;

class AlphaNumWithLineEnds implements Rule
{

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return preg_match('/^[\pL\pM\pN\n\s\.\,\!\-\;\:]+?$/', $value) > 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.alpha_num_with_line_ends');
    }
}
