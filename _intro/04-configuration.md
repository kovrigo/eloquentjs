---
title: Set up / configuration
---

#### Edit your model classes to accept queries from EloquentJs

* Implement the `AcceptsEloquentJsQueries` interface.
* You can use the `EloquentJsQueries` trait to provide the implementation.

<div class="ui segment php sample">
    <div class="ui right corner label"></div>
{% highlight php startinline %}
use EloquentJs\Model\AcceptsEloquentJsQueries;
use EloquentJs\Model\EloquentJsQueries;
use Illuminate\Database\Eloquent\Model;

class Post extends Model implements AcceptsEloquentJsQueries {
    use EloquentJsQueries;
}
{% endhighlight %}
</div>


#### Create routes to handle queries from EloquentJs

* EloquentJs needs a controller to perform CRUD operations.
* You can use the `eloquent` macro to set one up automatically.

<div class="ui segment php sample">
    <div class="ui right corner label"></div>
{% highlight php startinline %}
// app/Http/routes.php
Route::eloquent('api/posts', App\Post::class);
{% endhighlight %}
</div>


#### Generate a custom eloquent.js build

* Use the artisan command to build a version of EloquentJs pre-configured
for your models.

<div class="ui segment terminal sample">
    <div class="ui right corner label"></div>
{% highlight console %}
$ php artisan eloquentjs:generate [--output="public/eloquent.js"]
{% endhighlight %}
</div>
