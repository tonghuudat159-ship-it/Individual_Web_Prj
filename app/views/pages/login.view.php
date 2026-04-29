<?php
/**
 * Login View
 * User login form
 */
?>
<main class="main-content">
    <div class="auth-container">
        <div class="auth-card">
            <h1>Log in to your DatEdu account</h1>
            <p class="auth-description">Continue learning with your enrolled courses.</p>

            <?php if (!empty($errors)): ?>
                <div class="auth-error-box">
                    <ul class="auth-error-list">
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form class="auth-form" method="post" action="">
                <?php echo csrfField(); ?>
                <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($redirectPath); ?>">

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

                <div class="form-group">
                    <label for="password">Password *</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-input"
                        placeholder="Enter your password"
                        required
                    >
                </div>

                <button type="submit" class="btn btn-primary btn-auth">Log In</button>
            </form>

            <div class="auth-links">
                <p>
                    <a href="<?php echo base_url('forgot-password.php'); ?>" class="auth-link">Forgot password?</a>
                </p>
                <p>
                    Don't have an account?
                    <a href="<?php echo base_url('register.php'); ?>" class="auth-link">Sign up</a>
                </p>
            </div>
        </div>
    </div>
</main>
