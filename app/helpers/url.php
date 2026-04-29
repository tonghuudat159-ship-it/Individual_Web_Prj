<?php
/**
 * URL Helper
 * Functions for URL generation, routing, and navigation
 */

/**
 * Generate base URL
 * @param string $path Optional path to append to base URL
 * @return string The base URL with optional path
 */
function base_url($path = '')
{
    $base = BASE_URL;
    
    if ($path !== '') {
        // Remove leading slash if present
        $path = ltrim($path, '/');
        // Combine base URL and path, ensuring single slash separator
        $base = rtrim($base, '/') . '/' . $path;
    }
    
    return $base;
}

/**
 * Generate asset URL
 * @param string $path Path to asset (css/style.css, js/main.js, images/logo.png, etc.)
 * @return string The full URL to the asset
 */
function asset($path = '')
{
    return base_url($path);
}

/**
 * Redirect to a page
 * @param string $path Path to redirect to
 * @return void
 */
function redirect($path)
{
    $url = base_url($path);
    header('Location: ' . $url);
    exit();
}
?>
