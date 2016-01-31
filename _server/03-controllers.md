---
title: Controllers
---

### Controllerless

To get up and running as fast as possible, you don't even need to write a controller
to handle your *EloquentJs* queries. The package adds an `eloquent` macro to the
router that takes a URI and an eloquent model. Similar to the native
[`Route::resource()`](https://laravel.com/docs/5.2/controllers#restful-resource-controllers),
it registers multiple routes to handle various RESTful actions on the model.

<div class="ui segment php sample">
  <div class="ui right corner label"></div>
  {% highlight php startinline %}
// app/Http/routes.php
Route::eloquent('api/posts', App\Post::class);
  {% endhighlight %}
</div>

You can specify a subset of actions to handle on the route, just like with `Route::resource()`:

<div class="ui segment php sample">
  <div class="ui right corner label"></div>
  {% highlight php startinline %}
Route::eloquent('api/posts', App\Post::class, ['only' => ['show', 'index']]);

Route::eloquent('api/posts', App\Post::class, ['except' => ['destroy']]);
  {% endhighlight %}
</div>

And that's it! Next step: [generating your javascript](server/#script-generator).

##### However...

`Route::eloquent()` allows any query to be executed. In most cases, you'll
want finer control over which methods may be called. This can be easily
achieved with your own resource controller.

### Using your own controllers

Assuming you've set up your models as [described above](server/#models),
you can use the `eloquentJs` query scope to

<div class="ui basic secondary segment">
  Behind the scenes, <code class="small">Route::eloquent()</code> registers a resource route that
  uses <code class="small"><a href="https://github.com/parsnick/eloquentjs/blob/master/src/Controllerless/GenericController.php">EloquentJs\Controllerless\GenericController</a></code>. You might want to take a look as
  a guide for your own resource controller.
</div>

#### Authorisation