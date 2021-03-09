<?php

namespace EloquentJs\Model;

use Carbon\Carbon;
use DateTime;
use EloquentJs\Query\Events\EloquentJsWasCalled;
use Illuminate\Database\Eloquent\Builder;
use InvalidArgumentException;
use UnexpectedValueException;

trait EloquentJsQueries
{
    /**
     * Scope to results that satisfy an EloquentJs query.
     *
     * @param Builder $query
     * @param string|null|callable $rules
     */
    public function scopeEloquentJs(Builder $query, $rules = null)
    {
        if ( ! static::$dispatcher) {
            throw new UnexpectedValueException(
                'Event dispatcher not found. Install illuminate/events package for EloquentJS usage without Laravel.'
            );
        }

        event(new EloquentJsWasCalled($query, $rules));
    }

    /**
     * Handle dynamic calls to scope methods.
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

        array_unshift($parameters, $query); // prepend $query to $parameters array
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
    protected function serializeDate($date)
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
        if (is_string($value)) {
            return Carbon::parse($value);
        }

        return parent::asDateTime($value);
    }

    /**
     * Get the endpoint defined on this model.
     *
     * @return string|null
     */
    public function getEndpoint()
    {
        if (property_exists($this, 'endpoint')) {
            return $this->endpoint;
        }
        
        return null;
    }
}
