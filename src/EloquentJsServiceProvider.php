<?php

namespace EloquentJs;

use EloquentJs\Controllerless\GenericController;
use EloquentJs\Controllerless\RouteRegistrar;
use EloquentJs\Model\AcceptsEloquentJsQueries;
use EloquentJs\Query\Events\EloquentJsWasCalled;
use EloquentJs\Query\Guard\Policy\Builder;
use EloquentJs\Query\Guard\Policy\Factory;
use EloquentJs\Query\Interpreter;
use EloquentJs\Query\Listeners\ApplyQueryToBuilder;
use EloquentJs\Query\Listeners\CheckQueryIsAuthorized;
use EloquentJs\Query\Query;
use EloquentJs\ScriptGenerator\Console\Command;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class EloquentJsServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('eloquentjs.query', function ($app) {
            return $app[Interpreter::class]->parse($app['request']);
        });

        $this->app->when(CheckQueryIsAuthorized::class)
            ->needs(Query::class)
            ->give('eloquentjs.query');

        $this->app->when(ApplyQueryToBuilder::class)
            ->needs(Query::class)
            ->give('eloquentjs.query');

        $this->commands([Command::class]);
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
        $this->addListenersToApplyQuery($events);

        $this->enableGenericResourceRouting($router);

        $this->setDefaultPolicy();
    }

    /**
     * Add listener for EloquentJs usage.
     *
     * @param Dispatcher $events
     * @return void
     */
    protected function addListenersToApplyQuery(Dispatcher $events)
    {
        $events->listen(EloquentJsWasCalled::class, CheckQueryIsAuthorized::class, 10);
        $events->listen(EloquentJsWasCalled::class, ApplyQueryToBuilder::class);
    }

    /**
     * Set up the generic resource routes + controller.
     *
     * @param Router $router
     * @return void
     */
    protected function enableGenericResourceRouting(Router $router)
    {
        $app = $this->app;

        $app->bind('eloquentjs.router', RouteRegistrar::class);

        $app->when(RouteRegistrar::class)
            ->needs('$controller')
            ->give(GenericController::class);

        $app->when(GenericController::class)
            ->needs(AcceptsEloquentJsQueries::class)
            ->give(function ($app) {
                if ($resource = $app['eloquentjs.router']->getCurrentResource()) {
                    return $app->make($resource);
                }
            });

        $router->macro('eloquent', function ($uri, $resource, $options = []) use ($app) {
            $app['eloquentjs.router']->addRoute($uri, $resource, $options);
        });
    }

    /**
     * Set default policy for guarding EloquentJs queries.
     *
     * @return void
     */
    protected function setDefaultPolicy()
    {
        $this->app->bind(Factory::class, function () {
            return new Factory(
                function (Builder $guard) {
                    $guard->allow('select');
                    $guard->allow('distinct');
                    $guard->allow('where');
                    $guard->allow('groupBy');
                    $guard->allow('having');
                    $guard->allow('orderBy');
                    $guard->allow('offset');
                    $guard->allow('limit');
                    $guard->allow('scope');
                    $guard->allow('with');
                }
            );
        });
    }
}
