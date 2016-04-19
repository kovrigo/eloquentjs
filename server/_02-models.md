Any Eloquent <code><abbr title="Illuminate\Database\Eloquent\Model">Model</abbr></code> can be used with *EloquentJs*.

* Simply implement <code>scopeEloquentJs()</code> in the model
* You can use the <code><abbr title="EloquentJs\Model\EloquentJsQueries">EloquentJsQueries</abbr></code> trait to provide the implementation.

For example, a `Post` model might look like:

```language-php
<?php

namespace App;

use EloquentJs\Model\EloquentJsQueries;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
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
