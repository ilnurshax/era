<?php
/**
 * Created by PhpStorm.
 * User: nur
 * Date: 06.06.2018
 * Time: 14:32
 */

namespace Ilnurshax\Era\Database\Eloquent\Repository\Specifications;


use Ilnurshax\Era\Database\Eloquent\Repository\Repository;
use Ilnurshax\Era\Specifications\Specification;
use Ilnurshax\Era\Specifications\SpecificationAsQuery;
use Illuminate\Database\Eloquent\Model;

class IdShouldEqualsTo implements Specification, SpecificationAsQuery
{

    /**
     * @var
     */
    private $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Check is the given Model ID equals to another ID
     *
     * @param Model $model
     * @return bool
     */
    public function check(Model $model)
    {
        return $model->id == $this->id;
    }

    public function asQuery($query)
    {
        return Repository::instance()->queryById($query, $this->id);
    }
}
