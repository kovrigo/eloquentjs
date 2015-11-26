<?php

namespace EloquentJs\Translators;

use Illuminate\Database\Eloquent\Builder;

interface QueryTranslator
{
    /**
     * Set the input which describes the query methods to call.
     *
     * @param $stack
     * @return $this
     */
    public function source($stack);

    /**
     * Apply the query methods described by $stack to the given $builder instance.
     *
     * @param Builder $builder
     * @return void
     */
    public function applyTo(Builder $builder);
}
