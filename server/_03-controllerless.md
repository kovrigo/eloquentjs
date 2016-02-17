To get up and running as fast as possible, you don't even need to write a controller
to handle your *EloquentJs* queries. The `eloquent` macro on the router takes a
URI and an eloquent model, and sets up a RESTful resource controller similar to the native
`Route::resource()`
[<i class="tiny external icon"></i>](https://laravel.com/docs/5.2/controllers#restful-resource-controllers "Laravel documentation on RESTful resource controllers").

```language-php
// app/Http/routes.php
Route::eloquent('api/posts', App\Post::class);
```

You can even specify a subset of actions to handle, just like a regular resource controller:

```language-php
// For a read-only controller
Route::eloquent('api/posts', App\Post::class, ['only' => ['show', 'index']]);

// Or allow everything except deletions
Route::eloquent('api/posts', App\Post::class, ['except' => ['destroy']]);
```

And that's all there is to it! Skip ahead to [create your eloquent.js build](server/#create-your-eloquent-js-build) and start
using Eloquent in the browser.

<div class="ui basic inverted orange tertiary segment">
  <i class="red warning icon"></i>
  <code>Route::eloquent()</code> allows any query to be executed. If you need finer control over which
  queries are allowed, this can be easily achieved with your own resource controller - see below.
</div>
