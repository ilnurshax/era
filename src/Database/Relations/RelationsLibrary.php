<?php
/**
 * Created by PhpStorm.
 * User: Nur
 * Date: 14.08.2018
 * Time: 20:39
 */

namespace Ilnurshax\Era\Database\Relations;


use Ilnurshax\Era\Support\Container\Container;
use Illuminate\Support\Collection;
use IteratorAggregate;

/**
 * Class RelationsLibrary
 *
 * What we expect:
 * 1. Get all defined relations when the instance has been sent (new SomeRelations) only
 * 2. Get necessary relations only with fluid calling
 * 3. Get necessary relations with deeper relations (such as "customer.userable" or "customer.website")
 * 4. Get the necessary relation name as a string when calling relation as a property (such as "(new Relations)->relation)
 *
 * @package Application\Database\Relations
 */
abstract class RelationsLibrary extends Container implements IteratorAggregate
{

    /**
     * @var Collection The collection of relations
     */
    protected $relations;

    public function __construct()
    {
        $this->relations = collect();
    }

    /**
     * Get the relation name as a string by calling an attribute name
     *
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->$name()->last();
    }

    /**
     * Returns the relations as an array
     *
     * @return array
     */
    public function toArray(): array
    {
        $this->loadAllRelationsIfRelationsEmpty();

        return $this->keepUniqueRelations()->toArray();
    }

    /**
     * Loads the all relations if the relations is empty
     *
     * @return RelationsLibrary
     */
    private function loadAllRelationsIfRelationsEmpty(): RelationsLibrary
    {
        if ($this->relations->isEmpty()) {
            $this->relations();
        }

        return $this;
    }

    /**
     * Should dynamically call all necessary relations
     */
    abstract protected function relations(): void;

    /**
     * Returns the only unique relations from the relations container
     *
     * @return Collection
     */
    private function keepUniqueRelations(): Collection
    {
        return $this->relations->unique()->values();
    }

    /**
     * Returns an Iterator to iterate over the relations
     *
     * @return \ArrayIterator|\Traversable
     */
    public function getIterator()
    {
        $this->loadAllRelationsIfRelationsEmpty();

        return $this->keepUniqueRelations()->getIterator();
    }

    /**
     * The caller function name used as relation name. The child relation name can be used
     * to define the relation with child relations.
     *
     * @param array $childRelations
     * @return $this
     */
    protected function asRelation(array $childRelations = [])
    {
        list($one, $two, $caller) = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3);

        $relationName = $two['function'];

        if (empty($childRelations)) {
            $this->relations->push($relationName);

            return $this;
        }

        $this->addChildRelations($relationName, $childRelations);

        return $this;
    }

    /**
     * Returns the last added relation
     *
     * @return string
     */
    public function last(): string
    {
        if ($this->relations->isEmpty()) {
            throw new RelationsCollectionIsEmpty("Before calling the " . __FUNCTION__ . "() method this is required to add relation name to the relations collection.");
        }

        return $this->relations->last();
    }

    public function asString()
    {
        return $this->last();
    }

    /**
     * Add the relation name and the given child relations recursively
     *
     * @param string $relationName
     * @param array $childRelations
     */
    private function addChildRelations(string $relationName, array $childRelations = [])
    {
        foreach ($childRelations as $child) {
            if (!($child instanceof RelationsLibrary) && !is_array($child)) {
                $this->relations->push(empty($child) ? $relationName : "{$relationName}.{$child}");

                continue;
            }

            if ($child instanceof RelationsLibrary) {
                $childRelationsFromLibrary = $child->toArray();
            }

            if (is_array($child)) {
                $childRelationsFromLibrary = $child;
            }

            $this->addChildRelations($relationName, $childRelationsFromLibrary);
        }
    }
}
