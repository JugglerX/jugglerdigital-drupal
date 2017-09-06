<?php

namespace Drupal\advagg_mod\Asset;

use Drupal\Core\Config\ConfigFactoryInterface;

/**
 * Add defer tag to scripts.
 */
class DeferJs {

  /**
   * The defer type to use from advagg_mod configuration.
   *
   * @var int
   */
  protected $deferType;

  /**
   * DeferCss constructor.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory.
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    $this->deferType = $config_factory->get('advagg_mod.settings')->get('css_defer_js_code');
  }

  /**
   * Add defer attribute to script tags.
   *
   * @param string $content
   *   The response content.
   *
   * @return string
   *   Updated content.
   */
  public function defer($content) {
    // Only defer local scripts.
    if ($this->deferType === 2) {
      $pattern = '/<script src="\/[a-zA-Z0-0].*"/';
    }

    // Or defer all scripts.
    else {
      $pattern = '/<script src=".*"/';
    }
    return preg_replace_callback($pattern, [$this, 'callback'], $content);
  }

  /**
   * Callback to replace individual stylesheet links.
   *
   * @param array $matches
   *   Array from matches from preg_replace_callback.
   *
   * @return string
   *   Updated html string.
   */
  protected function callback(array $matches) {
    return "{$matches[0]} defer";
  }

}
