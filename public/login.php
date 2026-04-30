<?php
/**
 * Login Page
 * Authentication form for existing users to log in to their accounts
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
$pageTitle = 'Login to Your DatEdu Account';
$pageDescription = 'Login to DatEdu to access your courses, cart, checkout, and My Learning page.';
$activePage = 'login';

$errors = [];
$old = [
    'email' => '',
];

function normalizeLoginRedirect($value): string
{
    $redirect = trim((string) $value);

    if ($redirect === '') {
        return 'index.php';
    }

    if (
        stripos($redirect, 'http://') !== false ||
        stripos($redirect, 'https://') !== false ||
        strpos($redirect, '//') === 0 ||
        strpos($redirect, '/') === 0
    ) {
        return 'index.php';
    }

    $blockedTargets = [
        'login.php',
        'register.php',
        'forgot-password.php',
        'reset-password.php',
        'logout.php',
    ];

    $redirectPath = strtolower((string) parse_url($redirect, PHP_URL_PATH));

    if (in_array($redirectPath, $blockedTargets, true)) {
        return 'index.php';
    }

    return $redirect;
}

$redirectPath = normalizeLoginRedirect($_GET['redirect'] ?? 'index.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = cleanInput($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $csrfToken = $_POST['csrf_token'] ?? null;
    $redirectPath = normalizeLoginRedirect($_POST['redirect'] ?? $redirectPath);

    $old['email'] = $email;

    if (!verifyCsrfToken($csrfToken)) {
        $errors[] = 'Invalid form submission. Please try again.';
    }

    if (!validateRequired($email)) {
        $errors[] = 'Email is required.';
    } elseif (!isValidEmail($email)) {
        $errors[] = 'Please enter a valid email address.';
    }

    if (!validateRequired($password)) {
        $errors[] = 'Password is required.';
    }

    if (empty($errors)) {
        try {
            $pdo = getPDO();
            $userModel = new User($pdo);
            $user = $userModel->findByEmail($email);

            if ($user === null) {
                $errors[] = 'Invalid email or password.';
            } elseif (($user['status'] ?? '') !== 'active') {
                $errors[] = 'Your account is not active.';
            } elseif (!password_verify($password, $user['password_hash'])) {
                $errors[] = 'Invalid email or password.';
            } else {
                loginUser($user);
                setFlashMessage('Login successful.', 'success');
                redirect($redirectPath);
            }
        } catch (Throwable $exception) {
            $errors[] = 'Login failed. Please try again.';
            error_log('DatEdu login error: ' . $exception->getMessage());
        }
    }
}

if (isLoggedIn()) {
    redirect($redirectPath);
}

// Use output buffering to capture view content
ob_start();
require_once '../app/views/pages/login.view.php';
$content = ob_get_clean();

// Include main layout
require_once '../app/views/layouts/main.php';
?>
