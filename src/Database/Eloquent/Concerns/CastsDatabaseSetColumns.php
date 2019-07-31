<?php
/**
 * Created by PhpStorm.
 * User: Nur
 * Date: 19.09.2018
 * Time: 10:21
 */

namespace Ilnurshax\Era\Database\Eloquent\Concerns;


trait CastsDatabaseSetColumns
{

    /**
     * Get the SET type value from the database
     *
     * @param $value
     * @param iterable|null $castTo
     * @return \Illuminate\Support\Collection
     * @throws \Exception
     */
    public static function getSetValueAttribute($value, iterable $castTo = null)
    {
        if (empty($value)) {
            return collect();
        }

        if (empty($castTo)) {
            return collect(explode(',', $value));
        }

        throw new \Exception("The casting way is undefined yet: {$value}");
    }

    /**
     * Set the SET type value before saving it in database
     *
     * @param iterable $values
     * @return string
     */
    public static function setSetValueAttribute(iterable $values)
    {
        return implode(',', $values);
    }
}
