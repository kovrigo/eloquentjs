@extends('recipes.index')

@section('content')
  
  <h2 class="ui dividing header">Customising the connection</h2>
  
  <p>
    <em>EloquentJs</em> comes with a <code>RestConnection</code> <a href="https://github.com/parsnick/eloquentjs-client/blob/master/src/Connection/RestConnection.js" title="View source on GitHub"><i class="github icon"></i></a>, which sends HTTP requests following REST conventions. If you want to persist data using a different method, such
    as LocalStorage, IndexedDB, or an integration with another library like <a href="http://lokijs.org/">LokiJS</a> 
    or <a href="https://pouchdb.com/">PouchDB</a>, not a problem.
  </p>

  <p>
    The <code>Connection</code> interface is very simple:
  </p>

  @highlight('js')
class Connection {

    /**
     * Run an INSERT query.
     *
     * @param  {Object} data
     * @return {Promise}
     */
    create(data) {/* ... */}

    /**
     * Run a SELECT type query.
     *
     * @param  {number|Array} idOrQuery
     * @return {Promise}
     */
    read(idOrQuery) {/* ... */}

    /**
     * Run an UPDATE query.
     *
     * @param  {number|Array} idOrQuery
     * @param  {Object} data
     * @return {Promise}
     */
    update(idOrQuery, data) {/* ... */}

    /**
     * Run a DELETE query.
     *
     * @param  {number|Array} idOrQuery
     * @return {Promise}
     */
    delete(idOrQuery) {/* ... */}
}

// or equivalent in ES5
var Connection = function() {/* ... */};
Connection.prototype.create = function(data) {/* ... */};
Connection.prototype.read   = function(idOrQuery) {/* ... */};
Connection.prototype.update = function(idOrQuery, data) {/* ... */};
Connection.prototype.delete = function(idOrQuery) {/* ... */};
  @endhighlight

  <p>
    &hellip; where <code>idOrQuery</code> is either a primary key or an array of query builder methods.
  </p>

  <p>
    To illustrate:
  </p>

  <div class="ui relaxed list">
    <div class="item">
      <div class="header"><code>Eloquent.Post.find(1)</code></div>
      <div class="description">calls <code>connection.read(1)</code></div>
    </div>
    <div class="item">
      <div class="header"><code>Eloquent.Post.where('title', '=', 'Hello').limit(5).get()</code></div>
      <div class="description">
        calls <code>connection.read([['where', ['title', '=', 'Hello']], ['limit', [5]]])</code>
      </div>
    </div>
  </div>

  <p>
    For types of connections that don't sufficiently support all the query builder methods available
    in <em>EloquentJs</em>, you may need to load all results into memory and apply the query methods
    yourself.
  </p>

  <p>
    An incomplete implementation of an in-memory <code>ArrayConnection</code> which does exactly that can
    be seen at <a href="https://github.com/parsnick/eloquentjs-arrayconnection">parsnick/eloquentjs-arrayconnection <i class="github icon"></i></a>.
  </p>

  <h3>Using your connection</h3>

  <p>
    To use your custom connection on an <em>EloquentJs</em> model, simply override the <code>connection</code>
    property on the model prototype:
  </p>

  @highlight('javascript')
Eloquent.Post.prototype.connection = new MyConnection();
  @endhighlight
@stop
