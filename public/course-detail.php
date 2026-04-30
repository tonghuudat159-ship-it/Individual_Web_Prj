<?php
/**
 * Course Detail Page
 * Shows detailed information about a specific course including description, instructor, reviews, and enrollment
 */

// Load configuration
require_once '../config/app.php';

// Start session for flash messages and future auth features
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load database and models
require_once '../config/database.php';
require_once '../app/models/Course.php';
require_once '../app/models/Cart.php';
require_once '../app/models/Enrollment.php';

// Load helpers
require_once '../app/helpers/url.php';
require_once '../app/helpers/auth.php';
require_once '../app/helpers/csrf.php';

// Load course detail data
$slug = isset($_GET['slug']) ? trim((string) $_GET['slug']) : '';
$course = null;
$lessons = [];
$locations = [];
$relatedCourses = [];
$courseError = '';
$isLoggedIn = isLoggedIn();
$isInCart = false;
$isEnrolled = false;

if ($slug !== '') {
    try {
        $pdo = getPDO();
        $courseModel = new Course($pdo);
        $course = $courseModel->getCourseBySlug($slug);

        if ($course !== null) {
            $lessons = $courseModel->getCourseLessons((int) $course['course_id']);
            $locations = $courseModel->getCourseLocations((int) $course['course_id']);
            $relatedCourses = $courseModel->getRelatedCourses((int) $course['course_id'], (int) $course['category_id'], 4);

            if ($isLoggedIn) {
                $userId = currentUserId();

                if ($userId !== null) {
                    $cartModel = new Cart($pdo);
                    $enrollmentModel = new Enrollment($pdo);
                    $isInCart = $cartModel->isCourseInCart($userId, (int) $course['course_id']);
                    $isEnrolled = $enrollmentModel->isUserEnrolled($userId, (int) $course['course_id']);
                }
            }

            if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST' && ($_POST['course_action'] ?? '') === 'enroll_now') {
                $csrfToken = $_POST['csrf_token'] ?? null;

                if (!verifyCsrfToken($csrfToken)) {
                    setFlashMessage('Invalid form submission. Please try again.', 'error');
                    redirect('course-detail.php?slug=' . urlencode($slug));
                }

                if (!$isLoggedIn) {
                    setFlashMessage('Please login to add this course to your cart.', 'info');
                    redirect('login.php?redirect=' . urlencode('course-detail.php?slug=' . $slug));
                }

                $userId = currentUserId();

                if ($userId === null) {
                    setFlashMessage('Please login to continue.', 'info');
                    redirect('login.php?redirect=' . urlencode('course-detail.php?slug=' . $slug));
                }

                if ($isEnrolled) {
                    setFlashMessage('You are already enrolled in this course.', 'info');
                    redirect('my-learning.php');
                }

                if ($isInCart) {
                    setFlashMessage('This course is already in your cart.', 'info');
                    redirect('cart.php');
                }

                $addedToCart = $cartModel->addItem($userId, (int) $course['course_id']);

                if ($addedToCart || $cartModel->isCourseInCart($userId, (int) $course['course_id'])) {
                    setFlashMessage('Course added to cart. Continue to checkout to complete your enrollment.', 'success');
                    redirect('cart.php');
                }

                setFlashMessage('Could not add this course to your cart.', 'error');
                redirect('course-detail.php?slug=' . urlencode($slug));
            }
        }
    } catch (Throwable $exception) {
        $courseError = 'We could not load this course right now.';
        error_log('DatEdu course detail error: ' . $exception->getMessage());
    }
}

// Define page variables
$pageTitle = $course !== null
    ? $course['title'] . ' | DatEdu'
    : 'Course Not Found | DatEdu';
$pageDescription = $course !== null
    ? $course['short_description']
    : 'The requested DatEdu course could not be found.';
$activePage = "courses";

// Use output buffering to capture view content
ob_start();
require_once '../app/views/pages/course-detail.view.php';
$content = ob_get_clean();

// Include main layout
require_once '../app/views/layouts/main.php';
?>
