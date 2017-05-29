/**
 * @file
 * Initializes foundation's JavaScript.
 *
 */
(function ($, Drupal) {

  /**
   * Initializes foundation's JavaScript for new content added to the page.
   */
  Drupal.behaviors.foundationInit = {
    attach: function (context, settings) {
      $(document).foundation();
    }
  };

})(jQuery, Drupal);
