<?php

namespace EloquentJs\Events;

use Illuminate\Database\Eloquent\Builder;

class EloquentJsWasCalled
{
    /**
     * @var Builder
     */
    public $builder;

    /**
     * @var null|string
     */
    public $stack;

    /**
     * Create a new event instance
     *
     * @param Builder $builder
     * @param null|string $stack a string representation of query methods to call
     */
    public function __construct(Builder $builder, $stack = null)
    {
        $this->builder = $builder;
        $this->stack = $stack;
    }
}
