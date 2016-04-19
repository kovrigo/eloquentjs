@extends('recipes.index')

@section('content')
  
  <h2 class="ui dividing header">Usage with data-binding libraries</h2>
  
  <p>
    Showing a listing of a particular resource - be it posts on a blog, tasks in a to-do list, or whatever else -
    is a common use-case. The example below shows how <em>EloquentJs</em> makes it easy to add server-side filtering
    and sorting to a list.
  </p>

  <h3>Preparation</h3>
  
  <p>
    This example focuses on the javascript side of <em>EloquentJs</em>. It assumes there's an existing <code>Task</code> model with fields for <code>title</code> (string) and <code>is_completed</code> (boolean),
    and you've generated an <code>eloquent.js</code> build. If you need help getting there, instructions are below&hellip; otherwise, skip ahead.
  </p>

  <div class="ui accordion">
    <div class="title">
      <i class="dropdown icon"></i>
      View set up steps
    </div>
    <div class="content">
      <ol>
        <li>
          Follow the <strong>Installation</strong> step as described in <a href="getting-started">Getting Started</a>
        </li>
        <li>
          Create a <code>Task</code> model that uses the <code>EloquentJsQueries</code> trait:
          @highlight('php')
// app/Post.php
namespace App;

use EloquentJs\Model\EloquentJsQueries;
use Illuminate\Database\Eloquent\Model;

class Task extends Model {
    use EloquentJsQueries;
}
          @endhighlight
        </li>
        <li>
          Create and run a migration for the <code>tasks</code> table with the following schema:
          @highlight('schema')
Schema::create('tasks', function (Blueprint $table) {
    $table->increments('id');
    $table->string('title');
    $table->boolean('is_completed');
    $table->timestamps();
});
          @endhighlight
        </li>
        <li>
          Register a route for the <code>Task</code> model using <code>Route::eloquent()</code>
          @highlight('routes')
    // app/Http/routes.php
    Route::eloquent('api/task', App\Task::class, ['only' => ['index']]);
          @endhighlight      
        </li>
        <li>
          Create an <code>eloquent.js</code> build by running <code>php artisan eloquentjs:generate</code>
        </li>
      </ol>
    </div>
  </div>

  <h3>Data</h3>

  <p>
    Assume our items are in the format:
  </p>
  @highlight('json')
{
  "id": 1,
  "title": "First task",
  "is_completed": false,
  "created_at": "2016-01-23T00:42:35+0000"
}
  @endhighlight

  <h3>Markup</h3>

  <p>
    To start with, we need some markup to display our list. We also some form elements to control
    which items we show, and in what order:
  </p>

  @highlight('html5')
  {{ htmlentities(<<<'HTML'
<fieldset>
  <label>
    <input type="checkbox"> Show only completed
  </label>
  <br>
  Order by
  <label>
    <input type="radio" name="order" value="created_at" checked> date
  </label>
  <label>
    <input type="radio" name="order" value="title"> title
  </label>
</fieldset>
<ul>
  <li>Task 1</li>
  <li>Task 2</li>
  <li>...</li>
</ul>
HTML
    ) }}
  @endhighlight

  <div class="ui segment">
    <fieldset>
      <label>
        <input type="checkbox"> Show only completed
      </label>
      <br>
      Order by
      <label>
        <input type="radio" name="order" value="created_at" checked> date
      </label>
      <label>
        <input type="radio" name="order" value="title"> title
      </label>
    </fieldset>
    <ul>
      <li>Task 1</li>
      <li>Task 2</li>
      <li>...</li>
    </ul>
  </div>

  <h3>Objective</h3>

  <p>
    We need to do two things here:
  </p>
  <ol>
    <li>render our list of items into that <code>ul</code></li>
    <li>use those form elements to control which items our list shows</li>
  </ol>

  <h3>Implementation</h3>
  <p>
    Although we <em>could</em> do this in native javascript, using our favourite data-binding library makes
    it almost trivial - we can simply bind those form elements to a <code>modifiers</code> property on the
    view model, and define a <code>load</code> method that fetches the correct items.
  </p>

  <p>
    Here's a complete example using the Angular framework (but of course, other libraries are available):
  </p>

  <h4>Angular (1.x)</h4>
  @highlight('html')
