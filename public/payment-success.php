<?php
/**
 * Payment Success Page
 * Displays confirmation after successful payment and order placement
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
require_once '../app/models/Order.php';
require_once '../app/models/Payment.php';

// Define page variables
$pageTitle = "Payment Successful | DatEdu";
$pageDescription = "Your DatEdu demo payment was successful and your courses are now available in My Learning.";
$activePage = "cart";
$orderCode = trim((string) ($_GET['order_code'] ?? ''));
$order = null;
$orderItems = [];
$payment = null;
$paymentSuccessError = '';

if (!isLoggedIn()) {
    $redirectTarget = 'payment-success.php';

    if ($orderCode !== '') {
        $redirectTarget .= '?order_code=' . urlencode($orderCode);
    }

    setFlashMessage('Please login to view your order.', 'info');
    redirect('login.php?redirect=' . urlencode($redirectTarget));
}

if ($orderCode === '') {
    $paymentSuccessError = 'Missing order code.';
} else {
    try {
        $pdo = getPDO();
        $orderModel = new Order($pdo);
        $paymentModel = new Payment($pdo);

        $order = $orderModel->getOrderByCode($orderCode, currentUserId());

        if ($order !== null) {
            $orderItems = $orderModel->getOrderItems((int) $order['order_id']);
            $payment = $paymentModel->getPaymentByOrderId((int) $order['order_id']);
        } else {
            $paymentSuccessError = 'Order not found.';
        }
    } catch (Throwable $exception) {
        $paymentSuccessError = 'We could not load this order right now.';
        error_log('DatEdu payment success error: ' . $exception->getMessage());
    }
}

// Use output buffering to capture view content
ob_start();
require_once '../app/views/pages/payment-success.view.php';
$content = ob_get_clean();

// Include main layout
require_once '../app/views/layouts/main.php';
?>
