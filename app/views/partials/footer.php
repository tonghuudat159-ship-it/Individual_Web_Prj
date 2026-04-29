<?php
/**
 * Footer Partial
 * Website footer with links, information, and closing HTML tags
 */
?>
<footer class="footer">
    <div class="footer-container">
        <div class="footer-content">
            <div class="footer-section">
                <h3><?php echo APP_NAME; ?></h3>
                <p>An online platform for practical courses in programming, business, design, and more.</p>
            </div>
            <div class="footer-section">
                <h4>Quick Links</h4>
                <ul class="footer-links">
                    <li><a href="<?php echo base_url('index.php'); ?>">Home</a></li>
                    <li><a href="<?php echo base_url('courses.php'); ?>">Courses</a></li>
                    <li><a href="<?php echo base_url('contact.php'); ?>">Contact</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Contact</h4>
                <p>Email: <a href="mailto:support@datedu.local">support@datedu.local</a></p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 DatEdu. All rights reserved.</p>
        </div>
    </div>
</footer>

<script src="<?php echo asset('js/main.js'); ?>"></script>
</body>
</html>
