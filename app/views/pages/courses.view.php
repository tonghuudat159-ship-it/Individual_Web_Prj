<?php
/**
 * Courses Listing View
 * Displays all courses with filters, sorting, and pagination
 */
?>
<main class="main-content">
    <!-- Breadcrumb -->
    <nav class="breadcrumb-nav">
        <div class="breadcrumb-container">
            <a href="<?php echo base_url('index.php'); ?>">Home</a>
            <span class="breadcrumb-separator">></span>
            <span class="breadcrumb-current">Courses</span>
        </div>
    </nav>

    <!-- Page Header -->
    <section class="page-header">
        <div class="page-header-container">
            <h1>All Online Courses</h1>
            <p>Browse practical courses designed to help you build real-world skills.</p>
        </div>
    </section>

    <!-- Courses Toolbar -->
    <section class="courses-toolbar">
        <div class="toolbar-container">
            <div class="toolbar-filters">
                <select class="filter-select" disabled>
                    <option>Category Filter (Coming Soon)</option>
                </select>
                <select class="filter-select" disabled>
                    <option>Sort By (Coming Soon)</option>
                </select>
            </div>
        </div>
    </section>

    <!-- Courses Grid -->
    <section class="courses-section">
        <div class="courses-container">
            <div class="courses-grid">
                <?php
                // Static placeholder courses
                $courses = [
                    [
                        'title' => 'PHP & MySQL Web Development',
                        'instructor' => 'Nguyen Van A',
                        'rating' => 4.7,
                        'price' => '499,000 VND',
                        'slug' => 'php-mysql-web-development'
                    ],
                    [
                        'title' => 'JavaScript Essentials',
                        'instructor' => 'Tran Thi B',
                        'rating' => 4.6,
                        'price' => '399,000 VND',
                        'slug' => 'javascript-essentials'
                    ],
                    [
                        'title' => 'Python for Data Analysis',
                        'instructor' => 'Le Van C',
                        'rating' => 4.8,
                        'price' => '599,000 VND',
                        'slug' => 'python-for-data-analysis'
                    ],
                    [
                        'title' => 'UI/UX Design Fundamentals',
                        'instructor' => 'Pham Thi D',
                        'rating' => 4.5,
                        'price' => '349,000 VND',
                        'slug' => 'ui-ux-design-fundamentals'
                    ]
                ];

                foreach ($courses as $course) {
                    ?>
                    <div class="course-card">
                        <div class="course-thumbnail">
                            <div class="thumbnail-placeholder">
                                <span class="placeholder-text">Course Thumbnail</span>
                            </div>
                        </div>
                        <div class="course-info">
                            <h3 class="course-title"><?php echo htmlspecialchars($course['title']); ?></h3>
                            <p class="course-instructor">by <?php echo htmlspecialchars($course['instructor']); ?></p>
                            <div class="course-meta">
                                <div class="rating">
                                    <span class="stars">★</span>
                                    <span class="rating-value"><?php echo $course['rating']; ?></span>
                                </div>
                                <div class="price">
                                    <?php echo htmlspecialchars($course['price']); ?>
                                </div>
                            </div>
                            <a href="<?php echo base_url('course-detail.php?slug=' . $course['slug']); ?>" class="btn btn-secondary">View Details</a>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </section>
</main>
