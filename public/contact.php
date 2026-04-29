<?php
/**
 * Contact Page
 * Contact form for users to send messages to DatEdu support
 */

// Load configuration
require_once '../config/app.php';

// Load helpers
require_once '../app/helpers/url.php';

// Define page variables
$pageTitle = "Contact DatEdu";
$pageDescription = "Contact DatEdu for support, course information, or partnership inquiries.";
$activePage = "contact";

// Use output buffering to capture view content
ob_start();
require_once '../app/views/pages/contact.view.php';
$content = ob_get_clean();

// Include main layout
require_once '../app/views/layouts/main.php';
?>
