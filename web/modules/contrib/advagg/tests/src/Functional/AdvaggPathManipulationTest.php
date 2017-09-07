<?php

namespace Drupal\Tests\advagg\Functional;

use Drupal\Core\Url;

/**
 * Tests that all the asset path settings function correctly.
 *
 * @ingroup advagg_tests
 *
 * @group advagg
 */
class AdvaggPathManipulationTest extends AdvaggFunctionalTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = ['advagg', 'advagg_test'];

  /**
   * Tests path converting functions, and that saving a change to them works.
   */
  public function testPathFunctions() {
    $this->drupalGet(Url::fromRoute('advagg.settings'));
    $this->assertSession()->responseContains('src="//cdn.jsdelivr.net/jquery.actual/1.0.18/jquery.actual.min.js');

    $edit = [];
    $edit['path_convert_absolute_to_protocol_relative'] = FALSE;
    $edit['path_convert_force_https'] = TRUE;
    $this->drupalPostForm(NULL, $edit, 'op');

    $config = $this->config('advagg.settings');
    $this->assertTrue($config->get('path.convert.force_https'));
    $this->assertSession()->responseContains('src="https://cdn.jsdelivr.net/jquery.actual/1.0.18/jquery.actual.min.js');
  }

}
