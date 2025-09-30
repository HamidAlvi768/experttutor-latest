<?php if (!$canReview): ?>
<form method="post" action="<?= \yii\helpers\Url::to(['job/review', 'job_id' => $job_id, 'tutor_id' => $tutor_id]) ?>">
    <div>
        <label>Rate this tutor:</label>
        <div class="star-rating">
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <input type="radio" id="star<?= $i ?>" name="rating" value="<?= $i ?>">
                <label for="star<?= $i ?>">&#9733;</label>
            <?php endfor; ?>
        </div>
    </div>
    <div>
        <label for="review_message">Your Review:</label>
        <textarea name="review_message" id="review_message" rows="4" required></textarea>
    </div>
    <button type="submit" class="btn btn-success">Submit Review</button>
</form>
<?php endif; ?>