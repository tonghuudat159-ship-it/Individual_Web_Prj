<?php
/**
 * Register View
 * User registration form
 */
?>
<main class="main-content">
    <div class="auth-container">
        <div class="auth-card">
            <h1>Create your DatEdu account</h1>
            <p class="auth-description">Join DatEdu and start learning practical skills today.</p>

            <form class="auth-form" method="post" action="#">
                <div class="form-group">
                    <label for="fullname">Full Name *</label>
                    <input type="text" id="fullname" name="fullname" class="form-input" placeholder="Your Full Name" required>
                </div>

                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" class="form-input" placeholder="your@email.com" required>
                </div>

                <div class="form-group">
                    <label for="password">Password *</label>
                    <input type="password" id="password" name="password" class="form-input" placeholder="Enter a password" required>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirm Password *</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-input" placeholder="Confirm your password" required>
                </div>

                <button type="submit" class="btn btn-primary btn-auth">Create Account</button>
            </form>

            <div class="auth-links">
                <p>
                    Already have an account?
                    <a href="<?php echo base_url('login.php'); ?>" class="auth-link">Log in</a>
                </p>
            </div>
        </div>
    </div>
</main>
