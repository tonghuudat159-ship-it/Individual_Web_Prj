<?php
/**
 * Courses Listing Page
 * Displays all available courses with filters and search functionality
 */

// Load configuration
require_once '../config/app.php';

// Load helpers
require_once '../app/helpers/url.php';

// Define page variables
$pageTitle = "All Online Courses | DatEdu";
$pageDescription = "Browse practical online courses on DatEdu in web development, data science, business, design, and more.";
$activePage = "courses";

// Use output buffering to capture view content
ob_start();
require_once '../app/views/pages/courses.view.php';
$content = ob_get_clean();

// Include main layout
require_once '../app/views/layouts/main.php';
?>
