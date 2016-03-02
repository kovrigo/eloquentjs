
Executing any query in *EloquentJs* is inevitably asynchronous since it requires
a round trip to the server and back. This accounts for the most obvious difference
between our client-side implementation and Laravel's Eloquent - any method that causes
a query to run will always return a [Promise](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Promise)
rather than the result directly.

<div class="ui two column grid">
  <div class="column">
<pre><code class="language-php">$post = Post::find(1);

var_dump($post);
</code></pre>
  </div>
  <div class="column">
<pre><code class="language-js">Post.find(1).then(function (post) {
  console.log(post);
});
</code></pre>
  </div>
</div>

<br>

The main Eloquent features are supported as described below. Note that the
existence of a method in the client-side API does not necessarily mean the
server will allow the method to be called.

<br>

<div class="ui basic secondary small segment">
  <div class="ui three column grid">
    <div class="column">
      <h4 class="ui header">
        <i class="green checkmark box icon"></i> Supported
      </h4>
      <p>Feature is supported and implemented in the current version.</p>
    </div>
    <div class="column">
      <h4 class="ui header">
        <i class="red minus square box icon"></i> Unsupported
      </h4>
      <p>Feature is deliberately unsupported, usually for security considerations.</p>
    </div>
    <div class="column">
      <h4 class="ui header">
        <i class="minus square outline box icon"></i> Not implemented
      </h4>
      <p>Feature is not yet implemented but may be in future.</p>
    </div>
  </div>
</div>

### Query Builder

<div class="ui very relaxed celled list">

  <div class="item">
    <i class="green checkmark box icon"></i>
    <div class="content">
      Basic builder methods that use PDO parameter binding to protect against SQL injection:
      <p>
        <code class="small">select()</code>,
        <code class="small">distinct()</code>,
        <code class="small">where()</code>,
        <code class="small">having()</code>,
        <code class="small">orderBy()</code>,
        <code class="small">offset()</code>,
        <code class="small">limit()</code>,
        &hellip;
      </p>
      <p>
        Sugary methods are also supported:
        <code class="small">orWhereNotNull()</code>,
        <code class="small">latest()</code>,
        <code class="small">forPage()</code>,
        &hellip;
      </p>
    </div>
  </div>

  <div class="item">
    <i class="red minus square icon"></i>
    <div class="content">
      Builder methods that allow raw SQL:
      <p>
        <code class="small">selectRaw()</code>,
        <code class="small">whereRaw()</code>,
        <code class="small">havingRaw()</code>,
        &hellip;
      </p>
    </div>
  </div>

  <div class="item">
    <i class="red minus square icon"></i>
    <div class="content">
      Builder methods that perform joins to an arbitrary table:
      <p>
        <code class="small">join()</code>,
        <code class="small">leftJoin()</code>,
        &hellip;
      </p>
    </div>
  </div>

  <div class="item">
    <i class="minus square outline icon"></i>
    <div class="content">
      Builder methods that perform unions:
      <p>
        <code class="small">union()</code>,
        <code class="small">unionAll()</code>
      </p>
    </div>
  </div>

</div>


### Collections

<div class="ui very relaxed celled list">

  <div class="item">
    <i class="minus outline square icon"></i>
    <div class="content">
      Queries that fetch multiple rows will return a native <code class="small">Array</code>.
      There is currently no equivalent to <code class="small">Illuminate\Database\Eloquent\Collection</code>,
      but this may change when there's better browser support for subclassing built-ins.
    </div>
  </div>

</div>


### Retrieving Single Models

<div class="ui very relaxed celled list">

  <div class="item">
    <i class="green checkmark box icon"></i>
    <div class="content">
      Fetches a model by primary key with <code class="small">find()</code>:
<pre><code class="language-js">Post.find(1).then(function (post) {
  console.log(post);
});</code></pre>
    </div>
  </div>

  <div class="item">
    <i class="green checkmark box icon"></i>
    <div class="content">
      Fetches the first matching row with <code class="small">first()</code>:
<pre><code class="language-js">Post.where('visible', true).first().then(function (post) {
  console.log(post);
});</code></pre>
    </div>
  </div>

  <div class="item">
    <i class="green checkmark box icon"></i>
    <div class="content">
      Not found exceptions thrown if no results found:
      <p>
        <code class="small">firstOrFail()</code>,
        <code class="small">findOrFail()</code>
      </p>
    </div>
  </div>

