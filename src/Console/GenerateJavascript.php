<?php

namespace EloquentJs\Console;

use EloquentJs\Generator\Generator;
use EloquentJs\Generator\ModelInputParser;
use Illuminate\Console\Command;

class GenerateJavascript extends Command
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
     * @var ModelInputParser
     */
    protected $inputParser;
    /**
     * @var Generator
     */
    protected $generator;

    /**
     * Create a new command instance.
     *
     * @param ModelInputParser $inputParser
     * @param Generator $generator
     */
    public function __construct(ModelInputParser $inputParser, Generator $generator)
    {
        parent::__construct();

        $this->inputParser = $inputParser;
        $this->generator = $generator;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $models = $this->inputParser
            ->searchIn(app_path())
            ->getEndpointMapping($this->option('models'), $this->option('namespace'));

        $this->populateMissingEndpoints($models);

        $this->printMapping($models);

        if ($this->confirm('Generate javascript for these models and associated endpoints?', true)) {
            $output = $this->option('output');
            $this->generator->saveTo($output)->build($models);
            $this->info("Javascript written to {$output}");
        }
    }

    /**
     * Print the inferred Model => Endpoint mapping.
     *
     * @param $models
     * @return void
     */
    protected function printMapping($models)
    {
        $rows = array_map(function($model, $endpoint) {
            return [$model, $endpoint];
        }, array_keys($models), $models);

        $this->table(['Model', 'Endpoint'], $rows);
    }

    /**
     * Ask user to specify an endpoint for those we failed to determine automatically.
     *
     * @param array $models
     */
    protected function populateMissingEndpoints(&$models)
    {
        array_walk($models, function(&$endpoint, $model) {
            if (empty($endpoint)) {
                $endpoint = $this->ask("Enter the endpoint to use for the '{$model}' model");
            }
        });
    }
}
