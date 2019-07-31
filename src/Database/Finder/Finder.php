<?php
/**
 * Created by PhpStorm.
 * User: nur
 * Date: 08.11.2017
 * Time: 13:05
 */

namespace Ilnurshax\Era\Database\Finder;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

abstract class Finder
{

    /**
     * The default count of records which should be given from data source
     *
     * @var int
     */
    protected $limit = 10;
    /**
     * The default count of records which should be skipped
     *
     * @var int
     */
    protected $offset = 0;
    /**
     * The count of total records without applying limit and offset
     *
     * @var int
     */
    protected $total;
    /**
     * Should total count of records be calculated or not
     *
     * @var bool
     */
    protected $withTotal = true;
    /**
     * Should pagination be applied or not
     *
     * @var bool
     */
    protected $applyPagination = true;

    /**
     * Set the limit count of the query
     *
     * @param $limit
     * @return Finder
     */
    public function setLimit($limit)
    {
        if (!empty($limit)) {
            $this->limit = $limit;
        }

        return $this;
    }

    /**
     * Set the offset of the query
     *
     * @param $offset
     * @return Finder
     */
    public function setOffset($offset)
    {
        if (!empty($offset)) {
            $this->offset = $offset;
        }

        return $this;
    }

    /**
     * Set the flag to describe does the finder should get the 'total' records count or not
     *
     * @param bool $with
     * @return $this
     */
    public function shouldCountTotal(bool $with = true)
    {
        $this->withTotal = $with;

        return $this;
    }

    /**
     * Set the flag to describe does the finder should apply pagination to the result query/collection or not
     *
     * @param bool $applyPagination
     * @return $this
     */
    public function shouldApplyPagination(bool $applyPagination = true)
    {
        $this->applyPagination = $applyPagination;

        return $this;
    }

    /**
     * Set pagination settings by the given data
     *
     * @param iterable $container
     * @return Finder
     */
    public function setPaginationFrom(iterable $container)
    {
        $this
            ->setOffset($container['offset'] ?? null)
            ->setLimit($container['limit'] ?? null);

        return $this;
    }

    /**
     * Returns the result collection of the Query
     *
     * @param array $searches
     * @return Collection
     */
    public function search(array $searches = [])
    {
        $query = $this->buildQuery($searches);

        if ($this->withTotal) {
            $this->setTotalFromQuery($query);
        }

        if ($this->applyPagination) {
            $query = $this->applyLimitAndOffset($query);
        }

        $collection = $this->getCollectionFromQuery($query);

        return $collection;
    }

    /**
     * Build your own query with custom where's, orderBy's, etc.
     *
     * @param array $searches
     * @return Builder|Collection
     */
    abstract protected function buildQuery(array $searches = []);

    /**
     * Set the total records count by the finder
     *
     * @param $count
     * @return $this
     */
    protected function setTotal($count)
    {
        $this->total = $count;

        return $this;
    }

    /**
     * Build your own collection with your own conditions by the given Query
     *
     * @param Builder|Collection $query
     * @return Collection
     */
    abstract protected function getCollectionFromQuery($query);

    /**
     * Returns the total records count by the finder query
     *
     * @return int
     */
    public function total(): int
    {
        return $this->total;
    }

    /**
     * Returns the limit count
     *
     * @return int
     */
    public function limit(): int
    {
        return $this->limit;
    }

    /**
     * Returns the offset count
     *
     * @return int
     */
    public function offset(): int
    {
        return $this->offset;
    }

    /**
     * Returns the meta information of the finder
     *
     * @return array
     */
    public function meta()
    {
        return [
            'meta' => [
                'offset' => $this->offset(),
                'limit'  => $this->limit(),
                'total'  => $this->total(),
            ]
        ];
    }

    /**
     * Applies limit and offset functions depending on the given Query type.
     * When the query it is the Collection, when we need to return the
     * restricted Collection instance directly from the method.
     *
     * @param $query
     * @return Collection|Builder
     */
    private function applyLimitAndOffset($query)
    {
        if ($query instanceof Collection) {
            return $query
                ->slice($this->offset)
                ->take($this->limit);
        }

        return $query
            ->offset($this->offset)
            ->limit($this->limit);
    }

    /**
     * Set the total rows count from the given query
     *
     * @param Builder $query
     * @return $this
     */
    protected function setTotalFromQuery($query)
    {
        if ($query instanceof Builder) {
            /**
             * We should call the method which properly count the rows count
             * even if the 'groupBy' has been set
             */
            $count = $query->getQuery()->getCountForPagination();
        } elseif ($query instanceof Collection) {
            $count = $query->count();
        } else {
            throw new \Exception("The count() function is not defined for the query [".get_class($query)."].");
        }

        $this->setTotal($count);

        return $this;
    }
}
