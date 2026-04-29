<?php
/**
 * Login Page
 * Authentication form for existing users to log in to their accounts
 */

// Load configuration
require_once '../config/app.php';

// Load helpers
require_once '../app/helpers/url.php';

// Define page variables
$pageTitle = "Login to Your DatEdu Account";
$pageDescription = "Login to DatEdu to access your courses, cart, checkout, and My Learning page.";
$activePage = "login";

// Use output buffering to capture view content
ob_start();
require_once '../app/views/pages/login.view.php';
$content = ob_get_clean();

// Include main layout
require_once '../app/views/layouts/main.php';
?>
