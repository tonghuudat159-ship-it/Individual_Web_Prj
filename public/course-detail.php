<?php
/**
 * Course Detail Page
 * Shows detailed information about a specific course including description, instructor, reviews, and enrollment
 */

// Load configuration
require_once '../config/app.php';

// Load helpers
require_once '../app/helpers/url.php';

// Define page variables
$pageTitle = "PHP & MySQL Web Development | DatEdu";
$pageDescription = "Learn PHP and MySQL by building dynamic database-driven websites with DatEdu.";
$activePage = "courses";

// Use output buffering to capture view content
ob_start();
require_once '../app/views/pages/course-detail.view.php';
$content = ob_get_clean();

// Include main layout
require_once '../app/views/layouts/main.php';
?>
