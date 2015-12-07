# EloquentJs
[![Build Status](https://scrutinizer-ci.com/g/parsnick/eloquentjs/badges/build.png?b=master)](https://scrutinizer-ci.com/g/parsnick/eloquentjs/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/parsnick/eloquentjs/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/parsnick/eloquentjs/?branch=master)

Brings the Eloquent ORM from the [Laravel framework](https://github.com/laravel/framework) to the browser.

*! Work-in-progress, not recommended for production use*

<small>(!! this project has nothing to do with either the book titled *Eloquent JavaScript*, nor is it affiliated with Laravel or Taylor Otwell)</small>

## Overview
EloquentJs gives you the same fluent API you already know from the [Eloquent ORM](http://laravel.com/docs/5.1/eloquent) but in javascript.

| Feature | Supported |
|--------|:-----------------------:|
| **Query\Builder** ||
| parameterised query methods: where(), having(), orderBy(), groupBy(), take(), skip(), ... | ✔ |
| raw SQL injection methods: selectRaw(), whereRaw(), ... | ✗ |
| table joins, unions, and locks | ✗ |
| aggregates: sum(), max(), ... | *to do* |
| increment() and decrement() | *to do* |
| arbitrary CRUD queries: insert(), get(), update(), and delete() | ✔ |
| **Eloquent\Builder** ||
| find models by primary key: find(), findMany(), ... | ✔ |
| throw on failure: findOrFail(), firstOrFail(), ... | ✔ |
| get a partial result: lists(), value(), pluck() | ✔ |
| eager loading: with() | *to do* |
| soft deletes | *to do* |
| **Eloquent\Model** ||
| query scopes | ✔ |
| CRUD on a model instance: create(), update(), ... | ✔ |
| model events: creating, created, saving, saved, ... | ✔ |
| relationships | *to do* |
| mutators for date columns | ✔ |
| mutators for other columns | ✗ |
| mass assignment protection | ✗ |
| **Eloquent\Collection** ||
| utility methods | ✗ |

Features marked ✗ are not supported by design - usually for obvious security concerns (accepting raw SQL), because of language constraints (cannot subclass Array to make a Collection), or due to limited value in having a client-side implementation (mass assignment protection, mutators).

## Usage
1. **Install via Composer and add the service provider**
    ```
    composer require parsnick/eloquentjs:dev
    ```

    ```
    // config/app.php
    'providers' => [
        // ...
        EloquentJs\EloquentJsServiceProvider::class,
        // ...
    ],
    ```
    The package provides a macro for the Router and therefore must be listed *before* your app's RouteServiceProvider (if you want to use the macro, that is).

2. **Update your model classes to use the `EloquentJsQueries` trait**
    ```php
    class Post {
        use \EloquentJs\Model\EloquentJsQueries;
        // ...
    }
    ```

3. **Add RESTful routes to provide endpoints for the javascript to communicate via**
    ```php
    // app/Http/routes.php
    Route::eloquent('api/posts', App\Post::class);
    ```
    The eloquent() router macro shown here allows all CRUD operations for the given model, and is used here for brevity. In reality, you'll probably want to use your own resource controller.

4. **Create a customised EloquentJs build for your specific models**
    ```
    php artisan eloquentjs:generate [--models=*] [--output=public/eloquent.js]
    ```

5. **Include the eloquent.js file on a page and start using Eloquent in the browser!**
    ```js
    // New up an instance
    var post = new Eloquent.Post({ title: 'My firsht post!' });

    // Database operations are inevitably asynchronous so we'll always be
    // returned a Promise when saving/getting/deleting, etc.

    // Save our new post
    post.save().then(function (post) {
        // carry on...
    });

    // This is the same as the above...
    Eloquent.Post.create({ title: 'My firsht post!' }).then(function (post) {
        // carry on...
    });

    // Read data attributes
    console.log(post.title); // My firsht post!
    console.log(post.idontexist); // undefined

    // Change a value
    post.title = 'Updated';

    // Once an update/save operation is completed, the instance will be
    // updated with values from the server. This means other fields will
    // be present, despite not providing them when we constructed the instance.

    // Date columns are automatically converted to native javascript Date objects
    post.updated_at.setFullYear(2000);

    // Interrogate the model
    console.log(post.getKey()); // 1
    console.log(post.getDirty()); // { updated_at: [Date], title: 'Updated' }
    console.log(post.getAttributes()); // plain data object with no behaviour
    console.log(post.exists); // true

    // Update and save
    post.update({ title: 'My first post!'});

    // Use the query builder
    Eloquent.Post.whereNotNull('published_at').get().then(function (results) {
        // ...
    });

    // Call a 'scope' method
    Eloquent.Post.published().latest().get();

    // Listen to the saving event
    Eloquent.Post.saving(function (post) {
        return !! post.title; // prevent posting without a title
    });
    ```

## Example application
An example project using EloquentJs with Laravel can be found at [parsnick/eloquentjs-example](https://github.com/parsnick/eloquentjs-example). This is the quickest way to try out the package - just clone, install and go!

```sh
git clone https://github.com/parsnick/eloquentjs-example.git
cd eloquentjs-example
composer install
php artisan migrate --seed
php artisan serve
```

## Roadmap
1. Features marked *to do* in the overview.
2. Documentation.
3. See issues.

## Contributing
All contributions welcome. For anything related to the companion javascript library, please use [parsnick/eloquentjs-client](https://github.com/parsnick/eloquentjs-client).

## License
MIT
