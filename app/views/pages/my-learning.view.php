<?php
/**
 * My Learning View
 * Shows enrolled courses and learning progress
 */
?>
<main class="main-content">
    <div class="container">
        <!-- Breadcrumb -->
        <div class="breadcrumb">
            <a href="<?php echo base_url('/'); ?>">Home</a>
            <span> > </span>
            <span>My Learning</span>
        </div>

        <!-- Page Title -->
        <h1 class="page-title">My Learning</h1>
        <p class="page-subtitle">Continue learning from your enrolled courses.</p>

        <!-- Enrolled Courses Grid -->
        <div class="my-learning-grid">
            <!-- Course 1 -->
            <div class="my-learning-card">
                <div class="course-badge">
                    <span class="badge-text">Enrolled</span>
                </div>
                
                <div class="learning-card-content">
                    <h3 class="learning-course-title">PHP & MySQL Web Development for Beginners</h3>
                    <p class="learning-course-instructor">Instructor: Nguyen Van A</p>
                    
                    <div class="learning-card-meta">
                        <span class="meta-item">
                            <span class="meta-label">Enrolled:</span>
                            <span class="meta-value">28/04/2026</span>
                        </span>
                        <span class="meta-item">
                            <span class="meta-label">Status:</span>
                            <span class="meta-value status-active">Active</span>
                        </span>
                    </div>
                </div>

                <div class="learning-card-footer">
                    <a href="<?php echo base_url('course-detail.php?slug=php-mysql-web-development'); ?>" class="btn btn-primary btn-sm">Start Learning</a>
                </div>
            </div>

            <!-- Course 2 -->
            <div class="my-learning-card">
                <div class="course-badge">
                    <span class="badge-text">Enrolled</span>
                </div>
                
                <div class="learning-card-content">
                    <h3 class="learning-course-title">JavaScript Essentials</h3>
                    <p class="learning-course-instructor">Instructor: Tran Thi B</p>
                    
                    <div class="learning-card-meta">
                        <span class="meta-item">
                            <span class="meta-label">Enrolled:</span>
                            <span class="meta-value">28/04/2026</span>
                        </span>
                        <span class="meta-item">
                            <span class="meta-label">Status:</span>
                            <span class="meta-value status-active">Active</span>
                        </span>
                    </div>
                </div>

                <div class="learning-card-footer">
                    <a href="<?php echo base_url('course-detail.php?slug=javascript-essentials'); ?>" class="btn btn-primary btn-sm">Start Learning</a>
                </div>
            </div>
        </div>
    </div>
</main>
