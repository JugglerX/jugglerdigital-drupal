<?php

assert_options(ASSERT_ACTIVE, TRUE);
\Drupal\Component\Assertion\Handle::register();

/**
 * services.yml
 */
$settings['container_yamls'][] = DRUPAL_ROOT . '/sites/default/services.local.yml';

$config['system.logging']['error_level'] = 'verbose';
$config['system.performance']['css']['preprocess'] = FALSE;
$config['system.performance']['js']['preprocess'] = FALSE;
$settings['cache']['bins']['render'] = 'cache.backend.null';
$settings['cache']['bins']['dynamic_page_cache'] = 'cache.backend.null';
$settings['extension_discovery_scan_tests'] = FALSE;
$settings['hash_salt'] = 'dfjhafslkjfalsfslkfjaslfjkasfd';
$settings['rebuild_access'] = TRUE;
$settings['skip_permissions_hardening'] = TRUE;

/**
 * Local Database
 */
if (!defined('PANTHEON_ENVIRONMENT')) {
  // Database.
  $databases['default']['default'] = array (
    'database' => 'drupal',
    'username' => 'root',
    'password' => 'root',
    'prefix' => '',
    'host' => '127.0.0.1',
    'port' => '',
    'namespace' => 'Drupal\\Core\\Database\\Driver\\mysql',
    'driver' => 'mysql',
  );
}
