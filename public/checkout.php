<?php
/**
 * Checkout Page
 * Handles the purchase process including payment information and order summary
 */

// Load configuration
require_once '../config/app.php';

// Load helpers
require_once '../app/helpers/url.php';

// Define page variables
$pageTitle = "Checkout | DatEdu";
$pageDescription = "Complete a simulated payment and enroll in your selected DatEdu courses.";
$activePage = "cart";

// Use output buffering to capture view content
ob_start();
require_once '../app/views/pages/checkout.view.php';
$content = ob_get_clean();

// Include main layout
require_once '../app/views/layouts/main.php';
?>
