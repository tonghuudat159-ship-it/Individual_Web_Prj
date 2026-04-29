<?php
/**
 * Checkout Page
 * Handles the purchase process including payment information and order summary
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
require_once '../app/helpers/validation.php';
require_once '../app/helpers/csrf.php';
require_once '../app/helpers/format.php';
require_once '../app/models/Cart.php';
require_once '../app/models/Order.php';
require_once '../app/models/Payment.php';
require_once '../app/models/Enrollment.php';

// Define page variables
$pageTitle = "Checkout | DatEdu";
$pageDescription = "Complete a simulated payment and enroll in your selected DatEdu courses.";
$activePage = "cart";
$errors = [];
$cartItems = [];
$cartTotal = 0.0;
$orderSummaryTotal = 0.0;
$userId = currentUserId();
$pdo = null;
$cartModel = null;
$orderModel = null;
$paymentModel = null;
$enrollmentModel = null;
$old = [
    'full_name' => currentUserName() ?? '',
    'email' => '',
    'phone' => '',
    'payment_method' => 'momo',
];

if (!isLoggedIn()) {
    setFlashMessage('Please login to continue checkout.', 'info');
    redirect('login.php?redirect=checkout.php');
}

try {
    $pdo = getPDO();
    $cartModel = new Cart($pdo);
    $orderModel = new Order($pdo);
    $paymentModel = new Payment($pdo);
    $enrollmentModel = new Enrollment($pdo);

    if ($userId !== null) {
        $cartItems = $cartModel->getCartItemsByUser($userId);
        $cartTotal = $cartModel->getCartTotal($userId);
        $orderSummaryTotal = $cartTotal;
    }
} catch (Throwable $exception) {
    $errors[] = 'We could not load your checkout right now.';
    error_log('DatEdu checkout load error: ' . $exception->getMessage());
}

if (empty($errors) && empty($cartItems) && ($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    setFlashMessage('Your cart is empty.', 'info');
    redirect('cart.php');
}

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    $fullName = cleanInput($_POST['full_name'] ?? '');
    $email = cleanInput($_POST['email'] ?? '');
    $phone = cleanInput($_POST['phone'] ?? '');
    $paymentMethod = cleanInput($_POST['payment_method'] ?? '');
    $csrfToken = $_POST['csrf_token'] ?? null;

    $old['full_name'] = $fullName;
    $old['email'] = $email;
    $old['phone'] = $phone;
    $old['payment_method'] = $paymentMethod !== '' ? $paymentMethod : 'momo';

    if (!verifyCsrfToken($csrfToken)) {
        $errors[] = 'Invalid form submission. Please try again.';
    }

    if (!validateRequired($fullName)) {
        $errors[] = 'Full name is required.';
    }

    if (!validateRequired($email)) {
        $errors[] = 'Email is required.';
    } elseif (!isValidEmail($email)) {
        $errors[] = 'Please enter a valid email address.';
    }

    $allowedPaymentMethods = ['credit_card', 'bank_transfer', 'momo'];
    if (!in_array($paymentMethod, $allowedPaymentMethods, true)) {
        $errors[] = 'Please select a valid payment method.';
    }

    try {
        if (
            !($pdo instanceof PDO) ||
            !($cartModel instanceof Cart) ||
            !($orderModel instanceof Order) ||
            !($paymentModel instanceof Payment) ||
            !($enrollmentModel instanceof Enrollment)
        ) {
            $pdo = getPDO();
            $cartModel = new Cart($pdo);
            $orderModel = new Order($pdo);
            $paymentModel = new Payment($pdo);
            $enrollmentModel = new Enrollment($pdo);
        }

        if ($userId !== null) {
            $cartItems = $cartModel->getCartItemsByUser($userId);
            $cartTotal = $cartModel->getCartTotal($userId);
            $orderSummaryTotal = $cartTotal;
        }
    } catch (Throwable $exception) {
        $errors[] = 'We could not refresh your cart for checkout.';
        error_log('DatEdu checkout cart refresh error: ' . $exception->getMessage());
    }

    if (empty($cartItems)) {
        $errors[] = 'Your cart is empty.';
    }

    if (empty($errors) && $userId !== null) {
        foreach ($cartItems as $cartItem) {
            if ($enrollmentModel->isUserEnrolled($userId, (int) $cartItem['course_id'])) {
                $errors[] = 'One or more courses in your cart are already enrolled. Please remove them before checkout.';
                break;
            }
        }
    }

    if (empty($errors) && $userId !== null) {
        try {
            if (
                !($pdo instanceof PDO) ||
                !($cartModel instanceof Cart) ||
                !($orderModel instanceof Order) ||
                !($paymentModel instanceof Payment) ||
                !($enrollmentModel instanceof Enrollment)
            ) {
                $pdo = getPDO();
                $cartModel = new Cart($pdo);
                $orderModel = new Order($pdo);
                $paymentModel = new Payment($pdo);
                $enrollmentModel = new Enrollment($pdo);
            }

            $pdo->beginTransaction();

            $orderId = $orderModel->createOrder($userId, $cartTotal, 'pending');

            foreach ($cartItems as $cartItem) {
                $createdOrderItem = $orderModel->createOrderItem(
                    $orderId,
                    (int) $cartItem['course_id'],
                    (float) $cartItem['price']
                );

                if (!$createdOrderItem) {
                    throw new RuntimeException('Could not create one or more order items.');
                }
            }

            $paymentId = $paymentModel->createPayment($orderId, $paymentMethod, $cartTotal, 'success');

            if ($paymentId < 1) {
                throw new RuntimeException('Could not create payment record.');
            }

            if (!$orderModel->updateOrderStatus($orderId, 'paid')) {
                throw new RuntimeException('Could not update order status.');
            }

            foreach ($cartItems as $cartItem) {
                $createdEnrollment = $enrollmentModel->createEnrollment(
                    $userId,
                    (int) $cartItem['course_id'],
                    $orderId,
                    'active'
                );

                if (!$createdEnrollment) {
                    throw new RuntimeException('Could not create one or more enrollments.');
                }
            }

            if (!$cartModel->clearCart($userId)) {
                throw new RuntimeException('Could not clear cart after checkout.');
            }

            $createdOrder = $orderModel->getOrderById($orderId);

            if ($createdOrder === null || empty($createdOrder['order_code'])) {
                throw new RuntimeException('Could not load the created order.');
            }

            $pdo->commit();

            setFlashMessage('Payment successful. Your courses are now available in My Learning.', 'success');
            redirect('payment-success.php?order_code=' . urlencode($createdOrder['order_code']));
        } catch (Throwable $exception) {
            if ($pdo instanceof PDO && $pdo->inTransaction()) {
                $pdo->rollBack();
            }

            $errors[] = 'Checkout failed. Please try again.';
            error_log('DatEdu checkout process error: ' . $exception->getMessage());
        }
    }
}

// Use output buffering to capture view content
ob_start();
require_once '../app/views/pages/checkout.view.php';
$content = ob_get_clean();

// Include main layout
require_once '../app/views/layouts/main.php';
?>
