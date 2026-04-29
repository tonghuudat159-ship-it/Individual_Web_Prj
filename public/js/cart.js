/**
 * Shopping Cart Functionality
 * Manages cart operations including add and remove actions
 */
document.addEventListener('DOMContentLoaded', function () {
  const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
  const removeCartItemButtons = document.querySelectorAll('.remove-cart-item-btn');

  const updateNavbarCartCount = function (count) {
    const cartCount = document.getElementById('cartCount');

    if (!cartCount) {
      return;
    }

    const safeCount = Number(count);
    cartCount.textContent = Number.isFinite(safeCount) && safeCount > 0 ? '(' + safeCount + ')' : '';
  };

  const formatPriceVnd = function (amount) {
    const safeAmount = Number(amount);
    const displayAmount = Number.isFinite(safeAmount) ? safeAmount : 0;

    return displayAmount.toLocaleString('vi-VN') + ' VND';
  };

  const showCartMessage = function (button, message, type) {
    const purchaseCard = button.closest('.purchase-card');
    const messageBox =
      (purchaseCard && purchaseCard.querySelector('#cartMessage')) ||
      document.getElementById('cartMessage');

    if (!messageBox) {
      return;
    }

    messageBox.textContent = message;
    messageBox.className = 'cart-message ' + type;
  };

  if (addToCartButtons.length) {
    addToCartButtons.forEach(function (button) {
      const originalText = button.textContent;

      button.addEventListener('click', function () {
        const courseId = button.getAttribute('data-course-id');

        if (!courseId) {
          showCartMessage(button, 'Invalid course.', 'error');
          return;
        }

        button.disabled = true;
        button.textContent = 'Adding...';

        fetch('ajax/add_to_cart.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
          },
          body: 'course_id=' + encodeURIComponent(courseId),
        })
          .then(function (response) {
            return response.json();
          })
          .then(function (data) {
            if (data.success) {
              showCartMessage(button, data.message || 'Course added to cart.', 'success');
              button.textContent = 'Added to Cart';
              button.disabled = true;
              updateNavbarCartCount(data.cart_count);
              return;
            }

            if (data.auth_required) {
              showCartMessage(button, data.message || 'Please log in to continue.', 'error');

              const currentPage = window.location.pathname.split('/').pop() || 'course-detail.php';
              const redirectTarget = currentPage + window.location.search;
              const redirectPage = data.redirect || 'login.php';

              window.location.href = redirectPage + '?redirect=' + encodeURIComponent(redirectTarget);
              return;
            }

            if (data.already_in_cart) {
              showCartMessage(button, data.message || 'This course is already in your cart.', 'error');
              button.textContent = 'Already in Cart';
              button.disabled = true;
              return;
            }

            showCartMessage(button, data.message || 'Could not add course to cart.', 'error');
            button.disabled = false;
            button.textContent = originalText;
          })
          .catch(function () {
            showCartMessage(button, 'Could not add course to cart.', 'error');
            button.disabled = false;
            button.textContent = originalText;
          });
      });
    });
  }

  if (removeCartItemButtons.length) {
    removeCartItemButtons.forEach(function (button) {
      const originalText = button.textContent;

      button.addEventListener('click', function () {
        const cartItemId = button.getAttribute('data-cart-item-id');

        if (!cartItemId) {
          window.alert('Invalid cart item.');
          return;
        }

        if (!window.confirm('Remove this course from your cart?')) {
          return;
        }

        button.disabled = true;
        button.textContent = 'Removing...';

        fetch('ajax/remove_from_cart.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
          },
          body: 'cart_item_id=' + encodeURIComponent(cartItemId),
        })
          .then(function (response) {
            return response.json();
          })
          .then(function (data) {
            if (data.success) {
              const cartItem = document.querySelector('.cart-item[data-cart-item-id="' + cartItemId + '"]');

              if (cartItem) {
                cartItem.remove();
              }

              updateNavbarCartCount(data.cart_count);

              const cartPageCount = document.getElementById('cartPageCount');
              if (cartPageCount) {
                cartPageCount.textContent = String(data.cart_count);
              }

              const cartSubtotal = document.getElementById('cartSubtotal');
              if (cartSubtotal) {
                cartSubtotal.textContent = formatPriceVnd(data.cart_total);
              }

              const cartTotal = document.getElementById('cartTotal');
              if (cartTotal) {
                cartTotal.textContent = formatPriceVnd(data.cart_total);
              }

              const orderSummaryTotal = document.getElementById('orderSummaryTotal');
              if (orderSummaryTotal) {
                orderSummaryTotal.textContent = formatPriceVnd(data.cart_total);
              }

              if (Number(data.cart_count) === 0) {
                window.location.reload();
              }

              return;
            }

            if (data.auth_required) {
              window.location.href = 'login.php?redirect=' + encodeURIComponent('cart.php');
              return;
            }

            window.alert(data.message || 'Could not remove course from cart.');
            button.disabled = false;
            button.textContent = originalText;
          })
          .catch(function () {
            window.alert('Could not remove course from cart.');
            button.disabled = false;
            button.textContent = originalText;
          });
      });
    });
  }
});
