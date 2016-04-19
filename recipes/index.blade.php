@extends('_layouts.docs')

@section('breadcrumb', 'Recipes')
@section('sidebar:recipes:class', 'active')
@section('sidebar:recipes')
  <div class="menu">
    <div class="item">
      <a href="recipes/data-binding.html">Usage with data-binding libraries</a>
    </div>
    <div class="item">
      <a href="recipes/npm-integration.html">Integrating with the npm package</a>
    </div>
    <div class="item">
      <a href="recipes/custom-connection.html">Customising the connection</a>
    </div>    
  </div>
@stop

@section('content')
  
  <h2 class="ui header">
    Recipes
  </h2>
  <p>The pages in this section show how you might use <em>EloquentJs</em> in a real-world project.</p>

  <h3 class="ui dividing header">
    <a href="recipes/data-binding.html">
      Usage with data-binding libraries
    </a>    
  </h3>

  <p>
    Combine <em>EloquentJs</em> with something like <em>Angular</em>, <em>Knockout</em> or <em>Vue</em>
    to create a powerful UI for your app in minutes.
  </p>

  <h3 class="ui dividing header">
    <a href="recipes/npm-integration.html">
      Integrating with the npm package
    </a>    
  </h3>

  <p>
    If you have an existing build process for your javascript, you might prefer
    to <code>require()</code> or <code>import</code> <em>EloquentJs</em> as an npm module.
    Not a problem!
  </p>

  <h3 class="ui dividing header">
    <a href="recipes/custom-connection.html">
      Customising the connection
    </a>    
  </h3>

  <p>
    The package assumes you want models to be persisted via an HTTP REST connection.
    If that's not the case, swap out the <code>Connection</code> class for one that suits.
  </p>

  <h3 class="ui dividing header">More to come&hellip;</h3>
  
  <p>
    Submit an issue (or even better, a pull request) if there's anything else you'd like to see here.
  </p>
  
@stop
