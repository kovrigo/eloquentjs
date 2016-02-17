<div class="ui sidebar inverted left vertical @stack('sidebarClass') menu">

  <div class="ui inverted icon menu">
    <div class="right aligned item">
      <i class="large close icon"></i>
    </div>
  </div>

  <a href="." class="header item">EloquentJs</a>

  <div class="item @yield('sidebar:getting-started:class')">
    <a href="getting-started/">Getting Started</a>
    @yield('sidebar:getting-started')
  </div>

  <div href="client" class="item @yield('sidebar:client:class')">
    <a href="client/">Javascript library (client)</a>
    @yield('sidebar:client')
  </div>

  <div href="server" class="item @yield('sidebar:server:class')">
    <a href="server/">PHP package for Laravel (server)</a>
    @yield('sidebar:server')
  </div>
  
  <div href="examples" class="item @yield('sidebar:examples:class')">
    <a href="examples/">Examples</a>
    @yield('sidebar:examples')
  </div>

  <a href="//github.com/parsnick/eloquentjs" class="ui big secondary button" title="View on GitHub">
    <i class="github icon"></i>
    View on GitHub
  </a>

</div>
