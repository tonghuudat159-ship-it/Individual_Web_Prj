<?php
/**
 * AJAX: Search Courses
 * Returns course search results in JSON format
 */

header('Content-Type: application/json');

require_once '../../config/app.php';
require_once '../../config/database.php';
require_once '../../app/models/Course.php';

$query = trim($_GET['q'] ?? '');

if (mb_strlen($query) < 2) {
    echo json_encode([
        'success' => true,
        'query' => $query,
        'results' => [],
    ]);
    exit;
}

try {
    $pdo = getPDO();
    $courseModel = new Course($pdo);
    $results = $courseModel->searchCourses($query, 8);

    echo json_encode([
        'success' => true,
        'query' => $query,
        'results' => $results,
    ]);
} catch (Throwable $exception) {
    error_log('DatEdu AJAX search error: ' . $exception->getMessage());

    echo json_encode([
        'success' => false,
        'message' => 'Search failed.',
    ]);
}
?>
