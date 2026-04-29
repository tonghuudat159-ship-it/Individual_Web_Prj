<?php
/**
 * AJAX: Remove from Cart
 * Handles removing courses from the shopping cart via AJAX
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

require_once '../../config/app.php';
require_once '../../config/database.php';
require_once '../../app/helpers/auth.php';
require_once '../../app/models/Cart.php';

function respondJson(array $payload): void
{
    echo json_encode($payload);
    exit();
}

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    respondJson([
        'success' => false,
        'message' => 'Invalid request method.',
    ]);
}

if (!isLoggedIn()) {
    respondJson([
        'success' => false,
        'auth_required' => true,
        'message' => 'Please log in to update your cart.',
    ]);
}

$cartItemId = filter_input(INPUT_POST, 'cart_item_id', FILTER_VALIDATE_INT);

if ($cartItemId === false || $cartItemId === null || $cartItemId < 1) {
    respondJson([
        'success' => false,
        'message' => 'Invalid cart item.',
    ]);
}

try {
    $userId = currentUserId();

    if ($userId === null) {
        respondJson([
            'success' => false,
            'auth_required' => true,
            'message' => 'Please log in to update your cart.',
        ]);
    }

    $pdo = getPDO();
    $cartModel = new Cart($pdo);
    $removed = $cartModel->removeItemById((int) $userId, (int) $cartItemId);

    if ($removed) {
        respondJson([
            'success' => true,
            'message' => 'Course removed from cart.',
            'cart_count' => $cartModel->countCartItems((int) $userId),
            'cart_total' => $cartModel->getCartTotal((int) $userId),
        ]);
    }

    respondJson([
        'success' => false,
        'message' => 'Cart item not found.',
    ]);
} catch (Throwable $exception) {
    respondJson([
        'success' => false,
        'message' => 'Error: ' . $exception->getMessage(),
    ]);
}
?>
