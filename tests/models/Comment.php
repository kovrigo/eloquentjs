<?php

namespace Acme;

use EloquentJs\Model\AcceptsEloquentJsQueries;
use EloquentJs\Model\EloquentJsQueries;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model implements AcceptsEloquentJsQueries
{
    use EloquentJsQueries;
}
