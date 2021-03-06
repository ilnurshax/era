<?php
/**
 * Created by PhpStorm.
 * User: nur
 * Date: 07.05.2018
 * Time: 14:03
 */

namespace Ilnurshax\Era\Validation\Rules;


use Illuminate\Contracts\Validation\Rule;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberUtil;

class PhoneNumber implements Rule
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
        try {
            PhoneNumberUtil::getInstance()->parse($value);

            return true;
        } catch (NumberParseException $e) {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $message = trans('validation.phone_number');

        if (!is_string($message)) {
            return 'The :attribute should contain the correct phone number in the E.164 international format.';
        }

        return $message;
    }
}
