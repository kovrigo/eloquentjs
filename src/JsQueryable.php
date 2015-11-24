<?php

namespace Parsnick\EloquentJs;

use InvalidArgumentException;

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

    /**
     * Handle dynamic calls to scope methods.
     *
     * Yes, this is indeed a scope for calling another scope method.
     * While there are other ways we could support scopes, this has
     * the benefit of requiring no special treatment in our Applicator
     * - no different from how we handle `where`, `orderBy`, etc.
     *
     * @param Builder $query
     * @param string $name
     * @param array $parameters
     */
    public function scopeScope($query, $name, $parameters = [])
    {
        $methodName = 'scope'.ucfirst($name);

        if ( ! method_exists($this, $methodName)) {
            throw new InvalidArgumentException("No such scope: $name");
        }

        array_unshift($parameters, $query);
        call_user_func_array([$this, $methodName], $parameters);
    }
}
