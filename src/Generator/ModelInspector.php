<?php

namespace EloquentJs\Generator;

use Illuminate\Database\Eloquent\Model;

class ModelInspector
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get the basename for this model.
     *
     * @return string
     */
    public function getBaseName()
    {
        return class_basename($this->model);
    }

    /**
     * Get any additional date columns for this model.
     *
     * @return array
     */
    public function getDates()
    {
        return array_values(
            array_diff($this->model->getDates(), ['created_at', 'updated_at', 'deleted_at'])
        );
    }

    /**
     * Get the non-prefixed scope methods for this model.
     *
     * @return array
     */
    public function getScopes()
    {
        return array_map(function ($method) {
            return lcfirst(substr($method, 5));
        }, $this->getScopeMethods());
    }

    /**
     * Get all the scope methods defined on this model.
     *
     * Excludes the scopes that are defined by EloquentJsQueries trait.
     *
     * @return array
     */
    protected function getScopeMethods()
    {
        return array_values(
            array_filter(get_class_methods($this->model), function ($method) {
                return substr($method, 0, 5) === 'scope' && ! in_array($method, ['scopeScope', 'scopeUseEloquentJs']);
            })
        );
    }
}
