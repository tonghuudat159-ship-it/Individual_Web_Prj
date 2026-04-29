USE datedu_db;

-- =========================================================
-- Demo users
-- All demo accounts use the password: password123
-- PHP password_hash('password123', PASSWORD_DEFAULT):
-- $2y$10$OQ86J0hZYe6NRZ.x8.8FueRoNzHkWh4m/q2Ek4zPCot/.DjchYYsq
-- =========================================================

INSERT INTO users (user_id, full_name, email, password_hash, role, status) VALUES
    (1, 'DatEdu Admin', 'admin@datedu.local', '$2y$10$OQ86J0hZYe6NRZ.x8.8FueRoNzHkWh4m/q2Ek4zPCot/.DjchYYsq', 'admin', 'active'),
    (2, 'Demo Student', 'student@datedu.local', '$2y$10$OQ86J0hZYe6NRZ.x8.8FueRoNzHkWh4m/q2Ek4zPCot/.DjchYYsq', 'student', 'active'),
    (3, 'Viet Nguyen', 'viet@datedu.local', '$2y$10$OQ86J0hZYe6NRZ.x8.8FueRoNzHkWh4m/q2Ek4zPCot/.DjchYYsq', 'student', 'active');

-- =========================================================
-- Course categories
-- =========================================================

INSERT INTO categories (category_id, parent_id, name, slug, description) VALUES
    (1, NULL, 'Web Development', 'web-development', 'Build modern websites and dynamic web applications.'),
    (2, NULL, 'Data Science', 'data-science', 'Learn data analysis, Python, and practical data skills.'),
    (3, NULL, 'Business', 'business', 'Develop business, management, and entrepreneurship knowledge.'),
    (4, NULL, 'Design', 'design', 'Create better interfaces, visuals, and user experiences.'),
    (5, NULL, 'Marketing', 'marketing', 'Understand digital marketing, SEO, and online promotion.'),
    (6, NULL, 'IT & Software', 'it-software', 'Explore software tools, systems, and core IT topics.'),
    (7, NULL, 'Personal Development', 'personal-development', 'Improve communication, confidence, and productivity.');

-- =========================================================
-- Instructors
-- =========================================================

INSERT INTO instructors (instructor_id, full_name, email, bio, expertise, avatar) VALUES
    (1, 'Nguyen Van A', 'nguyen.a@datedu.local', 'Nguyen Van A teaches practical backend development with a focus on real-world PHP and MySQL projects.', 'PHP, MySQL, backend development', 'instructors/nguyen-van-a.jpg'),
    (2, 'Tran Thi B', 'tran.b@datedu.local', 'Tran Thi B helps beginners build confidence in JavaScript, responsive layouts, and frontend workflows.', 'JavaScript, HTML, CSS, frontend development', 'instructors/tran-thi-b.jpg'),
    (3, 'Le Van C', 'le.c@datedu.local', 'Le Van C specializes in Python, analytics, and turning raw data into useful business insights.', 'Python, data analytics, data science', 'instructors/le-van-c.jpg'),
    (4, 'Pham Thi D', 'pham.d@datedu.local', 'Pham Thi D teaches visual design and user experience through hands-on design exercises and product thinking.', 'UI/UX, Figma, product design', 'instructors/pham-thi-d.jpg'),
    (5, 'Hoang Van E', 'hoang.e@datedu.local', 'Hoang Van E supports learners in business strategy, project planning, and professional growth.', 'Business, entrepreneurship, project management', 'instructors/hoang-van-e.jpg'),
    (6, 'Do Thi F', 'do.f@datedu.local', 'Do Thi F covers digital marketing, communication strategy, and search visibility for modern brands.', 'Digital marketing, SEO, communication', 'instructors/do-thi-f.jpg');

-- =========================================================
-- Courses
-- =========================================================

