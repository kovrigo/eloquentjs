<?php

namespace EloquentJs\Generator;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Filesystem\Filesystem;

class Generator
{
    /**
     * @var Filesystem
     */
    protected $files;

    /**
     * @var string
     */
    protected $output;

    /**
     * @type string location of the base EloquentJs build
     */
    const BASE_BUILD = __DIR__.'/../../eloquent.js';

    /**
     * @param Filesystem $files
     */
    public function __construct(Filesystem $files)
    {
        $this->files = $files;
    }

    /**
     * Set the output path for the generated javascript.
     *
     * @param string $path
     * @return $this
     */
    public function saveTo($path)
    {
        $this->output = $path;

        return $this;
    }

    /**
     * Generate EloquentJs javascript for the given models.
     *
     * @param array $models
     * @return bool
     */
    public function build(array $models)
    {
        $this->reset();

        $this->append(file_get_contents(static::BASE_BUILD));

        $this->append('(function(E){');
        foreach ($models as $model => $endpoint) {
            $this->append($this->modelConfig(new $model, $endpoint));
        }
        $this->append('})(Eloquent);');
    }

    /**
     * Create a blank file at the output path.
     *
     * @return bool
     */
    protected function reset()
    {
        return $this->files->put($this->output, '');
    }

    /**
     * Write the given data to the output file.
     *
     * @param string $data
     * @return int
     */
    protected function append($data)
    {
        return $this->files->append($this->output, $data);
    }

    /**
     * Generate the given model's configuration for EloquentJs.
     *
     * @param Model $model
     * @param $endpoint
     * @return string
     */
    protected function modelConfig(Model $model, $endpoint)
    {
        $inspector = new ModelInspector($model);

        $name = $inspector->getBaseName();
        $config = array_filter([
            'endpoint' => $endpoint,
            'dates'    => $inspector->getDates(),
            'scopes'   => $inspector->getScopes(),
        ]);

        return sprintf("E('%s', %s);", $name, json_encode($config, JSON_UNESCAPED_SLASHES));
    }
}
