<?php
/**
 * Created by PhpStorm.
 * User: nur
 * Date: 04.05.2018
 * Time: 18:16
 */

namespace Ilnurshax\Era\Support;


trait CanPipeClosures
{

    /**
     * Call the given closure only when condition is true
     *
     * @param $condition
     * @param callable $closure
     * @return $this
     */
    public function when($condition, callable $closure)
    {
        if ($condition) {
            $closure();
        }

        return $this;
    }

    /**
     * Handles the given closure
     *
     * @param callable $closure
     * @return static
     */
    public function pipe(callable $closure)
    {
        $closure();

        return $this;
    }

    /**
     * Handles the given closure
     *
     * @param callable $closure
     * @return static
     */
    public function then(callable $closure)
    {
        $closure();

        return $this;
    }

    /**
     * Calls the given closure if it is a callable
     *
     * @param callable|null $closure
     * @param array $args
     * @return CanPipeClosures
     */
    protected function callIfCallable(callable $closure = null, ...$args)
    {
        callIfCallable($closure, ...$args);

        return $this;
    }
}
