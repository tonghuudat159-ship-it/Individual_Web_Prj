<?php
/**
 * Payment Success Page
 * Displays confirmation after successful payment and order placement
 */

// Load configuration
require_once '../config/app.php';

// Load helpers
require_once '../app/helpers/url.php';

// Define page variables
$pageTitle = "Payment Successful | DatEdu";
$pageDescription = "Your DatEdu demo payment was successful and your courses are now available in My Learning.";
$activePage = "cart";

// Use output buffering to capture view content
ob_start();
require_once '../app/views/pages/payment-success.view.php';
$content = ob_get_clean();

// Include main layout
require_once '../app/views/layouts/main.php';
?>
