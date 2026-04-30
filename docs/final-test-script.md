# DatEdu Final Manual Test Script

## 1. Test Environment

- Project path:
  `C:\BKU\Web_Programming\xampp\htdocs\Individual_Web_Prj`
- Local URL:
  `http://localhost/Individual_Web_Prj/public/`
- Required services:
  - Apache
  - MySQL

## 2. Database Reset Before Testing

Steps:
1. Open phpMyAdmin:
   `http://localhost/phpmyadmin`
2. Import:
   `database/datedu_db.sql`
3. Import:
   `database/sample_data.sql`
4. Confirm database:
   `datedu_db`
5. Confirm tables:
   `users`, `categories`, `courses`, `cart_items`, `orders`, `order_items`, `payments`, `enrollments`

## 3. Configuration Checks

Checklist:
- [ ] `config/app.php` `BASE_URL` is `http://localhost/Individual_Web_Prj/public`
- [ ] `config/database.php` uses `datedu_db`
- [ ] `ALLOW_DEV_TEST_PAGES` is `false` for final submission
- [ ] `sitemap.xml` opens
- [ ] `README.md` has no mojibake characters

## 4. Home Page Test

URL:
`http://localhost/Individual_Web_Prj/public/`

Expected:
- Page loads
- Navbar appears
- Hero section appears
- Categories load from database
- Featured courses load from database
- Footer appears
- No PHP errors

- [ ] Pass
- [ ] Fail
- Notes:

## 5. Responsive Test

Steps:
1. Open DevTools.
2. Test desktop width.
3. Test tablet width.
4. Test mobile width.

Expected:
- Desktop navbar horizontal
- Hamburger only on mobile/tablet
- Hamburger opens/closes
- Course cards stack correctly
- No horizontal scroll

- [ ] Pass
- [ ] Fail
- Notes:

## 6. Courses Page Test

URL:
`http://localhost/Individual_Web_Prj/public/courses.php`

Expected:
- Courses load from database
- Category sidebar appears
- Sort dropdown appears
- Pagination appears if more than 8 courses

Test URLs:
- `courses.php?sort=price_asc`
- `courses.php?sort=rating_desc`
- `courses.php?page=2`
- `courses.php?category=web-development`

Expected:
- Sorting works
- Pagination works
- Category filter works
- Breadcrumb updates

- [ ] Pass
- [ ] Fail
- Notes:

## 7. AJAX Search Test

Steps:
1. Type `php` in navbar search.
2. Type `data`.
3. Type `zzzzzzz`.
4. Click one search result.

Expected:
- Results appear without full page reload
- No-result message appears for unknown keyword
- Clicking result opens course detail
- Network request returns JSON from `ajax/search_courses.php`

- [ ] Pass
- [ ] Fail
- Notes:

## 8. Course Detail Test

URL:
`http://localhost/Individual_Web_Prj/public/course-detail.php?slug=php-mysql-web-development-for-beginners`

Expected:
- Course title appears
- Instructor appears
- Lessons appear
- Price appears
- Learning support locations appear
- Google Maps link opens
- Related courses appear
- Breadcrumb appears

Invalid URL:
`course-detail.php?slug=not-existing-course`

Expected:
- Friendly not found page

- [ ] Pass
- [ ] Fail
- Notes:

## 9. Authentication Test

Register:
- Open `register.php`
- Submit invalid form
- Register a new account

Login:
- Login with `student@datedu.local / password123`
- Navbar changes to logged-in state

Logout:
- Click logout
- Navbar returns to guest state

Forgot/Reset:
- Open `forgot-password.php`
- Generate reset link
- Reset password
- Login with new password

Expected:
- Passwords are not displayed or stored as plain text
- Validation errors appear
- Flash messages appear

- [ ] Pass
- [ ] Fail
- Notes:

## 10. Cart Test

Steps:
1. Login.
2. Open a course detail page.
3. Click Add to Cart.
4. Open `cart.php`.
5. Remove course with AJAX.
6. Add a course again for checkout.

Expected:
- Add to cart works without full reload
- Cart page shows real cart item
- Total is correct
- Remove works with AJAX
- Empty state appears if cart is empty

- [ ] Pass
- [ ] Fail
- Notes:

## 11. Checkout Test

Steps:
1. Ensure cart has at least one course.
2. Open `checkout.php`.
3. Submit invalid form.
4. Submit valid billing info.
5. Choose `Momo Demo` or another fake payment method.
6. Confirm payment.

Expected:
- Validation errors appear for invalid input
- Total is calculated server-side
- Order is created
- Order items are created
- Payment is created with success status
- Enrollments are created
- Cart is cleared
- Redirects to `payment-success.php?order_code=...`

- [ ] Pass
- [ ] Fail
- Notes:

## 12. Payment Success Test

Expected:
- Real order code appears
- Payment method appears
- Payment status appears
- Purchased course list appears
- Go to My Learning button works

- [ ] Pass
- [ ] Fail
- Notes:

## 13. My Learning Test

URL:
`http://localhost/Individual_Web_Prj/public/my-learning.php`

Expected:
- Logged-in user sees enrolled courses
- Guest user is redirected to login
- Start Learning opens course detail

- [ ] Pass
- [ ] Fail
- Notes:

## 14. SEO Test

Check:
- Home page source has title and meta description
- Course detail source has course-specific title
- `sitemap.xml` opens
- Course URLs use slug

- [ ] Pass
- [ ] Fail
- Notes:

## 15. Database Verification

In phpMyAdmin, check:
- `users`
- `courses`
- `cart_items`
- `orders`
- `order_items`
- `payments`
- `enrollments`

Expected:
- New user appears after register
- Cart item appears after add to cart
- Cart item disappears after checkout
- Order/payment/enrollment rows appear after checkout

- [ ] Pass
- [ ] Fail
- Notes:

## 16. Final Submission Checklist

- [ ] Website runs from correct URL
- [ ] Database SQL files included
- [ ] Sample data included
- [ ] README completed
- [ ] Demo checklist completed
- [ ] Report outline completed
- [ ] `ALLOW_DEV_TEST_PAGES` set to false
- [ ] No old project path remains
- [ ] No mojibake characters remain in README/docs
- [ ] Final demo flow tested
