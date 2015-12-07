<?php

namespace EloquentJs\Generator;

use Illuminate\Routing\Router;

class EndpointLocator
{
    /**
     * @var Router
     */
    protected $router;

    /**
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * Get the endpoint for the given model class.
     *
     * @param $modelClass
     * @return null|string
     */
    public function getEndpoint($modelClass)
    {
        if ($definedByModel = $this->fromModel($modelClass)) {
            return $definedByModel;
        }

        return $this->fromRouter($modelClass);
    }

    /**
     * Get the endpoint defined within the model class.
     *
     * @param string $modelClass
     * @return null|string
     */
    protected function fromModel($modelClass)
    {
        return (new $modelClass)->getEndpoint();
    }

    /**
     * Get the endpoint from a route with a resource property in the action array.
     *
     * @param string $modelClass
     * @return string|null
     */
    protected function fromRouter($modelClass)
    {
        foreach ($this->router->getRoutes() as $route) {
            $action = $route->getAction();

            if (isset($action['resource']) and $action['resource'] == $modelClass) {
                return $route->getUri();
            }
        }

        return null;
    }


}
