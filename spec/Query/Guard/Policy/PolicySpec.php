<?php

namespace spec\EloquentJs\Query\Guard\Policy;

use EloquentJs\Query\Guard\Policy\Rule;
use EloquentJs\Query\MethodCall;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PolicySpec extends ObjectBehavior
{
    function it_passes_if_any_of_its_rules_pass(Rule $pass, Rule $fail)
    {
        $pass->test(Argument::any())->willReturn(true);
        $fail->test(Argument::any())->willReturn(false);

        $this->beConstructedWith([$pass, $fail]);

        $this->test(new MethodCall('where'))->shouldBe(true);
    }

    function it_fails_if_no_rules_pass()
    {
        $this->beConstructedWith([]);

        $this->test(new MethodCall('orderBy'))->shouldBe(false);
    }
}