INSERT INTO courses (
    course_id, category_id, instructor_id, title, slug, short_description, description, thumbnail,
    price, level, duration_hours, language, rating, total_students, is_featured, status
) VALUES
    (1, 1, 1, 'PHP & MySQL Web Development for Beginners', 'php-mysql-web-development-for-beginners', 'Learn to build dynamic PHP websites with MySQL from scratch.', 'A beginner-friendly course that covers PHP fundamentals, forms, sessions, MySQL integration, and a complete mini project for practice.', 'courses/php-mysql-web-development-for-beginners.jpg', 499000.00, 'Beginner', 18.50, 'English', 4.8, 1240, 1, 'published'),
    (2, 1, 2, 'JavaScript Essentials', 'javascript-essentials', 'Master core JavaScript concepts for interactive web pages.', 'This course introduces JavaScript syntax, functions, arrays, DOM manipulation, and event handling through practical coding exercises.', 'courses/javascript-essentials.jpg', 349000.00, 'Beginner', 12.00, 'English', 4.6, 1580, 1, 'published'),
    (3, 1, 2, 'HTML CSS Responsive Web Design', 'html-css-responsive-web-design', 'Design clean responsive websites for desktop and mobile.', 'Students learn semantic HTML, CSS styling, layout techniques, and responsive design patterns for modern websites.', 'courses/html-css-responsive-web-design.jpg', 299000.00, 'Beginner', 14.00, 'English', 4.7, 1715, 0, 'published'),
    (4, 6, 1, 'SQL Database Design Basics', 'sql-database-design-basics', 'Understand table design, keys, and practical SQL relationships.', 'Build a strong foundation in relational database concepts, table design, constraints, and common SQL queries used in web applications.', 'courses/sql-database-design-basics.jpg', 399000.00, 'Beginner', 10.50, 'English', 4.5, 930, 0, 'published'),
    (5, 2, 3, 'Python for Data Analysis', 'python-for-data-analysis', 'Analyze real datasets using Python and popular libraries.', 'Work with Python, spreadsheets, and common analysis workflows to clean, summarize, and visualize data for better decision-making.', 'courses/python-for-data-analysis.jpg', 599000.00, 'Intermediate', 16.00, 'English', 4.9, 1125, 1, 'published'),
    (6, 2, 3, 'Data Science Fundamentals', 'data-science-fundamentals', 'Explore the core workflow of data science projects.', 'An accessible introduction to the data science lifecycle, including problem framing, data preparation, simple models, and communication of results.', 'courses/data-science-fundamentals.jpg', 699000.00, 'Beginner', 20.00, 'English', 4.7, 870, 0, 'published'),
    (7, 3, 3, 'Excel for Business Analytics', 'excel-for-business-analytics', 'Use Excel tools to solve business reporting problems.', 'Learn formulas, pivot tables, dashboards, and analytical thinking to improve business reporting and decision support.', 'courses/excel-for-business-analytics.jpg', 349000.00, 'Beginner', 11.50, 'English', 4.4, 760, 0, 'published'),
    (8, 3, 5, 'Startup Business Foundations', 'startup-business-foundations', 'Understand the basics of launching and validating a startup idea.', 'This course covers idea validation, customer discovery, lean planning, and the basics of turning a concept into a viable startup.', 'courses/startup-business-foundations.jpg', 449000.00, 'Beginner', 9.50, 'English', 4.5, 540, 0, 'published'),
    (9, 3, 5, 'Project Management Basics', 'project-management-basics', 'Plan, organize, and deliver projects with confidence.', 'Students learn project goals, scope, teamwork, timelines, and simple planning tools useful for both study and work environments.', 'courses/project-management-basics.jpg', 399000.00, 'Beginner', 8.50, 'English', 4.3, 680, 0, 'published'),
    (10, 4, 4, 'UI/UX Design Fundamentals', 'ui-ux-design-fundamentals', 'Learn the foundations of user interface and user experience design.', 'Understand user flows, wireframes, visual hierarchy, and usability principles through practical UI/UX case studies.', 'courses/ui-ux-design-fundamentals.jpg', 499000.00, 'Beginner', 13.00, 'English', 4.8, 950, 1, 'published'),
    (11, 4, 4, 'Figma for Beginners', 'figma-for-beginners', 'Design interfaces and prototypes in Figma step by step.', 'A hands-on Figma course that walks through frames, components, prototyping, and a simple app design workflow.', 'courses/figma-for-beginners.jpg', 299000.00, 'Beginner', 7.50, 'English', 4.6, 845, 0, 'published'),
    (12, 5, 6, 'Digital Marketing Masterclass', 'digital-marketing-masterclass', 'Build a complete introduction to digital marketing channels.', 'Learn content marketing, social media basics, campaign planning, and performance metrics for online growth.', 'courses/digital-marketing-masterclass.jpg', 599000.00, 'Intermediate', 15.00, 'English', 4.7, 1020, 1, 'published'),
    (13, 5, 6, 'SEO Basics for Websites', 'seo-basics-for-websites', 'Improve search visibility with practical on-page SEO techniques.', 'This course explains keywords, page structure, content optimization, and simple SEO habits that improve website discoverability.', 'courses/seo-basics-for-websites.jpg', 349000.00, 'Beginner', 8.00, 'English', 4.4, 790, 0, 'published'),
    (14, 6, 2, 'Git and GitHub for Developers', 'git-and-github-for-developers', 'Track code changes and collaborate using Git and GitHub.', 'Students learn version control basics, branching, pull requests, and common collaboration workflows for software projects.', 'courses/git-and-github-for-developers.jpg', 299000.00, 'Beginner', 6.50, 'English', 4.8, 1395, 0, 'published'),
    (15, 6, 1, 'Computer Networking Fundamentals', 'computer-networking-fundamentals', 'Understand networks, protocols, and internet basics for IT learners.', 'A practical overview of networking concepts including IP addresses, routing, network devices, and common troubleshooting ideas.', 'courses/computer-networking-fundamentals.jpg', 449000.00, 'Beginner', 12.50, 'English', 4.5, 625, 0, 'published'),
    (16, 6, 1, 'Cybersecurity Awareness for Beginners', 'cybersecurity-awareness-for-beginners', 'Learn safe digital habits and basic cybersecurity concepts.', 'Covers passwords, phishing, secure browsing, account protection, and the security mindset needed for everyday technology use.', 'courses/cybersecurity-awareness-for-beginners.jpg', 399000.00, 'Beginner', 7.00, 'English', 4.6, 1180, 0, 'published'),
    (17, 7, 5, 'Public Speaking Confidence', 'public-speaking-confidence', 'Build confidence when speaking in class, meetings, or presentations.', 'Practice structure, storytelling, vocal delivery, and audience engagement to communicate with clarity and confidence.', 'courses/public-speaking-confidence.jpg', 299000.00, 'Beginner', 6.00, 'English', 4.5, 710, 0, 'published'),
    (18, 7, 5, 'Time Management for Students', 'time-management-for-students', 'Improve focus, planning, and study productivity.', 'Students learn practical scheduling, prioritization, habit building, and distraction control strategies for busy study routines.', 'courses/time-management-for-students.jpg', 299000.00, 'Beginner', 5.50, 'English', 4.3, 1340, 0, 'published'),
    (19, 1, 2, 'Advanced JavaScript Projects', 'advanced-javascript-projects', 'Build portfolio-ready JavaScript projects beyond the basics.', 'Create interactive applications using modern JavaScript patterns, APIs, async workflows, and component-based thinking.', 'courses/advanced-javascript-projects.jpg', 699000.00, 'Advanced', 19.00, 'English', 4.9, 905, 1, 'published'),
    (20, 1, 1, 'Practical PHP Login System', 'practical-php-login-system', 'Create a secure PHP login system with sessions and validation.', 'A project-based course focused on authentication, password hashing, session management, and reusable PHP login system patterns.', 'courses/practical-php-login-system.jpg', 399000.00, 'Intermediate', 9.00, 'English', 4.7, 980, 1, 'published');

