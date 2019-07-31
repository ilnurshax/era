<?php
/**
 * Created by PhpStorm.
 * User: Nur
 * Date: 14.09.2018
 * Time: 10:41
 */

namespace Ilnurshax\Era\Validation\Rules;


class Rule extends \Illuminate\Validation\Rule
{

    /**
     * Returns the min rule constraint
     *
     * @param $min
     * @return string
     */
    public static function min($min)
    {
        return 'min:' . $min;
    }
}
