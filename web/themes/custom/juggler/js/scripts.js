console.log("Scripts.js");

(function ($, Drupal) {

  Drupal.behaviors.foundation5 = {
    attach: function(context) {
    }

  };

  Drupal.behaviors.tooltipster = {
    attach: function(context) {
      $('.tooltipster-text').tooltipster({
        animation: 'fade',
        delay: [300,100],
        trigger: 'custom',
        triggerOpen: {
          mouseenter: true,
          touchstart: true
        },
        triggerClose: {
          mouseleave: true,
          click: true,
          scroll: true,
          tap: true
        },
        interactive: true,
        side: "right",
        arrow: true,
        maxWidth: 250
      });
    }
  };

}(jQuery, Drupal));
