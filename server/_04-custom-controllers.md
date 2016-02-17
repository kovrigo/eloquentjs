For a real-world project, you'll likely want to use your own controller logic instead.
Now that you've set up your models to implement
<code><abbr title="EloquentJs\Model\AcceptsEloquentJsQueries">AcceptsEloquentJsQueries</abbr></code>,
it's trivial to apply an incoming *EloquentJs* query:

```language-php
$posts = Post::eloquentJs()->get();
```

Because the `eloquentJs()` call is just a regular [Eloquent query scope <i class="tiny external icon"></i>](https://laravel.com/docs/5.2/eloquent#local-scopes),
you can mix and match with other scopes and the standard query builder methods. Depending on where in the
chain you call the eloquentJs scope, you can set a default value that may be overriden, or enforce certain conditions
that should always apply:

```language-php
Post::take(50)     // default to show 50 but allow EloquentJs to override
    ->eloquentJs() // apply whatever conditions are set in the incoming query
    ->published()  // always require the posts to be published
    ->get();
```

And since Eloquent models automatically cast to JSON when returned from a controller,
this makes implementing your own controller methods a breeze:

```language-php
/**
 * Get a listing of posts.
 *
 * @return \Illuminate\Database\Eloquent\Collection
 */
public function index()
{
  return Post::take(50)->eloquentJs()->published()->get();
}
```

<div class="ui basic secondary segment">
  Behind the scenes, <code>Route::eloquent()</code> registers a resource route that uses the package's own
  <code><abbr title="EloquentJs\Controllerless\GenericController">GenericController</abbr></code>
  <a href="https://github.com/parsnick/eloquentjs/blob/master/src/Controllerless/GenericController.php"><i class="tiny external icon"></i></a>.
  You might want to give it a quick look as a guide for your own resource controller.
</div>


### Authorisation

For finer control, the `eloquentJs()` scope takes an optional argument to describe which query methods are permitted:

```language-php
Post::eloquentJs('where()')->get(); // only allow where() clauses

Post::eloquentJs('where() orderBy()')->get(); // allow where() and orderBy()
```

An incoming *EloquentJs* query will be rejected if it contains any other query methods.

<div class="ui basic secondary segment">
  For the purposes of authorisation, syntactic sugar is ignored - in other words, if you specify
  <b>where</b> as an allowed method, then <b>whereNull</b>, <b>orWhere&hellip;</b>, etc. are all
  allowed. Similarly, <b>orderBy</b> also permits <b>latest</b> and <b>oldest</b>.
</div>

Of course, as well as the *methods* you may want to restrict the *arguments* as well.
Not a problem!

```language-php
// Restrict to WHERE clauses on the published date
Post::eloquentJs('where(published_at)')->get();

// Restrict to WHERE clauses on the status column,
// and only allow "active" and "draft" as values
Post::eloquentJs('where(status, active|draft)')->get();
```

#### String-based rules

* For more flexibility, you can use modifiers:

<table class="ui very compact celled definition table">
  <thead>
    <tr>
      <th></th>
      <th>Description</th>
      <th>Example</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><code>|</code></td>
      <td>match any one of multiple values</td>
      <td><code>where(created_at|updated_at)</code></td>
    </tr>
    <tr>
      <td><code>*</code></td>
      <td>match anything</td>
      <td><code>orderBy(*, desc)</code></td>
    </tr>
    <tr>
      <td><code>!</code></td>
      <td>match anything <em>except</em> the value</td>
      <td><code>orderBy(!private_score)</code></td>
    </tr>
    <tr>
      <td><code>&lt;</code></td>
      <td>match a maximum (numeric) value</td>
      <td><code>limit(&lt;100)</code></td>
    </tr>
  </tbody>
</table>

<div class="ui basic secondary segment">
  If a rule specifies a method without arguments, <code>*</code> is assumed.
</div>

#### Array-based rules

* You can also specify your rules as an array and use a closure to apply custom logic.
* This example will only allow WHERE clauses against the **status** column and only if the value starts with **visible_**

```language-php
Post::eloquentJs([
  'where' => ['status', function ($value) {
    return starts_with($value, 'visible_');
  }],
])->get();
```

#### Closure-based rules

* If your rules are dynamic, you may prefer to use the <code>Builder</code>:

```language-php
Post::eloquentJs(function (Builder $rules) use (User $user) {

  $rules->allow('orderBy', ['public_score|published_at']);

  if ($user->isAdmin()) {

    $rules->allow('where'); // allows any where clause
    $rules->allow('orderBy'); // allows any orderBy clause

  }

})->get();
```


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
