<?php
/**
 * Shopping Cart Page
 * Displays items in user's shopping cart with options to modify quantities and proceed to checkout
 */

// Load configuration
require_once '../config/app.php';

// Start session for flash messages and future auth features
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../config/database.php';

// Load helpers
require_once '../app/helpers/url.php';
require_once '../app/helpers/auth.php';
require_once '../app/helpers/format.php';
require_once '../app/models/Cart.php';

// Define page variables
$pageTitle = "Shopping Cart | DatEdu";
$pageDescription = "Review the online courses in your DatEdu shopping cart before checkout.";
$activePage = "cart";
$cartItems = [];
$cartTotal = 0.0;
$cartCount = 0;
$cartError = '';

if (!isLoggedIn()) {
    setFlashMessage('Please login to view your cart.', 'info');
    redirect('login.php?redirect=cart.php');
}

try {
    $userId = currentUserId();
    $pdo = getPDO();
    $cartModel = new Cart($pdo);

    if ($userId !== null) {
        $cartItems = $cartModel->getCartItemsByUser($userId);
        $cartTotal = $cartModel->getCartTotal($userId);
        $cartCount = $cartModel->countCartItems($userId);
    }
} catch (Throwable $exception) {
    $cartError = 'We could not load your cart right now.';
    error_log('DatEdu cart page error: ' . $exception->getMessage());
}

// Use output buffering to capture view content
ob_start();
require_once '../app/views/pages/cart.view.php';
$content = ob_get_clean();

// Include main layout
require_once '../app/views/layouts/main.php';
?>
