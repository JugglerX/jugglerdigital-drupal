<?php

namespace Drupal\advagg\EventSubscriber;

use Drupal\Core\Config\ConfigFactoryInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Respond to event processes.
 */
class ResponseSubscriber implements EventSubscriberInterface {

  /**
   * A config object for the advagg configuration.
   *
   * @var \Drupal\Core\Config\Config
   */
  protected $config;

  /**
   * Constructs the Subscriber object.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   A config factory for retrieving required config objects.
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    $this->config = $config_factory->get('advagg.settings');
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    return [KernelEvents::RESPONSE => ['processResponse', -9999]];
  }

  /**
   * Passes HtmlResponse responses on to other functions if enabled.
   *
   * @param \Symfony\Component\HttpKernel\Event\FilterResponseEvent $event
   *   The event to process.
   */
  public function processResponse(FilterResponseEvent $event) {
    // Only subscribe to the event if DNS prefetching is enabled.
    if ($this->config->get('dns_prefetch')) {
      $response = $event->getResponse();

      // Ensure that it is an html response.
      if (stripos($response->headers->get('Content-Type'), 'text/html') === FALSE) {
        return;
      }

      global $_advagg_prefetch;
      if (empty($_advagg_prefetch)) {
        return;
      }
      $_advagg_prefetch = array_unique($_advagg_prefetch);
      $domains = '<head>';
      foreach ($_advagg_prefetch as $domain) {
        $domains .= "<link rel='dns-prefetch' href='{$domain}'>";
      }
      $response->setContent(str_replace('<head>', $domains, $response->getContent()));
    }
  }

}
