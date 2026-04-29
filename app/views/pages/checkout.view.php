<?php
/**
 * Checkout View
 * Payment and order completion form
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
        'url' => null,
    ],
];
?>
<main class="main-content">
    <?php require APP_PATH . '/views/partials/breadcrumb.php'; ?>

    <section class="cart-page-section">
        <div class="cart-page-container">
            <h1 class="page-title">Checkout</h1>
            <p class="page-subtitle">Review your information and choose a demo payment method.</p>

            <?php if (!empty($errors)): ?>
                <div class="checkout-error-box">
                    <ul class="checkout-error-list">
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if (empty($cartItems)): ?>
                <div class="cart-empty-state">
                    <h2>Your cart is empty.</h2>
                    <p>Add one or more DatEdu courses to continue to checkout.</p>
                    <a href="<?php echo base_url('courses.php'); ?>" class="btn btn-primary">Browse Courses</a>
                </div>
            <?php else: ?>
                <form class="checkout-form-main" method="post" action="">
                    <?php echo csrfField(); ?>

                    <div class="checkout-layout">
                        <div class="checkout-form-column">
                            <div class="checkout-section">
                                <h2 class="checkout-section-title">Billing Information</h2>
                                <div class="checkout-form">
                                    <div class="form-group">
                                        <label for="full_name">Full Name *</label>
                                        <input
                                            type="text"
                                            id="full_name"
                                            name="full_name"
                                            class="form-input"
                                            placeholder="Your Full Name"
                                            value="<?php echo htmlspecialchars($old['full_name'] ?? ''); ?>"
                                            required
                                        >
                                    </div>

                                    <div class="form-group">
                                        <label for="email">Email *</label>
                                        <input
                                            type="email"
                                            id="email"
                                            name="email"
                                            class="form-input"
                                            placeholder="your@email.com"
                                            value="<?php echo htmlspecialchars($old['email'] ?? ''); ?>"
                                            required
                                        >
                                    </div>

                                    <div class="form-group">
                                        <label for="phone">Phone Number</label>
                                        <input
                                            type="tel"
                                            id="phone"
                                            name="phone"
                                            class="form-input"
                                            placeholder="0123456789"
                                            value="<?php echo htmlspecialchars($old['phone'] ?? ''); ?>"
                                        >
                                    </div>
                                </div>
                            </div>

                            <div class="checkout-section">
                                <h2 class="checkout-section-title">Payment Method</h2>
                                <div class="payment-method-form">
                                    <label class="payment-option">
                                        <input
                                            type="radio"
                                            name="payment_method"
                                            value="momo"
                                            <?php echo ($old['payment_method'] ?? 'momo') === 'momo' ? 'checked' : ''; ?>
                                        >
                                        <span class="payment-label">Momo Demo</span>
                                    </label>

                                    <label class="payment-option">
                                        <input
                                            type="radio"
                                            name="payment_method"
                                            value="credit_card"
                                            <?php echo ($old['payment_method'] ?? '') === 'credit_card' ? 'checked' : ''; ?>
                                        >
                                        <span class="payment-label">Credit Card Demo</span>
                                    </label>

                                    <label class="payment-option">
                                        <input
                                            type="radio"
                                            name="payment_method"
                                            value="bank_transfer"
                                            <?php echo ($old['payment_method'] ?? '') === 'bank_transfer' ? 'checked' : ''; ?>
                                        >
                                        <span class="payment-label">Bank Transfer Demo</span>
                                    </label>
                                </div>
                            </div>

                            <div class="checkout-section">
                                <h2 class="checkout-section-title">Demo Payment Note</h2>
                                <p class="checkout-note">
                                    This is a simulated payment for a local XAMPP semester project. No real payment is processed.
                                </p>
                            </div>

                            <div class="checkout-section demo-card-section">
                                <h2 class="checkout-section-title">Credit Card Demo</h2>
                                <p class="checkout-note">These demo card details are shown for presentation only and are not stored anywhere.</p>
                                <div class="credit-card-demo">
                                    <div class="card-front">
                                        <div class="card-logo">DATEDU</div>
                                        <div class="card-number">
                                            <span>4532</span>
                                            <span>1234</span>
                                            <span>5678</span>
                                            <span>9101</span>
                                        </div>
                                        <div class="card-details">
                                            <div class="card-holder">
                                                <span class="label">Card Holder Name</span>
                                                <span class="value">DEMO STUDENT</span>
                                            </div>
                                            <div class="card-expiry">
                                                <span class="label">Expiry</span>
                                                <span class="value">12/28</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-back">
                                        <div class="card-cvv">
                                            <span class="label">CVV</span>
                                            <span class="value">***</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="checkout-summary-column">
                            <div class="checkout-summary-card">
                                <h2>Order Summary</h2>

                                <?php foreach ($cartItems as $item): ?>
                                    <div class="summary-item">
                                        <span class="summary-item-title"><?php echo htmlspecialchars($item['title']); ?></span>
                                        <span><?php echo htmlspecialchars(formatPrice($item['price'])); ?></span>
                                    </div>
                                <?php endforeach; ?>

                                <div class="summary-divider"></div>

                                <div class="summary-item">
                                    <span>Subtotal</span>
                                    <span><?php echo htmlspecialchars(formatPrice($cartTotal)); ?></span>
                                </div>

                                <div class="summary-item">
                                    <span>Discount</span>
                                    <span>0 VND</span>
                                </div>

                                <div class="summary-item summary-total">
                                    <span>Total</span>
                                    <span><?php echo htmlspecialchars(formatPrice($orderSummaryTotal)); ?></span>
                                </div>

                                <button type="submit" class="btn btn-primary btn-block btn-confirm">Confirm Payment</button>
                            </div>
                        </div>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </section>
</main>
