<?php

namespace EloquentJs\Query;

use Illuminate\Http\Request;
use InvalidArgumentException;

class Interpreter
{
    /**
     * Read an EloquentJs `Query` from the given request.
     *
     * @param Request $request
     * @return Query
     */
    public function parse(Request $request)
    {
        $calls = json_decode($request->input('query', '[]'));

        if ($calls === null) {
            throw new InvalidArgumentException('The query could not be decoded: '.json_last_error_msg());
        }

        return new Query($this->getMethodCalls($calls));
    }

    /**
     * Convert plain array of [methodName, [methodArgs...]] to MethodCall instances.
     *
     * @param array $calls
     * @return array
     */
    protected function getMethodCalls(array $calls)
    {
        return array_map(function ($call) {
            return new MethodCall($call[0], $call[1]);
        }, $calls);
    }
}
