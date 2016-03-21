<?php

namespace spec\EloquentJs\ScriptGenerator\Model;

use EloquentJs\ScriptGenerator\Model\Metadata;
use Acme\Comment;
use Acme\Post;
use Acme\Secret;
use Illuminate\Config\Repository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class InspectorSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(new Repository());
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('EloquentJs\ScriptGenerator\Model\Inspector');
    }

    function it_returns_a_model_metadata_object()
    {
        $this->inspect(new Post)->shouldBeAnInstanceOf(Metadata::class);
    }

    function it_finds_the_name_of_the_model()
    {
        $this->inspect(new Post)->name->shouldBe('Post');
        $this->inspect(new Comment)->name->shouldBe('Comment');
    }

    function it_finds_the_endpoint_defined_by_the_model()
    {
        $this->inspect(new Post)->endpoint->shouldBe('POSTS');
    }

    function it_finds_the_date_columns_for_the_model()
    {
        $this->inspect(new Post)->dates->shouldBe(['published_at']);
        $this->inspect(new Comment)->dates->shouldBe([]);
    }

    function it_finds_the_scope_methods()
    {
        $this->inspect(new Post)->scopes->shouldBe(['published']);
    }
}
