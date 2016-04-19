
<div class="ui basic secondary segment">
  This section relates to the server-side component of <em>EloquentJs</em>,
  in particular how it's coupled to Laravel.
  The client-side library has no such dependency and can be freely modified.
</div>

The source files for the package are located in <a href="https://github.com/parsnick/eloquentjs/tree/master/src" class="ui label" title="View on GitHub"><i class="folder icon"></i> src/</a> and are organised as follows:

<div class="ui relaxed celled list">

  <div class="item">
    <i class="open folder icon"></i>
    <div class="content">
      <div class="header">Controllerless</div>
      <div class="description">Enables <code class="small">Route::eloquent()</code> usage.</div>
    </div>
  </div>

  <div class="item">
    <i class="open folder icon"></i>
    <div class="content">
      <div class="header">Model</div>
      <div class="description">Augments Eloquent models to support <em>EloquentJs</em></div>
    </div>
  </div>

  <div class="item">
   <i class="open folder icon"></i>
    <div class="content">
      <div class="header">Query</div>
      <div class="description">Interprets, authorises and applies incoming <em>EloquentJs</em> queries</div>
    </div>
  </div>

  <div class="item">
    <i class="open folder icon"></i>
    <div class="content">
      <div class="header">ScriptGenerator</div>
      <div class="description">Creates the eloquent.js build</div>
    </div>
  </div>

  <div class="item">
    <i class="file code outline icon"></i>
    <div class="content">
      <div class="header">EloquentJsServiceProvider</div>
      <div class="description">Bootstraps the package for Laravel</div>
    </div>
  </div>

</div>

The service provider [<i class="tiny external icon"></i>](https://github.com/parsnick/eloquentjs/blob/master/src/EloquentJsServiceProvider.php)
is a good high-level introduction point to see how the package is put together. If you're not already
familiar with Laravel's [service container](https://laravel.com/docs/5.2/container), it's worth reading
up on before going much further.

The rest of the package is namespaced as:

* `Controllerless` is only relevant if you use the `Route::eloquent()` shortcut.
  If not, you can safely disregard this namespace.
* `Model` contains the central component of the package:
  * The <code><abbr title="EloquentJs\Model\EloquentJsQueries">EloquentJsQueries</abbr></code>
    trait provides the default implementation - it simply fires an `EloquentJsWasCalled` event.
* `Query` makes up the bulk of the package
  * `Events` holds the single event in the package `EloquentJsWasCalled`
  * `Guard` contains the logic for authorising a `Query`
  * `Listeners` respond to the `EloquentJsWasCalled` event
  * `Interpreter` reads the current `Illuminate\Http\Request` and returns a `Query`
  * `Query` is a plain object representing an *EloquentJs* query coming from the browser
* `ScriptGenerator` is exclusively concerned with the Artisan command that builds your eloquent.js.

You can hook into the package wherever seems most sensible for your needs.

* Perhaps the most important binding in the service container is `eloquentjs.query`, and the first thing
  our provider does is set this up. You might like to replace this binding with a `Query` that you read
  from somewhere else.
* `EloquentJsWasCalled` is triggered and listened for with Laravel's [event](https://laravel.com/docs/5.2/events)
  system. You can of course add your own listeners, and control the order the listeners run with
  the [$priority](https://laravel.com/api/5.2/Illuminate/Contracts/Events/Dispatcher.html#method_listen)
  argument.
* You can even bypass the default event-based handling altogether, and provide your own
  implementation of `scopeEloquentJs()` without using the package's trait.
