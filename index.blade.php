@extends('_layouts.master')

@section('body')

<div class="ui inverted vertical masthead center aligned segment">

  <div class="ui container">
    <div class="ui large secondary inverted pointing menu">
      <a class="toc toggler item">
        <i class="sidebar icon"></i>
      </a>
      <a class="active item" href=".">Overview</a>
      <a class="item" href="getting-started">Getting Started</a>
      <a class="item" href="client">Client</a>
      <a class="item" href="server">Server</a>
      <a class="item" href="recipes">Recipes</a>
      <div class="right item">
        <a class="ui right inverted button" href="https://github.com/parsnick/eloquentjs">
          <i class="github icon"></i>
          View on Github
        </a>
      </div>
    </div>
  </div>

  <div class="ui text container">
    
    <div class="ui basic clearing segment dev console">
      <div class="input">
        <i class="blue angle right icon"></i>
        Eloquent.Post.find(1).then(post => console.log(post));
        <span>&nbsp;</span>
      </div>
      <div class="output">
        <i class="grey angle left icon"></i>
        Promise {<span class="purple">[[PromiseStatus]]</span>: <span class="red">"pending"</span>, <span class="purple">[[PromiseValue]]</span>: <span class="grey">undefined</span>}
      </div>
      <div class="log">
        <i class="caret right icon"></i>
        Post {<span class="purple">id</span>: <span class="blue">1</span>,
        <span class="purple">title</span>: <span class="red">"My first post"</span>,
        <span class="purple">body</span>: <span class="red">"Hello, this is a post!"</span>,
        <span class="purple">visible</span>: <span class="blue">true</span>,
        <span class="purple">created_at</span>: Sat Jan 23 2016 00:42:26 GMT+0000 (GMT)&hellip;}
      </div>
    </div>
    
    <h1 class="ui inverted header">
      EloquentJs
    </h1>
    
    <h2>Bring your Eloquent ORM to the browser</h2>
    <a class="ui huge primary button" href="getting-started">Get Started <i class="right arrow icon"></i></a>
  </div>

</div>

<div class="ui vertical stripe segment">
  <div class="ui text container">
    <p>
      If you've already defined your models as part of a Laravel application, don't start from scratch with
      your javascript! <em>EloquentJs</em> takes your existing configuration and provides client-side access
      to your data with the same <a href="https://laravel.com/docs/5.2/eloquent">Eloquent</a> API you already know.
    </p>
  </div>
</div>

<div class="ui vertical stripe segment">
  <div class="ui equal width relaxed stackable grid container">
    <div class="ui center aligned getting started row">

      <div class="column">
        <i class="huge database icon"></i>
        <h3>Define an Eloquent model</h3>
          
@highlight('php')
class Post extends Model
{
  public function comments()
  {
    return $this->hasMany(Comment::class);
  }
}
@endhighlight
          
      </div>

      <div class="column">
        <i class="huge configure icon"></i>
        <h3>Build your eloquent.js</h3>
          
@highlight('bash')
$ php artisan eloquentjs:generate

| Model    | Endpoint  |
+----------+-----------+
| App\Post | api/posts |

written to: public/eloquent.js
@endhighlight
          
      </div>

      <div class="column">
        <i class="huge file code outline icon"></i>
        <h3>Use eloquent in javascript</h3>
          
@highlight('js')
Eloquent.Post.find(1).then(post => {

  console.log('fetched #' + post.id);
  post.update({title: 'My new title'});
  post.load('comments').then(/* ... */);

});
@endhighlight
          
      </div>

    </div><!-- /.row -->
  </div><!-- /.grid.container -->

</div>

<div class="ui inverted vertical stripe features segment">
  <div class="ui container">
    <h3 class="ui inverted header">Why use EloquentJs?</h3>
    <div class="ui list">
      
      <div class="item">
        <i class="line chart icon"></i>
        <div class="content">
          <strong>minimal learning curve</strong> - as far as practical, uses the same API as Laravel's Eloquent          
        </div>
      </div>

      <div class="item">
        <i class="browser icon"></i>
        <div class="content">
          runs in any ES5 and Fetch capable browser<sup>*</sup>          
        </div>
      </div>
      
      <div class="item">
        <i class="leaf icon"></i>
        <div class="content">
          client library is just 17<small>KB</small> (<b>3.8<small>KB</small></b> gzipped) and no dependencies
        </div>
      </div>
      
      <div class="item">
        <i class="rocket icon"></i>
        <div class="content">
          written in <strong>ES2015</strong> (babelified for production)
        </div>
      </div>

      <div class="item">
        <i class="checkmark icon"></i>
        <div class="content">
          with tests and docs
          <a href="https://coveralls.io/github/parsnick/eloquentjs-client?branch=master"><img src="https://coveralls.io/repos/parsnick/eloquentjs-client/badge.svg?branch=master&amp;service=github" alt="Coverage Status"></a> 
          <a href="https://doc.esdoc.org/github.com/parsnick/eloquentjs-client/"><img src="https://doc.esdoc.org/github.com/parsnick/eloquentjs-client/badge.svg" alt="API docs"></a>
        </div>
      </div>

      <div class="small item">
        <small>* <a href="https://github.com/github/fetch">fetch polyfill</a> can be used </small>
      </div>
{{-- 
      <div class="item">
        <div class="read-more content">
          <a href="why">
            <i class="right arrow icon"></i> read more on the motivation behind EloquentJs
            <br>
            and when you might - or might not - want to use it.                        
          </a>
        </div>
      </div>
--}}
    </div>

  </div>
</div>

<div class="ui vertical stripe segment">
  <div class="ui text container">
    <div class="ui basic segment">
      <div class="ui right floated tiny basic buttons">
        <a href="https://packagist.org/packages/parsnick/eloquentjs" class="ui button">Packagist</a>
        <a href="https://github.com/parsnick/eloquentjs" class="ui button">Github</a>
      </div>
      <h3 class="ui header">parsnick/eloquentjs <span class="subtitle">the PHP package</span></h3>
      <p>
        This is the server-side package which interprets incoming queries,
        checks for authorisation, and generates the relevant response.
        It comes bundled with the latest <code>eloquentjs</code> build
        so it's all you usually need.
      </p>
      <p>
      <a href="server" class="ui large button">documentation</a>
      </p>
    </div>

    <br>

    <div class="ui basic segment">
      <div class="ui right floated tiny basic buttons">
        <a href="https://www.npmjs.com/package/eloquentjs" class="ui button">npm</a>
        <a href="https://github.com/parsnick/eloquentjs-client" class="ui button">Github</a>
      </div>
      <h3 class="ui header">eloquentjs <span class="subtitle">the node package</span></h3>
      <p>
        For advanced usage, the complete source of the client-side half of EloquentJs
        is available here. It provides the Eloquent API in javascript and can be
        imported into your own build process using browserify, webpack, or similar.
      </p>
      <a href="client" class="ui large button">documentation</a>
    </div>

  </div>
</div>

<div class="ui inverted vertical footer segment">
  <div class="ui equal width container grid">
    <div class="column">
      <h3 class="ui inverted sub header">License</h3>
      MIT
    </div>
    <div class="right aligned column">
      based on the <a href="https://laravel.com/docs/5.1/eloquent">Eloquent ORM</a> by Taylor Otwell, not affiliated with Laravel
      <br>
      website built with <a href="http://parsnick.github.io/steak/">steak</a>
    </div>
  </div>
</div>
  
@stop
