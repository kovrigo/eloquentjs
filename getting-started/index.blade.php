@extends('_layouts.docs')

@section('breadcrumb', 'Getting Started')
@section('sidebar:getting-started:class', 'active')

@section('content')

  <h2 class="ui dividing header">Introduction</h2>
  @include('getting-started/_01-about')

  <h2 class="ui dividing header">Requirements</h2>
  @include('getting-started/_02-requirements')

  <h2 class="ui dividing header">Installation</h2>
  @include('getting-started/_03-installation')

  <h2 class="ui dividing header">Set up / configuration</h2>
  @include('getting-started/_04-configuration')

  <h2 class="ui dividing header">Usage</h2>
  @include('getting-started/_05-usage')

  <h2 class="ui dividing header">Next steps</h2>
  @include('getting-started/_06-next-steps')
  
@stop
