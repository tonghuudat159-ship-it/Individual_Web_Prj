-- =========================================================
-- DatEdu Database Schema
-- Project: D5 - Online Course Platform
-- Database: datedu_db
-- This script creates the full database structure.
-- No sample data is inserted in this phase.
-- =========================================================

-- =========================================================
-- Database creation
-- Drop and recreate the database with utf8mb4 settings.
-- =========================================================
DROP DATABASE IF EXISTS datedu_db;

CREATE DATABASE datedu_db
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE datedu_db;

-- =========================================================
-- User and authentication tables
-- Stores user accounts and password reset requests.
-- Passwords are stored as password_hash only.
-- =========================================================

CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('student', 'admin') NOT NULL DEFAULT 'student',
    status ENUM('active', 'blocked') NOT NULL DEFAULT 'active',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT uq_users_email UNIQUE (email)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

CREATE TABLE password_resets (
    reset_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    token_hash VARCHAR(255) NOT NULL,
    expires_at DATETIME NOT NULL,
    used_at DATETIME NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_password_resets_user
        FOREIGN KEY (user_id)
        REFERENCES users(user_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

-- =========================================================
-- Course catalog tables
-- Stores categories, instructors, and courses.
-- =========================================================

CREATE TABLE categories (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    parent_id INT NULL,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(120) NOT NULL,
    description TEXT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT uq_categories_slug UNIQUE (slug),
    CONSTRAINT fk_categories_parent
        FOREIGN KEY (parent_id)
        REFERENCES categories(category_id)
        ON DELETE SET NULL
        ON UPDATE CASCADE
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

CREATE TABLE instructors (
    instructor_id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NULL,
    bio TEXT NULL,
    expertise VARCHAR(150) NULL,
    avatar VARCHAR(255) NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

CREATE TABLE courses (
    course_id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    instructor_id INT NOT NULL,
    title VARCHAR(200) NOT NULL,
    slug VARCHAR(220) NOT NULL,
    short_description VARCHAR(255) NOT NULL,
    description TEXT NULL,
    thumbnail VARCHAR(255) NULL,
    price DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    level ENUM('Beginner', 'Intermediate', 'Advanced', 'All Levels') NOT NULL DEFAULT 'Beginner',
    duration_hours DECIMAL(5,2) NOT NULL DEFAULT 0.00,
    language VARCHAR(50) NOT NULL DEFAULT 'English',
    rating DECIMAL(2,1) NOT NULL DEFAULT 0.0,
    total_students INT NOT NULL DEFAULT 0,
    is_featured TINYINT(1) NOT NULL DEFAULT 0,
    status ENUM('draft', 'published') NOT NULL DEFAULT 'published',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT uq_courses_slug UNIQUE (slug),
    CONSTRAINT fk_courses_category
        FOREIGN KEY (category_id)
        REFERENCES categories(category_id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE,
    CONSTRAINT fk_courses_instructor
        FOREIGN KEY (instructor_id)
        REFERENCES instructors(instructor_id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

-- =========================================================
-- Course lessons
-- Stores the curriculum and lesson list for each course.
-- =========================================================

CREATE TABLE course_lessons (
    lesson_id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT NOT NULL,
    title VARCHAR(200) NOT NULL,
    duration_minutes INT NOT NULL DEFAULT 0,
    is_preview TINYINT(1) NOT NULL DEFAULT 0,
    sort_order INT NOT NULL DEFAULT 0,
    CONSTRAINT fk_course_lessons_course
        FOREIGN KEY (course_id)
        REFERENCES courses(course_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

-- =========================================================
-- Learning support locations
-- Stores online or offline learning support locations and
-- Google Maps links for the contact/support requirement.
-- =========================================================

CREATE TABLE locations (
    location_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    address VARCHAR(255) NOT NULL,
    city VARCHAR(100) NOT NULL DEFAULT 'Ho Chi Minh City',
    type ENUM('online', 'offline', 'hybrid') NOT NULL DEFAULT 'online',
    google_maps_url VARCHAR(500) NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

CREATE TABLE course_locations (
    course_location_id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT NOT NULL,
    location_id INT NOT NULL,
    support_type VARCHAR(100) NULL,
    availability_note VARCHAR(255) NULL,
    CONSTRAINT uq_course_locations_course_location UNIQUE (course_id, location_id),
    CONSTRAINT fk_course_locations_course
        FOREIGN KEY (course_id)
        REFERENCES courses(course_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT fk_course_locations_location
        FOREIGN KEY (location_id)
        REFERENCES locations(location_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

-- =========================================================
-- Cart
-- Stores courses that logged-in users add to their cart.
-- =========================================================

CREATE TABLE cart_items (
    cart_item_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    course_id INT NOT NULL,
    added_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT uq_cart_items_user_course UNIQUE (user_id, course_id),
    CONSTRAINT fk_cart_items_user
        FOREIGN KEY (user_id)
        REFERENCES users(user_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT fk_cart_items_course
        FOREIGN KEY (course_id)
        REFERENCES courses(course_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

-- =========================================================
-- Orders
-- Stores checkout orders and the course items purchased.
-- =========================================================

CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    order_code VARCHAR(50) NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    status ENUM('pending', 'paid', 'cancelled') NOT NULL DEFAULT 'pending',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT uq_orders_order_code UNIQUE (order_code),
    CONSTRAINT fk_orders_user
        FOREIGN KEY (user_id)
        REFERENCES users(user_id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

CREATE TABLE order_items (
    order_item_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    course_id INT NOT NULL,
    price_at_purchase DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    CONSTRAINT uq_order_items_order_course UNIQUE (order_id, course_id),
    CONSTRAINT fk_order_items_order
        FOREIGN KEY (order_id)
        REFERENCES orders(order_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT fk_order_items_course
        FOREIGN KEY (course_id)
        REFERENCES courses(course_id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

-- =========================================================
-- Payments
-- Stores simulated payment records for each order.
-- =========================================================

CREATE TABLE payments (
    payment_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    payment_method ENUM('credit_card', 'bank_transfer', 'momo') NOT NULL,
    amount DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    status ENUM('pending', 'success', 'failed') NOT NULL DEFAULT 'pending',
    transaction_ref VARCHAR(100) NULL,
    paid_at DATETIME NULL,
    CONSTRAINT uq_payments_order_id UNIQUE (order_id),
    CONSTRAINT fk_payments_order
        FOREIGN KEY (order_id)
        REFERENCES orders(order_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

-- =========================================================
-- Enrollments
-- Stores successful course enrollments after checkout.
-- =========================================================

CREATE TABLE enrollments (
    enrollment_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    course_id INT NOT NULL,
    order_id INT NOT NULL,
    status ENUM('active', 'completed', 'cancelled') NOT NULL DEFAULT 'active',
    enrolled_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT uq_enrollments_user_course UNIQUE (user_id, course_id),
    CONSTRAINT fk_enrollments_user
        FOREIGN KEY (user_id)
        REFERENCES users(user_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT fk_enrollments_course
        FOREIGN KEY (course_id)
        REFERENCES courses(course_id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE,
    CONSTRAINT fk_enrollments_order
        FOREIGN KEY (order_id)
        REFERENCES orders(order_id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

-- =========================================================
-- Indexes
-- Adds useful indexes for authentication, filtering, sorting,
-- and foreign key relationships.
-- =========================================================

CREATE INDEX idx_password_resets_user_id
    ON password_resets (user_id);

CREATE INDEX idx_password_resets_expires_at
    ON password_resets (expires_at);

CREATE INDEX idx_categories_parent_id
    ON categories (parent_id);

CREATE INDEX idx_courses_title
    ON courses (title);

CREATE INDEX idx_courses_price
    ON courses (price);

CREATE INDEX idx_courses_rating
    ON courses (rating);

CREATE INDEX idx_courses_created_at
    ON courses (created_at);

CREATE INDEX idx_courses_category_id
    ON courses (category_id);

CREATE INDEX idx_courses_instructor_id
    ON courses (instructor_id);

CREATE INDEX idx_course_lessons_course_id
    ON course_lessons (course_id);

CREATE INDEX idx_course_lessons_sort_order
    ON course_lessons (sort_order);

CREATE INDEX idx_locations_city
    ON locations (city);

CREATE INDEX idx_locations_type
    ON locations (type);

CREATE INDEX idx_course_locations_course_id
    ON course_locations (course_id);

CREATE INDEX idx_course_locations_location_id
    ON course_locations (location_id);

CREATE INDEX idx_cart_items_user_id
    ON cart_items (user_id);

CREATE INDEX idx_cart_items_course_id
    ON cart_items (course_id);

CREATE INDEX idx_orders_user_id
    ON orders (user_id);

CREATE INDEX idx_orders_status
    ON orders (status);

CREATE INDEX idx_orders_created_at
    ON orders (created_at);

CREATE INDEX idx_order_items_order_id
    ON order_items (order_id);

CREATE INDEX idx_order_items_course_id
    ON order_items (course_id);

CREATE INDEX idx_payments_status
    ON payments (status);

CREATE INDEX idx_payments_paid_at
    ON payments (paid_at);

CREATE INDEX idx_enrollments_user_id
    ON enrollments (user_id);

CREATE INDEX idx_enrollments_course_id
    ON enrollments (course_id);

CREATE INDEX idx_enrollments_order_id
    ON enrollments (order_id);

CREATE INDEX idx_enrollments_status
    ON enrollments (status);

-- =========================================================
-- Foreign key relationships summary
-- password_resets.user_id -> users.user_id
-- categories.parent_id -> categories.category_id
-- courses.category_id -> categories.category_id
-- courses.instructor_id -> instructors.instructor_id
-- course_lessons.course_id -> courses.course_id
-- course_locations.course_id -> courses.course_id
-- course_locations.location_id -> locations.location_id
-- cart_items.user_id -> users.user_id
-- cart_items.course_id -> courses.course_id
-- orders.user_id -> users.user_id
-- order_items.order_id -> orders.order_id
-- order_items.course_id -> courses.course_id
-- payments.order_id -> orders.order_id
-- enrollments.user_id -> users.user_id
-- enrollments.course_id -> courses.course_id
-- enrollments.order_id -> orders.order_id
-- =========================================================
