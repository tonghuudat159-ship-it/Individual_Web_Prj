<?php
/**
 * Shopping Cart Page
 * Displays items in user's shopping cart with options to modify quantities and proceed to checkout
 */

// Load configuration
require_once '../config/app.php';

// Load helpers
require_once '../app/helpers/url.php';

// Define page variables
$pageTitle = "Shopping Cart | DatEdu";
$pageDescription = "Review the online courses in your DatEdu shopping cart before checkout.";
$activePage = "cart";

// Use output buffering to capture view content
ob_start();
require_once '../app/views/pages/cart.view.php';
$content = ob_get_clean();

// Include main layout
require_once '../app/views/layouts/main.php';
?>
