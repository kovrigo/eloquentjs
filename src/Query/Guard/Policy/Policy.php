<?php

namespace EloquentJs\Query\Guard\Policy;

use EloquentJs\Query\MethodCall;

class Policy
{
    /**
     * @var Rule[]
     */
    protected $rules;

    /**
     * Create a new Policy instance.
     *
     * @param array $rules
     */
    public function __construct(array $rules = [])
    {
        $this->rules = $rules;
    }

    /**
     * Test if the method call is allowed by this policy.
     *
     * @param MethodCall $call
     * @return bool
     */
    public function test(MethodCall $call)
    {
        return ! ! array_first($this->rules, function($rule, $index) use ($call) {
            return $rule->test($call);
        });
    }
}
