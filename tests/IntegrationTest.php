<?php

namespace EloquentJs\Tests;

use Acme\Post;
use Illuminate\Support\Facades\Route;

class IntegrationTest extends TestCase
{
    /**
     * Setup the test environment
     */
    function setUp()
    {
        parent::setUp();

        Route::eloquent('api/posts', Post::class);
    }

    /** @test */
    function it_can_get_all_items()
    {
        $this->get('api/posts')
            ->seeJsonStructure([
                '*' => [
                    'id', 'title'
                ]
            ]);
    }

    /** @test */
    function it_can_get_an_item_by_id()
    {
        $this->get('api/posts/5')
            ->seeJson(Post::find(5)->toArray());
    }

    /** @test */
    function it_applies_a_query_encoded_in_the_url()
    {
        $this->get('api/posts?query=[["where",["visible","=",false]],["limit",[20]]]')
            ->seeJsonEquals(Post::where('visible', '=', false)->limit(20)->get()->toArray());
    }

    /** @test */
    function it_creates_a_new_post()
    {
        $newPost = ['title' => 'My new post'];

        $this->post('api/posts', $newPost)
             ->seeInDatabase('posts', $newPost);
    }

    /** @test */
    function it_updates_a_post()
    {
        $this->put('api/posts/5', ['title' => 'updated!'])
            ->seeInDatabase('posts', ['id' => 5, 'title' => 'updated!']);
    }

    /** @test */
    function it_deletes_a_post()
    {
        $this->delete('api/posts/5')
            ->notSeeInDatabase('posts', ['id' => 5]);
    }
}
