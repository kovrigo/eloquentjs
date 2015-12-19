<?php

namespace EloquentJs\Tests;

use EloquentJs\EloquentJsServiceProvider;
use Illuminate\Database\Eloquent\Collection;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Get package providers
     *
     * @param  \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [EloquentJsServiceProvider::class];
    }

    /**
     * Define environment setup
     *
     * @param  \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
        ]);
    }

    /**
     * Assert two query results (either models or collections) are identical
     *
     * @param $expected
     * @param $actual
     * @param string $message
     */
    protected function assertSameResult($expected, $actual, $message = 'Result not the same')
    {
        if ($expected instanceof Collection) {
            return $this->assertEquals($expected->implode('id', ','), $actual->implode('id', ','), $message);
        }

        return $this->assertEquals($expected->getKey(), $actual->getKey(), $message);
    }
}
