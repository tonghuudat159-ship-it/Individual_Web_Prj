<?php
/**
 * Authentication Helper
 * Functions for user authentication, session management, and access control
 */

function ensureSessionStarted(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

function requireDevMode(): void
{
    if (defined('ALLOW_DEV_TEST_PAGES') && ALLOW_DEV_TEST_PAGES === true) {
        return;
    }

    http_response_code(404);
    echo 'This development test page is disabled.';
    exit;
}

function setFlashMessage(string $message, string $type = 'info'): void
{
    ensureSessionStarted();

    $allowedTypes = ['success', 'error', 'info', 'warning'];
    $flashType = in_array($type, $allowedTypes, true) ? $type : 'info';

    $_SESSION['flash_message'] = $message;
    $_SESSION['flash_type'] = $flashType;
}

function isLoggedIn(): bool
{
    ensureSessionStarted();

    return isset($_SESSION['user_id']);
}

function currentUserId(): ?int
{
    ensureSessionStarted();

    return isset($_SESSION['user_id']) ? (int) $_SESSION['user_id'] : null;
}

function currentUserName(): ?string
{
    ensureSessionStarted();

    return isset($_SESSION['user_name']) ? (string) $_SESSION['user_name'] : null;
}

function currentUserRole(): ?string
{
    ensureSessionStarted();

    return isset($_SESSION['user_role']) ? (string) $_SESSION['user_role'] : null;
}

function isAdmin(): bool
{
    return isLoggedIn() && currentUserRole() === 'admin';
}

function loginUser(array $user): void
{
    ensureSessionStarted();

    if (!headers_sent()) {
        session_regenerate_id(true);
    }

    $_SESSION['user_id'] = (int) ($user['user_id'] ?? 0);
    $_SESSION['user_name'] = (string) ($user['full_name'] ?? '');
    $_SESSION['user_role'] = (string) ($user['role'] ?? 'student');
}

function logoutUser(): void
{
    ensureSessionStarted();

    $_SESSION = [];

    if (ini_get('session.use_cookies') && !headers_sent()) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );
    }

    session_destroy();
}

function requireLogin(string $redirectTo = 'login.php'): void
{
    if (isLoggedIn()) {
        return;
    }

    setFlashMessage('Please login to continue.', 'info');

    $target = $redirectTo;
    $currentUrl = $_SERVER['REQUEST_URI'] ?? '';

    if ($currentUrl !== '') {
        $separator = strpos($target, '?') === false ? '?' : '&';
        $target .= $separator . 'redirect=' . urlencode($currentUrl);
    }

    if (function_exists('redirect')) {
        redirect($target);
    }

    header('Location: ' . $target);
    exit();
}
?>
