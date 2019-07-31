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

class TimeShouldBeGreaterThan implements Rule
{

    protected $format = 'H:i:s';
    protected $inputWithLessTime;

    public function __construct($inputWithLessTime)
    {
        $this->inputWithLessTime = request()->input($inputWithLessTime);
    }

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
            $greaterTime = DateTime::createFromFormat($this->format, $value);
            $lessTime = DateTime::createFromFormat($this->format, $this->inputWithLessTime);

            if (!($greaterTime && ($greaterTime->format($this->format) === $value))) {
                return false;
            }

            if (!($lessTime && ($lessTime->format($this->format) === $value))) {
                return false;
            }

            return $greaterTime > $lessTime;
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
