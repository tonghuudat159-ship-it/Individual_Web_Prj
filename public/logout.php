<?php
/**
 * Logout Handler
 * Handles user logout and session termination
 */

require_once '../config/app.php';
require_once '../app/helpers/url.php';
require_once '../app/helpers/auth.php';

ensureSessionStarted();
logoutUser();

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

setFlashMessage('You have been logged out.', 'success');
redirect('index.php');
?>
