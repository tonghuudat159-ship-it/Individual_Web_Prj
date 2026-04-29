<?php
/**
 * Course Detail View
 * Shows complete course information, instructor details, reviews, and enrollment options
 */
?>
<main class="main-content">
    <!-- Breadcrumb -->
    <nav class="breadcrumb-nav">
        <div class="breadcrumb-container">
            <a href="<?php echo base_url('index.php'); ?>">Home</a>
            <span class="breadcrumb-separator">></span>
            <a href="<?php echo base_url('courses.php'); ?>">Courses</a>
            <span class="breadcrumb-separator">></span>
            <a href="<?php echo base_url('courses.php'); ?>">Web Development</a>
            <span class="breadcrumb-separator">></span>
            <span class="breadcrumb-current">PHP & MySQL Web Development</span>
        </div>
    </nav>

    <!-- Course Hero Section -->
    <section class="course-hero">
        <div class="course-hero-container">
            <div class="course-hero-content">
                <h1>PHP & MySQL Web Development for Beginners</h1>
                <p class="course-description">Build dynamic websites using PHP, MySQL, HTML, CSS, and JavaScript.</p>
                
                <div class="course-meta-info">
                    <div class="meta-item">
                        <span class="meta-label">Rating:</span>
                        <span class="meta-value">
                            <span class="stars">★</span> 4.7
                        </span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Students:</span>
                        <span class="meta-value">1,245</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Instructor:</span>
                        <span class="meta-value">Nguyen Van A</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Language:</span>
                        <span class="meta-value">English</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Last updated:</span>
                        <span class="meta-value">04/2026</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Course Main Content -->
    <section class="course-content-section">
        <div class="course-content-container">
            <div class="course-main">
                <!-- What You Will Learn -->
                <section class="course-section learning-outcomes">
                    <h2>What You Will Learn</h2>
                    <div class="learning-grid">
                        <div class="learning-item">
                            <span class="checkmark">✓</span>
                            <p>Build dynamic websites with PHP and MySQL</p>
                        </div>
                        <div class="learning-item">
                            <span class="checkmark">✓</span>
                            <p>Create basic login and register systems</p>
                        </div>
                        <div class="learning-item">
                            <span class="checkmark">✓</span>
                            <p>Work with database-driven pages</p>
                        </div>
                        <div class="learning-item">
                            <span class="checkmark">✓</span>
                            <p>Understand simple server-side validation</p>
                        </div>
                        <div class="learning-item">
                            <span class="checkmark">✓</span>
                            <p>Use JavaScript for interactive behavior</p>
                        </div>
                        <div class="learning-item">
                            <span class="checkmark">✓</span>
                            <p>Structure a PHP project clearly</p>
                        </div>
                    </div>
                </section>

                <!-- Course Content -->
                <section class="course-section course-curriculum">
                    <h2>Course Content</h2>
                    <div class="lessons-list">
                        <?php
                        $lessons = [
                            'Introduction to Web Programming',
                            'Setting up XAMPP',
                            'PHP Basics',
                            'Working with MySQL',
                            'Building Dynamic Pages',
                            'Final Project Demo'
                        ];

                        foreach ($lessons as $index => $lesson) {
                            ?>
                            <div class="lesson-item">
                                <span class="lesson-number"><?php echo $index + 1; ?></span>
                                <span class="lesson-title"><?php echo htmlspecialchars($lesson); ?></span>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </section>

                <!-- Instructor Section -->
                <section class="course-section instructor-section">
                    <h2>Meet Your Instructor</h2>
                    <div class="instructor-card">
                        <div class="instructor-avatar">
                            <div class="avatar-placeholder">NA</div>
                        </div>
                        <div class="instructor-info">
                            <h3>Nguyen Van A</h3>
                            <p>A web development instructor with experience in PHP, MySQL, and practical web application projects.</p>
                        </div>
                    </div>
                </section>

                <!-- Learning Support Locations -->
                <section class="course-section locations-section">
                    <h2>Learning Support Locations</h2>
                    <div class="locations-table-wrapper">
                        <table class="locations-table">
                            <thead>
                                <tr>
                                    <th>Location Name</th>
                                    <th>Type</th>
                                    <th>Address</th>
                                    <th>Map</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>DatEdu Online Platform</td>
                                    <td><span class="type-badge type-online">Online</span></td>
                                    <td>Remote Learning</td>
                                    <td><a href="https://www.google.com/maps" target="_blank" class="map-link">Website</a></td>
                                </tr>
                                <tr>
                                    <td>HCMUT Learning Center</td>
                                    <td><span class="type-badge type-offline">Offline</span></td>
                                    <td>268 Ly Thuong Kiet, District 10, Ho Chi Minh City</td>
                                    <td><a href="https://www.google.com/maps" target="_blank" class="map-link">View Map</a></td>
                                </tr>
                                <tr>
                                    <td>District 1 Partner Center</td>
                                    <td><span class="type-badge type-hybrid">Hybrid</span></td>
                                    <td>District 1, Ho Chi Minh City</td>
                                    <td><a href="https://www.google.com/maps" target="_blank" class="map-link">View Map</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>

                <!-- Related Courses -->
                <section class="course-section related-courses">
                    <h2>Related Courses</h2>
                    <div class="related-courses-grid">
                        <?php
                        $relatedCourses = [
                            ['title' => 'JavaScript Essentials', 'instructor' => 'Tran Thi B', 'rating' => 4.6, 'price' => '399,000 VND'],
                            ['title' => 'HTML CSS Responsive Web Design', 'instructor' => 'Le Van C', 'rating' => 4.7, 'price' => '449,000 VND'],
                            ['title' => 'SQL Database Design Basics', 'instructor' => 'Pham Thi D', 'rating' => 4.5, 'price' => '379,000 VND']
                        ];

                        foreach ($relatedCourses as $course) {
                            ?>
                            <div class="course-card-mini">
                                <div class="course-thumbnail-mini">
                                    <div class="thumbnail-placeholder-mini">Course</div>
                                </div>
                                <div class="course-info-mini">
                                    <h4><?php echo htmlspecialchars($course['title']); ?></h4>
                                    <p class="instructor-name"><?php echo htmlspecialchars($course['instructor']); ?></p>
                                    <div class="rating-price">
                                        <span class="rating"><span class="stars">★</span> <?php echo $course['rating']; ?></span>
                                        <span class="price"><?php echo htmlspecialchars($course['price']); ?></span>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </section>
            </div>

            <!-- Purchase Card Sidebar -->
            <aside class="course-sidebar">
                <div class="purchase-card">
                    <div class="course-thumbnail-large">
                        <div class="thumbnail-placeholder-large">Course Thumbnail</div>
                    </div>

                    <div class="course-price">
                        <h3>499,000 VND</h3>
                    </div>

                    <div class="purchase-buttons">
                        <button class="btn btn-primary btn-add-cart">Add to Cart</button>
                        <button class="btn btn-secondary btn-enroll">Enroll Now</button>
                    </div>

                    <div class="course-includes">
                        <h4>This course includes:</h4>
                        <ul>
                            <li>12 hours of content</li>
                            <li>24 lessons</li>
                            <li>Lifetime access</li>
                            <li>Certificate demo</li>
                        </ul>
                    </div>
                </div>
            </aside>
        </div>
    </section>
</main>
