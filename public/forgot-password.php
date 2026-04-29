<?php
/**
 * Forgot Password Page
 * Form for users to request password reset via email
 */

// Load configuration
require_once '../config/app.php';

// Start session for flash messages and future auth features
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load dependencies
require_once '../config/database.php';
require_once '../app/helpers/url.php';
require_once '../app/helpers/auth.php';
require_once '../app/helpers/validation.php';
require_once '../app/helpers/csrf.php';
require_once '../app/models/User.php';

// Define page variables
$pageTitle = 'Forgot Password | DatEdu';
$pageDescription = 'Generate a demo password reset link for your DatEdu account.';
$activePage = 'login';

$errors = [];
$old = ['email' => ''];
$demoResetLink = null;
$successMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = cleanInput($_POST['email'] ?? '');
    $csrfToken = $_POST['csrf_token'] ?? null;

    $old['email'] = $email;

    if (!verifyCsrfToken($csrfToken)) {
        $errors[] = 'Invalid form submission. Please try again.';
    }

    if (!validateRequired($email)) {
        $errors[] = 'Email is required.';
    } elseif (!isValidEmail($email)) {
        $errors[] = 'Please enter a valid email address.';
    }

    if (empty($errors)) {
        try {
            $pdo = getPDO();
            $userModel = new User($pdo);
            $user = $userModel->findByEmail($email);

            if ($user === null) {
                $errors[] = 'No account found with this email address.';
            } else {
                $rawToken = bin2hex(random_bytes(32));
                $tokenHash = hash('sha256', $rawToken);
                $expiresAt = (new DateTime('now', new DateTimeZone('Asia/Ho_Chi_Minh')))
                    ->modify('+30 minutes')
                    ->format('Y-m-d H:i:s');

                $tokenCreated = $userModel->createPasswordResetToken((int) $user['user_id'], $tokenHash, $expiresAt);

                if (!$tokenCreated) {
                    throw new RuntimeException('Unable to store reset token.');
                }

                $demoResetLink = base_url('reset-password.php?token=' . urlencode($rawToken));
                $successMessage = 'Demo reset link generated. Use the link below to reset your password.';
            }
        } catch (Throwable $exception) {
            $errors[] = 'Could not generate reset link. Please try again.';
            error_log('DatEdu forgot password error: ' . $exception->getMessage());
        }
    }
}

// Use output buffering to capture view content
ob_start();
require_once '../app/views/pages/forgot-password.view.php';
$content = ob_get_clean();

// Include main layout
require_once '../app/views/layouts/main.php';
?>
