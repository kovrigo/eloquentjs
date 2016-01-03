---
layout: blank
---

{% include navbar.html active="overview" classes="hidden fixed" %}

<!-- Sidebar Menu -->
<div class="ui vertical inverted sidebar menu">
  <a class="active item" href="/">Overview</a>
  <a class="item" href="/getting-started">Getting Started</a>
  <a class="item" href="/php">Server</a>
  <a class="item" href="/js">Client</a>
</div>

<div class="pusher">

  <div class="ui inverted vertical masthead center aligned segment">

    <div class="ui container">
      <div class="ui large secondary inverted pointing menu">
        <a class="toc item">
          <i class="sidebar icon"></i>
        </a>
        <a class="active item" href="/">Overview</a>
        <a class="item" href="/getting-started">Getting Started</a>
        <a class="item" href="/php">Server</a>
        <a class="item" href="/js">Client</a>
        <div class="right item">
          <a class="ui right inverted button" href="https://github.com/parsnick/eloquentjs">
            <i class="github icon"></i>
            View on Github
          </a>
        </div>
      </div>
    </div>

    <div class="ui text container">
      <h1 class="ui inverted header">
        EloquentJs
      </h1>
      <h2>Bring your Eloquent ORM to the browser</h2>
      <a class="ui huge primary button" href="/getting-started">Get Started <i class="right arrow icon"></i></a>
    </div>

  </div>

  <div class="ui vertical stripe segment">
    <div class="ui equal width relaxed stackable grid container">
      <div class="ui center aligned getting started row">

        <div class="column">
          <i class="huge database icon"></i>
          <h3>Define an <a href="https://laravel.com/docs/5.1/eloquent">Eloquent</a> model</h3>
          <div class="ui segment">
{% highlight php startinline %}
class Post extends \Illuminate\Database\Eloquent\Model
{
  public function comments()
  {
    return $this->hasMany(Comment::class);
  }
}
{% endhighlight %}
          </div>
        </div>

        <div class="column">
          <i class="huge configure icon"></i>
          <h3>Build your eloquent.js</h3>
          <div class="ui inverted segment">
            <div class="sample terminal">
{% highlight console %}
$ php artisan eloquentjs:generate

| Model    | Endpoint  |
+----------+-----------+
| App\Post | api/posts |

Javascript written to public/eloquent.js
{% endhighlight %}
            </div>
          </div>
        </div>

        <div class="column">
          <i class="huge file code outline icon"></i>
          <h3>Use eloquent in javascript</h3>
          <div class="ui segment">
{% highlight javascript %}
Eloquent.Post.find(1).then(post => {
  console.log('fetched post #' + post.id);

  post.update({ title: 'My new title' });

  post.load('comments').then(/* ... */);
});
{% endhighlight %}
        </div>
      </div>

    </div><!-- /.row -->
  </div><!-- /.grid.container -->

</div>

<div class="ui vertical stripe segment">
  <div class="ui text container">
    <div class="ui basic segment">
      <div class="ui right floated tiny basic buttons">
        <a href="https://packagist.org/packages/parsnick/eloquentjs" class="ui button">Packagist</a>
        <a href="https://github.com/parsnick/eloquentjs" class="ui button">Github</a>
      </div>
      <h3 class="ui header">eloquentjs <span class="subtitle">the PHP package</span></h3>
      <p>
        This is the server-side package which interprets incoming queries,
        checks for authorisation, and generates the relevant response.
        It comes bundled with the latest <code>laravel-eloquentjs</code> build
        so it's all you usually need.
      </p>
      <p>
      <a href="/php" class="ui large button">Read documentation</a>
      </p>
    </div>

    <br>

    <div class="ui basic segment">
      <div class="ui right floated tiny basic buttons">
        <a href="https://www.npmjs.com/package/laravel-eloquentjs" class="ui button">npm</a>
        <a href="https://github.com/parsnick/eloquentjs-client" class="ui button">Github</a>
      </div>
      <h3 class="ui header">laravel-eloquentjs <span class="subtitle">the node package</span></h3>
      <p>
        The client-side companion to <code>eloquentjs</code>, this provides the Eloquent API
        in javascript. It supports the fluent syntax you already know, sends the encoded query
        to the server, and interprets the response.
      </p>
      <a href="/js" class="ui large button">Read documentation</a>
    </div>

  </div>
</div>

<div class="ui inverted vertical footer segment">
  <div class="ui equal width container grid">
    <div class="column">
      <h3 class="header">License</h3>
      MIT
    </div>
    <div class="right aligned column">
      based on the <a href="https://laravel.com/docs/5.1/eloquent">Eloquent ORM</a> by Taylor Otwell
      <br>
      not affiliated with Laravel
    </div>
  </div>
</div>

</div><!-- /.pusher -->