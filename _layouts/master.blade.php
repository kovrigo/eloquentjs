<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

  <title>@section('title') EloquentJs @show</title>

  <base href="/eloquentjs/">

  <link rel="stylesheet" href="vendor/all.css">
  <link rel="stylesheet" href="site.css">

</head>
<body class="@stack('bodyClass') pushable">

  @include('_partials.sidebar')

  <div class="pusher">
    @yield('body')
  </div>

  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <script src="vendor/all.js"></script>
  <script>

    $(document).ready(function() {

      $('.help.popup').popup();

      // create sidebar and attach to menu open
      $('.ui.sidebar')
        .sidebar('attach events', '.toc.toggler')
        .sidebar('attach events', '.ui.sidebar .close.icon')
        .sidebar('setting', 'transition', 'overlay')
        .sidebar('setting', 'dimPage', false)
        .sidebar('setting', 'closable', false)
        .sidebar('setting', 'onChange', rememberState)
      ;

      // Restore sidebar state
      if (cookie.get('sidebar_open')) $('.ui.restorable.sidebar').sidebar('show');

      // Highlight current section in sidebar
      $('main.ui.text.container h2')
        .visibility({
          onTopPassed: function () {
            setActiveItem(this.id);
          },
          onTopPassedReverse: function () {
            var previous = $(this).prevAll('h2').first().attr('id');
            if (previous) setActiveItem(previous);
          },
          once: false
        });
    });

    function rememberState()
    {
      if ($(this).sidebar('is hidden'))
        cookie.set('sidebar_open', true, { path: '/eloquentjs/' });
      else
        cookie.set('sidebar_open', '', { path: '/eloquentjs/' });
    }

    function setActiveItem(name)
    {
      $('.ui.sidebar.menu a').each(function () {
        var $this = $(this);
        if (name && $this.attr('href').indexOf('#'+name) >= 0) {
          $this.addClass('active');
        } else {
          $this.removeClass('active');
        }
      });
    }

  </script>

  @stack('scripts')
</body>
</html>
