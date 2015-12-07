<?php

namespace spec\EloquentJs\Generator;

use EloquentJs\Generator\EndpointLocator;
use EloquentJs\Generator\ModelFinder;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use spec\Fixtures\CommentModel;
use spec\Fixtures\PostModel;

class ModelInputParserSpec extends ObjectBehavior
{
    function let(ModelFinder $finder, EndpointLocator $locator)
    {
        $this->beConstructedWith($finder, $locator, '.');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('EloquentJs\Generator\ModelInputParser');
    }

    function it_scans_the_app_directory_when_no_input_provided(ModelFinder $finder, EndpointLocator $locator)
    {
        $finder->inDirectory('.')->willReturn([PostModel::class, CommentModel::class]);
        $locator->getEndpoint(PostModel::class)->willReturn('api/posts');
        $locator->getEndpoint(CommentModel::class)->willReturn('api/comments');

        $this->getEndpointMapping(null, '.')->shouldReturn([
            PostModel::class    => 'api/posts',
            CommentModel::class => 'api/comments',
        ]);
    }

    function it_reads_the_model_classes_from_a_csv_list(ModelFinder $finder, EndpointLocator $locator)
    {
        $finder->inList(['PostModel', 'CommentModel'], 'spec\Fixtures')
            ->willReturn([PostModel::class, CommentModel::class]);
        $locator->getEndpoint(PostModel::class)->willReturn('api/posts');
        $locator->getEndpoint(CommentModel::class)->willReturn('api/comments');

        $this->getEndpointMapping('PostModel, CommentModel', 'spec\Fixtures')->shouldReturn([
            PostModel::class    => 'api/posts',
            CommentModel::class => 'api/comments',
        ]);
    }
}
