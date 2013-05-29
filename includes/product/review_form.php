<form action="product.php?id=<?php echo $product["id"]; ?>&amp;action=add_review" method="post">
    <div class="form">
        <div class="form_row">
            <div class="form_label">Rating</div>
            <div class="form_field">
                <select name="rating">
                    <option value="">-- Select one --</option>
                    <option value="0" <?php if ($review_rating == 0) { echo "selected"; } ?>>No stars</option>
                    <option value="1" <?php if ($review_rating == 1) { echo "selected"; } ?>>1 star</option>
                    <option value="2" <?php if ($review_rating == 2) { echo "selected"; } ?>>2 stars</option>
                    <option value="3" <?php if ($review_rating == 3) { echo "selected"; } ?>>3 stars</option>
                    <option value="4" <?php if ($review_rating == 4) { echo "selected"; } ?>>4 stars</option>
                    <option value="5" <?php if ($review_rating == 5) { echo "selected"; } ?>>5 stars</option>
                </select>
                <div class="form_error"><?php if ($review_rating_error) { echo $review_rating_error; } ?></div>
            </div>
        </div>
        <div class="form_row">
            <div class="form_label">Comment</div>
            <div class="form_field">
                <textarea name="comment"><?php echo $review_comment; ?></textarea>
                <div class="form_error"><?php if ($review_comment_error) { echo $review_comment_error; } ?></div>
            </div>
        </div>
        <div class="form_row">
            <input type="submit" value="Submit review" />
        </div>
    </div>
</form>
