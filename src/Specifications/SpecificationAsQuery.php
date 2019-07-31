<?php
/**
 * Created by PhpStorm.
 * User: nur
 * Date: 30.04.2018
 * Time: 9:01
 */

namespace Ilnurshax\Era\Specifications;


interface SpecificationAsQuery
{

    /**
     * Set the specification rules to the given Query
     *
     * @param $query
     */
    public function asQuery($query);
}
