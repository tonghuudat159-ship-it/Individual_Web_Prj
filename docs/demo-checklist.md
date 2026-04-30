# DatEdu Final Demo Checklist

## 1. Pre-demo Setup

- [ ] Open the correct project folder: `C:\BKU\Web_Programming\xampp\htdocs\Individual_Web_Prj`
- [ ] Start XAMPP Control Panel.
- [ ] Start Apache.
- [ ] Start MySQL.
- [ ] Open phpMyAdmin: `http://localhost/phpmyadmin`
- [ ] Import database schema first: `database/datedu_db.sql`
- [ ] Import sample data second: `database/sample_data.sql`
- [ ] Open the website: `http://localhost/Individual_Web_Prj/public/`
- [ ] Confirm `config/app.php` uses: `http://localhost/Individual_Web_Prj/public`
- [ ] Confirm `config/database.php` connects to: `datedu_db`
- [ ] Confirm `ALLOW_DEV_TEST_PAGES` is `false` before final submission unless the instructor asks to see development test pages.

## 2. Demo Accounts

Admin account:
- Email: `admin@datedu.local`
- Password: `password123`

Student account:
- Email: `student@datedu.local`
- Password: `password123`

Second student account:
- Email: `viet@datedu.local`
- Password: `password123`

Note:
If a password was changed during reset password testing, re-import `sample_data.sql` or reset the password again through the Forgot Password flow.

## 3. Main Demonstration Flow

### Step 1 - Home Page

Demo:
- Open `http://localhost/Individual_Web_Prj/public/`
- Show DatEdu logo
- Show navbar
- Show hero section
- Show popular categories
- Show featured courses loaded from database
- Show footer

Evidence:
- Layout and navigation requirement
- Database-driven content

### Step 2 - Responsive Design

Demo:
- Open browser DevTools
- Switch to desktop/tablet/mobile widths
- Show desktop navbar
- Show mobile hamburger menu
- Show cards stacking properly on small screens

Evidence:
- Responsive design requirement

### Step 3 - Courses Page

Demo:
- Open `courses.php`
- Show real courses from database
- Show course cards
- Show category sidebar
- Show sorting toolbar
- Show pagination

Evidence:
- Products/Items page requirement
- Courses represent Products/Items for the D5 domain

### Step 4 - Sorting

Demo:
- Sort by Newest
- Sort by Price: Low to High
- Sort by Price: High to Low
- Sort by Highest Rated
- Sort by Title A-Z or Most Popular

Evidence:
- Sorting requirement

### Step 5 - Pagination

Demo:
- Move to page 2
- Return to page 1
- Show URL parameters if useful

Evidence:
- Pagination requirement

### Step 6 - Categories and Breadcrumbs

Demo:
- Click Web Development category
- Show filtered courses
- Show breadcrumb: `Home > Courses > Web Development`
- Open a course detail page
- Show breadcrumb: `Home > Courses > Web Development > Course Title`

Evidence:
- Categories and breadcrumbs requirement

### Step 7 - AJAX Search

Demo:
- Type `php` in the navbar search input
- Show dynamic dropdown results
- Type `data`
- Show different results
- Type a keyword with no result
- Show `No courses found`
- Optionally open DevTools Network and show request to: `ajax/search_courses.php`

Evidence:
- AJAX search requirement
- No full page reload

### Step 8 - Course Detail Page

Demo:
- Open a course detail page
- Show course title
- Show short description
- Show rating
- Show instructor
- Show lessons
- Show price
- Show related courses

Evidence:
- Item detail page
- Database-driven content

### Step 9 - Learning Support Locations and Google Maps

Demo:
- In course detail page, scroll to Learning Support Locations
- Show online/offline/hybrid locations
- Click View Map

Evidence:
- Store Locations and Maps Integration requirement
- In this domain, store locations are mapped to learning support locations

### Step 10 - Register

Demo:
- Open `register.php`
- Submit empty or invalid form to show validation
- Register a new account
- Show redirect to login

Evidence:
- Register requirement
- Input validation

### Step 11 - Login and Logout

