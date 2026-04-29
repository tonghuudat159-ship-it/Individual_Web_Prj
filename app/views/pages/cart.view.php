<?php
/**
 * Shopping Cart View
 * Displays cart contents with options to modify quantities and remove items
 */
?>
<main class="main-content">
    <div class="container">
        <!-- Breadcrumb -->
        <div class="breadcrumb">
            <a href="<?php echo base_url('/'); ?>">Home</a>
            <span> > </span>
            <span>Cart</span>
        </div>

        <!-- Page Title -->
        <h1 class="page-title">Shopping Cart</h1>
        <p class="page-subtitle">You have 2 courses in your cart.</p>

        <!-- Cart Content -->
        <div class="cart-layout">
            <!-- Left Column: Cart Items -->
            <div class="cart-items-column">
                <div class="cart-items">
                    <!-- Cart Item 1 -->
                    <div class="cart-item">
                        <div class="cart-item-info">
                            <h3 class="cart-item-title">PHP & MySQL Web Development for Beginners</h3>
                            <p class="cart-item-instructor">Instructor: Nguyen Van A</p>
                            <div class="cart-item-rating">
                                <span class="rating-stars">★★★★★</span>
                                <span class="rating-value">4.7</span>
                            </div>
                        </div>
                        <div class="cart-item-footer">
                            <span class="cart-item-price">499,000 VND</span>
                            <button class="btn btn-link btn-remove">Remove</button>
                        </div>
                    </div>

                    <!-- Cart Item 2 -->
                    <div class="cart-item">
                        <div class="cart-item-info">
                            <h3 class="cart-item-title">JavaScript Essentials</h3>
                            <p class="cart-item-instructor">Instructor: Tran Thi B</p>
                            <div class="cart-item-rating">
                                <span class="rating-stars">★★★★★</span>
                                <span class="rating-value">4.6</span>
                            </div>
                        </div>
                        <div class="cart-item-footer">
                            <span class="cart-item-price">399,000 VND</span>
                            <button class="btn btn-link btn-remove">Remove</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Order Summary -->
            <div class="cart-summary-column">
                <div class="order-summary-card">
                    <h2>Order Summary</h2>
                    
                    <div class="summary-row">
                        <span class="summary-label">Subtotal:</span>
                        <span class="summary-value">898,000 VND</span>
                    </div>

                    <div class="summary-row">
                        <span class="summary-label">Discount:</span>
                        <span class="summary-value">0 VND</span>
                    </div>

                    <div class="summary-divider"></div>

                    <div class="summary-row summary-total">
                        <span class="summary-label">Total:</span>
                        <span class="summary-value">898,000 VND</span>
                    </div>

                    <a href="<?php echo base_url('checkout.php'); ?>" class="btn btn-primary btn-block btn-checkout">Proceed to Checkout</a>
                </div>
            </div>
        </div>
    </div>
</main>
