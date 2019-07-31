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

class TimestampShouldBeGreaterThan implements Rule
{

    /**
     * @var
     */
    private $input;

    public function __construct($input)
    {
        $this->input = $input;
    }

    /**
     * Check is the attribute timestamp value is greater than the another timestamp attribute
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        /**
         * The attribute that should be less may be not validated as timestamp
         */
        try {
            $shouldBeLess = Carbon::createFromTimestamp(request($this->input));
        } catch (\Exception $e) {
            return false;
        }

        try {
            return Carbon::createFromTimestamp($value)->gt($shouldBeLess);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function message()
    {
        return "The :attribute should be greater than {$this->input} attribute.";
    }
}
