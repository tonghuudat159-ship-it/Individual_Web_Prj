# DatEdu Project Report Outline

## 1. Introduction

- Project name: DatEdu
- Domain: D5 Online Course Platform
- Inspired by Udemy
- Purpose of the website
- Main users: learners/students
- Main use cases:
- browsing courses
- searching courses
- viewing course details
- enrolling through checkout
- accessing My Learning

Suggested paragraph:
DatEdu is an online course platform developed for the Web Programming semester project. The website allows users to browse and search online courses, view course details, register/login, add courses to cart, complete a simulated payment, and access enrolled courses through My Learning.

## 2. Domain-Specific Design Choices

- Courses are the main Products/Items in the D5 domain adaptation.
- Course categories satisfy the category requirement and help users browse by topic.
- The course detail page acts as the item detail page for each course.
- Store locations are adapted as Learning Support Locations because the platform is focused on online education rather than physical retail products.
- Google Maps links represent offline or hybrid learning support centers where students can receive help or attend supporting sessions.
- Payment is simulated for local XAMPP demonstration, which keeps the project suitable for a classroom environment.
- My Learning represents the final enrolled-course area after successful checkout and payment.

## 3. Technology Stack

- XAMPP provides Apache and the MySQL-compatible database environment.
- PHP is used for server-side logic, routing through public entry pages, validation, and database operations.
- The MySQL database stores users, courses, orders, payments, enrollments, and other supporting data.
- HTML and CSS build the interface and page structure.
- JavaScript handles dynamic user interface behavior such as mobile navigation and interactive page actions.
- AJAX with the Fetch API is used for search and cart actions without requiring full page reloads.
- PDO prepared statements are used for secure and reusable database access.

No PHP framework is used to keep the project simple and suitable for a Web Programming course.

## 4. Website Layout and Responsive Design

- The website uses a shared layout with a header, navbar, main content section, and footer.
- The header includes the DatEdu logo and branding.
- The navbar includes Home, Courses, Search, Contact, Cart, My Learning, and either Login/Register or the logged-in user state with Logout.
- The main content area changes depending on the selected page while keeping a consistent overall layout.
- The footer contains contact-style information and quick navigation links.
- The visual structure follows a course marketplace style similar to Udemy, especially through reusable course cards and a grid-based course catalog.
- The layout is responsive across desktop, tablet, and mobile widths.
- A mobile hamburger menu is shown on smaller screens to keep navigation usable without horizontal overflow.
- The course grid changes from multiple columns on wider screens to fewer columns and eventually a single-column layout on mobile devices.

## 5. Database Design

Authentication tables:
- `users`
- `password_resets`

Course catalog tables:
- `categories`
- `instructors`
- `courses`
- `course_lessons`

Location tables:
- `locations`
- `course_locations`

Cart and checkout tables:
- `cart_items`
- `orders`
- `order_items`
- `payments`
- `enrollments`

Key relationships:
- One category has many courses.
- One instructor has many courses.
- One course has many lessons.
- One course can have many learning support locations.
- One user can have many cart items.
- One user can have many orders.
- One order has many order items.
- One order has one payment.
- One user can enroll in many courses.

Primary keys and foreign keys are used to maintain data integrity.

[Insert ER Diagram here]

## 6. Course Catalog Implementation

- The Courses page loads data from the database instead of using static hard-coded course entries.
- Category filtering is based on the selected category slug so that users can browse a focused subset of the catalog.
- Sorting supports newest, price, rating, title, and popularity, which gives users several useful ways to organize the catalog.
- Pagination is implemented with `LIMIT` and `OFFSET` in SQL queries to control how many courses appear on each page.
- Reusable course card rendering helps keep the layout consistent between the Home page and the Courses page.
- Course detail links use slugs so that URLs are more readable and better aligned with SEO requirements.

Suggested explanation:
Pagination was chosen instead of lazy loading because it is easier to implement reliably with PHP and MySQL, easier to test, and easier to demonstrate during the final lab session.

## 7. AJAX Search Implementation

- The search input is placed in the navbar so it is available from multiple pages.
- JavaScript listens for typing in the search field and triggers asynchronous requests for matching courses.
- Debounce can be mentioned in the report if it is used in the current JavaScript implementation; the main idea is that search requests are handled dynamically rather than through a full page submit.
- `fetch()` sends the request to `public/ajax/search_courses.php`.
- PHP queries the database using the typed keyword and returns JSON results.
- Results are rendered dynamically in a dropdown without a full page reload.
- Clicking a result opens `course-detail.php?slug=...` for the selected course.

