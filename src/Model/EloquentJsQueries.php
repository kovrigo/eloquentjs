<?php

namespace EloquentJs\Model;

use Carbon\Carbon;
use DateTime;
use InvalidArgumentException;
use EloquentJs\Events\EloquentJsWasCalled;
use UnexpectedValueException;

trait EloquentJsQueries
{
    /**
     * Scope to results that satisfy the string-encoded list of query methods described by $stack.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $stack
     */
    public function scopeUseEloquentJs($query, $stack = null)
    {
        if ( ! static::$dispatcher) {
            throw new UnexpectedValueException(
                'Event dispatcher not found. Install illuminate/events package for EloquentJS usage without Laravel.'
            );
        }

        static::$dispatcher->fire(new EloquentJsWasCalled($query, $stack));
    }

    /**
     * Handle dynamic calls to scope methods.
     *
     * Yes, this is indeed a scope for calling another scope method.
     * While there are other ways we could support scopes, this has
     * the benefit of requiring no special treatment in our BaseQueryTranslator
     * - no different from how we handle `where`, `orderBy`, etc.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $name
     * @param array $parameters
     */
    public function scopeScope($query, $name, $parameters = [])
    {
        $methodName = 'scope'.ucfirst($name);

        if ( ! method_exists($this, $methodName)) {
            throw new InvalidArgumentException("No such scope [$name]");
        }

        array_unshift($parameters, $query);
        call_user_func_array([$this, $methodName], $parameters);
    }

    /**
     * Prepare a date for array / JSON serialization.
     *
     * Overrides the date serializer to ensure our Javascript can
     * understand the format.
     *
     * @todo  implement date handling without global side effects
     * @param DateTime $date
     * @return string
     */
    protected function serializeDate(DateTime $date)
    {
        return $date->toIso8601String();
    }

    /**
     * Return a timestamp as DateTime object.
     *
     * Accept dates from Javascript in any format that Carbon recognises.
     *
     * @param  string $value
     * @return Carbon
     */
    protected function asDateTime($value)
    {
        return Carbon::parse($value);
    }
}
