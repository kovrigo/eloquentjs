Any Eloquent <code><abbr title="Illuminate\Database\Eloquent\Model">Model</abbr></code> can be used with *EloquentJs*.

* Simply implement <code><abbr title="EloquentJs\Model\EloquentJsQueries">AcceptsEloquentJsQueries</abbr></code>
[<i class="tiny external icon" title="View on GitHub"></i>](https://github.com/parsnick/eloquentjs/blob/master/src/Model/AcceptsEloquentJsQueries.php)
* You can use the <code><abbr title="EloquentJs\Model\EloquentJsQueries">EloquentJsQueries</abbr></code> trait to provide the implementation.

For example, a `Post` model might look like:

```language-php
<?php

namespace App;

use EloquentJs\Model\AcceptsEloquentJsQueries;
use EloquentJs\Model\EloquentJsQueries;
use Illuminate\Database\Eloquent\Model;

class Post extends Model implements AcceptsEloquentJsQueries
{
    use EloquentJsQueries;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['published_at'];

    /**
     * Define relationship to comments.
     *
      * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Scope a query to only include posts with a published date in the past.
     *
     * @param  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished($query)
    {
        return $query->whereDate('published_at', '<', \DB::raw('NOW()'))
                     ->whereNotNull('published_at');
    }
}
```
