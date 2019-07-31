<?php
/**
 * Created by PhpStorm.
 * User: Nur
 * Date: 19.09.2018
 * Time: 10:10
 */

namespace Ilnurshax\Era\Database\Eloquent;


use Illuminate\Database\Eloquent\Model;

class ModelAccessor
{

    /**
     * @var Model
     */
    private $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Instantiates the new instance from the static context
     *
     * @param Model $model
     * @return ModelAccessor
     */
    public static function from(Model $model)
    {
        return new static($model);
    }

    /**
     * Returns the cast type by the given attribute name or returns null if the cast is not defined by attribute
     *
     * @param $key
     * @return null|string
     */
    public function getCastType($key)
    {
        if (!array_key_exists($key, $this->model->getCasts())) {
            return null;
        }

        return trim(strtolower($this->model->getCasts()[$key]));
    }
}
