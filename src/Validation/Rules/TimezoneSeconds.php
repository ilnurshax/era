<?php
/**
 * Created by PhpStorm.
 * User: nur
 * Date: 30.03.2018
 * Time: 8:28
 */

namespace Ilnurshax\Era\Validation\Rules;


use Illuminate\Contracts\Validation\Rule;

class TimezoneSeconds implements Rule
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
        $timezoneName = timezone_name_from_abbr('', $value, 1);

        // Workaround for bug #44780
        if ($timezoneName === false) {
            $timezoneName = timezone_name_from_abbr('', $value, 0);
        }

        if ($timezoneName === false) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.timezone_seconds');
    }
}
