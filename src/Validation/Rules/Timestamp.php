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

class Timestamp implements Rule
{

    public function passes($attribute, $value)
    {
        try {
            Carbon::createFromTimestamp($value);
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    public function message()
    {
        return 'The :attribute should be in the UNIX-timestamp format.';
    }
}
