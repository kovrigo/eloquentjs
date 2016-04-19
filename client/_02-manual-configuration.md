
*EloquentJs* is unopinionated about the actual back-end implementation - by default,
it assumes you'll use the server-side package to provide a RESTful endpoint for
each model. For usage outside Laravel, you can configure your models manually.

* Load the core `eloquent.js` library
* Use the `Eloquent(name, options)` global to define your model.
* Each model requires a RESTful endpoint. Additional configuration is optional.

```language-js
Eloquent('Post', {
    endpoint: '/api/posts',  // URL that accepts queries for this model
    dates: ['published_at'], // columns to mutate to Date instances
    scopes: ['published'],   // the available query scope methods
    relations: {             // map of `relationshipName: relatedModelName`
        comments: 'Comment'
    }
});

Eloquent('Comments', {
    endpoint: '/api/posts',
    relations: {
        post: 'Post'
    }
});
```

<div class="ui basic tertiary segment">
    The package for Laravel includes the latest build of eloquent.js, and has
    an Artisan command that generates the configuration automatically by looking
    at the model classes in your application.
</div>
