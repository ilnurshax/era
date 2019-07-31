<?php
/**
 * Created by PhpStorm.
 * User: Nur
 * Date: 15.09.2018
 * Time: 12:13
 */

namespace Ilnurshax\Era\Support;


trait CanDebug
{

    /**
     * Dump the given arguments and die
     *
     * @param mixed ...$args
     * @return CanDebug
     */
    public function dd(...$args)
    {
        dd(...$args);

        return $this;
    }

    /**
     * Dump the given arguments
     *
     * @param mixed ...$args
     * @return CanDebug
     */
    public function dump(...$args)
    {
        dump(...$args);

        return $this;
    }

    /**
     * Variable dump the given arguments and die
     *
     * @param mixed ...$args
     * @return CanDebug
     */
    public function vdd(...$args)
    {
        vdd(...$args);

        return $this;
    }
}