</div>

### Retrieving Aggregates

<div class="ui very relaxed celled list">

  <div class="item">
    <i class="minus outline square icon"></i>
    <div class="content">
      Aggregate functions:
      <p>
        <code class="small">count()</code>,
        <code class="small">sum()</code>,
        <code class="small">min()</code>,
        <code class="small">max()</code>,
        <code class="small">avg()</code>
      </p>
    </div>
  </div>

</div>


### Inserting & Updating

<div class="ui very relaxed celled list">

  <div class="item">
    <i class="green checkmark box icon"></i>
    <div class="content">
      Basic inserts and mass assignments:
<pre><code class="language-js">var post = new Post();
post.title = 'My first post';
post.save();
// or
Post.create({ title: 'My first post' });</code></pre>
      <div class="small ui basic secondary segment">
        Both syntaxes are equivalent in <em>EloquentJs</em>, unlike in server-side Eloquent.
        <br>
        Models created client-side are always subject to the server-side mass assignment protection.
      </div>
    </div>
  </div>

  <div class="item">
    <i class="green checkmark box icon"></i>
    <div class="content">
      Updates an existing model
<pre><code class="language-js">// Post.find(1).then(post => {
  post.title = 'My first updated post';
  post.save();
  // or
  post.update({ title: 'update' });
// });</code></pre>
      <div class="small ui basic secondary segment">
        Both syntaxes are equivalent in <em>EloquentJs</em>, unlike in server-side Eloquent.
        <br>
        Models updated client-side are always subject to the server-side mass assignment protection.
      </div>
    </div>
  </div>

  <div class="item">
    <i class="green checkmark box icon"></i>
    <div class="content">
      Updates any number of models matching a query
<pre><code class="language-js">Post.whereNull('reviewed_at')
    .whereNotNull('published_at')
    .update({ visible: false });</code></pre>
    </div>
  </div>

  <div class="item">
    <i class="minus square outline icon"></i>
    <div class="content">
      Other creation methods:
      <p>
        <code class="small">firstOrNew()</code>,
        <code class="small">firstOrCreate()</code>
      </p>
    </div>
  </div>

</div>


### Deleting

<div class="ui very relaxed celled list">

  <div class="item">
    <i class="green checkmark box icon"></i>
    <div class="content">
      Deletes an existing model
<pre><code class="language-js">// Post.find(1).then(post => {
  post.delete();
// });</code></pre>
    </div>
  </div>

  <div class="item">
    <i class="green checkmark box icon"></i>
    <div class="content">
      Deletes any number of models matching a query
<pre><code class="language-js">Post.where('visible', false).delete();</code></pre>
    </div>
  </div>

  <div class="item">
    <i class="minus outline square icon"></i>
    <div class="content">
      Soft deletes
    </div>
  </div>

</div>


### Query Scopes

<div class="ui very relaxed celled list">

  <div class="item">
    <i class="minus outline square icon"></i>
    <div class="content">
      Global scopes are respected by the server-side package, but
      cannot be removed by <em>EloquentJs</em>.
    </div>
  </div>

  <div class="item">
    <i class="green checkmark box icon"></i>
    <div class="content">
      Local scopes, including dynamic scopes:

<pre><code class="language-php">// app/Post.php
class Post {
  public function scopeAuthoredBy($query, $authorId) { /* ... */ }
}</code></pre>

<pre><code class="language-js">// javascript
Post.authoredBy(42).get();</code></pre>
    </div>
  </div>

</div>

<div class="ui basic secondary segment">
  <i class="info circle icon"></i>
  Only scalar values are allowed. This will not work:

<pre><code class="language-js">var user = { id: 1, name: 'Bob' };
Post.authoredBy(user).get();</code></pre>

</div>

### Events

<div class="ui very relaxed celled list">

  <div class="item">
    <i class="green checkmark box icon"></i>
    <div class="content">
      Model events:
      <p>
        <code class="small">creating</code>,
        <code class="small">created</code>,
        <code class="small">updating</code>,
        <code class="small">updated</code>,
        <code class="small">saving</code>,
        <code class="small">saved</code>,
        <code class="small">deleting</code>,
        <code class="small">deleted</code>
      </p>
<pre><code class="language-js">Post.creating(function (post) {
  return !! post.title; // validate the post
});

Post.create({ body: 'Hello' }); // will not be created</code></pre>
    </div>
  </div>

</div>
