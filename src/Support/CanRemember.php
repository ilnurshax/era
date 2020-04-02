<?php
/**
 * Created by PhpStorm.
 * User: nur
 * Date: 30.03.2018
 * Time: 10:29
 */

namespace Ilnurshax\Era\Support;


trait CanRemember
{

    protected $remembered;

    /**
     * Remember the given objects and save the objects to itself
     *
     * @param array ...$objects
     * @return $this
     */
    public function remember(...$objects)
    {
        $this->clearRemembered();

        foreach ($objects as $object) {
            $this->remembered[] = value($object);
        }

        return $this;
    }

    /**
     * Pipes the objects over given closure
     *
     * @param \Closure $closure
     * @return $this
     */
    public function remembered(\Closure $closure)
    {
        $closure(...$this->remembered);

        return $this;
    }

    /**
     * Clean the remembered objects repository
     */
    private function clearRemembered()
    {
        $this->remembered = [];
    }
}
