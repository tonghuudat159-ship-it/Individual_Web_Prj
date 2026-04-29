<?php
/**
 * Shopping Cart View
 * Displays cart contents with options to modify quantities and remove items
 */

$breadcrumbs = [
    [
        'label' => 'Home',
        'url' => base_url('index.php'),
    ],
    [
        'label' => 'Cart',
        'url' => null,
    ],
];
?>
<main class="main-content">
    <?php require APP_PATH . '/views/partials/breadcrumb.php'; ?>

    <section class="cart-page-section">
        <div class="cart-page-container">
            <h1 class="page-title">Shopping Cart</h1>

            <?php if ($cartError !== ''): ?>
                <div class="courses-message courses-message-error"><?php echo htmlspecialchars($cartError); ?></div>
            <?php elseif (!empty($cartItems)): ?>
                <p class="page-subtitle">You have <span id="cartPageCount"><?php echo (int) $cartCount; ?></span> course(s) in your cart.</p>
            <?php endif; ?>

            <?php if ($cartError === '' && empty($cartItems)): ?>
                <div id="cartEmptyState" class="cart-empty-state">
                    <h2>Your cart is empty.</h2>
                    <p>Browse DatEdu courses and add a course to your cart to continue.</p>
                    <a href="<?php echo base_url('courses.php'); ?>" class="btn btn-primary">Browse Courses</a>
                </div>
            <?php elseif (!empty($cartItems)): ?>
                <div class="cart-layout">
                    <div class="cart-items-column">
                        <div id="cartItemsList" class="cart-items">
                            <?php foreach ($cartItems as $item): ?>
                                <?php
                                $thumbnailPath = trim((string) ($item['thumbnail'] ?? ''));
                                $thumbnailFile = ROOT_PATH . '/public/images/' . ltrim($thumbnailPath, '/');
                                $hasThumbnail = $thumbnailPath !== '' && file_exists($thumbnailFile);
                                ?>
                                <div class="cart-item" data-cart-item-id="<?php echo (int) $item['cart_item_id']; ?>">
                                    <div class="cart-item-media">
                                        <?php if ($hasThumbnail): ?>
                                            <img
                                                src="<?php echo htmlspecialchars(asset('images/' . ltrim($thumbnailPath, '/'))); ?>"
                                                alt="<?php echo htmlspecialchars($item['title']); ?>"
                                                class="cart-item-thumbnail"
                                            >
                                        <?php else: ?>
                                            <div class="cart-item-thumbnail-placeholder">DatEdu</div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="cart-item-info">
                                        <div class="cart-item-header">
                                            <div>
                                                <h3 class="cart-item-title"><?php echo htmlspecialchars($item['title']); ?></h3>
                                                <p class="cart-item-instructor">Instructor: <?php echo htmlspecialchars($item['instructor_name']); ?></p>
                                                <p class="cart-item-category">Category: <?php echo htmlspecialchars($item['category_name']); ?></p>
                                            </div>
                                            <span class="cart-item-price"><?php echo htmlspecialchars(formatPrice($item['price'])); ?></span>
                                        </div>

                                        <div class="cart-item-meta">
                                            <span class="cart-item-rating"><span class="rating-stars">&#9733;</span> <?php echo htmlspecialchars((string) $item['rating']); ?></span>
                                            <span class="cart-item-students"><?php echo number_format((int) $item['total_students']); ?> students</span>
                                        </div>

                                        <p class="cart-item-description"><?php echo htmlspecialchars($item['short_description']); ?></p>

                                        <div class="cart-item-footer">
                                            <a href="<?php echo htmlspecialchars(base_url('course-detail.php?slug=' . urlencode($item['slug']))); ?>" class="btn btn-secondary btn-sm-inline">View Course</a>
                                            <button
                                                type="button"
                                                class="btn btn-link btn-remove remove-cart-item-btn"
                                                data-cart-item-id="<?php echo (int) $item['cart_item_id']; ?>"
                                            >
                                                Remove
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="cart-summary-column">
                        <div class="order-summary-card">
                            <h2>Order Summary</h2>

                            <div class="summary-row">
                                <span class="summary-label">Subtotal:</span>
                                <span id="cartSubtotal" class="summary-value"><?php echo htmlspecialchars(formatPrice($cartTotal)); ?></span>
                            </div>

                            <div class="summary-row">
                                <span class="summary-label">Discount:</span>
                                <span class="summary-value">0 VND</span>
                            </div>

                            <div class="summary-divider"></div>

                            <div class="summary-row summary-total">
                                <span class="summary-label">Total:</span>
                                <span id="cartTotal" class="summary-value"><?php echo htmlspecialchars(formatPrice($cartTotal)); ?></span>
                            </div>

                            <div class="summary-row summary-total summary-total-final">
                                <span class="summary-label">Order Total:</span>
                                <span id="orderSummaryTotal" class="summary-value"><?php echo htmlspecialchars(formatPrice($cartTotal)); ?></span>
                            </div>

                            <a href="<?php echo base_url('checkout.php'); ?>" class="btn btn-primary btn-block btn-checkout">Proceed to Checkout</a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>
