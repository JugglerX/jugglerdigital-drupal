(function ($, Drupal) {
  Drupal.behaviors.dropdown = {
    attach: function (context) {

      console.log("dropdown");
      // You need to add the class .dropdown to any menus that use dropdowns, you could do this using jquery like below, or you could 	// add the class in the markup (not possible if it's a block) or you could use the module blockclass to add a class through the 	// drupal blocks area

      //$(".region-top .block-menu-block ul.menu").addClass("dropdown");
      //$(".region-header .block-menu-block  ul.menu").addClass("dropdown");
      $(".block--submenu").addClass("dropdown");

      var config = {
        // sensitivity: 7, // number = sensitivity threshold (must be 1 or higher)
        // interval: 100,  // number = milliseconds for onMouseOver polling interval
        over: doOpen,   // function = onMouseOver callback (REQUIRED)
        out: doClose,    // function = onMouseOut callback (REQUIRED)
        timeout: 300   // number = milliseconds delay before onMouseOut
      };

      function doOpen() {
        $(this).addClass("hover");
        $('ul:first', this).css('visibility', 'visible');
      }

      function doClose() {
        $(this).removeClass("hover");
        $('ul:first', this).css('visibility', 'hidden');
      }

      $(".dropdown ul.menu li").hoverIntent(config);

      // $("ul.dropdown li ul li:has(ul)").find("a:first").append(" &raquo; ");
    }
  }
}(jQuery, Drupal));
