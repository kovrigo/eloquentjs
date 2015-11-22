<?php

namespace Parsnick\EloquentJs;

use InvalidArgumentException;

class Applicator
{
    /**
     * @var null|string
     */
    protected $defaultStack;

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
    ];

    /**
     * Create a new Applicator instance.
     *
     * @param string $defaultStack a json-encoded list of query methods to call
     */
    public function __construct($defaultStack = null)
    {
        $this->defaultStack = $defaultStack;
    }

    /**
     * Apply the query methods from $stack (if set, otherwise
     * uses $defaultStack) to the given $builder instance.
     *
     * @param Builder $builder
     * @param null|string $stack
     */
    public function apply($builder, $stack = null)
    {
        $this->applyStack($builder, $stack ?: $this->defaultStack);
    }

    /**
     * Apply the query methods listed in $stack to the $builder object.
     *
     * @param Builder $builder
     * @param string $stackJson format: [["method1", ["method1Arg1", "method1Arg2"]], ...]
     */
    protected function applyStack($builder, $stackJson)
    {
        $stack = json_decode($stackJson);

        if ($stack === null) {
            throw new InvalidArgumentException('The query stack could not be decoded: '.json_last_error_msg());
        }

        foreach ($stack as list($method, $args)) {
            $this->applyMethod($builder, $method, $args);
        }
    }

    /**
     * Apply a method call to the builder.
     *
     * @param Builder $builder
     * @param string $method
     * @param array $args
     */
    protected function applyMethod($builder, $method, $args)
    {
        if ($this->isAllowed($method, $args)) {
            call_user_func_array([$builder, $method], $args);
        }
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
