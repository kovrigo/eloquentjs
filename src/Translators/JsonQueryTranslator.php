<?php

namespace Parsnick\EloquentJs\Translators;

use Illuminate\Database\Eloquent\Builder;
use InvalidArgumentException;
use Parsnick\EloquentJs\Translators\BaseQueryTranslator;

/**
 * JsonQueryTranslator supports the default EloquentJS encoding of query calls,
 * which is [ ["where", ["column", "=", "value"]], ["orderBy", ["name"]], ...]
 */
class JsonQueryTranslator extends BaseQueryTranslator
{
    /**
     * Apply the query methods described by $stack to the given $builder instance.
     *
     * @param Builder $builder
     * @return void
     */
    public function applyTo(Builder $builder)
    {
        $calls = json_decode($this->stack);

        if ($calls === null) {
            throw new InvalidArgumentException('The query stack could not be decoded: '.json_last_error_msg());
        }

        foreach ($calls as list($method, $args)) {
            $this->callMethod($builder, $method, $args);
        }
    }
}
