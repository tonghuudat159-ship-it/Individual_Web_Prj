<?php
/**
 * Forgot Password View
 * Password recovery form
 */
?>
<main class="main-content">
    <div class="auth-container">
        <div class="auth-card auth-card-wide">
            <h1>Forgot your password?</h1>
            <p class="auth-description">
                Enter your email address and DatEdu will generate a demo reset link. Because this project runs locally on XAMPP, the link is displayed directly instead of being sent by email.
            </p>

            <?php if (!empty($errors)): ?>
                <div class="auth-error-box">
                    <ul class="auth-error-list">
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if ($demoResetLink !== null): ?>
                <div class="auth-success-box">
                    <p class="auth-success-title"><?php echo htmlspecialchars($successMessage); ?></p>
                    <p>
                        Demo reset link:
                        <a href="<?php echo htmlspecialchars($demoResetLink); ?>" class="auth-link auth-demo-link">
                            <?php echo htmlspecialchars($demoResetLink); ?>
                        </a>
                    </p>
                </div>
            <?php endif; ?>

            <form class="auth-form" method="post" action="">
                <?php echo csrfField(); ?>

                <div class="form-group">
                    <label for="email">Email *</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-input"
                        placeholder="your@email.com"
                        value="<?php echo htmlspecialchars($old['email'] ?? ''); ?>"
                        required
                    >
                </div>

                <button type="submit" class="btn btn-primary btn-auth">Generate Reset Link</button>
            </form>

            <div class="auth-links">
                <p>
                    <a href="<?php echo base_url('login.php'); ?>" class="auth-link">Back to Login</a>
                </p>
            </div>
        </div>
    </div>
</main>
