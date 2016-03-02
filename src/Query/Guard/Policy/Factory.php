<?php

namespace EloquentJs\Query\Guard\Policy;

use InvalidArgumentException;

class Factory
{
    /**
     * @var mixed
     */
    protected $defaultPolicy;

    /**
     * Create a new Factory instance.
     *
     * @param \Closure $defaultPolicy
     */
    public function __construct($defaultPolicy = null)
    {
        $this->defaultPolicy = $defaultPolicy;
    }

    /**
     * Make a Policy object.
     *
     * @param string|array|callable|null $rules
     * @return Policy
     */
    public static function make($rules)
    {
        $factory = app(__CLASS__);

        if (is_string($rules)) {
            return $factory->fromPattern($rules);
        }

        if (is_array($rules)) {
            return $factory->fromArray($rules);
        }

        if (is_callable($rules)) {
            return $factory->fromCallback($rules);
        }

        if (is_null($rules)) {
            return $factory->fromDefault();
        }

        if (empty($rules)) {
            return $factory->fromEmpty();
        }

        throw new InvalidArgumentException('Could not make rules');
    }

    /**
     * Parse a string pattern and get a Policy.
     *
     * @param string $pattern
     * @return Policy
     */
    protected function fromPattern($pattern)
    {
        return $this->fromArray(
            $this->parseStringToArray($pattern)
        );
    }

    /**
     * Parse a rules array and get a Policy.
     *
     * @param array $rules
     * @return Policy
     */
    protected function fromArray(array $rules)
    {
        return $this->fromCallback(function($guard) use ($rules) {
            foreach ($rules as $method => $arguments) {
                $guard->allow($method, $arguments);
            }
        });
    }

    /**
     * Parse string into an array of method names and argument lists.
     *
     * For example
     *   "where(id|name, =, *)"
     * becomes
     *   [
     *      "where" => ["id|name", "=", "*"]
     *   ]
     *
     * @param string $input
     * @return array
     */
    protected function parseStringToArray($input)
    {
        return array_build(
            preg_split('#(?<=\))\s*(?=[a-z])#i', $input), // split on spaces between e.g. `where(*) orderBy(*)`
            function($index, $rule) {

                if ( ! preg_match('#^(?<method>[a-z]+)\((?<args>[^)]*)\)$#i', $rule, $clause)) {
                    throw new InvalidArgumentException('Could not parse rule ['.$rule.']');
                }

                return [
                    $clause['method'],
                    preg_split('#\s*,\s*#', $clause['args'])
                ];
            }
        );
    }

    /**
     * Use a callback to create a Policy.
     *
     * @param callable $callback
     * @return Policy
     */
    protected function fromCallback(callable $callback)
    {
        $builder = new Builder();

        call_user_func($callback, $builder);

        return $builder->toPolicy();
    }

    /**
     * Return the default policy.
     *
     * @return Policy
     */
    protected function fromDefault()
    {
        return $this->make($this->defaultPolicy);
    }

    /**
     * Create an null Policy.
     *
     * @return Policy
     */
    protected function fromEmpty()
    {
        return new Policy();
    }
}