<?php

namespace EloquentJs\Model;

use DateTime;
use InvalidArgumentException;
use EloquentJs\Events\EloquentJsWasCalled;
use UnexpectedValueException;

trait EloquentJsQueries
{
    /**
     * @var bool
     */
    static protected $overrideDates = false;

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

        static::$overrideDates = true;
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
     * Override the date serializer.
     *
     * When we're sending data back to our javascript, we want
     * dates in a predictable js-friendly format. At all other times,
     * defer back to the parent method.
     *
     * This seems like a rather ugly hack. :(
     *
     * @param DateTime $date
     * @return string
     */
    protected function serializeDate(DateTime $date)
    {
        if (static::$overrideDates) {
            return $date->toIso8601String();
        }

        return parent::serializeDate($date);
    }
}