&#x3C;!DOCTYPE html&#x3E;
&#x3C;html lang=&#x22;en&#x22; ng-app=&#x22;todos&#x22;&#x3E;
&#x3C;head&#x3E;
  &#x3C;title&#x3E;To-do list&#x3C;/title&#x3E;
&#x3C;/head&#x3E;
&#x3C;body ng-controller=&#x22;TaskController&#x22;&#x3E;

  &#x3C;fieldset&#x3E;
    &#x3C;label&#x3E;
      &#x3C;input type=&#x22;checkbox&#x22; ng-model=&#x22;modifiers.complete&#x22;&#x3E; Show only completed
    &#x3C;/label&#x3E;
    &#x3C;br&#x3E;
    Order by
    &#x3C;label&#x3E;
      &#x3C;input type=&#x22;radio&#x22; name=&#x22;order&#x22; value=&#x22;created_at&#x22; ng-model=&#x22;modifiers.order&#x22; checked&#x3E; date
    &#x3C;/label&#x3E;
    &#x3C;label&#x3E;
      &#x3C;input type=&#x22;radio&#x22; name=&#x22;order&#x22; value=&#x22;title&#x22; ng-model=&#x22;modifiers.order&#x22;&#x3E; title
    &#x3C;/label&#x3E;
  &#x3C;/fieldset&#x3E;

  &#x3C;ul&#x3E;
    &#x3C;li ng-repeat=&#x22;task in tasks&#x22;&#x3E;
      &#x3C;span ng-if=&#x22;task.is_completed&#x22;&#x3E;(done)&#x3C;/span&#x3E;
      @{{ task.title }}
    &#x3C;/li&#x3E;
  &#x3C;/ul&#x3E;

  &#x3C;script src=&#x22;https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.5.4/angular.js&#x22;&#x3E;&#x3C;/script&#x3E;
  &#x3C;script src=&#x22;eloquent.js&#x22;&#x3E;&#x3C;/script&#x3E;
  &#x3C;script&#x3E;
  angular
    .module(&#x27;todos&#x27;, [])
    .controller(&#x27;TaskController&#x27;, function($scope) {

      // Define the avilable modifiers for our task list
      $scope.modifiers = {
        complete: false,
        order: &#x27;id&#x27;
      };

      // Fetch task list using current modifiers
      $scope.reload = function () {
        var query = Eloquent.Task.query();

        if ($scope.modifiers.complete) {
          query.where(&#x27;is_completed&#x27;, true);
        }

        if ($scope.modifiers.order) {
          query.orderBy($scope.modifiers.order);
        }

        query.get().then(tasks =&#x3E; {
          $scope.tasks = tasks;
          $scope.$apply();
        });
      };

      // Reload if a filter changes
      $scope.$watch(&#x27;modifiers&#x27;, $scope.reload, true);

      // And show the initial list
      $scope.reload();
    })

  &#x3C;/script&#x3E;
&#x3C;/body&#x3E;
&#x3C;/html&#x3E;
  @endhighlight

  <h3>Footnotes</h3>
  <p>
    For brevity, the example only shows two fairly simple "modifiers" for the list but in reality, you'll likely have more. You should be able to see how to add any number of additional filtering or sorting options. In this way, 
    you can easily build up a powerful UI with very little code. Not to mention, when you need to make changes a few
    months later, the code clearly describes exactly what you're doing.
  </p>
@stop

@push('scripts')
  <script>
    $(function () {
      $('.ui.accordion').accordion();
    });
  </script>
@endpush
