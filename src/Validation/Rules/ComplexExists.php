<?php
/**
 * Created by PhpStorm.
 * User: nur
 * Date: 10.01.2018
 * Time: 16:47
 */

namespace Ilnurshax\Era\Validation\Rules;

use Illuminate\Contracts\Validation\Rule;

class ComplexExists implements Rule
{

    /**
     * @var callable
     */
    private $closure;

    public function __construct(callable $closure)
    {
        $this->closure = $closure;
    }

    public function passes($attribute, $value)
    {
        $closure = $this->closure;

        return $closure($attribute, $value);
    }

    public function message()
    {
        return trans('validation.exists');
    }
}
