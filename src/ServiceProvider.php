<?php

namespace Parsnick\EloquentJs;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('eloquentjs.applicator', function ($app) {
            return new Applicator($app['request']->input('query'));
        });
    }
}
