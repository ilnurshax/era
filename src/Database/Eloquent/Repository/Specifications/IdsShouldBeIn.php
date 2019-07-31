<?php
/**
 * Created by PhpStorm.
 * User: nur
 * Date: 01.06.2018
 * Time: 22:52
 */

namespace Ilnurshax\Era\Database\Eloquent\Repository\Specifications;


use Ilnurshax\Era\Database\Eloquent\Repository\Repository;
use Ilnurshax\Era\Specifications\SpecificationAsQuery;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class IdsShouldBeIn implements SpecificationAsQuery
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
            ->reject(function (Model $model, $key) {
                return in_array($model->id, $this->ids);
            })
            ->count();

        return $count == 0;
    }

    public function asQuery($query)
    {
        Repository::instance()->queryIdsIn($query, $this->ids);
    }
}
