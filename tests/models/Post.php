<?php

namespace Acme;

use EloquentJs\Model\EloquentJsQueries;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use EloquentJsQueries;

    protected $dates = ['published_at'];
    protected $endpoint = 'POSTS';
    protected $guarded = [];

    public function scopePublished($query)
    {
        $query->whereNotNull('published_at');
    }
}
