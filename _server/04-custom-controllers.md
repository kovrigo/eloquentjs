---
title: Usage with your own controller
---

For a real-world project, you'll likely want to use your own controller logic instead.
Now that you've set up your models to implement
<code><abbr title="EloquentJs\Model\AcceptsEloquentJsQueries">AcceptsEloquentJsQueries</abbr></code>,
it's trivial to apply an incoming *EloquentJs* query:

<div class="ui segment php sample">
  <div class="ui right corner label"></div>
  {% highlight php startinline %}
$posts = Post::eloquentJs()->get();
  {% endhighlight %}
</div>

Because the `eloquentJs()` call is just a regular [Eloquent query scope <i class="tiny external icon"></i>](https://laravel.com/docs/5.2/eloquent#local-scopes),
you can mix and match with other scopes and the standard query builder methods. Depending on where in the
chain you call the eloquentJs scope, you can set a default value that may be overriden, or enforce certain conditions
that should always apply:

<div class="ui segment php sample">
  <div class="ui right corner label"></div>
  {% highlight php startinline %}
Post::take(50)     // default to show 50 but allow EloquentJs to override
    ->eloquentJs() // apply whatever conditions are set in the incoming query
    ->published()  // always require the posts to be published
    ->get();
  {% endhighlight %}
</div>

And since Eloquent models cast to JSON when returned from a controller, this makes implementing
your own controller methods a breeze:

<div class="ui segment php sample">
  <div class="ui right corner label"></div>
  {% highlight php startinline %}
/**
 * Get a listing of posts.

 * @return \Illuminate\Database\Eloquent\Collection
 */
public function index()
{
  return Post::take(50)->eloquentJs()->published()->get();
}
  {% endhighlight %}
</div>

<div class="ui basic secondary segment">
  Behind the scenes, <code>Route::eloquent()</code> registers a resource route that uses the package's own
  <code><abbr title="EloquentJs\Controllerless\GenericController">GenericController</abbr></code>
  <a href="https://github.com/parsnick/eloquentjs/blob/master/src/Controllerless/GenericController.php"><i class="tiny external icon"></i></a>.
  You might want to give it a quick look as a guide for your own resource controller.
</div>

#### Authorisation

