<?php
/**
 * Courses Listing Page
 * Displays all available courses with filters, sorting, and pagination
 */

// Load configuration
require_once '../config/app.php';

// Start session for flash messages and future auth features
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load database and models
require_once '../config/database.php';
require_once '../app/models/Category.php';
require_once '../app/models/Course.php';

// Load helpers
require_once '../app/helpers/url.php';

// Query parameters
$categorySlug = isset($_GET['category']) ? trim((string) $_GET['category']) : null;
$categorySlug = $categorySlug !== '' ? $categorySlug : null;

$allowedSorts = [
    'newest',
    'price_asc',
    'price_desc',
    'rating_desc',
    'title_asc',
    'popular',
];

$sort = isset($_GET['sort']) ? trim((string) $_GET['sort']) : 'newest';
$sort = in_array($sort, $allowedSorts, true) ? $sort : 'newest';

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$page = $page >= 1 ? $page : 1;
$limit = 8;

// Page data
$categories = [];
$selectedCategory = null;
$courses = [];
$totalCourses = 0;
$totalPages = 0;
$coursesError = '';

try {
    $pdo = getPDO();
    $categoryModel = new Category($pdo);
    $courseModel = new Course($pdo);

    $categories = $categoryModel->getAllCategories();

    if ($categorySlug !== null) {
        $selectedCategory = $categoryModel->getCategoryBySlug($categorySlug);

        if ($selectedCategory === null) {
            $coursesError = 'The selected category could not be found.';
        }
    }

    if ($coursesError === '') {
        $effectiveCategorySlug = $selectedCategory !== null ? $categorySlug : null;
        $totalCourses = $courseModel->countCourses($effectiveCategorySlug);
        $totalPages = $totalCourses > 0 ? (int) ceil($totalCourses / $limit) : 0;

        if ($totalPages > 0 && $page > $totalPages) {
            $page = $totalPages;
        }

        $courses = $courseModel->getCourses($effectiveCategorySlug, $sort, $page, $limit);
    }
} catch (Throwable $exception) {
    $coursesError = 'We could not load courses right now.';
    error_log('DatEdu courses page error: ' . $exception->getMessage());
}

// Define page variables
$pageTitle = $selectedCategory !== null
    ? $selectedCategory['name'] . ' Courses | DatEdu'
    : 'All Online Courses | DatEdu';
$pageDescription = 'Browse practical online courses on DatEdu with category filtering, sorting, and pagination.';
$activePage = 'courses';

// Use output buffering to capture view content
ob_start();
require_once '../app/views/pages/courses.view.php';
$content = ob_get_clean();

// Include main layout
require_once '../app/views/layouts/main.php';
?>
