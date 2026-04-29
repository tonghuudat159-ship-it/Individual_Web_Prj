# DatEdu — Online Course Platform

## 1. Project Overview

DatEdu is an online course platform inspired by Udemy. It allows users to browse courses, search dynamically, view course details, register and log in, add courses to a cart, complete checkout with a fake payment flow, and access purchased courses in **My Learning**.

This project was developed as an individual **Web Programming semester project**.

## 2. Project Domain

- Domain ID: `D5`
- Domain: `Online Course Platform`

Requirement mapping:

- Products or items are implemented as **Courses**
- Store locations are implemented as **Learning Support Locations**

## 3. Technology Stack

- XAMPP
- Apache
- MySQL-compatible database
- PHP
- HTML
- CSS
- JavaScript
- AJAX with Fetch API
- PDO for database connection

Project notes:

- No PHP framework is used
- No external payment gateway is used
- Payment is simulated for local demo purposes

## 4. Main Features

### A. Layout and Navigation

- Header
- DatEdu logo
- Responsive navbar
- Footer

### B. Responsive Design

- Desktop, tablet, and mobile support
- Hamburger menu on mobile

### C. Course Catalog

- Courses loaded from database
- Category filter
- Sorting
- Pagination

### D. AJAX Search

- Dynamic search without full page reload
- JSON search endpoint

### E. Categories and Breadcrumbs

- Course categories
- Breadcrumb navigation

### F. Course Detail

- Course information
- Instructor information
- Lesson list
- Related courses
- Learning support locations
- Google Maps links

### G. Authentication

- Register
- Login
- Logout
- Forgot password
- Reset password
- Password hashing

### H. Cart and Checkout

- Add to cart
- Remove from cart
- Order summary
- Fake payment
- Payment success page
- Enrollment creation after checkout

### I. My Learning

- Shows enrolled courses for the logged-in user

### J. SEO

- Meaningful page titles
- Meta descriptions
- Semantic HTML
- Slug-based course URLs
- `sitemap.xml`

## 5. Folder Structure

```text
Individual_Web_Prj/
├── public/
├── app/
│   ├── controllers/
│   ├── models/
│   ├── helpers/
│   └── views/
├── config/
├── database/
├── storage/
├── docs/
└── README.md
```

Main folders:

- `public/`: entry pages, CSS, JavaScript, images, and AJAX endpoints
- `app/`: models, helpers, views, and controllers
- `config/`: application and database configuration
- `database/`: SQL schema and sample data
- `storage/`: local runtime storage such as logs
- `docs/`: report notes and demo notes

## 6. Setup Instructions

1. Place the project folder here:

   ```text
   C:\BKU\Web_Programming\xampp\htdocs\Individual_Web_Prj
   ```

2. Start XAMPP and enable:

- Apache
- MySQL

3. Open phpMyAdmin:

   ```text
   http://localhost/phpmyadmin
   ```

4. Import the database schema:

   ```text
   database/datedu_db.sql
   ```

5. Import the sample data:

   ```text
   database/sample_data.sql
   ```

6. Open the website:

   ```text
   http://localhost/Individual_Web_Prj/public/
   ```

## 7. Database Information

- Database name: `datedu_db`

Main tables:

- `users`
- `password_resets`
- `categories`
- `instructors`
- `courses`
- `course_lessons`
- `locations`
- `course_locations`
- `cart_items`
- `orders`
- `order_items`
- `payments`
- `enrollments`

## 8. Demo Accounts

Admin:

- Email: `admin@datedu.local`
- Password: `password123`

Student:

- Email: `student@datedu.local`
- Password: `password123`

Student 2:

- Email: `viet@datedu.local`
- Password: `password123`

Important note:

- If a password was changed during forgot/reset password testing, reset it again or re-import `sample_data.sql`

## 9. Important URLs

Home:

- `http://localhost/Individual_Web_Prj/public/`

Courses:

- `http://localhost/Individual_Web_Prj/public/courses.php`

Course Detail Example:

- `http://localhost/Individual_Web_Prj/public/course-detail.php?slug=php-mysql-web-development-for-beginners`

Login:

- `http://localhost/Individual_Web_Prj/public/login.php`

Register:

- `http://localhost/Individual_Web_Prj/public/register.php`

Cart:

- `http://localhost/Individual_Web_Prj/public/cart.php`

Checkout:

- `http://localhost/Individual_Web_Prj/public/checkout.php`

My Learning:

- `http://localhost/Individual_Web_Prj/public/my-learning.php`

Sitemap:

- `http://localhost/Individual_Web_Prj/public/sitemap.xml`

## 10. Demo Flow

Recommended demo sequence:

1. Open the Home page
2. Show the responsive navbar
3. Open the Courses page
4. Test the category filter
5. Test sorting
6. Test pagination
7. Test AJAX search
8. Open a Course Detail page
9. Show lessons and learning support locations
10. Register or Login
11. Add a course to the cart
12. Remove a course from the cart
13. Add a course again
14. Checkout with fake payment
15. Open the Payment Success page
16. Open My Learning
17. Show related database tables in phpMyAdmin

## 11. Development Test Pages

Temporary development test pages may exist:

- `db-test.php`
- `model-test.php`
- `auth-test.php`
- `cart-test.php`
- `checkout-model-test.php`

They are controlled by:

- `ALLOW_DEV_TEST_PAGES`

in:

- `config/app.php`

Before final submission, set:

- `ALLOW_DEV_TEST_PAGES = false`

## 12. Security Notes

- Passwords are hashed with `password_hash()`
- Login verification uses `password_verify()`
- PDO prepared statements are used for database queries
- Checkout totals are calculated server-side
- Fake payment does not store real card data
- Reset tokens are stored as hashes

## 13. Author / Course Note

This project was developed as an individual Web Programming semester project.
