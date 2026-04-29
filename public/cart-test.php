<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../config/app.php';
require_once '../config/database.php';
require_once '../app/helpers/url.php';
require_once '../app/helpers/auth.php';
require_once '../app/helpers/format.php';
require_once '../app/models/Cart.php';
require_once '../app/models/Enrollment.php';

$testUserId = 2;
$testCourseId = 1;
$errorMessage = '';
$cartCount = 0;
$cartItems = [];
$cartTotal = 0.0;
$enrollments = [];
$isInCart = false;
$isEnrolled = false;

try {
    $pdo = getPDO();
    $cartModel = new Cart($pdo);
    $enrollmentModel = new Enrollment($pdo);

    $cartCount = $cartModel->countCartItems($testUserId);
    $cartItems = $cartModel->getCartItemsByUser($testUserId);
    $cartTotal = $cartModel->getCartTotal($testUserId);
    $enrollments = $enrollmentModel->getUserEnrollments($testUserId);
    $isInCart = $cartModel->isCourseInCart($testUserId, $testCourseId);
    $isEnrolled = $enrollmentModel->isUserEnrolled($testUserId, $testCourseId);
} catch (Throwable $exception) {
    $errorMessage = $exception->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DatEdu Cart and Enrollment Model Test</title>
</head>
<body>
    <h1>DatEdu Cart and Enrollment Model Test</h1>
    <p>This test uses demo user ID 2.</p>
    <p><a href="<?php echo htmlspecialchars(base_url('index.php')); ?>">Back to Home</a></p>

    <?php if ($errorMessage !== ''): ?>
        <section>
            <h2>Development Error</h2>
            <p><?php echo htmlspecialchars($errorMessage); ?></p>
        </section>
    <?php else: ?>
        <section>
            <h2>A. Cart item count for user_id 2</h2>
            <p><?php echo $cartCount; ?> item(s)</p>
        </section>

        <section>
            <h2>B. Cart items list for user_id 2</h2>
            <?php if (empty($cartItems)): ?>
                <p>No cart items found for this user.</p>
            <?php else: ?>
                <ul>
                    <?php foreach ($cartItems as $item): ?>
                        <li>
                            <strong><?php echo htmlspecialchars($item['title']); ?></strong>
                            (Course ID: <?php echo (int) $item['course_id']; ?>)
                            <br>
                            Cart Item ID: <?php echo (int) $item['cart_item_id']; ?>
                            <br>
                            Slug: <?php echo htmlspecialchars($item['slug']); ?>
                            <br>
                            Category: <?php echo htmlspecialchars($item['category_name']); ?>
                            (<?php echo htmlspecialchars($item['category_slug']); ?>)
                            <br>
                            Instructor: <?php echo htmlspecialchars($item['instructor_name']); ?>
                            <br>
                            Price: <?php echo htmlspecialchars(formatPrice($item['price'])); ?>
                            <br>
                            Rating: <?php echo htmlspecialchars((string) $item['rating']); ?>
                            <br>
                            Students: <?php echo (int) $item['total_students']; ?>
                            <br>
                            Added At: <?php echo htmlspecialchars((string) $item['added_at']); ?>
                            <br>
                            Short Description: <?php echo htmlspecialchars($item['short_description']); ?>
                            <br>
                            Thumbnail: <?php echo htmlspecialchars((string) $item['thumbnail']); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </section>

        <section>
            <h2>C. Cart total for user_id 2</h2>
            <p><?php echo htmlspecialchars(formatPrice($cartTotal)); ?></p>
        </section>

        <section>
            <h2>D. Enrollment list for user_id 2</h2>
            <?php if (empty($enrollments)): ?>
                <p>No enrollments found for this user.</p>
            <?php else: ?>
                <ul>
                    <?php foreach ($enrollments as $enrollment): ?>
                        <li>
                            <strong><?php echo htmlspecialchars($enrollment['title']); ?></strong>
                            (Course ID: <?php echo (int) $enrollment['course_id']; ?>)
                            <br>
                            Enrollment ID: <?php echo (int) $enrollment['enrollment_id']; ?>
                            <br>
                            Slug: <?php echo htmlspecialchars($enrollment['slug']); ?>
                            <br>
                            Category: <?php echo htmlspecialchars($enrollment['category_name']); ?>
                            (<?php echo htmlspecialchars($enrollment['category_slug']); ?>)
                            <br>
                            Instructor: <?php echo htmlspecialchars($enrollment['instructor_name']); ?>
                            <br>
                            Status: <?php echo htmlspecialchars($enrollment['enrollment_status']); ?>
                            <br>
                            Enrolled At: <?php echo htmlspecialchars((string) $enrollment['enrolled_at']); ?>
                            <br>
                            Short Description: <?php echo htmlspecialchars($enrollment['short_description']); ?>
                            <br>
                            Thumbnail: <?php echo htmlspecialchars((string) $enrollment['thumbnail']); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </section>

        <section>
            <h2>E. isCourseInCart test for course_id 1</h2>
            <p><?php echo $isInCart ? 'true' : 'false'; ?></p>
        </section>

        <section>
            <h2>F. isUserEnrolled test for course_id 1</h2>
            <p><?php echo $isEnrolled ? 'true' : 'false'; ?></p>
        </section>
    <?php endif; ?>
</body>
</html>
