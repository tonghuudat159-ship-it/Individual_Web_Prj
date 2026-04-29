<?php
/**
 * CSRF Helper
 * Functions for CSRF token generation and validation
 */

function csrfEnsureSessionStarted(): void
{
    if (function_exists('ensureSessionStarted')) {
        ensureSessionStarted();
        return;
    }

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

function generateCsrfToken(): string
{
    csrfEnsureSessionStarted();

    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function verifyCsrfToken(?string $token): bool
{
    csrfEnsureSessionStarted();

    if (!is_string($token) || $token === '' || empty($_SESSION['csrf_token'])) {
        return false;
    }

    return hash_equals($_SESSION['csrf_token'], $token);
}

function csrfField(): string
{
    $token = generateCsrfToken();

    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . '">';
}
?>
