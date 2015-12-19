<?php

namespace EloquentJs\ScriptGenerator\Model;

use EloquentJs\Model\AcceptsEloquentJsQueries;

class Inspector
{
    /**
     * @var array
     */
    protected $excludeScopes = ['scopeScope', 'scopeEloquentJs'];

    /**
     * Inspect a model class and return its metadata.
     *
     * @param AcceptsEloquentJsQueries $instance
     * @return Metadata
     */
    public function inspect(AcceptsEloquentJsQueries $instance)
    {
        return new Metadata(
            class_basename($instance),
            $this->findEndpoint($instance),
            $this->findDateColumns($instance),
            $this->findScopeMethods($instance)
        );
    }

    /**
     * Find the endpoint for this model.
     *
     * @param AcceptsEloquentJsQueries $instance
     * @return string
     */
    protected function findEndpoint(AcceptsEloquentJsQueries $instance)
    {
        return $instance->getEndpoint();
    }

    /**
     * Get any additional date columns for this model.
     *
     * @param AcceptsEloquentJsQueries $instance
     * @return array
     */
    protected function findDateColumns(AcceptsEloquentJsQueries $instance)
    {
        return array_values(
            array_diff($instance->getDates(), ['created_at', 'updated_at', 'deleted_at'])
        );
    }

    /**
     * Get the scope methods for this model with 'scope' prefix removed.
     *
     * @param AcceptsEloquentJsQueries $instance
     * @return array
     */
    protected function findScopeMethods(AcceptsEloquentJsQueries $instance)
    {
        return array_map(
            function($method) {
                return lcfirst(substr($method, 5));
            },
            array_values(
                array_filter(
                    get_class_methods($instance),
                    function($method) {
                        return substr($method, 0, 5) === 'scope' and ! in_array($method, $this->excludeScopes);
                    }
                )
            )
        );
    }
}
