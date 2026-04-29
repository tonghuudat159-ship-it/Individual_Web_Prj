<?php
/**
 * Flash Message Partial
 * Displays session flash messages for notifications
 */

if (isset($_SESSION['flash_message'])) {
    $message = $_SESSION['flash_message'];
    $type = $_SESSION['flash_type'] ?? 'info';

    // Support both a simple string message and the older array format.
    if (is_array($message)) {
        $type = $message['type'] ?? $type;
        $message = $message['text'] ?? '';
    }

    if (is_string($message) && $message !== '') {
        ?>
        <div class="flash-message flash-<?php echo htmlspecialchars($type); ?>">
            <p><?php echo htmlspecialchars($message); ?></p>
        </div>
        <?php
    }

    unset($_SESSION['flash_message']);
    unset($_SESSION['flash_type']);
}
?>