-- =========================================================
-- Course lessons
-- At least 3 lessons per course, with extra lessons for the
-- first important courses to create a richer demo curriculum.
-- =========================================================

INSERT INTO course_lessons (lesson_id, course_id, title, duration_minutes, is_preview, sort_order) VALUES
    (1, 1, 'Introduction to Web Programming', 10, 1, 1),
    (2, 1, 'Setting Up XAMPP', 18, 1, 2),
    (3, 1, 'PHP Syntax and Variables', 26, 0, 3),
    (4, 1, 'Working with MySQL Databases', 32, 0, 4),
    (5, 1, 'Building Dynamic Pages', 35, 0, 5),
    (6, 2, 'Why JavaScript Matters', 12, 1, 1),
    (7, 2, 'Variables and Data Types', 20, 0, 2),
    (8, 2, 'Functions and Scope', 24, 0, 3),
    (9, 2, 'DOM Manipulation Basics', 28, 0, 4),
    (10, 2, 'Events and Interactive UI', 30, 0, 5),
    (11, 3, 'HTML Page Structure', 14, 1, 1),
    (12, 3, 'CSS Selectors and Styling', 22, 0, 2),
    (13, 3, 'Flexbox and Grid Layouts', 27, 0, 3),
    (14, 3, 'Responsive Design Techniques', 25, 0, 4),
    (15, 3, 'Mobile Navigation Mini Project', 30, 0, 5),
    (16, 4, 'Relational Database Concepts', 15, 1, 1),
    (17, 4, 'Creating Tables and Data Types', 23, 0, 2),
    (18, 4, 'Primary Keys and Foreign Keys', 20, 0, 3),
    (19, 4, 'SELECT Queries and Joins', 28, 0, 4),
    (20, 4, 'Database Normalization Basics', 24, 0, 5),
    (21, 5, 'Python Setup for Analysts', 15, 1, 1),
    (22, 5, 'Cleaning Data with Python', 32, 0, 2),
    (23, 5, 'Basic Charts and Summaries', 28, 0, 3),
    (24, 6, 'What Is Data Science', 14, 1, 1),
    (25, 6, 'Data Preparation Workflow', 27, 0, 2),
    (26, 6, 'Simple Models and Results', 33, 0, 3),
    (27, 7, 'Excel Formulas for Reports', 18, 1, 1),
    (28, 7, 'Pivot Tables for Analysis', 24, 0, 2),
    (29, 7, 'Dashboard Basics in Excel', 26, 0, 3),
    (30, 8, 'Validating a Startup Idea', 16, 1, 1),
    (31, 8, 'Understanding Your Customer', 22, 0, 2),
    (32, 8, 'Building a Simple Lean Plan', 24, 0, 3),
    (33, 9, 'Project Goals and Scope', 17, 1, 1),
    (34, 9, 'Timeline Planning Essentials', 21, 0, 2),
    (35, 9, 'Managing Team Communication', 20, 0, 3),
    (36, 10, 'Design Thinking Basics', 14, 1, 1),
    (37, 10, 'Wireframes and User Flows', 25, 0, 2),
    (38, 10, 'Usability Principles in Practice', 29, 0, 3),
    (39, 11, 'Getting Started with Figma', 13, 1, 1),
    (40, 11, 'Components and Auto Layout', 24, 0, 2),
    (41, 11, 'Prototype Your First App Screen', 27, 0, 3),
    (42, 12, 'Digital Marketing Overview', 16, 1, 1),
    (43, 12, 'Content and Social Media Basics', 27, 0, 2),
    (44, 12, 'Measuring Campaign Results', 23, 0, 3),
    (45, 13, 'How Search Engines Work', 14, 1, 1),
    (46, 13, 'Keyword Research Basics', 20, 0, 2),
    (47, 13, 'On-Page SEO Checklist', 22, 0, 3),
    (48, 14, 'Version Control Fundamentals', 12, 1, 1),
    (49, 14, 'Branching and Merging', 21, 0, 2),
    (50, 14, 'Working with GitHub Repositories', 24, 0, 3),
    (51, 15, 'Network Devices and Topologies', 18, 1, 1),
    (52, 15, 'IP Addressing Basics', 22, 0, 2),
    (53, 15, 'Common Network Troubleshooting', 25, 0, 3),
    (54, 16, 'Cybersecurity Mindset', 12, 1, 1),
    (55, 16, 'Recognizing Phishing and Scams', 19, 0, 2),
    (56, 16, 'Protecting Accounts and Devices', 23, 0, 3),
    (57, 17, 'Overcoming Speaking Anxiety', 15, 1, 1),
    (58, 17, 'Structuring a Clear Talk', 21, 0, 2),
    (59, 17, 'Improving Voice and Delivery', 24, 0, 3),
    (60, 18, 'Planning a Productive Week', 13, 1, 1),
    (61, 18, 'Prioritizing Important Tasks', 18, 0, 2),
    (62, 18, 'Reducing Distractions While Studying', 20, 0, 3),
    (63, 19, 'Project Planning for JavaScript Apps', 18, 1, 1),
    (64, 19, 'Working with APIs and Async Code', 31, 0, 2),
    (65, 19, 'Building a Portfolio Project', 36, 0, 3),
    (66, 20, 'Designing the Login Flow', 14, 1, 1),
    (67, 20, 'Password Hashing and Validation', 26, 0, 2),
    (68, 20, 'Sessions, Logout, and Security Checks', 28, 0, 3);

