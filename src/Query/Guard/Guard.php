<?php

namespace EloquentJs\Query\Guard;

use EloquentJs\Query\Guard\Policy\Policy;
use EloquentJs\Query\MethodCall;
use EloquentJs\Query\Query;

class Guard
{
    /**
     * Authorize a query according to the given policy.
     *
     * @param Query $query
     * @param Policy $policy
     * @throws NotPermittedException
     */
    public function authorize(Query $query, Policy $policy)
    {
        foreach ($query->calls as $call) {
            if ( ! $this->authorizeCall($call, $policy)) {
                throw new NotPermittedException($call->method);
            }
        }
    }

    /**
     * Authorize a method call according to the given policy.
     *
     * @param MethodCall $call
     * @param Policy $policy
     * @return bool
     */
    protected function authorizeCall(MethodCall $call, Policy $policy)
    {
        return $policy->test($call);
    }
}
