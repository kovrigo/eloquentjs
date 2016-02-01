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

And since Eloquent models automatically cast to JSON when returned from a controller,
this makes implementing your own controller methods a breeze:

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


### Authorisation

For finer control, the `eloquentJs()` scope takes an optional argument to describe which query methods are permitted:

<div class="ui segment php sample">
  <div class="ui right corner label"></div>
  {% highlight php startinline %}
Post::eloquentJs('where()')->get(); // only allow where() clauses

Post::eloquentJs('where() orderBy()')->get(); // allow where() and orderBy()
  {% endhighlight %}
</div>

An incoming *EloquentJs* query will be rejected if it contains any other query methods.

<div class="ui basic secondary segment">
  For the purposes of authorisation, syntactic sugar is ignored - in other words, if you specify
  <b>where</b> as an allowed method, then <b>whereNull</b>, <b>orWhere&hellip;</b>, etc. are all
  allowed. Similarly, <b>orderBy</b> also permits <b>latest</b> and <b>oldest</b>.
</div>

Of course, as well as the *methods* you may want to restrict the *arguments* as well.
Not a problem!

<div class="ui segment php sample">
  <div class="ui right corner label"></div>
  {% highlight php startinline %}
// Restrict to WHERE clauses on the published date
Post::eloquentJs('where(published_at)')->get();

// Restrict to WHERE clauses on the status column,
// and only allow "active" and "draft" as values
Post::eloquentJs('where(status, active|draft)')->get();
  {% endhighlight %}
</div>

#### String-based rules

* For more flexibility, you can use modifiers:

|     | Description                       | Example                        |
|:---:|:----------------------------------|:-------------------------------|
| `|` | match any one of multiple values  | `where(created_at|updated_at)` |
| `*` | match anything                    | `orderBy(*, desc)`             |
| `!` | match anything *except* the value | `orderBy(!private_score)`      |
| `<` | match a maximum (numeric) value   | `limit(<100)`                  |
{: .ui.very.compact.celled.definition.table }

<div class="ui basic secondary segment">
  If a method is listed without arguments, <code>*</code> is assumed.
</div>

#### Array-based rules

* You can also specify your rules as an array and use a closure to apply custom logic.
* This example will only allow WHERE clauses against the **status** column and only if the value starts with **visible_**

<div class="ui segment php sample">
  <div class="ui right corner label"></div>
  {% highlight php startinline %}
Post::eloquentJs([
  'where' => ['status', function ($value) {
    return starts_with($value, 'visible_');
  }],
])->get();
  {% endhighlight %}
</div>

#### Closure-based rules

* If your rules are dynamic, you may prefer to use the <code>Builder</code>:

<div class="ui segment php sample">
  <div class="ui right corner label"></div>
  {% highlight php startinline %}
Post::eloquentJs(function (Builder $rules) use (User $user) {

  $rules->allow('orderBy', ['public_score|published_at']);

  if ($user->isAdmin()) {

    $rules->allow('where'); // allows any where clause
    $rules->allow('orderBy'); // allows any orderBy clause

  }

})->get();
  {% endhighlight %}
</div>


### Setting default rules

* If your rules are consistent between models, you want to set a default. Default rules
can be passed to the <code>Factory</code> constructor, so just override this in your own
service provider.

* Take a look at `EloquentJsServiceProvider::setDefaultPolicy()`
[<i class="tiny external icon"></i>](https://github.com/parsnick/eloquentjs/blob/master/src/EloquentJsServiceProvider.php#L106)
to see how the package does this.

*[Builder]: EloquentJs\Query\Policy\Builder
*[Factory]: EloquentJs\Query\Policy\Factory
*[User]: App\User