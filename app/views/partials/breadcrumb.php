<?php
/**
 * Breadcrumb Partial
 * Navigation breadcrumb for showing current page location
 */
?>
<?php if (!empty($breadcrumbs) && is_array($breadcrumbs)): ?>
    <nav class="breadcrumb-nav" aria-label="Breadcrumb">
        <div class="breadcrumb-container">
            <?php foreach ($breadcrumbs as $index => $item): ?>
                <?php if ($index > 0): ?>
                    <span class="breadcrumb-separator">&gt;</span>
                <?php endif; ?>

                <?php if (!empty($item['url']) && $index < count($breadcrumbs) - 1): ?>
                    <a href="<?php echo htmlspecialchars($item['url']); ?>"><?php echo htmlspecialchars($item['label']); ?></a>
                <?php else: ?>
                    <span class="breadcrumb-current"><?php echo htmlspecialchars($item['label']); ?></span>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </nav>
<?php endif; ?>
