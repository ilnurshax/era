<?php
/**
 * Created by PhpStorm.
 * User: nur
 * Date: 30.03.2018
 * Time: 10:29
 */

namespace Ilnurshax\Era\Support;


use Illuminate\Support\Collection;

trait CanClone
{

    protected $cloned;

    /**
     * Clone the given objects
     *
     * @param array ...$objects
     * @return $this
     */
    public function clone(...$objects)
    {
        $this->clearCloned();

        foreach ($objects as $object) {
            $value = value($object);

            if ($value instanceof Collection) {
                $this->cloned[] = clone $value->map(function ($item, $key) {
                    return clone $item;
                });

                continue;
            }

            $this->cloned[] = clone $value;
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
