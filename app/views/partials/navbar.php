<?php
/**
 * Navbar Partial
 * Navigation bar with main menu and active page highlighting
 */

if (!function_exists('isLoggedIn') && defined('APP_PATH')) {
    require_once APP_PATH . '/helpers/auth.php';
}

// Determine if a nav item is active
function isActive($page) {
    global $activePage;
    return $activePage === $page ? 'active' : '';
}
?>
<header class="header">
    <div class="header-container">
        <div class="navbar-logo">
            <a href="<?php echo base_url('index.php'); ?>" class="navbar-logo-link">
                <h1><?php echo APP_NAME; ?></h1>
            </a>
        </div>
        <button class="navbar-toggle" id="navbar-toggle" aria-label="Toggle menu">
            <span class="hamburger">&#9776;</span>
        </button>
        <nav class="site-navbar navbar-links" id="navbar-links">
            <ul class="nav-list">
                <li><a href="<?php echo base_url('index.php'); ?>" class="nav-link <?php echo isActive('home'); ?>">Home</a></li>
                <li><a href="<?php echo base_url('courses.php'); ?>" class="nav-link <?php echo isActive('courses'); ?>">Courses</a></li>
                <li class="nav-search-item">
                    <div class="navbar-search">
                        <input
                            id="courseSearchInput"
                            class="search-input"
                            type="text"
                            placeholder="Search for courses"
                            autocomplete="off"
                        >
                        <div id="searchResults" class="search-results"></div>
                    </div>
                </li>
                <li><a href="<?php echo base_url('contact.php'); ?>" class="nav-link <?php echo isActive('contact'); ?>">Contact</a></li>
                <li><a href="<?php echo base_url('cart.php'); ?>" class="nav-link <?php echo isActive('cart'); ?>">Cart</a></li>
                <li><a href="<?php echo base_url('my-learning.php'); ?>" class="nav-link <?php echo isActive('my-learning'); ?>">My Learning</a></li>

                <?php if (function_exists('isLoggedIn') && isLoggedIn()): ?>
                    <li class="nav-user-greeting">Hello, <?php echo htmlspecialchars(currentUserName() ?? 'Student'); ?></li>
                    <li><a href="<?php echo base_url('logout.php'); ?>" class="nav-link">Logout</a></li>
                <?php else: ?>
                    <li><a href="<?php echo base_url('login.php'); ?>" class="nav-link <?php echo isActive('login'); ?>">Login</a></li>
                    <li><a href="<?php echo base_url('register.php'); ?>" class="nav-link <?php echo isActive('register'); ?>">Register</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>
