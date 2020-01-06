<?php
/**
 * Created by PhpStorm.
 * User: Nur
 * Date: 08.08.2018
 * Time: 9:11
 */

namespace Ilnurshax\Era\Support\Http\Common;


trait AdaptedToRoutes
{

    /**
     * Returns the pare of basename of the called class and the given method
     *
     * @param string $method
     * @return string
     */
    public static function at(string $method = '')
    {
        if (empty($method)) {
            return class_basename(static::class);
        }

        return class_basename(static::class) . "@{$method}";
    }

}
