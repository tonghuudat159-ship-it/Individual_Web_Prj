<?php
/**
 * Application Configuration
 * Global app settings, constants, and environment configuration
 */

// Application name
define('APP_NAME', 'DatEdu');

// Base URL for the application
define('BASE_URL', 'http://localhost/Individual_Web_Prj/public');

// Project paths
define('ROOT_PATH', dirname(__DIR__));
define('PUBLIC_PATH', ROOT_PATH . '/public');
define('APP_PATH', ROOT_PATH . '/app');
define('CONFIG_PATH', ROOT_PATH . '/config');

// Environment
define('APP_ENV', 'development');

// Set ALLOW_DEV_TEST_PAGES to false before final submission if you do not want public test pages accessible.
define('ALLOW_DEV_TEST_PAGES', false);

// Backward-compatible environment constant used by existing project code.
define('ENVIRONMENT', APP_ENV);
?>
