<?php
/**
 * Created by PhpStorm.
 * User: nur
 * Date: 30.04.2018
 * Time: 22:34
 */

namespace Ilnurshax\Era\Support;


use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;

abstract class ArrayableModel implements Arrayable
{

    protected $attributes = [];

    public function __construct($attributes = [])
    {
        $this->attributes = valueAsIterable($attributes);

        $this->callValidateAttributesIfExists();
    }

    private function callValidateAttributesIfExists(): void
    {
        if (method_exists($this, 'validateAttributes')) {
            $this->validateAttributes($this->attributes);
        }
    }

    public function __isset($name)
    {
        return !empty($this->attributes[$name]);
    }

    public function __get($name)
    {
        return $this->attributes[$name] ?? null;
    }

    public function __set($name, $value)
    {
        $this->attributes[$name] = $value;

        $this->callValidateAttributesIfExists();
    }

    /**
     * Get the attribute value using "dot" notation
     *
     * @param string $key
     * @param null $default
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        return Arr::get($this->attributes, $key, $default);
    }

    /**
     * Returns the instance attributes as an array
     *
     * @return array|iterable
     */
    public function toArray()
    {
        return $this->attributes;
    }

    /**
     * Returns the instance attributes as the Collection
     *
     * @return \Illuminate\Support\Collection
     */
    public function toCollection()
    {
        return collect($this->attributes);
    }
}
