<?php
/**
 * Validation Helper
 * Functions for input validation and sanitization
 */

function cleanInput($value): string
{
    return trim(strip_tags((string) $value));
}

function isValidEmail($email): bool
{
    return filter_var((string) $email, FILTER_VALIDATE_EMAIL) !== false;
}

function validateRequired($value): bool
{
    return trim((string) $value) !== '';
}

function validatePasswordLength($password, $min = 8): bool
{
    return mb_strlen((string) $password) >= (int) $min;
}

function passwordsMatch($password, $confirmPassword): bool
{
    return (string) $password === (string) $confirmPassword;
}

function validateName($name): bool
{
    return mb_strlen(cleanInput($name)) >= 2;
}
?>
