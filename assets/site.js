$(document)
  .ready(function() {

    // fix menu when passed
    $('.masthead')
      .visibility({
        once: false,
        onBottomPassed: function() {
          $('.fixed.menu').transition('fade in');
        },
        onBottomPassedReverse: function() {
          $('.fixed.menu').transition('fade out');
        }
      })
    ;

    // create sidebar and attach to menu open
    $('.ui.sidebar')
      .sidebar('attach events', '.toc.item')
    ;

    $('.ui.sticky')
      .sticky({
        offset: 50,
        context: 'main'
      });

    $('main.ui.text.container h2')
      .visibility({
        onTopVisible: function () {
          setActiveItem(this.id);
        },
        once: false
      });

    function setActiveItem(name) {
      $('.ui.toc .ui.menu a').each(function () {
        var $this = $(this);
        if ($this.attr('href').indexOf('#'+name) >= 0) {
          $this.addClass('active');
        } else {
          $this.removeClass('active');
        }
      });
    }
  })
;