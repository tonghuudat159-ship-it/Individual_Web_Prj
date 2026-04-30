<?php
/**
 * Course Detail View
 * Shows complete course information, instructor details, lessons, locations, and related courses
 */

$breadcrumbs = [
    [
        'label' => 'Home',
        'url' => base_url('index.php'),
    ],
    [
        'label' => 'Courses',
        'url' => base_url('courses.php'),
    ],
];

if ($course !== null) {
    $breadcrumbs[] = [
        'label' => $course['category_name'],
        'url' => base_url('courses.php?category=' . urlencode($course['category_slug'])),
    ];
    $breadcrumbs[] = [
        'label' => $course['title'],
        'url' => null,
    ];
} else {
    $breadcrumbs[] = [
        'label' => 'Course Not Found',
        'url' => null,
    ];
}

$courseThumbnailPath = $course !== null ? trim((string) ($course['thumbnail'] ?? '')) : '';
$courseThumbnailFile = ROOT_PATH . '/public/images/' . ltrim($courseThumbnailPath, '/');
$hasCourseThumbnail = $courseThumbnailPath !== '' && file_exists($courseThumbnailFile);

$instructorAvatarPath = $course !== null ? trim((string) ($course['instructor_avatar'] ?? '')) : '';
$instructorAvatarFile = ROOT_PATH . '/public/images/' . ltrim($instructorAvatarPath, '/');
$hasInstructorAvatar = $instructorAvatarPath !== '' && file_exists($instructorAvatarFile);

$priceText = $course !== null ? number_format((float) $course['price'], 0, ',', '.') . ' VND' : '';
$lessonCount = count($lessons);
$loginRedirectUrl = $course !== null
    ? base_url('login.php?redirect=' . urlencode('course-detail.php?slug=' . $course['slug']))
    : base_url('login.php');
