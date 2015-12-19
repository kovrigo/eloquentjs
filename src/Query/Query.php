<?php

namespace EloquentJs\Query;

class Query
{
    /**
     * @var array
     */
    public $calls;

    /**
     * Create a new Query instance.
     *
     * @param array $calls
     */
    public function __construct(array $calls = [])
    {
        $this->calls = $calls;
    }
}