-- =========================================================
-- Learning support locations
-- =========================================================

INSERT INTO locations (location_id, name, address, city, type, google_maps_url) VALUES
    (1, 'DatEdu Online Platform', 'Remote Learning', 'Ho Chi Minh City', 'online', NULL),
    (2, 'HCMUT Learning Center', '268 Ly Thuong Kiet, District 10, Ho Chi Minh City', 'Ho Chi Minh City', 'offline', 'https://www.google.com/maps'),
    (3, 'District 1 Partner Center', 'District 1, Ho Chi Minh City', 'Ho Chi Minh City', 'hybrid', 'https://www.google.com/maps'),
    (4, 'Thu Duc Learning Hub', 'Thu Duc City, Ho Chi Minh City', 'Ho Chi Minh City', 'hybrid', 'https://www.google.com/maps');

-- =========================================================
-- Course-location mappings
-- Every course is available on the online platform.
-- Additional support locations are mapped by category.
-- =========================================================

INSERT INTO course_locations (course_location_id, course_id, location_id, support_type, availability_note) VALUES
    (1, 1, 1, 'Online support', 'Available for enrolled students'),
    (2, 2, 1, 'Online support', 'Available for enrolled students'),
    (3, 3, 1, 'Online support', 'Available for enrolled students'),
    (4, 4, 1, 'Online support', 'Available for enrolled students'),
    (5, 5, 1, 'Online support', 'Available for enrolled students'),
    (6, 6, 1, 'Online support', 'Available for enrolled students'),
    (7, 7, 1, 'Online support', 'Available for enrolled students'),
    (8, 8, 1, 'Online support', 'Available for enrolled students'),
    (9, 9, 1, 'Online support', 'Available for enrolled students'),
    (10, 10, 1, 'Online support', 'Available for enrolled students'),
    (11, 11, 1, 'Online support', 'Available for enrolled students'),
    (12, 12, 1, 'Online support', 'Available for enrolled students'),
    (13, 13, 1, 'Online support', 'Available for enrolled students'),
    (14, 14, 1, 'Online support', 'Available for enrolled students'),
    (15, 15, 1, 'Online support', 'Available for enrolled students'),
    (16, 16, 1, 'Online support', 'Available for enrolled students'),
    (17, 17, 1, 'Online support', 'Available for enrolled students'),
    (18, 18, 1, 'Online support', 'Available for enrolled students'),
    (19, 19, 1, 'Online support', 'Available for enrolled students'),
    (20, 20, 1, 'Online support', 'Available for enrolled students'),
    (21, 1, 2, 'Offline workshop support', 'Weekend practice sessions at HCMUT'),
    (22, 2, 2, 'Offline workshop support', 'Weekend practice sessions at HCMUT'),
    (23, 3, 2, 'Offline workshop support', 'Weekend practice sessions at HCMUT'),
    (24, 4, 2, 'Offline workshop support', 'Weekend database workshops for enrolled students'),
    (25, 14, 2, 'Offline workshop support', 'Version control support lab at HCMUT'),
    (26, 15, 2, 'Offline workshop support', 'Networking lab support for enrolled students'),
    (27, 16, 2, 'Offline workshop support', 'Security awareness workshop support'),
    (28, 19, 2, 'Offline workshop support', 'Project review sessions at HCMUT'),
    (29, 20, 2, 'Offline workshop support', 'Authentication lab support for enrolled students'),
    (30, 7, 3, 'Hybrid mentoring', 'Business analytics mentoring in District 1'),
    (31, 8, 3, 'Hybrid mentoring', 'Startup discussion sessions available monthly'),
    (32, 9, 3, 'Hybrid mentoring', 'Project planning clinic for enrolled students'),
    (33, 12, 3, 'Hybrid mentoring', 'Campaign review support in District 1'),
    (34, 13, 3, 'Hybrid mentoring', 'SEO coaching sessions for enrolled students'),
    (35, 5, 4, 'Hybrid mentoring', 'Data analysis mentoring in Thu Duc'),
    (36, 6, 4, 'Hybrid mentoring', 'Data science study group support'),
    (37, 17, 4, 'Hybrid mentoring', 'Public speaking practice sessions available'),
    (38, 18, 4, 'Hybrid mentoring', 'Study productivity workshops for enrolled students');

-- =========================================================
-- Optional demo cart/order/enrollment data
-- Keeps the dataset simple while supporting later demos.
-- =========================================================

INSERT INTO cart_items (cart_item_id, user_id, course_id) VALUES
    (1, 2, 12);

INSERT INTO orders (order_id, user_id, order_code, total_amount, status) VALUES
    (1, 3, 'ORD-DEMO-0001', 599000.00, 'paid');

INSERT INTO order_items (order_item_id, order_id, course_id, price_at_purchase) VALUES
    (1, 1, 5, 599000.00);

INSERT INTO payments (payment_id, order_id, payment_method, amount, status, transaction_ref, paid_at) VALUES
    (1, 1, 'momo', 599000.00, 'success', 'MOMO-DEMO-0001', '2026-04-29 10:30:00');

INSERT INTO enrollments (enrollment_id, user_id, course_id, order_id, status, enrolled_at) VALUES
    (1, 3, 5, 1, 'active', '2026-04-29 10:35:00');
