<?php

namespace EloquentJs\ScriptGenerator;

use EloquentJs\ScriptGenerator\Model\Metadata;

class Generator
{
    /**
     * @type string location of the base EloquentJs build
     */
    const BASE_BUILD = __DIR__.'/../../eloquent.js';

    /**
     * Generate EloquentJs javascript for the given models.
     *
     * @param array $models
     * @return string
     */
    public function build(array $models)
    {
        return $this->prefix().$this->models($models).$this->suffix();
    }

    /**
     * Get prefix for our javascript build.
     *
     * @return string
     */
    protected function prefix()
    {
        return "var _ = require('lodash'); var Eloquent = require('eloquentjs');";
    }

    /**
     * Get custom model definitions for build.
     *
     * @param  array $models
     * @return string
     */
    protected function models(array $models)
    {
        return implode(';', array_map([$this, 'model'], $models));
    }

    /**
     * Get suffix for our javascript build.
     *
     * @return string
     */
    protected function suffix()
    {
        return ";";
    }

    /**
     * Generate javascript to describe the given model.
     *
     * @param  Metadata $model
     * @return string
     */
    protected function model(Metadata $model)
    {
        $config = json_encode(array_filter([
            'endpoint'  => $model->endpoint,
            'dates'     => $model->dates,
            'scopes'    => $model->scopes,
            'relations' => $model->relations,
        ]), JSON_UNESCAPED_SLASHES);

        return "Eloquent('{$model->name}', {$config})";
    }
}
