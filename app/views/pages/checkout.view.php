<?php
/**
 * Checkout View
 * Payment and order completion form
 */
?>
<main class="main-content">
    <div class="container">
        <!-- Breadcrumb -->
        <div class="breadcrumb">
            <a href="<?php echo base_url('/'); ?>">Home</a>
            <span> > </span>
            <a href="<?php echo base_url('cart.php'); ?>">Cart</a>
            <span> > </span>
            <span>Checkout</span>
        </div>

        <!-- Page Title -->
        <h1 class="page-title">Checkout</h1>
        <p class="page-subtitle">Review your information and choose a demo payment method.</p>

        <!-- Checkout Content -->
        <div class="checkout-layout">
            <!-- Left Column: Billing & Payment -->
            <div class="checkout-form-column">
                <!-- A. Billing Information -->
                <div class="checkout-section">
                    <h2 class="checkout-section-title">Billing Information</h2>
                    <form class="checkout-form" method="post" action="#">
                        <div class="form-group">
                            <label for="fullname">Full Name *</label>
                            <input type="text" id="fullname" name="fullname" class="form-input" placeholder="Your Full Name" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email *</label>
                            <input type="email" id="email" name="email" class="form-input" placeholder="your@email.com" required>
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone Number *</label>
                            <input type="tel" id="phone" name="phone" class="form-input" placeholder="+84 (123) 456-7890" required>
                        </div>
                    </form>
                </div>

                <!-- B. Payment Method -->
                <div class="checkout-section">
                    <h2 class="checkout-section-title">Payment Method</h2>
                    <form class="payment-method-form">
                        <div class="payment-option">
                            <input type="radio" id="card" name="payment_method" value="credit_card" checked>
                            <label for="card" class="payment-label">Credit Card Demo</label>
                        </div>

                        <div class="payment-option">
                            <input type="radio" id="bank" name="payment_method" value="bank_transfer">
                            <label for="bank" class="payment-label">Bank Transfer Demo</label>
                        </div>

                        <div class="payment-option">
                            <input type="radio" id="momo" name="payment_method" value="momo">
                            <label for="momo" class="payment-label">Momo Demo</label>
                        </div>
                    </form>
                </div>

                <!-- C. Credit Card Demo Box -->
                <div class="checkout-section">
                    <h2 class="checkout-section-title">Card Information (Demo)</h2>
                    <div class="credit-card-demo">
                        <div class="card-front">
                            <div class="card-logo">DAEDU</div>
                            <div class="card-number">
                                <span>4532</span>
                                <span>1234</span>
                                <span>5678</span>
                                <span>9101</span>
                            </div>
                            <div class="card-details">
                                <div class="card-holder">
                                    <span class="label">Card Holder Name</span>
                                    <span class="value">JOHN DOE</span>
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

            <!-- Right Column: Order Summary -->
            <div class="checkout-summary-column">
                <div class="checkout-summary-card">
                    <h2>Order Summary</h2>
                    
                    <div class="summary-item">
                        <span>PHP & MySQL Web Development:</span>
                        <span>499,000 VND</span>
                    </div>

                    <div class="summary-item">
                        <span>JavaScript Essentials:</span>
                        <span>399,000 VND</span>
                    </div>

                    <div class="summary-divider"></div>

                    <div class="summary-item summary-total">
                        <span>Total:</span>
                        <span>898,000 VND</span>
                    </div>

                    <a href="<?php echo base_url('payment-success.php'); ?>" class="btn btn-primary btn-block btn-confirm">Confirm Payment</a>
                </div>
            </div>
        </div>
    </div>
</main>
