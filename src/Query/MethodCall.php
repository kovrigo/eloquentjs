<?php

namespace EloquentJs\Query;

class MethodCall
{
    /**
     * @var string
     */
    public $method;

    /**
     * @var array
     */
    public $arguments;

    /**
     * Create a new MethodCall instance.
     *
     * @param string $method
     * @param array $arguments
     */
    public function __construct($method, array $arguments = [])
    {
        $this->method = $method;
        $this->arguments = $arguments;
    }
}