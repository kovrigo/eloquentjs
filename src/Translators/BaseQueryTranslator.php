<?php

namespace Parsnick\EloquentJs\Translators;

use Illuminate\Database\Eloquent\Builder;
use InvalidArgumentException;

abstract class BaseQueryTranslator implements QueryTranslator
{
    /**
     * @var array
     */
    protected $allowedMethods = [
        'select', 'addSelect',
        'distinct',
        'where', 'orWhere',
        'whereBetween', 'orWhereBetween', 'whereNotBetween', 'orWhereNotBetween',
        'whereNested',
        'whereExists', 'orWhereExists', 'whereNotExists', 'orWhereNotExists',
        'whereIn', 'orWhereIn', 'whereNotIn', 'orWhereNotIn',
        'whereNull', 'orWhereNull', 'whereNotNull', 'orWhereNotNull',
        'whereDate', 'whereDay', 'whereMonth', 'whereYear',
        'groupBy',
        'having', 'orHaving',
        'orderBy', 'latest', 'oldest',
        'offset', 'skip', 'limit', 'take', 'forPage',
        'scope',
    ];

    /**
     * @var string
     */
    protected $stack;

    /**
     * Create a new BaseQueryTranslator instance.
     *
     * @param null|mixed $stack
     */
    public function __construct($stack = null)
    {
        if ($stack) {
            $this->source($stack);
        }
    }

    /**
     * Set the input which describes the query methods to call.
     *
     * @param $stack
     * @return $this
     */
    public function source($stack)
    {
        $this->stack = $stack;

        return $this;
    }

    /**
     * Apply the query methods described by $stack to the given $builder instance.
     *
     * @param Builder $builder
     * @return void
     */
    abstract public function applyTo(Builder $builder);

    /**
     * Apply the named $method call to the given $builder.
     *
     * @param Builder $builder
     * @param string $method
     * @param array $args
     */
    protected function callMethod($builder, $method, array $args)
    {
        if ( ! $this->isAllowed($method, $args)) {
            throw new InvalidArgumentException("Method [$method] not allowed.");
        }

        call_user_func_array([$builder, $method], $args);
    }

    /**
     * Check if the named method is allowed here.
     *
     * @param string $name
     * @param array $args
     * @return bool
     */
    protected function isAllowed($name, array $args)
    {
        return in_array($name, $this->allowedMethods);
    }
}
