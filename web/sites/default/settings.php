<?php

$settings['container_yamls'][] = __DIR__ . '/services.yml';
$settings['install_profile'] = 'standard';
$settings['skip_permissions_hardening'] = FALSE;
$settings['rebuild_access'] = FALSE;
$config_directories[CONFIG_SYNC_DIRECTORY] = __DIR__ . '/config';
//$config_directories = array(CONFIG_SYNC_DIRECTORY => dirname(DRUPAL_ROOT) . '/config');

// Pantheon Settings
$pantheon_settings = __DIR__ . "/settings.pantheon.php";
if (defined('PANTHEON_ENVIRONMENT')) {
  if (file_exists($pantheon_settings)) {
    include $pantheon_settings;
  }
}

// Local Settings
$local_settings = __DIR__ . "/settings.local.php";
if (!defined('PANTHEON_ENVIRONMENT')) {
  if (file_exists($local_settings)) {
    include $local_settings;
  }
}

//chmod 644 sites/default/settings.local.php
//chmod 644 sites/default/settings.php
//chmod 755 sites/default
