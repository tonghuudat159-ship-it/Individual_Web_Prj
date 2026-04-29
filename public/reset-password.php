<?php
/**
 * Reset Password Page
 * Handles password reset using email token
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
$pageTitle = 'Reset Password | DatEdu';
$pageDescription = 'Reset your DatEdu account password using a demo reset link.';
$activePage = 'login';

$errors = [];
$token = trim((string) ($_GET['token'] ?? $_POST['token'] ?? ''));
$isTokenValid = false;
$resetRecord = null;

if ($token === '') {
    $errors[] = 'Invalid or missing reset token.';
} else {
    try {
        $pdo = getPDO();
        $userModel = new User($pdo);
        $tokenHash = hash('sha256', $token);
        $resetRecord = $userModel->findValidResetToken($tokenHash);

        if ($resetRecord === null) {
            $errors[] = 'Invalid or expired reset link.';
        } else {
            $isTokenValid = true;
        }
    } catch (Throwable $exception) {
        $errors[] = 'Could not verify reset link. Please try again.';
        error_log('DatEdu reset password lookup error: ' . $exception->getMessage());
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $isTokenValid) {
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    $csrfToken = $_POST['csrf_token'] ?? null;

    if (!verifyCsrfToken($csrfToken)) {
        $errors[] = 'Invalid form submission. Please try again.';
    }

    if (!validateRequired($newPassword)) {
        $errors[] = 'New password is required.';
    } elseif (!validatePasswordLength($newPassword, 8)) {
        $errors[] = 'New password must be at least 8 characters.';
    }

    if (!validateRequired($confirmPassword)) {
        $errors[] = 'Confirm password is required.';
    } elseif (!passwordsMatch($newPassword, $confirmPassword)) {
        $errors[] = 'New password and confirm password do not match.';
    }

    if (empty($errors)) {
        try {
            $passwordUpdated = $userModel->updatePassword((int) $resetRecord['user_id'], $newPassword);
            $tokenUsed = $userModel->markResetTokenAsUsed((int) $resetRecord['reset_id']);

            if ($passwordUpdated && $tokenUsed) {
                setFlashMessage('Your password has been updated. Please log in.', 'success');
                redirect('login.php');
            }

            $errors[] = 'Could not reset password. Please try again.';
        } catch (Throwable $exception) {
            $errors[] = 'Could not reset password. Please try again.';
            error_log('DatEdu reset password update error: ' . $exception->getMessage());
        }
    }
}

// Use output buffering to capture view content
ob_start();
require_once '../app/views/pages/reset-password.view.php';
$content = ob_get_clean();

// Include main layout
require_once '../app/views/layouts/main.php';
?>
