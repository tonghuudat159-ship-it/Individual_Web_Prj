<?php
/**
 * Contact View
 * Contact form for user inquiries
 */
?>
<main class="main-content">
    <!-- Breadcrumb -->
    <nav class="breadcrumb-nav">
        <div class="breadcrumb-container">
            <a href="<?php echo base_url('index.php'); ?>">Home</a>
            <span class="breadcrumb-separator">></span>
            <span class="breadcrumb-current">Contact</span>
        </div>
    </nav>

    <!-- Page Header -->
    <section class="page-header">
        <div class="page-header-container">
            <h1>Contact DatEdu</h1>
            <p>Have questions about our courses? Send us a message.</p>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section">
        <div class="contact-container">
            <div class="contact-content">
                <!-- Contact Information -->
                <div class="contact-info">
                    <h2>Contact Information</h2>
                    <div class="info-item">
                        <h4>Email</h4>
                        <p>
                            <a href="mailto:support@datedu.local">support@datedu.local</a>
                        </p>
                    </div>
                    <div class="info-item">
                        <h4>Phone</h4>
                        <p><a href="tel:+84123456789">+84 123 456 789</a></p>
                    </div>
                    <div class="info-item">
                        <h4>Address</h4>
                        <p>Ho Chi Minh City, Vietnam</p>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="contact-form-wrapper">
                    <h2>Send us a Message</h2>
                    <form class="contact-form" method="post" action="#">
                        <div class="form-group">
                            <label for="fullname">Full Name *</label>
                            <input type="text" id="fullname" name="fullname" class="form-input" placeholder="Your Full Name" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email *</label>
                            <input type="email" id="email" name="email" class="form-input" placeholder="Your Email Address" required>
                        </div>

                        <div class="form-group">
                            <label for="subject">Subject *</label>
                            <input type="text" id="subject" name="subject" class="form-input" placeholder="Message Subject" required>
                        </div>

                        <div class="form-group">
                            <label for="message">Message *</label>
                            <textarea id="message" name="message" class="form-textarea" placeholder="Your Message" rows="5" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>
