<?php
require_once '../config/app.php';
require_once '../app/helpers/auth.php';
requireDevMode();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../config/database.php';
require_once '../app/helpers/url.php';
require_once '../app/helpers/format.php';
require_once '../app/models/Order.php';
require_once '../app/models/Payment.php';
require_once '../app/models/Enrollment.php';

$action = isset($_GET['action']) ? trim((string) $_GET['action']) : '';
$demoUserId = 2;
$testCourseId = 1;
$message = '';
$messageType = 'info';
$latestOrders = [];
$createdOrder = null;
$createdOrderItems = [];
$createdPayment = null;
$enrollmentResult = '';

try {
    $pdo = getPDO();
    $orderModel = new Order($pdo);
    $paymentModel = new Payment($pdo);
    $enrollmentModel = new Enrollment($pdo);

    if ($action === 'read') {
        $statement = $pdo->prepare("
            SELECT
                order_id,
                order_code,
                total_amount,
                status,
                created_at
            FROM orders
            WHERE user_id = :user_id
            ORDER BY created_at DESC, order_id DESC
            LIMIT 5
        ");
        $statement->bindValue(':user_id', $demoUserId, PDO::PARAM_INT);
        $statement->execute();
        $latestOrders = $statement->fetchAll();

        $message = empty($latestOrders)
            ? 'No orders found yet for demo user 2. You can create a test order.'
            : 'Showing the latest orders for demo user 2.';
    } elseif ($action === 'create_test_order') {
        $pdo->beginTransaction();

        if ($enrollmentModel->isUserEnrolled($demoUserId, $testCourseId)) {
            $message = 'Demo user 2 is already enrolled in course ID 1. No duplicate enrollment was created.';
            $messageType = 'warning';
            $pdo->rollBack();
        } else {
            $courseStatement = $pdo->prepare("
                SELECT
                    course_id,
                    title,
                    price,
                    status
                FROM courses
                WHERE course_id = :course_id
                  AND status = :status
                LIMIT 1
            ");
            $courseStatement->bindValue(':course_id', $testCourseId, PDO::PARAM_INT);
            $courseStatement->bindValue(':status', 'published');
            $courseStatement->execute();
            $course = $courseStatement->fetch();

            if (!$course) {
                throw new RuntimeException('Test course ID 1 was not found or is not published.');
            }

            $orderId = $orderModel->createOrder($demoUserId, (float) $course['price'], 'pending');
            $orderModel->createOrderItem($orderId, (int) $course['course_id'], (float) $course['price']);
            $paymentId = $paymentModel->createPayment($orderId, 'momo', (float) $course['price'], 'success');
            $orderModel->updateOrderStatus($orderId, 'paid');

            $createdEnrollment = $enrollmentModel->createEnrollment($demoUserId, (int) $course['course_id'], $orderId, 'active');

            if (!$createdEnrollment) {
                throw new RuntimeException('Enrollment could not be created for this test order.');
            }

            $pdo->commit();

            $orderLookup = $pdo->prepare("
                SELECT
                    order_id,
                    order_code,
                    total_amount,
                    status,
                    created_at
                FROM orders
                WHERE order_id = :order_id
                LIMIT 1
            ");
            $orderLookup->bindValue(':order_id', $orderId, PDO::PARAM_INT);
            $orderLookup->execute();
            $createdOrder = $orderLookup->fetch() ?: null;

            $createdOrderItems = $orderModel->getOrderItems($orderId);
            $createdPayment = $paymentModel->getPaymentByOrderId($orderId);
            $enrollmentResult = 'Enrollment created successfully for course ID 1.';
            $message = 'Test order created successfully for demo user 2.';
            $messageType = 'success';
        }
    }
} catch (Throwable $exception) {
    if (isset($pdo) && $pdo instanceof PDO && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    $message = 'Error: ' . $exception->getMessage();
    $messageType = 'error';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DatEdu Checkout Model Test</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 2rem;
            background-color: #f8fafc;
            color: #1f2937;
        }

        .container {
            max-width: 960px;
            margin: 0 auto;
        }

        .card {
            background-color: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 0.75rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .actions a {
            display: inline-block;
            margin-right: 1rem;
            margin-bottom: 0.75rem;
            color: #5624d0;
            text-decoration: none;
            font-weight: 600;
        }

        .message {
            padding: 1rem 1.25rem;
            border-radius: 0.75rem;
            margin-bottom: 1.5rem;
        }

        .message.success {
            background-color: #ecfdf5;
            border: 1px solid #bbf7d0;
            color: #166534;
        }

        .message.warning {
            background-color: #fff7ed;
            border: 1px solid #fed7aa;
            color: #9a3412;
        }

        .message.error {
            background-color: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        th,
        td {
            padding: 0.75rem;
            border: 1px solid #e5e7eb;
            text-align: left;
            vertical-align: top;
        }

        th {
            background-color: #f8fafc;
        }

        ul {
            padding-left: 1.25rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>DatEdu Checkout Model Test</h1>
        <p>This page tests Order, Payment, and Enrollment model methods.</p>
        <p><a href="<?php echo htmlspecialchars(base_url('index.php')); ?>">Back to Home</a></p>

        <div class="card actions">
            <a href="<?php echo htmlspecialchars(base_url('checkout-model-test.php?action=read')); ?>">Run safe read tests</a>
            <a href="<?php echo htmlspecialchars(base_url('checkout-model-test.php?action=create_test_order')); ?>">Create test order for demo user 2</a>
        </div>

        <?php if ($message !== ''): ?>
            <div class="message <?php echo htmlspecialchars($messageType); ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <?php if ($action === 'read'): ?>
            <div class="card">
                <h2>Latest Orders for Demo User 2</h2>

                <?php if (empty($latestOrders)): ?>
                    <p>Read methods are available. Use create_test_order to create a test order.</p>
                <?php else: ?>
                    <?php foreach ($latestOrders as $order): ?>
                        <?php
                        $orderItems = $orderModel->getOrderItems((int) $order['order_id']);
                        $payment = $paymentModel->getPaymentByOrderId((int) $order['order_id']);
                        ?>
                        <div class="card">
                            <p><strong>Order Code:</strong> <?php echo htmlspecialchars($order['order_code']); ?></p>
                            <p><strong>Status:</strong> <?php echo htmlspecialchars($order['status']); ?></p>
                            <p><strong>Total Amount:</strong> <?php echo htmlspecialchars(formatPrice($order['total_amount'])); ?></p>
                            <p><strong>Created At:</strong> <?php echo htmlspecialchars((string) $order['created_at']); ?></p>

                            <h3>Order Items</h3>
                            <?php if (empty($orderItems)): ?>
                                <p>No order items found.</p>
                            <?php else: ?>
                                <ul>
                                    <?php foreach ($orderItems as $item): ?>
                                        <li>
                                            <?php echo htmlspecialchars($item['title']); ?>
                                            by <?php echo htmlspecialchars($item['instructor_name']); ?>
                                            (<?php echo htmlspecialchars(formatPrice($item['price_at_purchase'])); ?>)
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>

                            <h3>Payment</h3>
                            <?php if ($payment === null): ?>
                                <p>No payment found for this order.</p>
                            <?php else: ?>
                                <p><strong>Method:</strong> <?php echo htmlspecialchars($payment['payment_method']); ?></p>
                                <p><strong>Status:</strong> <?php echo htmlspecialchars($payment['status']); ?></p>
                                <p><strong>Transaction Ref:</strong> <?php echo htmlspecialchars((string) ($payment['transaction_ref'] ?? '')); ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ($action === 'create_test_order' && $createdOrder !== null): ?>
            <div class="card">
                <h2>Created Test Order</h2>
                <p><strong>Order Code:</strong> <?php echo htmlspecialchars($createdOrder['order_code']); ?></p>
                <p><strong>Order Status:</strong> <?php echo htmlspecialchars($createdOrder['status']); ?></p>
                <p><strong>Total Amount:</strong> <?php echo htmlspecialchars(formatPrice($createdOrder['total_amount'])); ?></p>
                <p><strong>Created At:</strong> <?php echo htmlspecialchars((string) $createdOrder['created_at']); ?></p>

                <h3>Order Items</h3>
                <?php if (empty($createdOrderItems)): ?>
                    <p>No order items were found.</p>
                <?php else: ?>
                    <ul>
                        <?php foreach ($createdOrderItems as $item): ?>
                            <li>
                                <?php echo htmlspecialchars($item['title']); ?>
                                by <?php echo htmlspecialchars($item['instructor_name']); ?>
                                (<?php echo htmlspecialchars(formatPrice($item['price_at_purchase'])); ?>)
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <h3>Payment</h3>
                <?php if ($createdPayment === null): ?>
                    <p>No payment data was found.</p>
                <?php else: ?>
                    <p><strong>Method:</strong> <?php echo htmlspecialchars($createdPayment['payment_method']); ?></p>
                    <p><strong>Status:</strong> <?php echo htmlspecialchars($createdPayment['status']); ?></p>
                    <p><strong>Transaction Ref:</strong> <?php echo htmlspecialchars((string) ($createdPayment['transaction_ref'] ?? '')); ?></p>
                    <p><strong>Paid At:</strong> <?php echo htmlspecialchars((string) ($createdPayment['paid_at'] ?? '')); ?></p>
                <?php endif; ?>

                <h3>Enrollment Result</h3>
                <p><?php echo htmlspecialchars($enrollmentResult); ?></p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
