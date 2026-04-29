<?php
/**
 * Reset Password Page
 * Handles password reset using email token
 */

// Load configuration
require_once '../config/app.php';

// Load helpers
require_once '../app/helpers/url.php';

// Define page variables
$pageTitle = "Reset Password | DatEdu";
$pageDescription = "Reset your DatEdu account password using a demo reset link.";
$activePage = "login";

// Use output buffering to capture view content
ob_start();
require_once '../app/views/pages/reset-password.view.php';
$content = ob_get_clean();

// Include main layout
require_once '../app/views/layouts/main.php';
?>