Demo:
- Login with a demo account
- Show navbar changes from Login/Register to Hello User/Logout
- Logout
- Show navbar returns to guest state

Evidence:
- Login/logout requirement
- Session-based authentication

### Step 12 - Forgot Password and Reset Password

Demo:
- Open `forgot-password.php`
- Enter a known email
- Generate demo reset link
- Explain that because this is local XAMPP, the reset link is displayed directly instead of being emailed
- Open reset link
- Set new password
- Login with new password

Evidence:
- Forgot Password requirement
- Password update
- Token-based reset

### Step 13 - Add to Cart

Demo:
- Login
- Open a course detail page
- Click Add to Cart
- Show AJAX success message
- Refresh course detail page
- Show `already in cart` state

Evidence:
- Dynamic cart behavior
- AJAX action

### Step 14 - Cart Page

Demo:
- Open `cart.php`
- Show real cart items from database
- Show total
- Remove item with AJAX
- Add another item again if needed

Evidence:
- Cart logic
- Server-side total
- AJAX remove

### Step 15 - Checkout and Fake Payment

Demo:
- Open `checkout.php`
- Show billing information
- Show payment method options: `Momo Demo`, `Credit Card Demo`, `Bank Transfer Demo`
- Confirm payment
- Explain payment is simulated and no real card data is stored

Evidence:
- Checkout flow
- Fake payment
- Server-side processing

### Step 16 - Payment Success

Demo:
- Show `payment-success.php?order_code=...`
- Show order code
- Show payment method
- Show payment status
- Show purchased course list

Evidence:
- Order and payment records

### Step 17 - My Learning

Demo:
- Open `my-learning.php`
- Show enrolled courses
- Click Start Learning

Evidence:
- Enrollment logic
- Purchased course access

### Step 18 - Database Demonstration

Demo in phpMyAdmin:
- `users`
- `categories`
- `courses`
- `course_lessons`
- `locations`
- `course_locations`
- `cart_items`
- `orders`
- `order_items`
- `payments`
- `enrollments`

Evidence:
- Database-driven dynamic website
- Primary and foreign key relationships

### Step 19 - SEO

Demo:
- Open page source of Home or Course Detail
- Show title
- Show meta description
- Open sitemap: `http://localhost/Individual_Web_Prj/public/sitemap.xml`

Evidence:
- SEO requirement

## 4. Requirement Coverage Table

| Requirement | Demo Evidence | Status |
| --- | --- | --- |
| Layout and Navigation | Header, navbar, main content, footer | Completed |
| Responsive Design | Desktop/tablet/mobile with hamburger menu | Completed |
| Products/Items Page | Courses page from database | Completed |
| Sorting and Pagination | Sort dropdown and pagination links | Completed |
| AJAX Search | Navbar search with JSON endpoint | Completed |
| Categories and Breadcrumbs | Category filter and breadcrumb paths | Completed |
| Store Locations and Maps | Learning support locations with Google Maps links | Completed |
| User Authentication | Register, login, logout, forgot/reset password | Completed |
| SEO | Titles, meta descriptions, semantic HTML, slug URLs, sitemap | Completed |
| Database | MySQL tables, sample data, relationships | Completed |
| Final Demonstration | End-to-end DatEdu flow | Ready |

## 5. Common Issues to Check Before Demo

- Apache is running.
- MySQL is running.
- The correct XAMPP Control Panel is used.
- The database has been imported.
- The website opens at: `http://localhost/Individual_Web_Prj/public/`
- `config/app.php` does not contain old paths.
- `BASE_URL` is correct.
- Login works.
- AJAX search works.
- Cart has at least one item before checkout.
- Checkout creates order/payment/enrollment.
- My Learning shows enrolled courses.
- `sitemap.xml` opens.
- `ALLOW_DEV_TEST_PAGES` is `false` for final submission.

## 6. Suggested Final Demo Order

Home -> Responsive -> Courses -> Sorting/Pagination -> AJAX Search -> Course Detail -> Maps -> Auth -> Cart -> Checkout -> Payment Success -> My Learning -> Database -> SEO.
