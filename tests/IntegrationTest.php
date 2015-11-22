<?php

namespace Parsnick\EloquentJs\Tests;

use Orchestra\Testbench\TestCase;
use Illuminate\Database\Eloquent\Model;
use Parsnick\EloquentJs\JsQueryable;
use Parsnick\EloquentJs\ServiceProvider;

class IntegrationTest extends TestCase
{
    /**
     * Define environment setup.
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
     * Get package providers.  At a minimum this is the package being tested, but also
     * would include packages upon which our package depends, e.g. Cartalyst/Sentry
     * In a normal app environment these would be added to the 'providers' array in
     * the config/app.php file.
     *
     * @param  \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }

    /**
     * Setup the test environment.
     */
    public function setUp()
    {
        parent::setUp();

        $this->artisan('migrate', [
            '--database' => 'testbench',
            '--realpath' => realpath(__DIR__ . '/migrations'),
        ]);

        Post::create([
            'title'   => 'Test Post 1',
            'body'    => 'This is a hidden post.',
            'visible' => 0,
        ]);

        Post::create([
            'title'   => 'Test Post 2',
            'body'    => 'This is a visible post.',
            'visible' => 1,
        ]);

        Post::create([
            'title'   => 'Test Post 3',
            'body'    => 'This is also a visible post.',
            'visible' => 1,
        ]);
    }

    /** @test */
    public function it_applies_a_json_encoded_query_to_the_eloquent_model()
    {
        $result = Post::applyJsQuery('[["where", ["visible", "=", "1"]],["orderBy", ["id", "desc"]]]')->get();

        $this->assertEquals($result->first()->title, 'Test Post 3');
    }
}

class Post extends Model
{
    use JsQueryable;

    protected $guarded = [];
}
