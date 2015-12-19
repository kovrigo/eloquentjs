<?php

namespace EloquentJs\Query\Guard\Policy;

class Builder
{
    /**
     * @var array
     */
    protected $calls = [];

    /**
     *
     *
     * @param string $method
     * @param array $arguments
     * @return $this
     */
    public function allow($method, array $arguments = [])
    {
        $this->calls[] = new Rule($method, $arguments);

        return $this;
    }

    /**
     * Get the rules as a Policy.
     *
     * @return Policy
     */
    public function toPolicy()
    {
        return new Policy($this->calls);
    }
}
