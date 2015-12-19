<?php

namespace EloquentJs\Query\Listeners;

use EloquentJs\Query\Events\EloquentJsWasCalled;
use EloquentJs\Query\Query;

class ApplyQueryToBuilder
{
    /**
     * @var Query
     */
    protected $query;

    /**
     * Create the event listener.
     *
     * @param Query $query
     */
    public function __construct(Query $query)
    {
        $this->query = $query;
    }

    /**
     * Handle the event.
     *
     * @param EloquentJsWasCalled $event
     * @return void
     */
    public function handle(EloquentJsWasCalled $event)
    {
        $builder = $event->builder;

        foreach ($this->query->calls as $call) {
            call_user_func_array([$builder, $call->method], $call->arguments);
        }
    }
}