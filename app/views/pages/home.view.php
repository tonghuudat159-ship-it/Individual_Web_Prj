<?php
/**
 * Home Page View
 * Homepage content with hero section and popular categories
 */
?>
<main class="main-content">
    <section class="hero">
        <div class="hero-content">
            <h2>Learn skills that move your future forward</h2>
            <p>Explore practical online courses in programming, business, design, and more.</p>
            <a href="<?php echo base_url('courses.php'); ?>" class="btn btn-primary">Explore Courses</a>
        </div>
    </section>

    <?php if (!empty($homeError)): ?>
        <section class="home-status-section">
            <div class="home-status-container">
                <div class="home-status-message">
                    <?php echo htmlspecialchars($homeError); ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <section class="categories-section popular-categories">
        <div class="categories-container">
            <h3 class="section-title">Popular Categories</h3>
            <p class="section-subtitle">Browse practical learning paths across the subjects students explore most.</p>
            <div class="categories-grid">
                <?php if (!empty($categories)): ?>
                    <?php foreach ($categories as $category): ?>
                        <article class="category-card">
                            <h4><?php echo htmlspecialchars($category['name']); ?></h4>
                            <p>
                                <?php echo htmlspecialchars($category['description'] ?: 'Explore practical courses designed to help you build useful skills.'); ?>
                            </p>
                            <a href="<?php echo base_url('courses.php?category=' . urlencode($category['slug'])); ?>" class="btn btn-secondary">View Courses</a>
                        </article>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="empty-state-message">Categories will appear here once they are available.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section class="home-featured-section featured-courses">
        <div class="courses-container">
            <h3 class="section-title">Featured Courses</h3>
            <p class="section-subtitle">Start with some of DatEdu's most popular and highly rated learning options.</p>

            <?php if (!empty($featuredCourses)): ?>
                <div class="courses-grid">
                    <?php foreach ($featuredCourses as $course): ?>
                        <?php require APP_PATH . '/views/partials/course-card.php'; ?>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="empty-state-message">No featured courses available yet.</p>
            <?php endif; ?>
        </div>
    </section>
</main>
