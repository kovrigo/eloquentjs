<?php

namespace Parsnick\EloquentJs;

use Illuminate\Support\ServiceProvider;
use Parsnick\EloquentJs\Events\EloquentJsWasCalled;
use Parsnick\EloquentJs\Listeners\ApplyQueryMethodsToBuilder;
use Parsnick\EloquentJs\Translators\JsonQueryTranslator;
use Parsnick\EloquentJs\Translators\QueryTranslator;

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
           return new JsonQueryTranslator($app['request']->input('query'));
        });
    }

    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['events']->listen(EloquentJsWasCalled::class, ApplyQueryMethodsToBuilder::class);
    }
}
