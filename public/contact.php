<?php
/**
 * Contact Page
 * Contact form for users to send messages to DatEdu support
 */

// Load configuration
require_once '../config/app.php';

// Start session for flash messages and future auth features
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load helpers
require_once '../app/helpers/url.php';
require_once '../app/helpers/auth.php';
require_once '../app/helpers/validation.php';
require_once '../app/helpers/csrf.php';

// Define page variables
$pageTitle = "Contact DatEdu";
$pageDescription = "Contact DatEdu for support, course information, or partnership inquiries.";
$activePage = "contact";
$contactAddress = '268 Ly Thuong Kiet, District 10, Ho Chi Minh City, Vietnam';
$contactMapUrl = 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode($contactAddress);
$contactErrors = [];
$contactOld = [
    'full_name' => '',
    'email' => '',
    'subject' => '',
    'message' => '',
];

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    $fullName = cleanInput($_POST['full_name'] ?? '');
    $email = cleanInput($_POST['email'] ?? '');
    $subject = cleanInput($_POST['subject'] ?? '');
    $message = trim((string) ($_POST['message'] ?? ''));
    $csrfToken = $_POST['csrf_token'] ?? null;

    $contactOld = [
        'full_name' => $fullName,
        'email' => $email,
        'subject' => $subject,
        'message' => $message,
    ];

    if (!verifyCsrfToken($csrfToken)) {
        $contactErrors[] = 'Invalid form submission. Please try again.';
    }

    if (!validateRequired($fullName)) {
        $contactErrors[] = 'Full name is required.';
    }

    if (!validateRequired($email)) {
        $contactErrors[] = 'Email is required.';
    } elseif (!isValidEmail($email)) {
        $contactErrors[] = 'Please enter a valid email address.';
    }

    if (!validateRequired($subject)) {
        $contactErrors[] = 'Subject is required.';
    }

    if (!validateRequired($message)) {
        $contactErrors[] = 'Message is required.';
    }

    if (empty($contactErrors)) {
        setFlashMessage('Thank you! Your message has been received.', 'success');
        redirect('contact.php');
    }
}

// Use output buffering to capture view content
ob_start();
require_once '../app/views/pages/contact.view.php';
$content = ob_get_clean();

// Include main layout
require_once '../app/views/layouts/main.php';
?>
