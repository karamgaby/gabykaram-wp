(function($) {
  'use strict';
  $(document).ready(function() {
    setupMenu();
  });

  function setupMenu() {
    const toggle = $('.ps-navigation-bar .ps-navigation-bar-menu-button');
    const menu = $('.ps-navigation-bar-navigation-wrapper');
    toggle.on('click', function() {
      if ($(this).attr('aria-expanded') === 'false') {
        $(this).attr('aria-expanded', 'true');
        menu.removeClass('d-none').removeClass('hide-menu');
      } else {
        $(this).attr('aria-expanded', 'false');
        menu.addClass('hide-menu');
      }
    });
    $(document).click(function(event) {
      const $target = $(event.target);
      if (!$target.closest('.ps-navigation-bar').length) {
        toggle.attr('aria-expanded', 'false');
        menu.addClass('hide-menu');
      }
    });
  }
})(jQuery);
