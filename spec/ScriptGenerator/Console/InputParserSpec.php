<?php

namespace spec\EloquentJs\ScriptGenerator\Console;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class InputParserSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('EloquentJs\ScriptGenerator\Console\InputParser');
    }

    function it_returns_fully_qualified_classnames()
    {
        $this->parse('Post', 'App')->shouldReturn(['App\Post']);
    }

    function it_accepts_a_comma_separated_list_of_classes()
    {
        $this->parse('Post,Comment', 'App')->shouldReturn(['App\Post', 'App\Comment']);
        $this->parse('Post, Comment', 'App')->shouldReturn(['App\Post', 'App\Comment']);
    }

    function it_does_not_prepend_the_namespace_to_already_qualified_class_names()
    {
        $this->parse('\Acme\Post', 'App')->shouldReturn(['Acme\Post']);
    }
}
