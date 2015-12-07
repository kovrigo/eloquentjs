<?php
namespace spec\Fixtures;

use EloquentJs\Model\EloquentJsQueries;
use Illuminate\Database\Eloquent\Model;

class PostModel {
    use EloquentJsQueries;
    protected $endpoint = 'api/posts';
}

class CommentModel {
    use EloquentJsQueries;
}

class NoEndpointModel {
    use EloquentJsQueries;
}

class UserModel {}

class MyController {}
