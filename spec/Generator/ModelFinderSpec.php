<?php

namespace spec\EloquentJs\Generator;

use Illuminate\Filesystem\ClassFinder;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use spec\Fixtures\CommentModel;
use spec\Fixtures\MyController;
use spec\Fixtures\PostModel;
use spec\Fixtures\UserModel;

class ModelFinderSpec extends ObjectBehavior
{
    function let(ClassFinder $finder)
    {
        $this->beConstructedWith($finder);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('EloquentJs\Generator\ModelFinder');
    }

    function it_finds_all_classes_using_our_trait(ClassFinder $finder)
    {
        $finder->findClasses('.')->willReturn([
            PostModel::class,
            CommentModel::class,
            UserModel::class,
            MyController::class
        ]);

        $this->inDirectory('.')->shouldReturn([PostModel::class, CommentModel::class]);
    }

    function it_verifies_all_the_given_classes_use_our_trait()
    {
        $this->inList([PostModel::class, CommentModel::class])
            ->shouldBe([PostModel::class, CommentModel::class]);

        $this->inList([PostModel::class, MyController::class])
            ->shouldBe([PostModel::class]);
    }

    function it_returns_fully_qualified_class_names_using_the_given_namespace_prefix()
    {
        $this->inList(['PostModel', 'CommentModel'], 'spec\Fixtures')
            ->shouldBe([PostModel::class, CommentModel::class]);

        $this->inList(['PostModel', 'MyController'], 'spec\Fixtures')
            ->shouldBe([PostModel::class]);
    }
}
