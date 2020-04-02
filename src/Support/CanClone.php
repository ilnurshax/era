<?php
/**
 * Created by PhpStorm.
 * User: nur
 * Date: 30.03.2018
 * Time: 10:29
 */

namespace Ilnurshax\Era\Support;


trait CanClone
{

    protected $cloned;

    /**
     * Clone the given objects and save the cloned objects to itself
     *
     * @param array ...$objects
     * @return $this
     */
    public function clone(...$objects)
    {
        $this->clearCloned();

        foreach ($objects as $object) {
            $this->cloned[] = clone value($object);
        }

        return $this;
    }

    /**
     * Pipes the cloned objects over given closure
     *
     * @param \Closure $closure
     * @return $this
     */
    public function cloned(\Closure $closure)
    {
        $closure(...$this->cloned);

        return $this;
    }

    /**
     * Clean the cloned objects repository
     */
    private function clearCloned()
    {
        $this->cloned = [];
    }
}
