<?php

namespace EloquentJs;

use EloquentJs\Console\GenerateJavascript;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use EloquentJs\Controllers\GenericResourceController;
use EloquentJs\Events\EloquentJsWasCalled;
use EloquentJs\Listeners\ApplyQueryMethodsToBuilder;
use EloquentJs\Translators\JsonQueryTranslator;
use EloquentJs\Translators\QueryTranslator;

class EloquentJsServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(QueryTranslator::class, function ($app) {
            return new JsonQueryTranslator($app['request']->input('query', '[]'));
        });

        $this->commands([GenerateJavascript::class]);
    }

    /**
     * Boot the service provider.
     *
     * @param Dispatcher $events
     * @param Router $router
     * @return void
     */
    public function boot(Dispatcher $events, Router $router)
    {
        $events->listen(EloquentJsWasCalled::class, ApplyQueryMethodsToBuilder::class);

        $this->addGenericResourceRouting($router);
    }

    /**
     * Set up the generic resource routes + controller.
     *
     * @param Router $router
     */
    protected function addGenericResourceRouting(Router $router)
    {
        $router->macro('eloquent', function($uri, $resource, $options = []) use ($router) {

            // The $router->resource() method doesn't allow custom route attributes
            // in the $options array. So, while the group() may look redundant here,
            // we need it to attach the relevant resource classname to each of the
            // individual restful routes being defined.
            //
            // This is so when we come to resolve the controller (see below), we
            // can easily tell what type of resource we need, i.e. which model.
            $router->group(compact('resource'), function($router) use ($uri, $options) {

                if (empty($options['only'])) { // Exclude the routes for displaying forms
                    $options['except'] = (array) array_get($options, 'except', []) + ['create', 'edit'];
                }

                $router->resource($uri, '\\'.GenericResourceController::class, $options);

            });
        });

        // Typically you'd have dedicated controllers for each resource.
        // Since that's not the case here, we need some way of telling
        // our generic controller which resource we're working with.
        $this->app->resolving(function(GenericResourceController $controller) {

            $currentRoute = $this->app['router']->current();

            if ($currentRoute) { // in case we're in the console, etc.
                $controller->setModel(
                    $this->app->make($currentRoute->getAction()['resource'])
                );
            }
        });
    }
}
