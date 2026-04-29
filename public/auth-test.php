<?php
/**
 * Temporary authentication utilities test page
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../config/app.php';
require_once '../config/database.php';
require_once '../app/helpers/url.php';
require_once '../app/helpers/auth.php';
require_once '../app/helpers/validation.php';
require_once '../app/helpers/csrf.php';
require_once '../app/helpers/format.php';
require_once '../app/models/User.php';

$tests = [];
$errorMessage = '';

try {
    $pdo = getPDO();
    $userModel = new User($pdo);

    $user = $userModel->findByEmail('student@datedu.local');
    $tests[] = [
        'label' => "findByEmail('student@datedu.local')",
        'passed' => $user !== null,
        'details' => $user !== null ? 'User found: ' . $user['full_name'] : 'User not found',
    ];

    $emailExists = $userModel->emailExists('student@datedu.local');
    $tests[] = [
        'label' => "emailExists('student@datedu.local')",
        'passed' => $emailExists === true,
        'details' => $emailExists ? 'Email exists in database.' : 'Email does not exist.',
    ];

    $passwordVerified = $user !== null && password_verify('password123', $user['password_hash']);
    $tests[] = [
        'label' => "password_verify('password123', password_hash)",
        'passed' => $passwordVerified,
        'details' => $passwordVerified ? 'Password verification passed.' : 'Password verification failed.',
    ];

    $csrfToken = generateCsrfToken();
    $csrfVerified = verifyCsrfToken($csrfToken);
    $tests[] = [
        'label' => 'generateCsrfToken() and verifyCsrfToken()',
        'passed' => $csrfToken !== '' && $csrfVerified,
        'details' => $csrfToken !== '' ? 'CSRF token generated successfully.' : 'CSRF token generation failed.',
    ];

    $validationPassed = validateRequired('DatEdu')
        && isValidEmail('student@datedu.local')
        && validatePasswordLength('password123', 8)
        && passwordsMatch('password123', 'password123')
        && validateName('Demo Student');
    $tests[] = [
        'label' => 'Validation helper functions',
        'passed' => $validationPassed,
        'details' => $validationPassed ? 'Validation helpers returned expected results.' : 'Validation helper test failed.',
    ];

    $formattedPrice = formatPrice(499000);
    $tests[] = [
        'label' => 'formatPrice(499000)',
        'passed' => $formattedPrice === '499.000 VND',
        'details' => 'Formatted price: ' . $formattedPrice,
    ];

    $formattedDate = formatDate('2026-04-29 10:35:00');
    $tests[] = [
        'label' => "formatDate('2026-04-29 10:35:00')",
        'passed' => $formattedDate === '29/04/2026',
        'details' => 'Formatted date: ' . $formattedDate,
    ];
} catch (Throwable $exception) {
    $errorMessage = $exception->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DatEdu Auth Test</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 24px;
            background: #f5f7fb;
            color: #1f2937;
        }

        .container {
            max-width: 860px;
            margin: 0 auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 12px 32px rgba(15, 23, 42, 0.08);
            padding: 24px;
        }

        h1 {
            margin-top: 0;
        }

        .test-item {
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 14px 16px;
            margin-bottom: 12px;
        }

        .pass {
            border-color: #bbf7d0;
            background: #f0fdf4;
        }

        .fail {
            border-color: #fecaca;
            background: #fef2f2;
        }

        .status {
            font-weight: 700;
            margin-bottom: 6px;
        }

        .pass .status {
            color: #166534;
        }

        .fail .status {
            color: #991b1b;
        }

        .error-box {
            padding: 14px 16px;
            border-radius: 10px;
            border: 1px solid #fecaca;
            background: #fef2f2;
            color: #991b1b;
        }

        a {
            color: #5624d0;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>DatEdu Authentication Test</h1>

        <?php if ($errorMessage !== ''): ?>
            <div class="error-box">
                <strong>Auth test failed.</strong><br>
                <?php echo htmlspecialchars($errorMessage); ?>
            </div>
        <?php else: ?>
            <?php foreach ($tests as $test): ?>
                <div class="test-item <?php echo $test['passed'] ? 'pass' : 'fail'; ?>">
                    <div class="status">
                        <?php echo $test['passed'] ? 'PASS' : 'FAIL'; ?>:
                        <?php echo htmlspecialchars($test['label']); ?>
                    </div>
                    <div><?php echo htmlspecialchars($test['details']); ?></div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <p><a href="<?php echo base_url('index.php'); ?>">Back to Home</a></p>
    </div>
</body>
</html>
