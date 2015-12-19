<?php

namespace EloquentJs\Query\Events;

use EloquentJs\Query\Guard\EloquentJsPolicy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class EloquentJsWasCalled
{
    /**
     * @var Builder
     */
    public $builder;

    /**
     * @var null|string|callable
     */
    public $rules;

    /**
     * Create a new event instance
     *
     * @param Builder $builder
     * @param null|string|callable $rules
     */
    public function __construct(Builder $builder, $rules = null)
    {
        $this->builder = $builder;
        $this->rules = $rules;
    }

    /**
     * Get the policy registered for this model.
     *
     * @param Model $model
     * @return mixed|null
     */
    protected function XgetModelPolicy(Model $model)
    {
        try {
            $policy = policy($model);

            if (is_subclass_of($policy, EloquentJsPolicy::class)) {
                return $policy;
            }
        } catch (\InvalidArgumentException $exception) {}

        return null;
    }
}
