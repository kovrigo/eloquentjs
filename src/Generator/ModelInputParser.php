<?php

namespace EloquentJs\Generator;

class ModelInputParser
{
    /**
     * @var ModelFinder
     */
    protected $finder;

    /**
     * @var EndpointLocator
     */
    protected $endpoint;

    /**
     * @var null|string
     */
    protected $appDir;

    /**
     * Create a new ModelInputParser instance.
     *
     * @param ModelFinder $finder
     * @param EndpointLocator $endpoint
     * @param string|null $appDir
     */
    public function __construct(ModelFinder $finder, EndpointLocator $endpoint, $appDir = null)
    {
        $this->finder = $finder;
        $this->endpoint = $endpoint;
        $this->appDir = $appDir;
    }

    /**
     * Set the directory to search for model classes.
     *
     * @param string $dir
     * @return $this
     */
    public function searchIn($dir)
    {
        $this->appDir = $dir;

        return $this;
    }

    /**
     * Get the model => endpoint mapping.
     *
     * This takes input (usually from the GenerateJavascript console command)
     * and returns a mapping of model class names and their endpoints.
     *
     * @param string $input
     * @param string|null $namespace
     * @return array
     */
    public function getEndpointMapping($input, $namespace = null)
    {
        $models = $this->getModelList($input, $namespace);

        return array_combine($models, array_map([$this->endpoint, 'getEndpoint'], $models));
    }

    /**
     * Get a list of models from either $input or by searching the app dir.
     *
     * @param string|null $input
     * @param string|null $namespace
     * @return array
     */
    protected function getModelList($input, $namespace)
    {
        if ($input) {
            return $this->getModelsFromString($input, $namespace);
        }

        return $this->finder->inDirectory($this->appDir);
    }

    /**
     * Get a list of models from a CSV string.
     *
     * @param string $input
     * @param string|null $namespace
     * @return array
     */
    protected function getModelsFromString($input, $namespace)
    {
        return $this->finder->inList(array_map('trim', explode(',', $input)), $namespace);
    }
}
