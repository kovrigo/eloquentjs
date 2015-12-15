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
        return $this->filterByTrait(
            $this->finder->findClasses($directory)
        );
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
            array_walk($classes, function(&$className) use ($namespace) {
                $className = str_replace('\\\\', '\\', $namespace.'\\'.$className);
            });
        }

        return $this->filterByTrait($classes);
    }


    /**
     * Filter a list of classes to only those that use EloquentJs trait.
     *
     * @param array $classes
     * @return array
     */
    protected function filterByTrait(array $classes)
    {
        return array_filter($classes, function ($className) {
            return in_array(EloquentJsQueries::class, class_uses_recursive($className));
        });
    }
}
