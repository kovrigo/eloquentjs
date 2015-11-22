<?php

namespace Parsnick\EloquentJs;

trait JsQueryable
{
    /**
     * @var Applicator
     */
    static protected $jsQueryApplicator;

    /**
     * Boot the trait.
     *
     * Fetches the default eloquentjs query applicator - this is
     * the class that translates the JSON-encoded list of query methods
     * to an Eloquent query builder.
     */
    public static function bootJsQueryable()
    {
        static::$jsQueryApplicator = app('eloquentjs.applicator');
    }

    /**
     * Apply the given $stack to the $query object.
     *
     * $stack is a JSON-encoded list of query methods to call.
     * If omitted, the "query" input from the current request is used.
     * See the ServiceProvider.
     *
     * @param Builder $query
     * @param null|string $stack
     */
    public function scopeApplyJsQuery($query, $stack = null)
    {
        static::$jsQueryApplicator->apply($query, $stack);
    }
}
