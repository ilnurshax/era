<?php
/**
 * Created by PhpStorm.
 * User: Nur
 * Date: 29.08.2018
 * Time: 9:36
 */

namespace Ilnurshax\Era\Database\Eloquent\Repository\Specifications;


use Ilnurshax\Era\Database\Eloquent\Repository\Repository;
use Ilnurshax\Era\Specifications\SpecificationAsQuery;

class ShouldLimitedCount implements SpecificationAsQuery
{

    /**
     * @var int
     */
    private $count;

    public function __construct($count = 1)
    {
        $this->count = $count;
    }

    public function check(iterable $collection)
    {
        return count($collection) == $this->count;
    }

    public function asQuery($query)
    {
        Repository::instance()->limit($query, $this->count);
    }
}
