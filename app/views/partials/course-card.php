<?php
/**
 * Course Card Partial
 * Reusable course card component for displaying course information
 */

$thumbnailPath = isset($course['thumbnail']) ? trim((string) $course['thumbnail']) : '';
$thumbnailPublicPath = ROOT_PATH . '/public/images/' . ltrim($thumbnailPath, '/');
$hasThumbnail = $thumbnailPath !== '' && file_exists($thumbnailPublicPath);
$priceText = number_format((float) ($course['price'] ?? 0), 0, ',', '.') . ' VND';
?>
<article class="course-card">
    <div class="course-thumbnail">
        <?php if ($hasThumbnail): ?>
            <img
                src="<?php echo htmlspecialchars(asset('images/' . ltrim($thumbnailPath, '/'))); ?>"
                alt="<?php echo htmlspecialchars($course['title'] ?? 'Course thumbnail'); ?>"
                class="course-thumbnail-image"
            >
        <?php else: ?>
            <div class="thumbnail-placeholder">
                <span class="placeholder-text">DatEdu</span>
            </div>
        <?php endif; ?>
    </div>

    <div class="course-info">
        <div class="course-card-top">
            <span class="course-category-badge"><?php echo htmlspecialchars($course['category_name'] ?? 'Course'); ?></span>
            <?php if (!empty($course['is_featured'])): ?>
                <span class="course-featured-badge">Featured</span>
            <?php endif; ?>
        </div>

        <h4 class="course-title"><?php echo htmlspecialchars($course['title'] ?? 'Untitled Course'); ?></h4>
        <p class="course-instructor"><?php echo htmlspecialchars($course['instructor_name'] ?? 'DatEdu Instructor'); ?></p>
        <p class="course-description-text"><?php echo htmlspecialchars($course['short_description'] ?? 'Course description coming soon.'); ?></p>

        <div class="course-meta">
            <div class="rating">
                <span class="stars">&#9733;</span>
                <span class="rating-value"><?php echo htmlspecialchars((string) ($course['rating'] ?? '0.0')); ?></span>
            </div>
            <span class="course-students"><?php echo number_format((int) ($course['total_students'] ?? 0)); ?> students</span>
        </div>

        <div class="course-footer">
            <span class="price"><?php echo htmlspecialchars($priceText); ?></span>
            <a href="<?php echo base_url('course-detail.php?slug=' . urlencode($course['slug'] ?? '')); ?>" class="btn btn-secondary course-card-link">View Details</a>
        </div>
    </div>
</article>
