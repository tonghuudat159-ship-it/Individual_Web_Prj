<?php
/**
 * Payment Success View
 * Displays payment confirmation and order details
 */

$breadcrumbs = [
    [
        'label' => 'Home',
        'url' => base_url('index.php'),
    ],
    [
        'label' => 'Cart',
        'url' => base_url('cart.php'),
    ],
    [
        'label' => 'Checkout',
        'url' => base_url('checkout.php'),
    ],
    [
        'label' => 'Payment Success',
        'url' => null,
    ],
];

$paymentMethodLabels = [
    'momo' => 'Momo Demo',
    'credit_card' => 'Credit Card Demo',
    'bank_transfer' => 'Bank Transfer Demo',
];
?>
<main class="main-content">
    <?php require APP_PATH . '/views/partials/breadcrumb.php'; ?>

    <section class="cart-page-section">
        <div class="cart-page-container">
            <?php if ($order === null): ?>
                <div class="payment-success-card payment-success-error-card">
                    <h1 class="success-title">Order not found</h1>
                    <p class="success-message"><?php echo htmlspecialchars($paymentSuccessError !== '' ? $paymentSuccessError : 'We could not find this order.'); ?></p>
                    <div class="success-actions">
                        <a href="<?php echo base_url('courses.php'); ?>" class="btn btn-primary">Back to Courses</a>
                    </div>
                </div>
            <?php else: ?>
                <div class="payment-success-layout">
                    <div class="payment-success-card">
                        <div class="success-icon">&#10003;</div>
                        <h1 class="success-title">Payment successful!</h1>
                        <p class="success-message">Your courses are now available in My Learning.</p>

                        <div class="order-info">
                            <div class="info-row">
                                <span class="info-label">Order Code:</span>
                                <span class="info-value"><?php echo htmlspecialchars($order['order_code']); ?></span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Order Status:</span>
                                <span class="info-value"><?php echo htmlspecialchars(ucfirst((string) $order['status'])); ?></span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Payment Method:</span>
                                <span class="info-value"><?php echo htmlspecialchars($paymentMethodLabels[$payment['payment_method'] ?? ''] ?? 'Not available'); ?></span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Payment Status:</span>
                                <span class="info-value"><?php echo htmlspecialchars(ucfirst((string) ($payment['status'] ?? 'Not available'))); ?></span>
                            </div>
                            <?php if (!empty($payment['transaction_ref'])): ?>
                                <div class="info-row">
                                    <span class="info-label">Transaction Reference:</span>
                                    <span class="info-value"><?php echo htmlspecialchars($payment['transaction_ref']); ?></span>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($payment['paid_at'])): ?>
                                <div class="info-row">
                                    <span class="info-label">Paid At:</span>
                                    <span class="info-value"><?php echo htmlspecialchars((string) $payment['paid_at']); ?></span>
                                </div>
                            <?php endif; ?>
                            <div class="info-row">
                                <span class="info-label">Total Amount:</span>
                                <span class="info-value"><?php echo htmlspecialchars(formatPrice($order['total_amount'])); ?></span>
                            </div>
                        </div>

                        <div class="success-actions">
                            <a href="<?php echo base_url('my-learning.php'); ?>" class="btn btn-primary">Go to My Learning</a>
                            <a href="<?php echo base_url('courses.php'); ?>" class="btn btn-secondary">Browse More Courses</a>
                        </div>
                    </div>

                    <div class="purchased-courses-card">
                        <h2>Purchased Courses</h2>

                        <?php if (empty($orderItems)): ?>
                            <p class="course-empty-text">No purchased courses were found for this order.</p>
                        <?php else: ?>
                            <div class="purchased-course-list">
                                <?php foreach ($orderItems as $item): ?>
                                    <div class="purchased-course-item">
                                        <div class="purchased-course-main">
                                            <h3><?php echo htmlspecialchars($item['title']); ?></h3>
                                            <p>Instructor: <?php echo htmlspecialchars($item['instructor_name']); ?></p>
                                            <p>Price at Purchase: <?php echo htmlspecialchars(formatPrice($item['price_at_purchase'])); ?></p>
                                        </div>
                                        <a href="<?php echo htmlspecialchars(base_url('course-detail.php?slug=' . urlencode($item['slug']))); ?>" class="btn btn-secondary purchased-course-link">View Course</a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>
