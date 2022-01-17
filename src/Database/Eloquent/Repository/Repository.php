<?php
/**
 * Created by PhpStorm.
 * User: nur
 * Date: 23.05.2018
 * Time: 13:45
 */

namespace Ilnurshax\Era\Database\Eloquent\Repository;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Ilnurshax\Era\Database\Relations\RelationsLibrary;
use Ilnurshax\Era\Specifications\CanPipeSpecifications;
use Ilnurshax\Era\Specifications\SpecificationAsQuery;
use Ilnurshax\Era\Support\CanClone;
use Ilnurshax\Era\Support\CanDebug;
use Ilnurshax\Era\Support\CanPipeClosures;
use Ilnurshax\Era\Support\Container\Container;

/**
 * Class Repository
 * @package Application\Eloquent\Repository
 * @version 0.5
 */
class Repository extends Container
{

    use CanDebug,
        CanPipeClosures,
        CanPipeSpecifications,
        CanClone,
        Queries;

    /**
     * @var Model Target Eloquent model
     */
    protected $target = 'App/User';

    /**
     * @var string|RelationsLibrary Relations which should be loaded
     */
    protected $relations = '';

    /**
     * @var bool Should repository try to load relations or not
     */
    public $shouldLoadRelations = true;

    /**
     * @var bool Should repository load trashed models or not
     */
    public $withTrashed = false;

    /**
     * @var bool Should repository load only trashed models or not
     */
    public $onlyTrashed = false;

    /**
     * @var array The columns which repository should load from database
     */
    public $columns = ['*'];

    /**
     * @var null|string The column to sort by
     */
    public $orderByColumn = null;
    /**
     * @var bool The sorting order
     */
    public $orderByDesc = true;

    /**
     * Repository constructor.
     */
    public function __construct()
    {
        $this->callBootRelationsIfDefined();
    }

    /**
     * Returns the new repository instance with disabled relations loading
     *
     * @return static
     */
    public function withoutRelations()
    {
        $repository = clone $this;
        $repository->shouldLoadRelations = false;

        return $repository;
    }

    /**
     * Replace the repository relations list with the given relations
     *
     * @param $relations
     * @return $this
     */
    public function withRelations($relations)
    {
        $this->relations = $relations;

        return $this;
    }

    /**
     * Returns the relations defined in relations attribute
     *
     * @return RelationsLibrary|array|string
     */
    protected function relations()
    {
        if ($this->relations instanceof RelationsLibrary) {
            return $this->relations->toArray();
        }

        return $this->relations;
    }

    /**
     * Returns the new repository instance which should load only some columns of the record
     *
     * @param array $columns
     * @return Repository
     */
    public function onlyColumns($columns = ['*'])
    {
        $repository = clone $this;
        $repository->columns = is_array($columns) ? $columns : func_get_args();

        return $repository;
    }

    /**
     * Returns the cloned repository instance which should load trashed models into each query
     *
     * @return Repository
     */
    public function withTrashed()
    {
        $repository = clone $this;
        $repository->withTrashed = true;

        return $repository;
    }

    /**
     * Returns the cloned repository instance which should load only trashed models into each query
     *
     * @return Repository
     */
    public function onlyTrashed()
    {
        $repository = clone $this;
        $repository->onlyTrashed = true;

        return $repository;
    }

    /**
     * Apply sorting by the some column
     *
     * @param string $column
     * @param bool $desc
     * @return Repository
     */
    public function orderBy(string $column, $desc = true)
    {
        $repository = clone $this;
        $repository->orderByColumn = $column;
        $repository->orderByDesc = $desc;

        return $repository;
    }

    /**
     * Returns the First Model by the given specifications or throws an Exception
     *
     * @param null|array|Collection|SpecificationAsQuery $specifications
     * @param callable $whenFound
     * @return mixed
     */
    public function firstBySpecificationsOrFail($specifications = null, callable $whenFound = null)
    {
        $model = $this->firstBySpecifications($specifications);

        if (empty($model)) {
            throw (new ModelNotFoundException)->setModel($this->target);
        }

        $this->callIfCallable($whenFound, $model);

        return $model;
    }

    /**
     * Returns the First Model by the given specifications with all relations loaded
     *
     * @param null|array|Collection|SpecificationAsQuery $specifications
     * @param \Closure $then The closure where the model should being passed. The passed value can be null.
     * @return mixed
     */
    public function firstBySpecifications($specifications = null, \Closure $then = null)
    {
        $query = $this->queryBySpecifications($specifications);

        $model = $query->first();

        callIfCallable($then, $model);

        return $model;
    }

    /**
     * Determine if any model exists for the given specifications
     *
     * @param null $specifications
     * @return bool
     */
    public function existsBySpecifications($specifications = null)
    {
        $query = $this->queryBySpecifications($specifications);

        return $query->exists();
    }

    /**
     * Returns the Random First Model by the given specifications with all relations loaded
     *
     * @param null|array|Collection|SpecificationAsQuery $specifications
     * @return mixed
     */
    public function firstRandomBySpecifications($specifications = null)
    {
        $query = $this
            ->queryBySpecifications($specifications)
            ->inRandomOrder();

        $model = $query->first();

        return $model;
    }

    /**
     * Returns the Collection of Models by the given specifications with all relations loaded
     *
     * @param null|array|Collection|SpecificationAsQuery $specifications
     * @param \Closure|null $map
     * @return Collection
     */
    public function allBySpecifications($specifications = null, \Closure $map = null)
    {
        $query = $this->queryBySpecifications($specifications);

        $collection = $query->get();

        if ($map instanceof \Closure) {
            $collection = $collection->map($map);
        }

        return $collection;
    }

