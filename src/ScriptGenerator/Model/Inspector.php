<?php

namespace EloquentJs\ScriptGenerator\Model;

use Illuminate\Database\Eloquent\Model;

class Inspector
{
    /**
     * @var array
     */
    protected $excludeScopes = ['scopeScope', 'scopeEloquentJs'];

    /**
     * Inspect a model class and return its metadata.
     *
     * @param Model $instance
     * @return Metadata
     */
    public function inspect(Model $instance)
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
     * @param Model $instance
     * @return string
     */
    protected function findEndpoint(Model $instance)
    {
        return $instance->getEndpoint();
    }

    /**
     * Get any additional date columns for this model.
     *
     * @param Model $instance
     * @return array
     */
    protected function findDateColumns(Model $instance)
    {
        return array_values(
            array_diff($instance->getDates(), ['created_at', 'updated_at', 'deleted_at'])
        );
    }

    /**
     * Get the scope methods for this model with 'scope' prefix removed.
     *
     * @param Model $instance
     * @return array
     */
    protected function findScopeMethods(Model $instance)
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
