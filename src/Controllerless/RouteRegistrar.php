<?php

namespace EloquentJs\Controllerless;

use Illuminate\Routing\Route;
use Illuminate\Routing\Router;

class RouteRegistrar
{
    /**
     * @var Router
     */
    protected $router;

    /**
     * @var string controller to handle generic resources
     */
    protected $controller;

    /**
     * Create a new RouteRegistrar instance.
     *
     * @param Router $router
     * @param string $controller
     */
    public function __construct(Router $router, $controller)
    {
        $this->router = $router;
        $this->controller = '\\'.$controller;
    }

    /**
     * Add the resourceful routes for the given uri and resource.
     *
     * @param string $uri
     * @param string $resource
     * @param array $options
     */
    public function addRoute($uri, $resource, array $options = [])
    {
        // The $router->resource() method doesn't allow custom route attributes
        // in the $options array. So, while the group() may look redundant here,
        // we need it to attach the relevant resource classname to each of the
        // individual restful routes being defined.
        // This is so when we come to resolve the controller, we
        // can easily tell what type of resource we need, i.e. which model.
        $this->router->group(
            $this->groupOptions($resource, $options),
            function($router) use ($uri, $options) {

                $router->resource(
                    $uri,
                    $this->controller,
                    $this->routeOptions($options)
                );

                $router->put($uri, $this->controller . '@updateAll');
                $router->delete($uri, $this->controller . '@destroyAll');
            }
        );
    }

    /**
     * Get the options for the resource route.
     *
     * @param array $options
     * @return array
     */
    protected function routeOptions(array $options)
    {
        // Exclude the routes for displaying forms
        if (empty($options['only'])) {
            $options['except'] = array_merge((array) array_get($options, 'except', []), ['create', 'edit']);
        }

        return $options;
    }

    /**
     * Get the options for the route group.
     *
     * @param string $resource
     * @param array $options
     * @return array
     */
    protected function groupOptions($resource, array $options)
    {
        return array_merge(compact('resource'), array_except($options, ['only', 'except']));
    }

    /**
     * Get the name of the resource currently being accessed.
     *
     * @return string
     */
    public function getCurrentResource()
    {
        if ($currentRoute = $this->router->current()) {
            return $currentRoute->getAction()['resource'];
        }

        return null;
    }
}
