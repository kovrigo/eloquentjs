@extends('_layouts.docs')

@section('breadcrumb', 'Client')
@section('sidebar:client:class', 'active')

@section('content')

  <h2 class="ui dividing header">Introduction</h2>
  @include('client/_01-introduction')
  
  <h2 class="ui dividing header">Manual configuration</h2>
  @include('client/_02-manual-configuration')
  
  <h2 class="ui dividing header">Usage</h2>
  @include('client/_03-usage')
  
  <h2 class="ui dividing header">Supported features</h2>
  @include('client/_04-supported-features')
  
  <h2 class="ui dividing header">Using the node package</h2>
  @include('client/_05-using-the-node-package')
  
  <h2 class="ui dividing header">API documentation</h2>
  @include('client/_06-api-docs')
  
  <div class="ui divider"></div>
  
  <div class="ui basic clearing segment">
      <a href="server/" class="ui right floated right labeled icon button">
        <i class="right arrow icon"></i>
        Docs for the PHP package
      </a>
  </div>

@stop
