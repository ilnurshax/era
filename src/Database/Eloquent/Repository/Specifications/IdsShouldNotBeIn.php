<?php
/**
 * Created by PhpStorm.
 * User: nur
 * Date: 01.06.2018
 * Time: 22:52
 */

namespace Ilnurshax\Era\Database\Eloquent\Repository\Specifications;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Ilnurshax\Era\Database\Eloquent\Repository\Repository;
use Ilnurshax\Era\Specifications\Specification;
use Ilnurshax\Era\Specifications\SpecificationAsQuery;

class IdsShouldNotBeIn implements Specification, SpecificationAsQuery
{

    /**
     * @var array|Collection
     */
    private $ids;

    public function __construct($ids)
    {
        $this->ids = $ids;
    }

    /**
     * Check is the given Collection of Models has the same IDs
     *
     * @param Collection $models
     * @return bool
     */
    public function check(Collection $models)
    {
        $count = $models
            // Keep all models which IDs present in the given IDs list
            ->filter(function (Model $model, $key) {
                return in_array($model->id, $this->ids);
            })
            ->count();

        /**
         * The resulting count should be 0, because the result collection should be empty.
         * Otherwise it means the collection contains some model which ID is present in the given IDs list.
         */
        return $count == 0;
    }

    public function asQuery($query)
    {
        Repository::instance()->queryIdsNotIn($query, $this->ids);
    }
}
