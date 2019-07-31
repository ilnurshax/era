<?php
/**
 * Created by PhpStorm.
 * User: nur
 * Date: 07.05.2018
 * Time: 14:03
 */

namespace Ilnurshax\Era\Validation\Rules;


use Illuminate\Contracts\Validation\Rule;

class UniqueItems implements Rule
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
        $originalItemsCount = count($value);

        $uniqueItemsCount = collect($value)->unique()->count();

        if ($originalItemsCount == $uniqueItemsCount) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.unique_items');
    }
}
