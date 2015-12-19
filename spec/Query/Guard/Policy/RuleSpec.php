<?php

namespace spec\EloquentJs\Query\Guard\Policy;

use EloquentJs\Query\MethodCall;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RuleSpec extends ObjectBehavior
{
    function it_tests_for_a_matching_method_name()
    {
        $this->beConstructedWith('where');

        $this->test(new MethodCall('where'))->shouldBe(true);
        $this->test(new MethodCall('orderBy'))->shouldBe(false);
    }

    function it_tests_for_a_matching_set_of_arguments()
    {
        $this->beConstructedWith('where', ['id', '*']);

        $this->test(new MethodCall('where', ['id', '=', 1]))->shouldBe(true);
    }

    function it_matches_against_multiple_values_with_alternate_pipe_separated_values()
    {
        $this->beConstructedWith('orderBy', ['id|name|email']);

        $this->test(new MethodCall('orderBy', ['name', 'desc']))->shouldBe(true);
        $this->test(new MethodCall('orderBy', ['password']))->shouldBe(false);
    }

    function it_supports_a_minimum_value_operator()
    {
        $this->beConstructedWith('limit', ['<200']);

        $this->test(new MethodCall('limit', [250]))->shouldBe(false);
        $this->test(new MethodCall('limit', [50]))->shouldBe(true);
    }

    function it_supports_a_not_operator()
    {
        $this->beConstructedWith('where', ['!password']);

        $this->test(new MethodCall('where', ['password', '=', 'abc']))->shouldBe(false);
        $this->test(new MethodCall('where', ['name', '=', 'abc']))->shouldBe(true);
    }

    function it_can_take_a_custom_callback_matcher()
    {
        $this->beConstructedWith('with', [function ($relation) {
            return ! starts_with($relation, 'secret_');
        }]);

        $this->test(new MethodCall('with', ['secret_relation']))->shouldBe(false);
        $this->test(new MethodCall('with', ['public_relation']))->shouldBe(true);
        $this->test(new MethodCall('with', ['anything_else']))->shouldBe(true);
    }
}