    /**
     * Returns the records count by the given specifications
     *
     * @param  null|array|Collection|SpecificationAsQuery  $specifications
     * @return int
     */
    public function countBySpecifications($specifications = null)
    {
        return $this->queryBySpecifications($specifications)->count();
    }

    /**
     * Add the eager loading of relations of the User to the given Query
     *
     * @param Builder $query
     * @param array|string $relations
     * @return $this
     */
    public function queryRelations(Builder $query, $relations = '')
    {
        if (!$this->shouldLoadRelations) {
            return $this;
        }

        if (empty($relations)) {
            $relations = $this->relations();
        }

        if (!empty($relations)) {
            $query->with($relations);
        }

        return $this;
    }

    /**
     * Load the given relations to the given Model
     *
     * @param Model $model
     * @param string $relations
     * @return $this
     */
    public function loadRelations(Model $model, $relations = '')
    {
        if (empty($relations)) {
            $relations = $this->relations();
        }

        $model->load($relations);

        return $this;
    }

    /**
     * Load the only missing relations to the given Model
     *
     * @param Model $model
     * @param string $relations
     * @return $this
     */
    public function loadMissingRelations(Model $model, $relations = '')
    {
        if (empty($relations)) {
            $relations = $this->relations();
        }

        $model->loadMissing($relations);

        return $this;
    }

    /**
     * Returns the Query Builder
     *
     * @param callable|null $then
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(callable $then = null)
    {
        $query = $this->instantiateATargetModel()::query();

        $this->queryTrashedModelsByTrashedFlags($query);

        if (!empty($this->orderByColumn)) {
            $this->queryOrderBy($query, $this->orderByColumn, $this->orderByDesc ? 'desc' : 'asc');
        }

        if (method_exists($this, 'restrictQuery')) {
            $this->restrictQuery($query);
        }

        $this->callIfCallable($then, $query);

        return $query;
    }

    /**
     * Returns the table name of the model
     *
     * @return mixed
     */
    public function getTable()
    {
        return $this->instantiateATargetModel()->getTable();
    }

    /**
     * Returns the key name of the model
     *
     * @return mixed
     */
    public function getKeyName()
    {
        return $this->instantiateATargetModel()->getKeyName();
    }

    /**
     * Creates a new model instance and saves it into database
     *
     * @param array $attributes
     * @param callable|null $then
     * @return mixed
     */
    public function create(array $attributes = [], callable $then = null)
    {
        $model = $this->instantiateATargetModel()::create($attributes);

        callIfCallable($then, $model);

        return $model;
    }

    /**
     * Create a new model instance and store it in database and then reload it from database
     *
     * @param array $attributes
     * @param callable|null $then
     * @return mixed
     */
    public function createAndRefresh(array $attributes = [], callable $then = null)
    {
        return $this->create($attributes, function ($model) use ($then) {
            $this->refresh($model, $then);
        });
    }

    /**
     * Reload the given model instance with fresh attributes from the database
     *
     * @param Model $model
     * @param callable|null $then
     * @return Repository
     */
    public function refresh(Model $model, callable $then = null)
    {
        $model->refresh();

        $this->loadRelations($model);

        callIfCallable($then, $model);

        return $this;
    }

    /**
     * Creates a new model instance without saving it in database
     *
     * @param array $attributes
     * @param callable|null $then
     * @return mixed
     */
    public function new(array $attributes = [], callable $then = null)
    {
        $model = new $this->target($attributes);

        callIfCallable($then, $model);

        return $model;
    }

    /**
     * Save the given Model into database
     *
     * @param Model $model
     * @param callable|null $then
     * @return static
     */
    public function save(Model $model, callable $then = null)
    {
        $model->save();

        callIfCallable($then, $model);

        return $this;
    }

    /**
     * Update the given Model with the given attributes
     *
     * @param Model|callable $model
     * @param array $attributes
     * @param callable|null $then
     * @return $this;
     */
    public function update($model, array $attributes = [], callable $then = null)
    {
        if (is_callable($model)) {
            $model = $model();
        }

        $model->update($attributes);

        callIfCallable($then, $model);

        return $this;
    }

    /**
     * Fill the given Model with the given attributes
     *
     * @param Model|callable $model
     * @param array|callable $attributes
     * @param callable|null $then
     * @return $this;
     */
    public function fill($model, $attributes = [], callable $then = null)
    {
        $model = value($model);

        $attributes = value($attributes);

        $model->fill($attributes);

        callIfCallable($then, $model);

        return $this;
    }

    /**
     * Deletes the given Model
     *
     * @param Model $model
     * @return bool|null
     * @throws \Exception
     */
    public function delete(Model $model)
    {
        return $model->delete();
    }

    /**
     * Queries the trashed models if the `trashed` flags has been set in the repository
     *
     * @param $query
     */
    protected function queryTrashedModelsByTrashedFlags($query)
    {
        if ($this->onlyTrashed) {
            $this->queryOnlyTrashed($query);

            return;
        }

        if ($this->withTrashed) {
            $this->queryWithTrashed($query);
        }
    }

    /**
     * Returns the query that already piped through specifications and relations loaded
     *
     * @param $specifications
     * @return Builder
     */
    public function queryBySpecifications($specifications): Builder
    {
        return $this
            ->query(function ($query) use ($specifications) {
                $this
                    ->pipeQueryThroughSpecifications($query, $specifications)
                    ->queryRelations($query)
                    ->select($query, $this->columns);
            });
    }

    /**
     * If the developer defined the own method to boot the relations
     * we should load relations from the defined method.
     */
    private function callBootRelationsIfDefined(): void
    {
        if (method_exists($this, 'bootRelations')) {
            $this->withRelations($this->bootRelations());
        }
    }

    /**
     * @return Model
     */
    protected function instantiateATargetModel()
    {
        return (new $this->target);
    }
}
