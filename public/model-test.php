<?php
/**
 * Temporary model test page
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../config/app.php';
require_once '../config/database.php';
require_once '../app/helpers/url.php';
require_once '../app/models/Category.php';
require_once '../app/models/Instructor.php';
require_once '../app/models/Course.php';

$errorMessage = '';
$testResults = [];

try {
    $pdo = getPDO();

    $categoryModel = new Category($pdo);
    $instructorModel = new Instructor($pdo);
    $courseModel = new Course($pdo);
} catch (Throwable $exception) {
    $errorMessage = $exception->getMessage();
}

if ($errorMessage === '') {
    $tests = [
        'A. getAllCategories()' => function () use ($categoryModel) {
            return $categoryModel->getAllCategories();
        },
        'B. getFeaturedCourses()' => function () use ($courseModel) {
            return $courseModel->getFeaturedCourses(5);
        },
        'C. getCourses(null, "newest", 1, 8)' => function () use ($courseModel) {
            return $courseModel->getCourses(null, 'newest', 1, 8);
        },
        'D. getCourses("web-development", "newest", 1, 8)' => function () use ($courseModel) {
            return $courseModel->getCourses('web-development', 'newest', 1, 8);
        },
        'E. getCourseBySlug("php-mysql-web-development-for-beginners")' => function () use ($courseModel) {
            return $courseModel->getCourseBySlug('php-mysql-web-development-for-beginners');
        },
        'F. searchCourses("php")' => function () use ($courseModel) {
            return $courseModel->searchCourses('php', 8);
        },
    ];

    foreach ($tests as $label => $callback) {
        try {
            $testResults[$label] = [
                'success' => true,
                'data' => $callback(),
                'message' => '',
            ];
        } catch (Throwable $exception) {
            $testResults[$label] = [
                'success' => false,
                'data' => null,
                'message' => $exception->getMessage(),
            ];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DatEdu Model Test</title>
</head>
<body style="font-family: Arial, sans-serif; margin: 24px; line-height: 1.6;">
    <h1>DatEdu Model Test</h1>

    <?php if ($errorMessage !== ''): ?>
        <div style="padding: 12px; border: 1px solid #f5c2c7; background: #f8d7da; color: #842029; margin-bottom: 20px;">
            <strong>Model test failed.</strong><br>
            <?php echo htmlspecialchars($errorMessage); ?>
        </div>
    <?php else: ?>
        <?php $categories = $testResults['A. getAllCategories()']['data'] ?? []; ?>
        <section style="margin-bottom: 24px;">
            <h2>All Categories</h2>
            <?php if (!($testResults['A. getAllCategories()']['success'] ?? false)): ?>
                <p style="color: #b91c1c;">Failed: <?php echo htmlspecialchars($testResults['A. getAllCategories()']['message'] ?? 'Unknown error'); ?></p>
            <?php else: ?>
                <p>Total categories: <?php echo count($categories); ?></p>
                <ul>
                    <?php foreach ($categories as $category): ?>
                        <li><?php echo htmlspecialchars($category['name']); ?> (<?php echo htmlspecialchars($category['slug']); ?>)</li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </section>

        <?php $featuredCourses = $testResults['B. getFeaturedCourses()']['data'] ?? []; ?>
        <section style="margin-bottom: 24px;">
            <h2>Featured Courses</h2>
            <?php if (!($testResults['B. getFeaturedCourses()']['success'] ?? false)): ?>
                <p style="color: #b91c1c;">Failed: <?php echo htmlspecialchars($testResults['B. getFeaturedCourses()']['message'] ?? 'Unknown error'); ?></p>
            <?php else: ?>
                <p>Total shown: <?php echo count($featuredCourses); ?></p>
                <ul>
                    <?php foreach ($featuredCourses as $course): ?>
                        <li><?php echo htmlspecialchars($course['title']); ?> by <?php echo htmlspecialchars($course['instructor_name']); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </section>

        <?php $coursesPageOne = $testResults['C. getCourses(null, "newest", 1, 8)']['data'] ?? []; ?>
        <section style="margin-bottom: 24px;">
            <h2>Courses Page 1</h2>
            <?php if (!($testResults['C. getCourses(null, "newest", 1, 8)']['success'] ?? false)): ?>
                <p style="color: #b91c1c;">Failed: <?php echo htmlspecialchars($testResults['C. getCourses(null, "newest", 1, 8)']['message'] ?? 'Unknown error'); ?></p>
            <?php else: ?>
                <p>Total shown: <?php echo count($coursesPageOne); ?></p>
                <ul>
                    <?php foreach ($coursesPageOne as $course): ?>
                        <li><?php echo htmlspecialchars($course['title']); ?> - <?php echo htmlspecialchars($course['category_name']); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </section>

        <?php $webDevelopmentCourses = $testResults['D. getCourses("web-development", "newest", 1, 8)']['data'] ?? []; ?>
        <section style="margin-bottom: 24px;">
            <h2>Web Development Courses</h2>
            <?php if (!($testResults['D. getCourses("web-development", "newest", 1, 8)']['success'] ?? false)): ?>
                <p style="color: #b91c1c;">Failed: <?php echo htmlspecialchars($testResults['D. getCourses("web-development", "newest", 1, 8)']['message'] ?? 'Unknown error'); ?></p>
            <?php else: ?>
                <p>Total shown: <?php echo count($webDevelopmentCourses); ?></p>
                <ul>
                    <?php foreach ($webDevelopmentCourses as $course): ?>
                        <li><?php echo htmlspecialchars($course['title']); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </section>

        <?php $courseDetail = $testResults['E. getCourseBySlug("php-mysql-web-development-for-beginners")']['data'] ?? null; ?>
        <section style="margin-bottom: 24px;">
            <h2>Course Detail by Slug</h2>
            <?php if (!($testResults['E. getCourseBySlug("php-mysql-web-development-for-beginners")']['success'] ?? false)): ?>
                <p style="color: #b91c1c;">Failed: <?php echo htmlspecialchars($testResults['E. getCourseBySlug("php-mysql-web-development-for-beginners")']['message'] ?? 'Unknown error'); ?></p>
            <?php elseif ($courseDetail !== null): ?>
                <p><strong>Title:</strong> <?php echo htmlspecialchars($courseDetail['title']); ?></p>
                <p><strong>Category:</strong> <?php echo htmlspecialchars($courseDetail['category_name']); ?></p>
                <p><strong>Instructor:</strong> <?php echo htmlspecialchars($courseDetail['instructor_name']); ?></p>
                <p><strong>Expertise:</strong> <?php echo htmlspecialchars($courseDetail['instructor_expertise']); ?></p>
            <?php else: ?>
                <p>Course not found.</p>
            <?php endif; ?>
        </section>

        <?php $searchResults = $testResults['F. searchCourses("php")']['data'] ?? []; ?>
        <section style="margin-bottom: 24px;">
            <h2>Search Results for "php"</h2>
            <?php if (!($testResults['F. searchCourses("php")']['success'] ?? false)): ?>
                <p style="color: #b91c1c;">Failed: <?php echo htmlspecialchars($testResults['F. searchCourses("php")']['message'] ?? 'Unknown error'); ?></p>
            <?php else: ?>
                <p>Total shown: <?php echo count($searchResults); ?></p>
                <ul>
                    <?php foreach ($searchResults as $course): ?>
                        <li><?php echo htmlspecialchars($course['title']); ?> - <?php echo htmlspecialchars($course['category_name']); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </section>
    <?php endif; ?>

    <p><a href="<?php echo base_url('index.php'); ?>">Back to Home</a></p>
</body>
</html>
