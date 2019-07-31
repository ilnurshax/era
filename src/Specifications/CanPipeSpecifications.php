<?php
/**
 * Created by PhpStorm.
 * User: nur
 * Date: 04.05.2018
 * Time: 18:37
 */

namespace Ilnurshax\Era\Specifications;


use Illuminate\Support\Collection;

trait CanPipeSpecifications
{

    /**
     * Pipes the given Query through the given Specifications
     *
     * @param array|Collection|SpecificationAsQuery $specifications
     * @param $query
     * @return $this
     */
    protected function pipeQueryThroughSpecifications($query, $specifications)
    {
        (new SpecificationPipeline($specifications))->with($query);

        return $this;
    }
}
