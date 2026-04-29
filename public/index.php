<?php
/**
 * Home Page / Landing Page
 * Main entry point that uses layout and view structure
 */

// Load configuration
require_once '../config/app.php';

// Load helpers
require_once '../app/helpers/url.php';

// Define page variables
$pageTitle = "DatEdu - Learn Practical Online Courses";
$pageDescription = "DatEdu is an online course platform for practical courses in programming, business, design, and more.";
$activePage = "home";

// Use output buffering to capture view content
ob_start();
require_once '../app/views/pages/home.view.php';
$content = ob_get_clean();

// Include main layout
require_once '../app/views/layouts/main.php';
?>
