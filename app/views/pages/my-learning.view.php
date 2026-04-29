<?php
/**
 * My Learning View
 * Shows enrolled courses and learning progress
 */

$breadcrumbs = [
    [
        'label' => 'Home',
        'url' => base_url('index.php'),
    ],
    [
        'label' => 'My Learning',
        'url' => null,
    ],
];
?>
<main class="main-content">
    <?php require APP_PATH . '/views/partials/breadcrumb.php'; ?>

    <section class="cart-page-section">
        <div class="cart-page-container">
            <h1 class="page-title">My Learning</h1>
            <p class="page-subtitle">Continue learning from your enrolled courses.</p>

            <?php if ($myLearningError !== ''): ?>
                <div class="courses-message courses-message-error"><?php echo htmlspecialchars($myLearningError); ?></div>
            <?php elseif (!empty($enrollments)): ?>
                <p class="courses-count-text">You are enrolled in <?php echo count($enrollments); ?> course(s).</p>
            <?php endif; ?>

            <?php if (empty($enrollments) && $myLearningError === ''): ?>
                <div class="cart-empty-state">
                    <h2>You have not enrolled in any courses yet.</h2>
                    <p>Browse DatEdu courses and complete checkout to start learning.</p>
                    <a href="<?php echo base_url('courses.php'); ?>" class="btn btn-primary">Browse Courses</a>
                </div>
            <?php elseif (!empty($enrollments)): ?>
                <div class="my-learning-grid">
                    <?php foreach ($enrollments as $enrollment): ?>
                        <?php
                        $thumbnailPath = trim((string) ($enrollment['thumbnail'] ?? ''));
                        $thumbnailFile = ROOT_PATH . '/public/images/' . ltrim($thumbnailPath, '/');
                        $hasThumbnail = $thumbnailPath !== '' && file_exists($thumbnailFile);
                        $statusClass = 'status-' . strtolower((string) $enrollment['enrollment_status']);
                        ?>
                        <div class="my-learning-card">
                            <div class="my-learning-thumbnail-wrap">
                                <?php if ($hasThumbnail): ?>
                                    <img
                                        src="<?php echo htmlspecialchars(asset('images/' . ltrim($thumbnailPath, '/'))); ?>"
                                        alt="<?php echo htmlspecialchars($enrollment['title']); ?>"
                                        class="my-learning-thumbnail"
                                    >
                                <?php else: ?>
                                    <div class="my-learning-thumbnail-placeholder">DatEdu</div>
                                <?php endif; ?>
                            </div>

                            <div class="course-badge">
                                <span class="badge-text"><?php echo htmlspecialchars(ucfirst((string) $enrollment['enrollment_status'])); ?></span>
                            </div>

                            <div class="learning-card-content">
                                <h3 class="learning-course-title"><?php echo htmlspecialchars($enrollment['title']); ?></h3>
                                <p class="learning-course-instructor">Instructor: <?php echo htmlspecialchars($enrollment['instructor_name']); ?></p>
                                <p class="learning-course-instructor">Category: <?php echo htmlspecialchars($enrollment['category_name']); ?></p>

                                <div class="learning-card-meta">
                                    <span class="meta-item">
                                        <span class="meta-label">Enrolled:</span>
                                        <span class="meta-value"><?php echo htmlspecialchars(formatDate($enrollment['enrolled_at'])); ?></span>
                                    </span>
                                    <span class="meta-item">
                                        <span class="meta-label">Status:</span>
                                        <span class="meta-value <?php echo htmlspecialchars($statusClass); ?>"><?php echo htmlspecialchars(ucfirst((string) $enrollment['enrollment_status'])); ?></span>
                                    </span>
                                </div>
                            </div>

                            <div class="learning-card-footer">
                                <a href="<?php echo htmlspecialchars(base_url('course-detail.php?slug=' . urlencode($enrollment['slug']))); ?>" class="btn btn-primary btn-sm">Start Learning</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>
