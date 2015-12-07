<?php

namespace spec\EloquentJs\Generator;

use Illuminate\Database\Eloquent\Model;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ModelInspectorSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(new EloquentModel());
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('EloquentJs\Generator\ModelInspector');
    }

    function it_gets_the_class_basename()
    {
        $this->getBaseName()->shouldBe('EloquentModel');
    }

    function it_gets_all_the_date_columns()
    {
        $dates = $this->getDates();

        $dates->shouldHaveCount(1);
        $dates->shouldContain('published_at');
    }

    function it_gets_all_the_scope_methods()
    {
        $scopes = $this->getScopes();

        $scopes->shouldHaveCount(2);
        $scopes->shouldContain('published');
        $scopes->shouldContain('archived');
    }
}

class EloquentModel extends Model
{
    protected $dates = ['published_at'];

    public function scopePublished($query) {}
    public function scopeArchived($query) {}
}
