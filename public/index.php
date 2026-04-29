<?php
/**
 * Home Page / Landing Page
 * Main entry point that uses layout and view structure
 */

// Load configuration
require_once '../config/app.php';

// Start session for flash messages and future auth features
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load database and models for homepage data
require_once '../config/database.php';
require_once '../app/models/Category.php';
require_once '../app/models/Course.php';

// Load helpers
require_once '../app/helpers/url.php';

// Define page variables
$pageTitle = "DatEdu - Learn Practical Online Courses";
$pageDescription = "DatEdu is an online course platform where learners can explore practical courses in web development, data science, business, design, and more.";
$activePage = "home";

// Homepage data
$categories = [];
$featuredCourses = [];
$homeError = '';

try {
    $pdo = getPDO();
    $categoryModel = new Category($pdo);
    $courseModel = new Course($pdo);

    $categories = $categoryModel->getAllCategories();
    $featuredCourses = $courseModel->getFeaturedCourses(8);
} catch (Throwable $exception) {
    $homeError = 'We could not load some homepage data right now.';
    error_log('DatEdu home page data error: ' . $exception->getMessage());
}

// Use output buffering to capture view content
ob_start();
require_once '../app/views/pages/home.view.php';
$content = ob_get_clean();

// Include main layout
require_once '../app/views/layouts/main.php';
?>
