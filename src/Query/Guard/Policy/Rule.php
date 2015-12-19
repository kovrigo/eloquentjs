<?php

namespace EloquentJs\Query\Guard\Policy;

use EloquentJs\Query\MethodCall;

class Rule
{
    /**
     * @var string
     */
    protected $method;

    /**
     * @var array
     */
    protected $arguments;

    /**
     * @var array
     */
    protected $sugarMap = [
        'select' => [
            'select', 'addSelect'
        ],
        'where' => [
            'where', 'orWhere',
            'whereBetween', 'orWhereBetween', 'whereNotBetween', 'orWhereNotBetween',
            'whereExists', 'orWhereExists', 'whereNotExists', 'orWhereNotExists',
            'whereIn', 'orWhereIn', 'whereNotIn', 'orWhereNotIn',
            'whereNull', 'orWhereNull', 'whereNotNull', 'orWhereNotNull',
            'whereDate', 'whereDay', 'whereMonth', 'whereYear',
        ],
        'having' => [
            'having', 'orHaving',
        ],
        'orderBy' => [
            'orderBy', 'latest', 'oldest',
        ],
        'offset' => [
            'offset', 'skip',
        ],
        'limit' => [
            'limit', 'take', 'forPage',
        ],
    ];

    /**
     * Create a new rule instance.
     *
     * @param string $method
     * @param array $arguments
     */
    public function __construct($method, array $arguments = [])
    {
        $this->method = $method;
        $this->arguments = $arguments;
    }

    /**
     * Test if the method call passes this rule.
     *
     * @param MethodCall $call
     * @return bool
     */
    public function test(MethodCall $call)
    {
        return $this->methodMatches($call->method)
            and $this->argumentListMatches($call->arguments);
    }

    /**
     * Test if the given value matches the required method pattern.
     *
     * @param string $value
     * @return bool
     */
    protected function methodMatches($value)
    {
        return $this->comparePattern($this->method, $value);
    }

    /**
     * Test if the given arguments match the required arguments signature.
     *
     * @param array $arguments
     * @return bool
     */
    protected function argumentListMatches(array $arguments)
    {
        foreach ($arguments as $index => $argument) {

            if (empty($this->arguments[$index])) {
                continue;
            }

            if ( ! $this->comparePattern($this->arguments[$index], $argument)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Compare the given value to the given pattern.
     *
     * @param string $pattern
     * @param string $value
     * @return bool
     */
    protected function comparePattern($pattern, $value)
    {
        if (is_callable($pattern)) {
            return $pattern($value);
        }

        $alternates = explode('|', $pattern);

        return !! array_first($alternates, function ($index, $pattern) use ($value) {

            $firstCharacter = substr($pattern, 0, 1);
            $remainder = substr($pattern, 1);

            switch ($firstCharacter) {
                case '>':
                    return $remainder < $value;
                case '<':
                    return $remainder > $value;
                case '!':
                    return ! str_is($remainder, $value);
            }

            return str_is($pattern, $value);
        });
    }
}