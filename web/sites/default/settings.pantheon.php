<?php

/**
 * services.yml
 */
$pantheon_services_file = __DIR__ . '/services.pantheon.preproduction.yml';
if (isset($_ENV['PANTHEON_ENVIRONMENT']) && (($_ENV['PANTHEON_ENVIRONMENT'] == 'live') || ($_ENV['PANTHEON_ENVIRONMENT'] == 'test'))) {
  $pantheon_services_file = __DIR__ . '/services.pantheon.production.yml';
}

if (file_exists($pantheon_services_file)) {
  $settings['container_yamls'][] = $pantheon_services_file;
}


$settings['file_private_path'] = 'sites/default/files/private';

/**
 * Override the $databases variable to pass the correct Database credentials
 * directly from Pantheon to Drupal.
 *
 * Issue: https://github.com/pantheon-systems/drops-8/issues/8
 *
 */
if (isset($_SERVER['PRESSFLOW_SETTINGS'])) {
  $pressflow_settings = json_decode($_SERVER['PRESSFLOW_SETTINGS'], TRUE);
  foreach ($pressflow_settings as $key => $value) {
    // One level of depth should be enough for $conf and $database.
    if ($key == 'conf') {
      foreach ($value as $conf_key => $conf_value) {
        $conf[$conf_key] = $conf_value;
      }
    } elseif ($key == 'databases') {
      // Protect default configuration but allow the specification of
      // additional databases. Also, allows fun things with 'prefix' if they
      // want to try multisite.
      if (!isset($databases) || !is_array($databases)) {
        $databases = array();
      }
      $databases = array_replace_recursive($databases, $value);
    } else {
      $$key = $value;
    }
  }
}

/**
 * Handle Hash Salt Value from Drupal
 *
 * Issue: https://github.com/pantheon-systems/drops-8/issues/10
 *
 */
if (isset($_ENV['PANTHEON_ENVIRONMENT'])) {
  $settings['hash_salt'] = $_ENV['DRUPAL_HASH_SALT'];
}

/**
 * Define appropriate location for tmp directory
 *
 * Issue: https://github.com/pantheon-systems/drops-8/issues/114
 *
 */
if (isset($_ENV['PANTHEON_ENVIRONMENT'])) {
  $config['system.file']['path']['temporary'] = $_SERVER['HOME'] . '/tmp';
}

/**
 * Place Twig cache files in the Pantheon rolling temporary directory.
 * A new rolling temporary directory is provided on every code deploy,
 * guaranteeing that fresh twig cache files will be generated every time.
 * Note that the rendered output generated from the twig cache files
 * are also cached in the database, so a cache clear is still necessary
 * to see updated results after a code deploy.
 */
if (isset($_ENV['PANTHEON_ROLLING_TMP']) && isset($_ENV['PANTHEON_DEPLOYMENT_IDENTIFIER'])) {
  // Relocate the compiled twig files to <binding-dir>/tmp/ROLLING/twig.
  // The location of ROLLING will change with every deploy.
  $settings['php_storage']['twig']['directory'] = $_ENV['PANTHEON_ROLLING_TMP'];
  // Ensure that the compiled twig templates will be rebuilt whenever the
  // deployment identifier changes.  Note that a cache rebuild is also necessary.
  $settings['deployment_identifier'] = $_ENV['PANTHEON_DEPLOYMENT_IDENTIFIER'];
  $settings['php_storage']['twig']['secret'] = $_ENV['DRUPAL_HASH_SALT'] . $settings['deployment_identifier'];
}

/**
 * Install the Pantheon Service Provider to hook Pantheon services into
 * Drupal 8. This service provider handles operations such as clearing the
 * Pantheon edge cache whenever the Drupal cache is rebuilt.
 */
if (isset($_ENV['PANTHEON_ENVIRONMENT'])) {
  $GLOBALS['conf']['container_service_providers']['PantheonServiceProvider'] = '\Pantheon\Internal\PantheonServiceProvider';
}

if (empty($settings['file_scan_ignore_directories'])) {
  $settings['file_scan_ignore_directories'] = [
      'node_modules',
      'bower_components',
  ];
}

/**
 * Trust host settings
 */
if (defined('PANTHEON_ENVIRONMENT')) {
  if (in_array($_ENV['PANTHEON_ENVIRONMENT'], array('dev', 'test', 'live'))) {
    $settings['trusted_host_patterns'][] = "{$_ENV['PANTHEON_ENVIRONMENT']}-{$_ENV['PANTHEON_SITE_NAME']}.getpantheon.io";
    $settings['trusted_host_patterns'][] = "{$_ENV['PANTHEON_ENVIRONMENT']}-{$_ENV['PANTHEON_SITE_NAME']}.pantheon.io";
    $settings['trusted_host_patterns'][] = "{$_ENV['PANTHEON_ENVIRONMENT']}-{$_ENV['PANTHEON_SITE_NAME']}.pantheonsite.io";
    $settings['trusted_host_patterns'][] = "{$_ENV['PANTHEON_ENVIRONMENT']}-{$_ENV['PANTHEON_SITE_NAME']}.panth.io";
    $settings['trusted_host_patterns'][] = '^.+.jugglerdigital.com$';
    $settings['trusted_host_patterns'][] = '^jugglerdigital.com$';
  }
}

/**
 * Redirect non-www domain to www domain
 */
if (isset($_SERVER['PANTHEON_ENVIRONMENT']) && php_sapi_name() != 'cli') {
  // Redirect to https://$primary_domain in the Live environment
  if ($_ENV['PANTHEON_ENVIRONMENT'] === 'live') {
    /** Replace www.example.com with your registered domain name */
    $primary_domain = 'www.jugglerdigital.com';
  } else {
    // Redirect to HTTPS on every Pantheon environment.
    $primary_domain = $_SERVER['HTTP_HOST'];
  }

  if ($_SERVER['HTTP_HOST'] != $primary_domain
      || !isset($_SERVER['HTTP_X_SSL'])
      || $_SERVER['HTTP_X_SSL'] != 'ON') {

    # Name transaction "redirect" in New Relic for improved reporting (optional)
    if (extension_loaded('newrelic')) {
      newrelic_name_transaction("redirect");
    }

    header('HTTP/1.0 301 Moved Permanently');
    header('Location: https://' . $primary_domain . $_SERVER['REQUEST_URI']);
    exit();
  }
  // Drupal 8 Trusted Host Settings
  if (is_array($settings)) {
    $settings['trusted_host_patterns'] = array('^' . preg_quote($primary_domain) . '$');
  }
}

/**
 * Version of Pantheon files.
 */
if (!defined("PANTHEON_VERSION")) {
  define("PANTHEON_VERSION", "3");
}