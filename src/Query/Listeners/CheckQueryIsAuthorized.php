<?php

namespace EloquentJs\Query\Listeners;

use EloquentJs\Query\Events\EloquentJsWasCalled;
use EloquentJs\Query\Guard\Guard;
use EloquentJs\Query\Guard\NotPermittedException;
use EloquentJs\Query\Guard\Policy\Factory;
use EloquentJs\Query\Query;

class CheckQueryIsAuthorized
{
    /**
     * @var Guard
     */
    protected $guard;

    /**
     * @var Query
     */
    protected $query;

    /**
     * @var Factory
     */
    protected $policy;

    /**
     * Create the event listener.
     *
     * @param Guard $guard
     * @param Query $query
     * @param Factory $policy
     */
    public function __construct(Guard $guard, Query $query, Factory $policy)
    {
        $this->guard = $guard;
        $this->query = $query;
        $this->policy = $policy;
    }

    /**
     * Handle the event.
     *
     * @param EloquentJsWasCalled $event
     * @throws NotPermittedException
     */
    public function handle(EloquentJsWasCalled $event)
    {
        $this->guard->authorize($this->query, $this->policy->make($event->rules));
    }
}