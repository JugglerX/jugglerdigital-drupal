console.log('Scripts.js');

(function ($, Drupal) {

  Drupal.behaviors.foundation5 = {
    attach: function (context) {
    }
  };

  Drupal.behaviors.tooltipster = {
    attach: function (context) {
      $('.tooltipster-text').tooltipster({
        animation: 'fade',
        delay: [300, 100],
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
        side: 'right',
        arrow: true,
        maxWidth: 250
      });
    }
  };

  Drupal.behaviors.scrollmagic = {
    attach: function (context) {
      // init controller
      var controller = new ScrollMagic.Controller({
      });

      new ScrollMagic.Scene({
        duration: 8000,	// the scene should last for a scroll distance of 100px
        offset: 80		// start this scene after scrolling for 50px
      }).setClassToggle('.layout-header', 'scrolled-into-view')
        .addTo(controller); // assign the scene to the controller

      new ScrollMagic.Scene({
        duration: 8000,	// the scene should last for a scroll distance of 100px
        offset: 150		// start this scene after scrolling for 50px
        // reverse: false
      }).setClassToggle('.view-portfolio', 'scrolled-into-view')
        .addTo(controller); // assign the scene to the controller

    }
  };

}(jQuery, Drupal));
