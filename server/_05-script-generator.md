
If you've read through the docs up to here, you already know how to use the *EloquentJs* package.

1. Set up the server-side handling as described on this page.
2. Configure and use the javascript library as described in the [client docs](client/).

But there's more!

* Simply run the Artisan command to create a custom build of the eloquent.js library,
  pre-configured for the models in your Laravel application:

```language-bash
php artisan eloquentjs:generate
```

* This scans your app directory for any classes implementing
<code><abbr title="EloquentJs\Model\AcceptsEloquentJsQueries">AcceptsEloquentJsQueries</abbr></code>
and adds them to your eloquent.js build. Query scopes and date mutators are taken from the model
class and added to the javascript config.
<div class="ui basic tertiary segment">
  <i class="configure icon"></i> <code>@todo</code> include relations in the generated javascript
</div>

* By default all models are included. Pass a CSV list to specify which models you want in your eloquent.js build:

```language-bash
php artisan eloquentjs:generate --models=Post,Comment
```

* The `--output` option can change where the generated eloquent.js is saved. The default is `public/eloquent.js`.

### Endpoints

The most important configuration value for an *EloquentJs* model is the endpoint - that is, where should
the javascript library send its HTTP requests. Or to put it another way, the URL that the resource
controller for this model responds to.

The javascript generator will try to work out the endpoint automatically, in order of precedence:

1. If the Model returns a value from `getEndpoint()`, this is used as the endpoint.
    <div class="ui basic secondary segment">
      <p>
        The interface <code><abbr title="EloquentJs\Model\AcceptsEloquentJsQueries">AcceptsEloquentJsQueries</abbr></code>
        requires a <code>getEndpoint()</code> method.
      </p>
      <p>
        The provided <code><abbr title="EloquentJs\Model\EloquentJsQueries">EloquentJsQueries</abbr></code>
        trait defers to an <code>$endpoint</code> property on the model. You can optionally set this property,
        or provide your own <code>getEndpoint()</code> implementation, or leave it undefined.
      </p>
    </div>
2. If `Route::eloquent($uri, $model)` is used for this model, the generator reads the endpoint from the router.
3. If it's still unable to find an endpoint, you will be prompted to enter one when running the Artisan command.

Once the Artisan command has an endpoint for each model, you'll be prompted to confirm the mapping:

```language-code
$ php artisan eloquentjs:generate

Enter the endpoint to use for the 'App\Post' model:
> api/posts

+-------+-----------+
| Model | Endpoint  |
+-------+-----------+
| Post  | api/posts |
+-------+-----------+

Generate javascript for these models and associated endpoints? (yes/no):
> y

Javascript written to public/eloquent.js
```

