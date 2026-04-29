<?php
/**
 * Main Layout Template
 * Master layout file that wraps all pages with header, navbar, footer, etc.
 */

// $content variable should be passed from the page renderer (public/index.php)
// It contains the rendered page view HTML

// Include header with HTML head and opening body tag
require_once APP_PATH . '/views/partials/header.php';

// Include navbar
require_once APP_PATH . '/views/partials/navbar.php';

// Include flash message display
require_once APP_PATH . '/views/partials/flash-message.php';

// Render the page content
echo $content;

// Include footer with closing tags and scripts
require_once APP_PATH . '/views/partials/footer.php';
?>
