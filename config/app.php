<?php
/**
 * Application Configuration
 * Global app settings, constants, and environment configuration
 */

// Application name
define('APP_NAME', 'DatEdu');

// Base URL for the application
define('BASE_URL', 'http://localhost/Online_Course_Platform/public');

// Project paths
define('ROOT_PATH', dirname(dirname(__FILE__)));
define('PUBLIC_PATH', ROOT_PATH . '/public');
define('APP_PATH', ROOT_PATH . '/app');
define('CONFIG_PATH', ROOT_PATH . '/config');

// Environment
define('ENVIRONMENT', 'development');
?>
