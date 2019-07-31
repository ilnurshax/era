<?php
/**
 * Created by PhpStorm.
 * User: nur
 * Date: 30.04.2018
 * Time: 8:58
 */

namespace Ilnurshax\Era\Specifications;


use Illuminate\Support\Collection;

class SpecificationPipeline
{

    /**
     * Specifications to pipe through pipeline
     *
     * @var SpecificationAsQuery|array|Collection
     */
    private $specifications;

    /**
     * SpecificationPipeline constructor.
     * @param array|Collection|SpecificationAsQuery $specifications
     */
    public function __construct($specifications)
    {
        $this->specifications = $specifications;
    }

    /**
     * Pipe the given Query through the Specifications
     *
     * @param $query
     */
    public function with($query)
    {
        if (empty($this->specifications)) {
            return;
        }

        if ($this->specifications instanceof SpecificationAsQuery) {
            $this->specifications->asQuery($query);

            return;
        }

        foreach ($this->specifications as $specification) {
            $specification->asQuery($query);
        }
    }
}
