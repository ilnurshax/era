<?php
/**
 * Created by PhpStorm.
 * User: nur
 * Date: 24.05.2018
 * Time: 15:15
 */

namespace Ilnurshax\Era\Support\Container;


abstract class Container
{
    /**
     * Returns the newly instance
     *
     * @return $this
     */
    public static function instance()
    {
        return new static();
    }
}
