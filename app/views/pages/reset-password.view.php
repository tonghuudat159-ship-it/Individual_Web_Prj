<?php
/**
 * Reset Password View
 * Password reset form using email token
 */
?>
<main class="main-content">
    <div class="auth-container">
        <div class="auth-card auth-card-wide">
            <h1>Reset your password</h1>
            <p class="auth-description">Enter a new password for your DatEdu account.</p>

            <?php if (!empty($errors)): ?>
                <div class="auth-error-box">
                    <ul class="auth-error-list">
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if ($isTokenValid): ?>
                <form class="auth-form" method="post" action="">
                    <?php echo csrfField(); ?>
                    <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">

                    <div class="form-group">
                        <label for="new_password">New Password *</label>
                        <input
                            type="password"
                            id="new_password"
                            name="new_password"
                            class="form-input"
                            placeholder="Enter a new password"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">Confirm New Password *</label>
                        <input
                            type="password"
                            id="confirm_password"
                            name="confirm_password"
                            class="form-input"
                            placeholder="Confirm your new password"
                            required
                        >
                    </div>

                    <button type="submit" class="btn btn-primary btn-auth">Reset Password</button>
                </form>
            <?php else: ?>
                <div class="auth-links auth-links-spaced">
                    <p>
                        <a href="<?php echo base_url('forgot-password.php'); ?>" class="auth-link">Back to Forgot Password</a>
                    </p>
                </div>
            <?php endif; ?>

            <div class="auth-links">
                <p>
                    <a href="<?php echo base_url('login.php'); ?>" class="auth-link">Back to Login</a>
                </p>
            </div>
        </div>
    </div>
</main>
