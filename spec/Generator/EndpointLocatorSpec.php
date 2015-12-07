<?php

namespace spec\EloquentJs\Generator;

use Illuminate\Routing\Route;
use Illuminate\Routing\RouteCollection;
use Illuminate\Routing\Router;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use spec\Fixtures\CommentModel;
use spec\Fixtures\NoEndpointModel;
use spec\Fixtures\PostModel;
use spec\Fixtures\UserModel;

class EndpointLocatorSpec extends ObjectBehavior
{
    function let(Router $router)
    {
        $this->beConstructedWith($router);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('EloquentJs\Generator\EndpointLocator');
    }

    function it_returns_the_endpoint_url_for_a_model_that_explicitly_defines_it()
    {
        $this->getEndpoint(PostModel::class)->shouldReturn('api/posts');
    }

    function it_returns_the_endpoint_url_for_a_model_that_uses_the_eloquent_router_macro(Router $router)
    {
        $routeCollection = new RouteCollection();
        $routeCollection->add($nonMatchingRoute = new Route('get', 'login', []));
        $routeCollection->add($matchingRoute = new Route('get', 'api/comments', ['resource' => CommentModel::class]));
        $router->getRoutes()->willReturn($routeCollection);

        $this->getEndpoint(CommentModel::class)->shouldReturn('api/comments');
        $this->getEndpoint(NoEndpointModel::class)->shouldReturn(null);
    }
}
