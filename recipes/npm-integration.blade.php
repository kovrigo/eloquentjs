@extends('recipes.index')

@section('content')
  
  <h2 class="ui dividing header">Integrating with the npm package</h2>
  
  <p>
    If you have an existing build process for your javascript, you might prefer
    to <code>require()</code> or <code>import</code> <em>EloquentJs</em> from npm:
  </p>

  <h3>Import only specific components (ES6)</h3>

  @highlight('javascript')
// resources/assets/js/Post.js
import {Model} from 'eloquentjs';

export default class Post extends Model {
    myCustomBehaviour() {
      console.log('Hello');
    }
} 
  @endhighlight

  <h3>Import the whole module (ES5)</h3>

  @highlight('js')
// resources/assets/js/Post.js
var Eloquent = require('eloquentjs');

Eloquent('Post', {
  endpoint: 'api/posts'
});

module.exports = Eloquent.Post;
  @endhighlight
@stop
