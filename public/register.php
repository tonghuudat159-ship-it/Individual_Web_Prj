<?php
/**
 * Registration Page
 * New user registration form to create a DatEdu account
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
$pageTitle = 'Create a DatEdu Account';
$pageDescription = 'Create a DatEdu account to enroll in online courses and access My Learning.';
$activePage = 'register';

$errors = [];
$old = [
    'full_name' => '',
    'email' => '',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = cleanInput($_POST['full_name'] ?? '');
    $email = cleanInput($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    $csrfToken = $_POST['csrf_token'] ?? null;

    $old['full_name'] = $fullName;
    $old['email'] = $email;

    if (!verifyCsrfToken($csrfToken)) {
        $errors[] = 'Invalid form submission. Please try again.';
    }

    if (!validateRequired($fullName) || !validateName($fullName)) {
        $errors[] = 'Full name is required and must be at least 2 characters.';
    }

    if (!validateRequired($email)) {
        $errors[] = 'Email is required.';
    } elseif (!isValidEmail($email)) {
        $errors[] = 'Please enter a valid email address.';
    }

    if (!validateRequired($password)) {
        $errors[] = 'Password is required.';
    } elseif (!validatePasswordLength($password, 8)) {
        $errors[] = 'Password must be at least 8 characters.';
    }

    if (!validateRequired($confirmPassword)) {
        $errors[] = 'Confirm password is required.';
    } elseif (!passwordsMatch($password, $confirmPassword)) {
        $errors[] = 'Password and confirm password do not match.';
    }

    if (empty($errors)) {
        try {
            $pdo = getPDO();
            $userModel = new User($pdo);

            if ($userModel->emailExists($email)) {
                $errors[] = 'This email is already registered.';
            } else {
                $userModel->create($fullName, $email, $password, 'student');
                setFlashMessage('Account created successfully. Please log in.', 'success');
                redirect('login.php');
            }
        } catch (Throwable $exception) {
            $errors[] = 'Could not create account. Please try again.';
            error_log('DatEdu register error: ' . $exception->getMessage());
        }
    }
}

// Use output buffering to capture view content
ob_start();
require_once '../app/views/pages/register.view.php';
$content = ob_get_clean();

// Include main layout
require_once '../app/views/layouts/main.php';
?>
