<?php
/**
 * Navbar Partial
 * Navigation bar with main menu and active page highlighting
 */

// Determine if a nav item is active
function isActive($page) {
    global $activePage;
    return $activePage === $page ? 'active' : '';
}
?>
<header class="header">
    <div class="header-container">
        <div class="navbar-logo">
            <h1><?php echo APP_NAME; ?></h1>
        </div>
        <button class="navbar-toggle" id="navbar-toggle" aria-label="Toggle menu">
            <span class="hamburger">☰</span>
        </button>
        <nav class="site-navbar navbar-links" id="navbar-links">
            <ul class="nav-list">
                <li><a href="<?php echo base_url('index.php'); ?>" class="nav-link <?php echo isActive('home'); ?>">Home</a></li>
                <li><a href="<?php echo base_url('courses.php'); ?>" class="nav-link <?php echo isActive('courses'); ?>">Courses</a></li>
                <li><a href="<?php echo base_url('courses.php'); ?>" class="nav-link <?php echo isActive('search'); ?>">Search</a></li>
                <li><a href="<?php echo base_url('contact.php'); ?>" class="nav-link <?php echo isActive('contact'); ?>">Contact</a></li>
                <li><a href="<?php echo base_url('cart.php'); ?>" class="nav-link <?php echo isActive('cart'); ?>">Cart</a></li>
                <li><a href="<?php echo base_url('my-learning.php'); ?>" class="nav-link <?php echo isActive('my-learning'); ?>">My Learning</a></li>
                <li><a href="<?php echo base_url('login.php'); ?>" class="nav-link <?php echo isActive('login'); ?>">Login</a></li>
                <li><a href="<?php echo base_url('register.php'); ?>" class="nav-link <?php echo isActive('register'); ?>">Register</a></li>
            </ul>
        </nav>
    </div>
</header>
