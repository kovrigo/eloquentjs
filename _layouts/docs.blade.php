@extends('_layouts.master')

@push('bodyClass', 'docs')
@push('sidebarClass', 'restorable')

@section('body')

  <a class="toc toggler ui black icon button" title="Menu">
    <i class="sidebar icon"></i>
  </a>

  <main class="ui main text container">

    <div class="ui breadcrumb">
      <a class="section" href=".">EloquentJs</a>
      <i class="right angle icon divider"></i>
      <div class="active section">@yield('breadcrumb')</div>
    </div>

    @yield('content')

  </main>
@stop
