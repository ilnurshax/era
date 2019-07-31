<?php
/**
 * Created by PhpStorm.
 * User: nur
 * Date: 01.06.2018
 * Time: 22:57
 */

namespace Ilnurshax\Era\Database\Eloquent\Repository;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait Queries
{

    /**
     * Query the models which has the exists given clause
     *
     * @param $query
     * @param \Closure $closure
     * @return $this
     */
    public function queryWhereExists($query, \Closure $closure)
    {
        $query->whereExists($closure);

        return $this;
    }

    /**
     * Query the models which has the given relation restricted with the given Closure
     *
     * @param $query
     * @param string $relation
     * @param \Closure $closure
     * @return $this
     */
    public function queryWhereHas(Builder $query, string $relation, \Closure $closure = null)
    {
        $query->whereHas($relation, $closure);

        return $this;
    }

    /**
     * Set the order to the query result records
     *
     * @param $query
     * @param string $column
     * @param string $order
     * @return $this
     */
    public function queryOrderBy($query, $column, $order = 'asc')
    {
        $query->orderBy($column, $order);

        return $this;
    }

    /**
     * Limit the query results by the given count
     *
     * @param $query
     * @param $count
     * @return $this
     */
    public function limit($query, $count)
    {
        $query->limit($count);

        return $this;
    }

    /**
     * Set the columns to be selected.
     *
     * @param $query
     * @param array|mixed $columns
     * @return $this
     */
    public function select($query, $columns = ['*'])
    {
        $query->select($columns);

        return $this;
    }

    /**
     * Query the models which the IDs should be in the given array of IDs
     *
     * @param $query
     * @param $ids
     * @return $this
     */
    public function queryIdsIn($query, $ids)
    {
        $query->whereIn('id', $ids);

        return $this;
    }

    /**
     * Query the models which the IDs should be NOT in the given array of IDs
     *
     * @param $query
     * @param $ids
     * @return $this
     */
    public function queryIdsNotIn($query, $ids)
    {
        $query->whereNotIn('id', $ids);

        return $this;
    }

    /**
     * Adds a rule to the given Query to query the record with the given ID
     *
     * @param $query
     * @param $id
     * @return $this
     */
    public function queryById($query, $id)
    {
        $query->where('id', $id);

        return $this;
    }

    /**
     * Queries only not deleted records
     *
     * @param $query
     * @return $this
     */
    public function queryNotDeleted($query)
    {
        $query->whereNull('deleted_at');

        return $this;
    }

    /**
     * Query the model by the given Value
     *
     * @param $query
     * @param $value
     * @return $this
     */
    public function queryByValue($query, $value)
    {
        $query->where('value', $value);

        return $this;
    }

    /**
     * Query the models by the is enabled attribute
     *
     * @param $query
     * @param $is_enabled
     * @return $this
     */
    public function queryByIsEnabled($query, $is_enabled)
    {
        $query->where('is_enabled', $is_enabled);

        return $this;
    }

    /**
     * Query the with trashed models by the given flag
     *
     * @param $query
     * @param bool $withTrashed
     * @return $this
     */
    public function queryWithTrashed($query, $withTrashed = true)
    {
        if ($withTrashed) {
            $query->withTrashed();
        }

        return $this;
    }

    /**
     * Query the only trashed models by the given flag
     *
     * @param $query
     * @param bool $onlyTrashed
     * @return $this
     */
    public function queryOnlyTrashed($query, $onlyTrashed = true)
    {
        if ($onlyTrashed) {
            $query->onlyTrashed();
        }

        return $this;
    }

    /**
     * Query the models which has been created between two dates
     *
     * @param Builder|HasMany $query
     * @param Carbon $from
     * @param Carbon $to
     * @return $this
     */
    public function queryByCreatedAtBetween($query, Carbon $from, Carbon $to)
    {
        $query->whereBetween('created_at', [$from->toDateTimeString(), $to->toDateTimeString()]);

        return $this;
    }
}
