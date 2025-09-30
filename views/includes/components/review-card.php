<?php
function renderReviewCard($reviewerImage, $reviewerName, $timeAgo, $rating, $content)
{
    if (empty($reviewerName) || empty($content)) {
        return;
    }
?>
    <div class="col-lg-4 mb-4">
        <div class="review-card">
            <div class="review-header d-flex justify-content-between align-items-start mb-4">
                <div class="reviewer-info">
                    <img src="<?php echo htmlspecialchars($reviewerImage); ?>"
                        alt="<?php echo htmlspecialchars($reviewerName); ?>"
                        class="reviewer-image"
                        loading="lazy">
                    <div class="reviewer-details">
                        <h5 class="reviewer-name"><?php echo htmlspecialchars($reviewerName); ?></h5>
                        <span class="review-time"><?php echo htmlspecialchars($timeAgo); ?></span>
                    </div>
                </div>
                <div class="review-rating">
                    <?php for ($i = 0; $i < 5; $i++): ?>
                        <i class="fa<?php echo $i < $rating ? 's' : 'r'; ?> fa-star"></i>
                    <?php endfor; ?>
                </div>
            </div>
            <div class="review-content">
                <p><?php echo htmlspecialchars($content); ?></p>
            </div>
        </div>
    </div>
<?php
}

function renderReviewsSection($reviews)
{

?>
    <section class="reviews-section">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Students Reviews</h2>
                <p class="section-subtitle">Read what our students have to say about their learning experience and success stories with our dedicated tutors.</p>
            </div>

            <div class="reviews-grid">
                <div class="row g-3">
                    <?php
                    if (!is_array($reviews) || empty($reviews)) {

                         echo ' 
                                        <h5 class="text-center">No Reviews Found</h5>
                                    ';
                    } else {
                        foreach ($reviews as $review) {
                            if (is_array($review) && count($review) >= 5) {
                                renderReviewCard($review[0], $review[1], $review[2], $review[3], $review[4]);
                            }
                        }
                       
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>
<?php
}
