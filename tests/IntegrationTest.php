<?php

namespace Parsnick\EloquentJs\Tests;

use Faker\Factory;
use Illuminate\Database\Eloquent\Collection;
use Orchestra\Testbench\TestCase;
use Illuminate\Database\Eloquent\Model;
use Parsnick\EloquentJs\Model\EloquentJsQueries;
use Parsnick\EloquentJs\EloquentJsServiceProvider;

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
        return [EloquentJsServiceProvider::class];
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

        $faker = Factory::create();
        $faker->seed(1234);

        for ($i = 0; $i < 100; $i++) {
            Post::create([
                'title'      => $faker->sentence,
                'body'       => $faker->text,
                'visible'    => $faker->boolean(75),
                'created_at' => $faker->dateTimeBetween('-30 years', 'now'),
            ]);
        }
    }

    /** @test */
    public function it_applies_a_json_encoded_query_to_the_eloquent_model()
    {
        $query = json_encode([
            ['where', ['visible', '=', '1']],
            ['orderBy', ['id', 'desc']],
        ]);
        $this->assertSameResult(
            Post::useEloquentJs($query)->get(),
            Post::where('visible', '=', 1)->orderBy('id', 'desc')->get()
        );

        $query = json_encode([
            ['latest', []],
            ['whereDay', ['created_at', '<', '20']],
            ['limit', [5]],
        ]);
        $this->assertSameResult(
            Post::useEloquentJs($query)->get(),
            Post::latest()->whereDay('created_at', '<', 20)->limit(5)->get()
        );

        $query = json_encode([
            ['distinct', []],
            ['groupBy', ['visible']],
        ]);
        $this->assertSameResult(
            Post::useEloquentJs($query)->get(),
            Post::distinct()->groupBy('visible')->get()
        );
    }

    /** @test */
    public function it_restricts_the_methods_you_can_use()
    {
        $query = json_encode([
            ['selectRaw', ['(SELECT arbitraryColumn FROM anyTable LIMIT 1']],
        ]);

        $this->setExpectedException('InvalidArgumentException');

        Post::useEloquentJs($query);
    }

    /**
     * Assert two query results (either models or collections) are identical.
     *
     * @param $expected
     * @param $actual
     * @param string $message
     */
    protected function assertSameResult($expected, $actual, $message = 'Result not the same')
    {
        if ($expected instanceof Collection) {
            return $this->assertEmpty($expected->diff($actual)->all());
        }

        $this->assertEquals($expected->getKey(), $actual->getKey(), $message);
    }
}

class Post extends Model
{
    use EloquentJsQueries;

    protected $guarded = [];
}
