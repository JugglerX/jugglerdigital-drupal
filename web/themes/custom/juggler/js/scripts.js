console.log('Scripts.js');

(function ($, Drupal) {

  // Drupal.behaviors.foundation5 = {
  //   attach: function (context) {
  //   }
  // };

  // Drupal.behaviors.tooltipster = {
  //   attach: function (context) {
  //     $('.tooltipster-text').tooltipster({
  //       animation: 'fade',
  //       delay: [300, 100],
  //       trigger: 'custom',
  //       triggerOpen: {
  //         mouseenter: true,
  //         touchstart: true
  //       },
  //       triggerClose: {
  //         mouseleave: true,
  //         click: true,
  //         scroll: true,
  //         tap: true
  //       },
  //       interactive: true,
  //       side: 'right',
  //       arrow: true,
  //       maxWidth: 250
  //     });
  //   }
  // };

  Drupal.behaviors.hamburger = {
    attach: function (context) {
      $('#hamburger').on('click', function (e) {
        console.log($(this));
        console.log($(this).hasClass('open'));
        if ($(this).hasClass('open')) {
          $(this).removeClass('open');
          $('#block-primarymenu').removeClass('open');
        } else {
          $(this).addClass('open');
          $('#block-primarymenu').addClass('open');
        }
      });
    }
  };

  // Drupal.behaviors.readmore = {
  //   attach: function (context) {
  //     $('.field--name-body').readmore({
  //       speed: 75,
  //       lessLink: '<a href="#">Read less</a>'
  //     });
  //   }
  // };

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
        offset: 150,		// start this scene after scrolling for 50px
        reverse: false
      }).setClassToggle('.view-portfolio', 'scrolled-into-view')
        .addTo(controller); // assign the scene to the controller

      new ScrollMagic.Scene({
        triggerElement: '.view-portfolio .views-row:nth-of-type(1) .node--type-portfolio',
        offset: 100,
        duration: 10000,
        reverse: false
      }).setClassToggle('.view-portfolio .views-row:nth-of-type(1) .node--type-portfolio .field--name-field-hero-image', 'show-screenshot')
        .addTo(controller);

      new ScrollMagic.Scene({
        triggerElement: '.view-portfolio .views-row:nth-of-type(2) .node--type-portfolio',
        offset: 100,
        duration: 10000,
        reverse: false
      }).setClassToggle('.view-portfolio .views-row:nth-of-type(2) .node--type-portfolio .field--name-field-hero-image', 'show-screenshot')
        .addTo(controller);

      new ScrollMagic.Scene({
        triggerElement: '.view-portfolio .views-row:nth-of-type(3) .node--type-portfolio',
        offset: 100,
        duration: 10000,
        reverse: false
      }).setClassToggle('.view-portfolio .views-row:nth-of-type(3) .node--type-portfolio .field--name-field-hero-image', 'show-screenshot')
        .addTo(controller);

    }
  };

}(jQuery, Drupal));