## 8. Categories and Breadcrumbs

- Courses are organized by categories so users can browse the platform by topic.
- Breadcrumbs help users understand the current navigation path and return to higher-level pages more easily.

Examples:
- `Home > Courses`
- `Home > Courses > Web Development`
- `Home > Courses > Web Development > PHP & MySQL Web Development`

## 9. Learning Support Locations and Maps

- The original semester requirement mentions store locations.
- For an online course platform, this requirement is adapted to learning support locations.
- Locations can be online, offline, or hybrid depending on how course support is provided.
- The course detail page displays which learning support locations are available for the course.
- Offline and hybrid locations include Google Maps links so that the feature still demonstrates location integration in a domain-appropriate way.

## 10. Authentication and Security

- The system includes Register, Login, Logout, Forgot Password, and Reset Password pages.
- Sessions are used to track logged-in users across requests.
- Flash messages are used to communicate success and error states after form submissions and redirects.
- CSRF tokens are included to reduce cross-site request forgery risk in important forms.
- Input validation is applied to registration, login, reset password, checkout, and similar actions.

Security details:
- Passwords are stored with `password_hash()`.
- Login verifies passwords with `password_verify()`.
- Reset tokens are stored as hashes instead of storing the raw token value.
- PDO prepared statements reduce SQL injection risk.
- Server-side validation is used because client-side validation can be bypassed.

## 11. Cart, Checkout, Fake Payment, and Enrollment

- Logged-in users can add courses to the cart from the course detail page.
- Cart items are stored in the `cart_items` table.
- Removing items from the cart uses AJAX for a smoother user experience.
- Checkout calculates totals on the server side to avoid trusting browser-side values.
- The available fake payment methods are `Momo Demo`, `Credit Card Demo`, and `Bank Transfer Demo`.
- The checkout transaction creates records in `orders`, `order_items`, `payments`, and `enrollments`.
- The cart is cleared after successful payment.
- The My Learning page displays the courses the user has enrolled in after checkout.

No real payment gateway is used and no real card data is stored.

## 12. SEO Implementation

- Meaningful page titles are used so that each page clearly describes its content.
- Meta descriptions are included to provide a short summary for search engines and browser previews.
- Semantic HTML is used to improve structure and readability.
- Slug-based course detail URLs make links more readable and more descriptive.
- `sitemap.xml` is included so the website exposes its main pages and course detail URLs in a crawlable format.

Course detail pages use slugs such as:
`course-detail.php?slug=php-mysql-web-development-for-beginners`

## 13. Challenges and Lessons Learned

- Organizing a PHP project cleanly without using a framework required careful separation of configuration, models, helpers, views, and public entry pages.
- Designing a normalized relational database was important because the project includes users, courses, lessons, locations, orders, payments, and enrollments.
- Implementing AJAX search with JSON responses required coordination between JavaScript rendering and PHP query logic.
- Managing sessions and authentication correctly was necessary to protect cart, checkout, and My Learning features.
- Handling password reset securely in a local demo required hashed reset tokens and an instructor-friendly local reset flow.
- Keeping checkout consistent required transaction-based thinking so orders, payments, enrollments, and cart clearing stay synchronized.
- Making the website responsive across devices required practical testing on desktop, tablet, and mobile widths.

## 14. Conclusion

- DatEdu demonstrates a complete dynamic, database-driven online course platform.
- The project covers front-end development, back-end logic, database design, AJAX interactions, authentication, SEO, and a full checkout flow.
- The implementation focuses on correctness, clarity, and understanding, which makes it appropriate for an individual Web Programming semester project.

## Appendix A - Important URLs

Home:
`http://localhost/Individual_Web_Prj/public/`

Courses:
`http://localhost/Individual_Web_Prj/public/courses.php`

Course Detail Example:
`http://localhost/Individual_Web_Prj/public/course-detail.php?slug=php-mysql-web-development-for-beginners`

Login:
`http://localhost/Individual_Web_Prj/public/login.php`

Register:
`http://localhost/Individual_Web_Prj/public/register.php`

Cart:
`http://localhost/Individual_Web_Prj/public/cart.php`

Checkout:
`http://localhost/Individual_Web_Prj/public/checkout.php`

My Learning:
`http://localhost/Individual_Web_Prj/public/my-learning.php`

Sitemap:
`http://localhost/Individual_Web_Prj/public/sitemap.xml`

## Appendix B - Demo Accounts

Admin:
`admin@datedu.local / password123`

Student:
`student@datedu.local / password123`

Student 2:
`viet@datedu.local / password123`
