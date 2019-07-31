<?php
/**
 * Created by PhpStorm.
 * User: nur
 * Date: 10.06.2018
 * Time: 12:31
 */

namespace Ilnurshax\Era\Database\Eloquent\Repository\Specifications;


use Ilnurshax\Era\Database\Eloquent\Repository\Repository;
use Ilnurshax\Era\Specifications\Specification;
use Ilnurshax\Era\Specifications\SpecificationAsQuery;
use Illuminate\Database\Eloquent\Model;

class ShouldNotBeenDeleted implements Specification, SpecificationAsQuery
{

    /**
     * Check is the given Model is not Soft Deleted
     *
     * @param Model $model
     * @return mixed
     */
    public function check(Model $model)
    {
        return !$model->trashed();
    }

    public function asQuery($query)
    {
        Repository::instance()->queryNotDeleted($query);
    }
}
