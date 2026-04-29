<?php
/**
 * Payment Success View
 * Displays payment confirmation and order details
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
            <a href="<?php echo base_url('checkout.php'); ?>">Checkout</a>
            <span> > </span>
            <span>Payment Success</span>
        </div>

        <!-- Success Message -->
        <div class="payment-success-card">
            <div class="success-icon">✓</div>
            <h1 class="success-title">Payment successful!</h1>
            <p class="success-message">Your courses are now available in My Learning.</p>

            <!-- Order Information -->
            <div class="order-info">
                <div class="info-row">
                    <span class="info-label">Order Code:</span>
                    <span class="info-value">DATEDU-DEMO-001</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Payment Method:</span>
                    <span class="info-value">Momo Demo</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Total:</span>
                    <span class="info-value">898,000 VND</span>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="success-actions">
                <a href="<?php echo base_url('my-learning.php'); ?>" class="btn btn-primary">Go to My Learning</a>
                <a href="<?php echo base_url('courses.php'); ?>" class="btn btn-secondary">Browse More Courses</a>
            </div>
        </div>
    </div>
</main>
