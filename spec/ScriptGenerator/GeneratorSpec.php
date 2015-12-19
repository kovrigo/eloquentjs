<?php

namespace spec\EloquentJs\ScriptGenerator;

use EloquentJs\ScriptGenerator\Model\Metadata;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class GeneratorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('EloquentJs\ScriptGenerator\Generator');
    }

    function it_includes_the_base_eloquentjs_library()
    {
        $this->build([])->shouldContain('Eloquent');
    }

    function it_includes_configuration_for_the_given_models()
    {
        $post = new Metadata('MyPostModel', 'my/post/endpoint');

        $this->build([$post])->shouldContain('MyPostModel');
        $this->build([$post])->shouldContain('my/post/endpoint');
    }
}
