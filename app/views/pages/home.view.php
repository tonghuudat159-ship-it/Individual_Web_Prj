<?php
/**
 * Home Page View
 * Homepage content with hero section and popular categories
 */
?>
<main class="main-content">
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h2>Learn skills that move your future forward</h2>
            <p>Explore practical online courses in programming, business, design, and more.</p>
            <a href="<?php echo base_url('courses.php'); ?>" class="btn btn-primary">Explore Courses</a>
        </div>
    </section>

    <!-- Popular Categories Section -->
    <section class="categories-section">
        <div class="categories-container">
            <h3 class="section-title">Popular Categories</h3>
            <div class="categories-grid">
                <?php
                // Static placeholder categories
                $categories = [
                    [
                        'name' => 'Web Development',
                        'description' => 'Learn web development with HTML, CSS, JavaScript, and more'
                    ],
                    [
                        'name' => 'Data Science',
                        'description' => 'Master data analysis and machine learning concepts'
                    ],
                    [
                        'name' => 'Business',
                        'description' => 'Improve business skills and leadership techniques'
                    ],
                    [
                        'name' => 'Design',
                        'description' => 'Create stunning designs with UI/UX principles'
                    ]
                ];

                foreach ($categories as $category) {
                    ?>
                    <div class="category-card">
                        <h4><?php echo htmlspecialchars($category['name']); ?></h4>
                        <p><?php echo htmlspecialchars($category['description']); ?></p>
                        <a href="<?php echo base_url('courses.php'); ?>" class="btn btn-secondary">View Courses</a>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </section>
</main>
