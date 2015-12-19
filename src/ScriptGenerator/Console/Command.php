<?php

namespace EloquentJs\ScriptGenerator\Console;

use EloquentJs\Model\AcceptsEloquentJsQueries;
use EloquentJs\ScriptGenerator\Generator;
use EloquentJs\ScriptGenerator\Model\Inspector;
use EloquentJs\ScriptGenerator\Model\Metadata;
use Illuminate\Console\Command as BaseCommand;
use Illuminate\Filesystem\ClassFinder;

class Command extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'eloquentjs:generate
                            {--models= : Models to include in the generated javascript}
                            {--namespace=App : Namespace prefix to use with the --models option}
                            {--output=public/eloquent.js : Where to save the generated javascript file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a javascript file for an Eloquent-ish API in the browser';

    /**
     * @var InputParser
     */
    protected $inputParser;

    /**
     * @var Generator
     */
    protected $generator;

    /**
     * @var ClassFinder
     */
    protected $classFinder;

    /**
     * @var Inspector
     */
    protected $inspector;

    /**
     * Create a new command instance.
     *
     * @param InputParser $inputParser
     * @param ClassFinder $classFinder
     * @param Inspector $inspector
     * @param Generator $generator
     */
    public function __construct(InputParser $inputParser, ClassFinder $classFinder, Inspector $inspector, Generator $generator)
    {
        parent::__construct();

        $this->inputParser = $inputParser;
        $this->classFinder = $classFinder;
        $this->inspector = $inspector;
        $this->generator = $generator;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $models = $this->inspectRequestedModels();

        $this->printMapping($models);

        if ($this->isConfirmed()) {
            $this->writeJavascript($models);

            $this->info("Javascript written to {$this->option('output')}");
        }
    }

    /**
     * Get models to include in the eloquentjs build.
     *
     * @return array
     */
    protected function inspectRequestedModels()
    {
        return array_map([$this, 'inspectModel'], $this->getRequestedClassNames());
    }

    /**
     * Get the model classes requested by the user.
     *
     * @return array
     */
    protected function getRequestedClassNames()
    {
        if ($this->option('models')) {
            return $this->inputParser->parse($this->option('models'), $this->option('namespace'));
        }

        return $this->searchAppForModels();
    }

    /**
     * Search the app path for any models that implement EloquentJs.
     *
     * @return array
     */
    protected function searchAppForModels()
    {
        return array_filter(
            $this->classFinder->findClasses(app_path()),
            function ($className) {
                return is_subclass_of($className, AcceptsEloquentJsQueries::class);
            }
        );
    }

    /**
     * Get the metadata for the given model name.
     *
     * @param string $className
     * @return Metadata
     */
    protected function inspectModel($className)
    {
        $metadata = $this->inspector->inspect(new $className);

        if (!$metadata->endpoint) {
            $metadata->endpoint = $this->findMissingEndpoint($className);
        }

        return $metadata;
    }

    /**
     * Find endpoint for the named model, either from router or from user prompt.
     *
     * @param string $className
     * @return string
     */
    protected function findMissingEndpoint($className)
    {
        foreach ($this->laravel['router']->getRoutes() as $route) {
            $action = $route->getAction();

            if (isset($action['resource']) and $action['resource'] == $className) {
                return $route->getUri();
            }
        }

        return $this->ask("Enter the endpoint to use for the '{$className}' model");
    }

    /**
     * Print the model-endpoint mapping.
     *
     * @param array $models
     * @return void
     */
    protected function printMapping(array $models)
    {
        $this->table(
            ['Model', 'Endpoint'],
            array_map(function ($metadata) {
                return [$metadata->name, $metadata->endpoint];
            }, $models)
        );
    }

    /**
     * Prompt user to confirm.
     *
     * @return bool
     */
    protected function isConfirmed()
    {
        return $this->confirm('Generate javascript for these models and associated endpoints?', true);
    }

    /**
     * Save the generated javascript to the filesystem.
     *
     * @param array $models
     * @return bool
     */
    protected function writeJavascript($models)
    {
        return $this->laravel['files']->put($this->option('output'), $this->generator->build($models)) > 0;
    }
}
