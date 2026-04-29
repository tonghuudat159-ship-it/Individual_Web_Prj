<?php
/**
 * Courses Listing View
 * Displays all courses with filters, sorting, and pagination
 */

$breadcrumbs = [
    [
        'label' => 'Home',
        'url' => base_url('index.php'),
    ],
    [
        'label' => 'Courses',
        'url' => $selectedCategory !== null ? base_url('courses.php') : null,
    ],
];

if ($selectedCategory !== null) {
    $breadcrumbs[] = [
        'label' => $selectedCategory['name'],
        'url' => null,
    ];
}

$heading = $selectedCategory !== null ? $selectedCategory['name'] . ' Courses' : 'All Online Courses';
$courseCountOnPage = count($courses);

$buildCoursesUrl = function (array $overrides = []) use ($categorySlug, $sort, $page) {
    $params = [];

    if ($categorySlug !== null && $categorySlug !== '') {
        $params['category'] = $categorySlug;
    }

    if ($sort !== 'newest') {
        $params['sort'] = $sort;
    }

    if ($page > 1) {
        $params['page'] = $page;
    }

    foreach ($overrides as $key => $value) {
        if ($value === null || $value === '' || $value === false) {
            unset($params[$key]);
        } else {
            $params[$key] = $value;
        }
    }

    $query = http_build_query($params);

    return base_url('courses.php' . ($query !== '' ? '?' . $query : ''));
};

$sortOptions = [
    'newest' => 'Newest',
    'price_asc' => 'Price: Low to High',
    'price_desc' => 'Price: High to Low',
    'rating_desc' => 'Highest Rated',
    'title_asc' => 'Title A-Z',
    'popular' => 'Most Popular',
];
?>
<main class="main-content">
    <?php require APP_PATH . '/views/partials/breadcrumb.php'; ?>

    <section class="page-header">
        <div class="page-header-container">
            <h1><?php echo htmlspecialchars($heading); ?></h1>
            <p>Browse practical courses designed to help you build real-world skills.</p>
        </div>
    </section>

    <section class="courses-catalog-section courses-page">
        <div class="courses-container">
            <div class="courses-catalog-layout">
                <aside class="courses-sidebar">
                    <div class="sidebar-card">
                        <h2 class="sidebar-title">Categories</h2>
                        <ul class="category-filter-list">
                            <li>
                                <a
                                    href="<?php echo $buildCoursesUrl(['category' => null, 'page' => null]); ?>"
                                    class="category-filter-link <?php echo $selectedCategory === null ? 'active' : ''; ?>"
                                >
                                    All Courses
                                </a>
                            </li>
                            <?php foreach ($categories as $category): ?>
                                <li>
                                    <a
                                        href="<?php echo $buildCoursesUrl(['category' => $category['slug'], 'page' => null]); ?>"
                                        class="category-filter-link <?php echo $selectedCategory !== null && $selectedCategory['slug'] === $category['slug'] ? 'active' : ''; ?>"
                                    >
                                        <?php echo htmlspecialchars($category['name']); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </aside>

                <div class="courses-main-area">
                    <?php if ($coursesError !== ''): ?>
                        <div class="courses-message courses-message-error">
                            <?php echo htmlspecialchars($coursesError); ?>
                        </div>
                    <?php endif; ?>

                    <section class="courses-toolbar courses-toolbar-panel">
                        <div class="toolbar-container">
                            <div class="courses-toolbar-content">
                                <p class="courses-count-text">Showing <?php echo $courseCountOnPage; ?> courses</p>

                                <form method="get" action="<?php echo base_url('courses.php'); ?>" class="courses-sort-form">
                                    <?php if ($selectedCategory !== null): ?>
                                        <input type="hidden" name="category" value="<?php echo htmlspecialchars($selectedCategory['slug']); ?>">
                                    <?php endif; ?>

                                    <label for="sort" class="sort-label">Sort by</label>
                                    <select name="sort" id="sort" class="filter-select">
                                        <?php foreach ($sortOptions as $sortValue => $sortLabel): ?>
                                            <option value="<?php echo htmlspecialchars($sortValue); ?>" <?php echo $sort === $sortValue ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($sortLabel); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <button type="submit" class="btn btn-secondary sort-submit-btn">Apply</button>
                                </form>
                            </div>
                        </div>
                    </section>

                    <?php if (!empty($courses)): ?>
                        <div class="courses-grid">
                            <?php foreach ($courses as $course): ?>
                                <?php require APP_PATH . '/views/partials/course-card.php'; ?>
                            <?php endforeach; ?>
                        </div>
                    <?php elseif ($coursesError === ''): ?>
                        <div class="courses-message courses-message-empty">
                            No courses found.
                        </div>
                    <?php endif; ?>

                    <?php if ($totalPages > 1): ?>
                        <nav class="pagination-nav" aria-label="Courses pagination">
                            <div class="pagination-list">
                                <?php if ($page > 1): ?>
                                    <a href="<?php echo $buildCoursesUrl(['page' => $page - 1]); ?>" class="pagination-link">Previous</a>
                                <?php else: ?>
                                    <span class="pagination-link disabled">Previous</span>
                                <?php endif; ?>

                                <?php for ($pageNumber = 1; $pageNumber <= $totalPages; $pageNumber++): ?>
                                    <a
                                        href="<?php echo $buildCoursesUrl(['page' => $pageNumber]); ?>"
                                        class="pagination-link <?php echo $pageNumber === $page ? 'active' : ''; ?>"
                                    >
                                        <?php echo $pageNumber; ?>
                                    </a>
                                <?php endfor; ?>

                                <?php if ($page < $totalPages): ?>
                                    <a href="<?php echo $buildCoursesUrl(['page' => $page + 1]); ?>" class="pagination-link">Next</a>
                                <?php else: ?>
                                    <span class="pagination-link disabled">Next</span>
                                <?php endif; ?>
                            </div>
                        </nav>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</main>
