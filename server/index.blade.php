@extends('_layouts.docs')

@section('breadcrumb', 'Server')
@section('sidebar:server:class', 'active')

@section('content')

  <h2 class="ui dividing header">Introduction</h2>
  @include('server/_01-introduction')
  
  <h2 class="ui dividing header">Configure your models</h2>
  @include('server/_02-models')
  
  <h2 class="ui dividing header">Usage with the built-in controller</h2>
  @include('server/_03-controllerless')
  
  <h2 class="ui dividing header">Usage with your own controller</h2>
  @include('server/_04-custom-controllers')
  
  <h2 id="create-your-eloquent-js-build" class="ui dividing header">Create your eloquent.js build</h2>
  @include('server/_05-script-generator')
  
  <h2 class="ui dividing header">Extending <em>EloquentJs</em></h2>
  @include('server/_06-extending-eloquentjs')
  
@stop
