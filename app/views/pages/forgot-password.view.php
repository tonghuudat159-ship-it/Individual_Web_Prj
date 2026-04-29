<?php
/**
 * Forgot Password View
 * Password recovery form
 */
?>
<main class="main-content">
    <div class="auth-container">
        <div class="auth-card">
            <h1>Forgot your password?</h1>
            <p class="auth-description">Enter your email address and DatEdu will generate a demo reset link later.</p>

            <form class="auth-form" method="post" action="#">
                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" class="form-input" placeholder="your@email.com" required>
                </div>

                <button type="submit" class="btn btn-primary btn-auth">Generate Reset Link</button>
            </form>

            <div class="auth-links">
                <p>
                    <a href="<?php echo base_url('login.php'); ?>" class="auth-link">← Back to Login</a>
                </p>
            </div>
        </div>
    </div>
</main>
