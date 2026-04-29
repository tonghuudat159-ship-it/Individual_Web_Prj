<?php
/**
 * Forgot Password Page
 * Form for users to request password reset via email
 */

// Load configuration
require_once '../config/app.php';

// Load helpers
require_once '../app/helpers/url.php';

// Define page variables
$pageTitle = "Forgot Password | DatEdu";
$pageDescription = "Generate a demo password reset link for your DatEdu account.";
$activePage = "login";

// Use output buffering to capture view content
ob_start();
require_once '../app/views/pages/forgot-password.view.php';
$content = ob_get_clean();

// Include main layout
require_once '../app/views/layouts/main.php';
?>
