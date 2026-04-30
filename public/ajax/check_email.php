<?php
/**
 * AJAX: Check Email
 * Validates email availability during registration via AJAX
 */

header('Content-Type: application/json');

require_once '../../config/app.php';
require_once '../../config/database.php';
require_once '../../app/helpers/validation.php';
require_once '../../app/models/User.php';

function respondJson(array $payload): void
{
    echo json_encode($payload);
    exit();
}

$email = cleanInput($_GET['email'] ?? $_POST['email'] ?? '');

if ($email === '') {
    respondJson([
        'success' => false,
        'message' => 'Email is required.',
        'available' => false,
        'exists' => false,
    ]);
}

if (!isValidEmail($email)) {
    respondJson([
        'success' => false,
        'message' => 'Please enter a valid email address.',
        'available' => false,
        'exists' => false,
    ]);
}

try {
    $pdo = getPDO();
    $userModel = new User($pdo);
    $exists = $userModel->emailExists($email);

    respondJson([
        'success' => true,
        'email' => $email,
        'available' => !$exists,
        'exists' => $exists,
        'message' => $exists ? 'This email is already registered.' : 'This email is available.',
    ]);
} catch (Throwable $exception) {
    error_log('DatEdu check email AJAX error: ' . $exception->getMessage());

    respondJson([
        'success' => false,
        'message' => 'Email check failed.',
        'available' => false,
        'exists' => false,
    ]);
}
?>
