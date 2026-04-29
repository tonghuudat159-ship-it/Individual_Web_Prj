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
