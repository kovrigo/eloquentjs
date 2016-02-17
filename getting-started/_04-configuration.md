#### Edit your model classes to accept queries from EloquentJs

* Implement the `AcceptsEloquentJsQueries` interface.
* You can use the `EloquentJsQueries` trait to provide the implementation.

```language-php
use EloquentJs\Model\AcceptsEloquentJsQueries;
use EloquentJs\Model\EloquentJsQueries;
use Illuminate\Database\Eloquent\Model;

class Post extends Model implements AcceptsEloquentJsQueries {
    use EloquentJsQueries;
}
```

#### Create routes to handle queries from EloquentJs

* EloquentJs needs a controller to perform CRUD operations.
* You can use the `eloquent` macro to set one up automatically.

```language-php
// app/Http/routes.php
Route::eloquent('api/posts', App\Post::class);
```

#### Generate a custom eloquent.js build

* Use the artisan command to build a version of EloquentJs pre-configured
for your models.

```language-bash
php artisan eloquentjs:generate [--output="public/eloquent.js"]
```