?>
<main class="main-content">
    <?php require APP_PATH . '/views/partials/breadcrumb.php'; ?>

    <?php if ($course === null): ?>
        <section class="course-not-found-section">
            <div class="course-not-found-container">
                <h1>Course not found</h1>
                <p>The course you are looking for does not exist or is no longer available.</p>
                <?php if ($courseError !== ''): ?>
                    <div class="courses-message courses-message-error"><?php echo htmlspecialchars($courseError); ?></div>
                <?php endif; ?>
                <a href="<?php echo base_url('courses.php'); ?>" class="btn btn-secondary">Back to Courses</a>
            </div>
        </section>
    <?php else: ?>
        <section class="course-hero">
            <div class="course-hero-container">
                <div class="course-hero-content">
                    <h1><?php echo htmlspecialchars($course['title']); ?></h1>
                    <p class="course-description"><?php echo htmlspecialchars($course['short_description']); ?></p>

                    <div class="course-meta-info">
                        <div class="meta-item">
                            <span class="meta-label">Rating:</span>
                            <span class="meta-value"><span class="stars">&#9733;</span> <?php echo htmlspecialchars((string) $course['rating']); ?></span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">Students:</span>
                            <span class="meta-value"><?php echo number_format((int) $course['total_students']); ?></span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">Instructor:</span>
                            <span class="meta-value"><?php echo htmlspecialchars($course['instructor_name']); ?></span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">Language:</span>
                            <span class="meta-value"><?php echo htmlspecialchars($course['language']); ?></span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">Level:</span>
                            <span class="meta-value"><?php echo htmlspecialchars($course['level']); ?></span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">Duration:</span>
                            <span class="meta-value"><?php echo htmlspecialchars((string) $course['duration_hours']); ?> hours</span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">Category:</span>
                            <span class="meta-value"><?php echo htmlspecialchars($course['category_name']); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="course-content-section">
            <div class="course-content-container">
                <div class="course-main">
                    <?php if ($courseError !== ''): ?>
                        <div class="courses-message courses-message-error"><?php echo htmlspecialchars($courseError); ?></div>
                    <?php endif; ?>

                    <section class="course-section learning-outcomes">
                        <h2>What You Will Learn</h2>
                        <div class="learning-grid">
                            <div class="learning-item">
                                <span class="checkmark">&#10003;</span>
                                <p>Build practical skills through this course</p>
                            </div>
                            <div class="learning-item">
                                <span class="checkmark">&#10003;</span>
                                <p>Understand the key concepts step by step</p>
                            </div>
                            <div class="learning-item">
                                <span class="checkmark">&#10003;</span>
                                <p>Apply knowledge in real-world examples</p>
                            </div>
                            <div class="learning-item">
                                <span class="checkmark">&#10003;</span>
                                <p>Learn from structured lessons and instructor guidance</p>
                            </div>
                        </div>
                    </section>

                    <section class="course-section course-curriculum">
                        <h2>Course Content</h2>
                        <?php if (!empty($lessons)): ?>
                            <div class="lessons-list">
                                <?php foreach ($lessons as $lesson): ?>
                                    <div class="lesson-item">
                                        <div class="lesson-order-block">
                                            <span class="lesson-number"><?php echo (int) $lesson['sort_order']; ?></span>
                                        </div>
                                        <div class="lesson-content">
                                            <span class="lesson-title"><?php echo htmlspecialchars($lesson['title']); ?></span>
                                            <div class="lesson-meta">
                                                <span><?php echo (int) $lesson['duration_minutes']; ?> min</span>
                                                <?php if ((int) $lesson['is_preview'] === 1): ?>
                                                    <span class="preview-badge">Preview</span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <p class="course-empty-text">No lessons available yet.</p>
                        <?php endif; ?>
                    </section>

                    <section class="course-section instructor-section">
                        <h2>Meet Your Instructor</h2>
                        <div class="instructor-card">
                            <div class="instructor-avatar">
                                <?php if ($hasInstructorAvatar): ?>
                                    <img
                                        src="<?php echo htmlspecialchars(asset('images/' . ltrim($instructorAvatarPath, '/'))); ?>"
                                        alt="<?php echo htmlspecialchars($course['instructor_name']); ?>"
                                        class="instructor-avatar-image"
                                    >
                                <?php else: ?>
                                    <div class="avatar-placeholder">
                                        <?php echo htmlspecialchars(strtoupper(substr($course['instructor_name'], 0, 1))); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="instructor-info">
                                <h3><?php echo htmlspecialchars($course['instructor_name']); ?></h3>
                                <?php if (!empty($course['instructor_expertise'])): ?>
                                    <p class="instructor-expertise"><?php echo htmlspecialchars($course['instructor_expertise']); ?></p>
                                <?php endif; ?>
                                <p><?php echo htmlspecialchars($course['instructor_bio'] ?: 'Instructor information will be updated soon.'); ?></p>
                            </div>
                        </div>
                    </section>

                    <section class="course-section locations-section">
                        <h2>Learning Support Locations</h2>
                        <?php if (!empty($locations)): ?>
                            <div class="locations-table-wrapper">
                                <table class="locations-table">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Type</th>
                                            <th>Address</th>
                                            <th>Support</th>
                                            <th>Availability</th>
                                            <th>Map</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($locations as $location): ?>
                                            <?php $typeClass = 'type-' . htmlspecialchars($location['type']); ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($location['name']); ?></td>
                                                <td><span class="type-badge <?php echo $typeClass; ?>"><?php echo htmlspecialchars(ucfirst($location['type'])); ?></span></td>
                                                <td>
                                                    <?php echo htmlspecialchars($location['address']); ?><br>
                                                    <span class="location-city"><?php echo htmlspecialchars($location['city']); ?></span>
                                                </td>
                                                <td><?php echo htmlspecialchars($location['support_type'] ?: 'Support available'); ?></td>
                                                <td><?php echo htmlspecialchars($location['availability_note'] ?: 'Available for enrolled students'); ?></td>
                                                <td>
                                                    <?php if ($location['type'] !== 'online' && !empty($location['google_maps_url'])): ?>
                                                        <a href="<?php echo htmlspecialchars($location['google_maps_url']); ?>" target="_blank" rel="noopener" class="map-link">View Map</a>
                                                    <?php else: ?>
                                                        <span class="online-support-label">Online Support</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <p class="course-empty-text">No learning support locations available yet.</p>
                        <?php endif; ?>
                    </section>

                    <?php if (!empty($relatedCourses)): ?>
                        <section class="course-section related-courses">
                            <h2>Related Courses</h2>
                            <div class="related-courses-grid">
                                <?php $currentCourse = $course; ?>
                                <?php foreach ($relatedCourses as $relatedCourse): ?>
                                    <?php $course = $relatedCourse; ?>
                                    <?php require APP_PATH . '/views/partials/course-card.php'; ?>
                                <?php endforeach; ?>
                                <?php $course = $currentCourse; ?>
                            </div>
                        </section>
                    <?php endif; ?>
                </div>

                <aside class="course-sidebar">
                    <div class="purchase-card">
                        <div class="course-thumbnail-large">
                            <?php if ($hasCourseThumbnail): ?>
                                <img
                                    src="<?php echo htmlspecialchars(asset('images/' . ltrim($courseThumbnailPath, '/'))); ?>"
                                    alt="<?php echo htmlspecialchars($course['title']); ?>"
                                    class="course-thumbnail-image"
                                >
                            <?php else: ?>
                                <div class="thumbnail-placeholder-large">DatEdu</div>
                            <?php endif; ?>
                        </div>

                        <div class="course-price">
                            <h3><?php echo htmlspecialchars($priceText); ?></h3>
                        </div>

                        <div class="purchase-buttons">
                            <?php if (!$isLoggedIn): ?>
                                <a href="<?php echo htmlspecialchars($loginRedirectUrl); ?>" class="btn btn-primary">Add to Cart</a>
                                <a href="<?php echo htmlspecialchars($loginRedirectUrl); ?>" class="btn btn-secondary btn-enroll">Enroll Now</a>
                                <p class="purchase-note">Please log in to add this course to your cart.</p>
                            <?php elseif ($isEnrolled): ?>
                                <p class="purchase-status purchase-status-success">You are already enrolled in this course.</p>
                                <a href="<?php echo base_url('my-learning.php'); ?>" class="btn btn-primary">Go to My Learning</a>
                            <?php elseif ($isInCart): ?>
                                <p class="purchase-status purchase-status-info">This course is already in your cart.</p>
                                <a href="<?php echo base_url('cart.php'); ?>" class="btn btn-primary">Go to Cart</a>
                                <a href="<?php echo base_url('courses.php'); ?>" class="btn btn-secondary">Continue Browsing</a>
                            <?php else: ?>
                                <button
                                    type="button"
                                    class="btn btn-primary add-to-cart-btn"
                                    data-course-id="<?php echo (int) $course['course_id']; ?>"
                                >
                                    Add to Cart
                                </button>
                                <a href="<?php echo base_url('cart.php'); ?>" class="btn btn-secondary btn-enroll">Enroll Now</a>
                                <div id="cartMessage" class="cart-message" aria-live="polite"></div>
                                <p class="purchase-note">Add this course to your cart first, then continue to checkout to complete your enrollment.</p>
                            <?php endif; ?>
                        </div>

                        <div class="course-includes">
                            <h4>This course includes:</h4>
                            <ul>
                                <li><?php echo htmlspecialchars((string) $course['duration_hours']); ?> hours of content</li>
                                <li><?php echo $lessonCount; ?> lessons</li>
                                <li>Lifetime access</li>
                                <li>Certificate demo</li>
                            </ul>
                        </div>
                    </div>
                </aside>
            </div>
        </section>
    <?php endif; ?>
</main>
