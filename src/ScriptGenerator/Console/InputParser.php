<?php

namespace EloquentJs\ScriptGenerator\Console;

class InputParser
{
    /**
     * Parse a comma separated class list and return array of FQCNs.
     *
     * @param string $classList
     * @param string $namespace
     * @return array
     */
    public function parse($classList, $namespace)
    {
        return array_map(
            function($className) use ($namespace) {
                return $this->getFullyQualifiedClassName($className, $namespace);
            },
            array_map('trim', explode(',', $classList))
        );
    }

    /**
     * Get the FQCN of the given $class and $namespace.
     *
     * @param string $class
     * @param string $namespace
     * @return string
     */
    protected function getFullyQualifiedClassName($class, $namespace)
    {
        if ($class[0] === '\\') {
            return substr($class, 1);
        }

        return "$namespace\\$class";
    }
}
