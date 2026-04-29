<?php
/**
 * AJAX: Add to Cart
 * Handles adding courses to the shopping cart via AJAX
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

require_once '../../config/app.php';
require_once '../../config/database.php';
require_once '../../app/helpers/auth.php';
require_once '../../app/models/Cart.php';
require_once '../../app/models/Enrollment.php';
require_once '../../app/models/Course.php';

function respondJson(array $payload): void
{
    echo json_encode($payload);
    exit();
}

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    respondJson([
        'success' => false,
        'message' => 'Invalid request method.',
    ]);
}

if (!isLoggedIn()) {
    respondJson([
        'success' => false,
        'auth_required' => true,
        'message' => 'Please log in to add courses to your cart.',
        'redirect' => 'login.php',
    ]);
}

$courseId = filter_input(INPUT_POST, 'course_id', FILTER_VALIDATE_INT);

if ($courseId === false || $courseId === null || $courseId < 1) {
    respondJson([
        'success' => false,
        'message' => 'Invalid course.',
    ]);
}

try {
    $userId = currentUserId();

    if ($userId === null) {
        respondJson([
            'success' => false,
            'auth_required' => true,
            'message' => 'Please log in to add courses to your cart.',
            'redirect' => 'login.php',
        ]);
    }

    $pdo = getPDO();
    $courseModel = new Course($pdo);
    $cartModel = new Cart($pdo);
    $enrollmentModel = new Enrollment($pdo);

    $course = $courseModel->getCourseById((int) $courseId);

    if ($course === null) {
        respondJson([
            'success' => false,
            'message' => 'Course not found.',
        ]);
    }

    if ($enrollmentModel->isUserEnrolled((int) $userId, (int) $courseId)) {
        respondJson([
            'success' => false,
            'message' => 'You are already enrolled in this course.',
        ]);
    }

    if ($cartModel->isCourseInCart((int) $userId, (int) $courseId)) {
        respondJson([
            'success' => false,
            'message' => 'This course is already in your cart.',
            'already_in_cart' => true,
        ]);
    }

    $added = $cartModel->addItem((int) $userId, (int) $courseId);

    if ($added) {
        respondJson([
            'success' => true,
            'message' => 'Course added to cart.',
            'cart_count' => $cartModel->countCartItems((int) $userId),
        ]);
    }

    respondJson([
        'success' => false,
        'message' => 'Could not add course to cart.',
    ]);
} catch (Throwable $exception) {
    respondJson([
        'success' => false,
        'message' => 'Error: ' . $exception->getMessage(),
    ]);
}
?>
