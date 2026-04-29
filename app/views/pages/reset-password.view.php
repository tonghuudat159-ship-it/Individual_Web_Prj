<?php
/**
 * Reset Password View
 * Password reset form using email token
 */
?>
<main class="main-content">
    <div class="auth-container">
        <div class="auth-card">
            <h1>Reset your password</h1>
            <p class="auth-description">Enter a new password for your DatEdu account.</p>

            <form class="auth-form" method="post" action="#">
                <div class="form-group">
                    <label for="new_password">New Password *</label>
                    <input type="password" id="new_password" name="new_password" class="form-input" placeholder="Enter a new password" required>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirm New Password *</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-input" placeholder="Confirm your new password" required>
                </div>

                <button type="submit" class="btn btn-primary btn-auth">Reset Password</button>
            </form>

            <div class="auth-links">
                <p>
                    <a href="<?php echo base_url('login.php'); ?>" class="auth-link">← Back to Login</a>
                </p>
            </div>
        </div>
    </div>
</main>
