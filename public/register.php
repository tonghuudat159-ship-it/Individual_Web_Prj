<?php
/**
 * Registration Page
 * New user registration form to create a DatEdu account
 */

// Load configuration
require_once '../config/app.php';

// Load helpers
require_once '../app/helpers/url.php';

// Define page variables
$pageTitle = "Create a DatEdu Account";
$pageDescription = "Create a DatEdu account to enroll in online courses and access My Learning.";
$activePage = "register";

// Use output buffering to capture view content
ob_start();
require_once '../app/views/pages/register.view.php';
$content = ob_get_clean();

// Include main layout
require_once '../app/views/layouts/main.php';
?>
