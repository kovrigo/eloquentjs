<?php

namespace EloquentJs\Generator;

use EloquentJs\Model\EloquentJsQueries;
use Illuminate\Filesystem\ClassFinder;

class ModelFinder
{
    /**
     * @var ClassFinder
     */
    protected $finder;

    /**
     * @param ClassFinder $finder
     */
    public function __construct(ClassFinder $finder)
    {
        $this->finder = $finder;
    }

    /**
     * Search the given directory for all classes using the EloquentJs trait.
     *
     * @param string $directory
     * @return array
     */
    public function inDirectory($directory)
    {
        return array_filter($this->finder->findClasses($directory), [$this, 'usesTrait']);
    }

    /**
     * Get a filtered list of FQCN for the given classes which use the EloquentJs trait.
     *
     * @param array $classes
     * @param string|null $namespace
     * @return array
     */
    public function inList(array $classes, $namespace = null)
    {
        if ($namespace) {
            array_walk($classes, function (&$className) use ($namespace) {
                $className = str_replace('\\\\', '\\', $namespace . '\\' . $className);
            });
        }

        return array_filter($classes, [$this, 'usesTrait']);
    }


    /**
     * Test if the given class is using the EloquentJs trait.
     *
     * @param string $className
     * @return bool
     */
    protected function usesTrait($className)
    {
        return in_array(EloquentJsQueries::class, class_uses_recursive($className));
    }
}
