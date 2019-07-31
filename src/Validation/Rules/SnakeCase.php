<?php
/**
 * Created by PhpStorm.
 * User: Nur
 * Date: 03.08.2018
 * Time: 12:33
 */

namespace Ilnurshax\Era\Validation\Rules;


use Illuminate\Contracts\Validation\Rule;

class SnakeCase implements Rule
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
        return preg_match('/^([a-z_\d])+$/', $value) > 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "The :attribute should be in snake_case format.";
    }
}
