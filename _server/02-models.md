---
title: Model setup
---

* Any subclass of `Illuminate\Database\Eloquent\Model` can be used with *EloquentJs*.
* Models should implement [`EloquentJs\Model\AcceptsEloquentJsQueries`](https://github.com/parsnick/eloquentjs/blob/master/src/Model/AcceptsEloquentJsQueries.php).
* You can use the included trait `EloquentJs\Model\EloquentJsQueries` to provide the implementation.

For example, a `Post` model might look like:

<div class="ui segment php sample">
  <div class="ui right corner label"></div>
  {% highlight php %}
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
     * Scope to results with a published date in the past.
     *
     * @param  $query
     * @return void
     */
    public function scopePublished($query)
    {
        $query->whereDate('published_at', '<', \DB::raw('NOW()'))
              ->whereNotNull('published_at');
    }
}
  {% endhighlight %}
</div>
