<?php
/**
 * Created by PhpStorm.
 * User: nur
 * Date: 07.05.2018
 * Time: 14:03
 */

namespace Ilnurshax\Era\Validation\Rules;


use DateTime;
use Illuminate\Contracts\Validation\Rule;

class Time implements Rule
{

    protected $format = 'H:i:s';

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
            $date = DateTime::createFromFormat($this->format, $value);

            return $date && ($date->format($this->format) === $value);
        } catch (\Exception $e) {
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
        return trans('validation.time', ['format' => $this->format]);
    }
}
