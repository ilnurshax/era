<?php
/**
 * Created by PhpStorm.
 * User: nur
 * Date: 10.01.2018
 * Time: 16:47
 */

namespace Ilnurshax\Era\Validation\Rules;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class TimestampShouldBeGreaterThanNow implements Rule
{

    /**
     * Check is the attribute timestamp value is greater than the another timestamp attribute
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        try {
            return Carbon::createFromTimestamp($value)->gt(now());
        } catch (\Exception $e) {
            return false;
        }
    }

    public function message()
    {
        return "The :attribute attribute should be greater than the current date and time.";
    }
}
