<?php
function renderSubjectCard($icon, $title, $description) {
    if (empty($title) ) {
        return;
    }
    ?>
    <div class="col-lg-3 col-md-6">
        <div class="subject-card">
            <div class="subject-icon"><?php echo htmlspecialchars($icon); ?></div>
            <h3><?php echo htmlspecialchars($title); ?></h3>
            <p><?php echo htmlspecialchars($description); ?></p>
        </div>
    </div>
    <?php
}

function renderSubjectsSection($subjects) {
    if (!is_array($subjects) || empty($subjects)) {
        return;
    }
    ?>
    <section class="subjects-section">
        <div class="container">
            <h2 class="section-title text-center">Browse Subject By Category</h2>
            <p class="section-subtitle text-center">School subjects can be categorized into various disciplines that students typically encounter throughout their education. Here's a list of common school subjects broken down into categories:</p>
            <div class="row g-4">
                <?php
                foreach ($subjects as $subject) {
                    if (is_array($subject) && count($subject) >= 3) {
                        renderSubjectCard($subject[0], $subject[1], $subject[2]);
                    }
                }
                ?>
            </div>
            <!-- <div class="text-center mt-5">
                <a href="#" class="btn btn-primary">Check More</a>
            </div> -->
        </div>
    </section>
    <?php
} 