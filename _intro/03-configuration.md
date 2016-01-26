---
title: Configuration
---

#### Implement `AcceptsEloquentJsQueries` on an Eloquent model

<div class="ui segment php sample">
{% highlight php startinline %}
use EloquentJs\Model\AcceptsEloquentJsQueries;
use EloquentJs\Model\EloquentJsQueries;
use Illuminate\Database\Eloquent\Model;

class Post extends Model implements AcceptsEloquentJsQueries {
    use EloquentJsQueries;
}
{% endhighlight %}
</div>

#### Create a RESTful endpoint

EloquentJs needs a controller to perform CRUD operations.
Use the `eloquent` macro on the router to set one up automatically.

<div class="ui segment php sample">
{% highlight php startinline %}
// app/Http/routes.php
Route::eloquent('api/posts', App\Post::class);
{% endhighlight %}
</div>


#### Generate your custom eloquent.js

Use the artisan command to build a version of EloquentJs pre-configured
for your models. Simply include the generated javascript file in your templates
and start using Eloquent in the browser.

<div class="ui segment terminal sample">
{% highlight bash %}
php artisan eloquentjs:generate [--output="public/eloquent.js"]
{% endhighlight %}
</div>
