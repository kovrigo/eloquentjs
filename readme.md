# EloquentJs
[![Build Status](https://travis-ci.org/parsnick/eloquentjs.svg?branch=master)](https://travis-ci.org/parsnick/eloquentjs)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/parsnick/eloquentjs/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/parsnick/eloquentjs/?branch=master)

Brings the Eloquent ORM from the [Laravel framework](https://github.com/laravel/framework) to the browser.

## Documentation

Full documentation for the package can be found at the [parsnick.github.io/eloquentjs](http://parsnick.github.io/eloquentjs).

## Quickstart

#### Install

```
composer require parsnick/eloquentjs
```
and add the service provider

```php
// config/app.php
'providers' => [
    // ...
    
    // before your RouteServiceProvider, add
    EloquentJs\EloquentJsServiceProvider::class,
    
    // ...
],
```

#### Usage

1. **Implement `EloquentJs\Model\AcceptsEloquentJsQueries`**
    
    The `EloquentJs\Model\EloquentJsQueries` trait can add the required methods.

    ```php
    use EloquentJs\Model\AcceptsEloquentJsQueries;
    use EloquentJs\Model\EloquentJsQueries;
    
    class Post implements AcceptsEloquentJsQueries {
        use EloquentJsQueries;
        // ...
    }
    ```

2. **Add routes for queries coming in via the client-side library**
    
    Use `Route::eloquent($url, $modelClass)` to register a set of RESTful routes similar to
    `Route::resource($url, $controllerClass)`.

    ```php
    // app/Http/routes.php
    Route::eloquent('api/posts', App\Post::class);
    ```
    
    Or, for greater control, use your own controller to limit or force certain clauses:

    ```php
    Route::get('api/posts', function () {
        return App\Post::eloquentJs('where(id|body) orderBy(body|rating|created_at)')
            ->take(50)
            ->get();
    });
    ```


4. **Create a javascript build customised for your specific models**
    ```
    php artisan eloquentjs:generate [--models=*] [--output=public/eloquent.js]
    ```

5. **Load eloquent.js on a page and start using Eloquent in the browser!**
    ```js
    var Post = Eloquent.Post;
    
    // The API is the same as the Eloquent you already know, as far as practical
    // with a few obvious limitations. Most notably, database operations are 
    // inevitably asynchronous so any method that executes a query will
    // always return a Promise.
    
    var post = new Post({ title: 'My first post!' });

    post.save().then(function (post) {
        // carry on...
    });

    Post.create({ title: 'My second post!' }).then(function (post) {
        
        console.log(post.exists); // true
        console.log(post.title); // My first post!
        console.log(post.blahblahblah); // undefined
        console.log(post.created_at.getFullYear()); // 2016
        console.log(post.getKey()); // 2    
        console.log(post.getAttributes()); // plain data object with no behaviour
        
        post.title = 'Updated';
    
        console.log(post.getDirty()); // { title: 'Updated' }
    
        post.update({ title: 'Hello!' }).then(function (post) {
            console.log('Saved at: ' + post.updated_at);
        });
    });

    Post.whereNotNull('published_at').get().then(function (results) {
        // results.forEach(...);
        // ...
    });

    Post.published().latest().get(); // assumes a scopePublished() method on the server

    Post.saving(function (post) {
        return !! post.title; // prevent posting without a title
    });
    ```

#### Contributing
All contributions welcome. For anything related to the companion javascript library, please use [parsnick/eloquentjs-client](https://github.com/parsnick/eloquentjs-client).

#### License
MIT
