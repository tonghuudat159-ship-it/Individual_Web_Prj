<?php
/**
 * Flash Message Partial
 * Displays session flash messages for notifications
 */

// Display flash message if it exists in session
if (isset($_SESSION['flash_message'])) {
    $flash = $_SESSION['flash_message'];
    $class = isset($flash['type']) ? 'flash-' . htmlspecialchars($flash['type']) : 'flash-info';
    ?>
    <div class="flash-message <?php echo $class; ?>">
        <p><?php echo htmlspecialchars($flash['text']); ?></p>
    </div>
    <?php
    unset($_SESSION['flash_message']);
}
?>
