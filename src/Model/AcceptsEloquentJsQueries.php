<?php

namespace EloquentJs\Model;

use Illuminate\Database\Eloquent\Builder;

/**
 * Interface AcceptsEloquentJsQueries
 * @deprecated
 */
interface AcceptsEloquentJsQueries
{
    /**
     * Scope to results matching an EloquentJs query.
     *
     * @param Builder $query query builder
     * @param string|null|callable $guard
     */
    public function scopeEloquentJs(Builder $query, $guard = null);

    /**
     * Get the endpoint for EloquentJs to use.
     *
     * @return string|null
     */
    public function getEndpoint();
}
