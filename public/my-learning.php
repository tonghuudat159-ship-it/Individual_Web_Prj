<?php
/**
 * My Learning Page
 * Displays user's enrolled courses and learning progress
 */

// Load configuration
require_once '../config/app.php';

// Start session for flash messages and future auth features
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load helpers
require_once '../app/helpers/url.php';

// Define page variables
$pageTitle = "My Learning | DatEdu";
$pageDescription = "Access your enrolled DatEdu courses and continue learning.";
$activePage = "my-learning";

// Use output buffering to capture view content
ob_start();
require_once '../app/views/pages/my-learning.view.php';
$content = ob_get_clean();

// Include main layout
require_once '../app/views/layouts/main.php';
?>
