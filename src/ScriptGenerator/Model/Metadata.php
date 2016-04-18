<?php

namespace EloquentJs\ScriptGenerator\Model;

class Metadata
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $endpoint;

    /**
     * @var array
     */
    public $dates;

    /**
     * @var array
     */
    public $scopes;

    /**
     * @var array
     */
    public $relations;

    /**
     * @param string $name
     * @param string $endpoint
     * @param array $dates
     * @param array $scopes
     */
    public function __construct($name, $endpoint, array $dates = [], array $scopes = [], array $relations = [])
    {
        $this->name = $name;
        $this->endpoint = $endpoint;
        $this->dates = $dates;
        $this->scopes = $scopes;
        $this->relations = $relations;
    }
}
