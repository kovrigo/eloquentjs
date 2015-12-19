<?php

namespace Acme;

use EloquentJs\Model\AcceptsEloquentJsQueries;
use EloquentJs\Model\EloquentJsQueries;
use Illuminate\Database\Eloquent\Model;

class Post extends Model implements AcceptsEloquentJsQueries
{
    use EloquentJsQueries;

    protected $dates = ['published_at'];
    protected $endpoint = 'POSTS';

    public function scopePublished($query)
    {
        $query->whereNotNull('published_at');
    }
}
