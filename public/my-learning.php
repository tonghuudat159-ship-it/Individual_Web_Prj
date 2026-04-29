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

require_once '../config/database.php';

// Load helpers
require_once '../app/helpers/url.php';
require_once '../app/helpers/auth.php';
require_once '../app/helpers/format.php';
require_once '../app/models/Enrollment.php';

// Define page variables
$pageTitle = "My Learning | DatEdu";
$pageDescription = "Access your enrolled DatEdu courses and continue learning.";
$activePage = "my-learning";
$enrollments = [];
$myLearningError = '';

if (!isLoggedIn()) {
    setFlashMessage('Please login to view My Learning.', 'info');
    redirect('login.php?redirect=my-learning.php');
}

try {
    $pdo = getPDO();
    $enrollmentModel = new Enrollment($pdo);
    $userId = currentUserId();

    if ($userId !== null) {
        $enrollments = $enrollmentModel->getUserEnrollments($userId);
    }
} catch (Throwable $exception) {
    $myLearningError = 'We could not load your enrolled courses right now.';
    error_log('DatEdu my learning error: ' . $exception->getMessage());
}

// Use output buffering to capture view content
ob_start();
require_once '../app/views/pages/my-learning.view.php';
$content = ob_get_clean();

// Include main layout
require_once '../app/views/layouts/main.php';
?>
