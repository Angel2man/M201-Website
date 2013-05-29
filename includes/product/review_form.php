<form action="product.php?id=<?php echo $product["id"]; ?>&action=add_review" method="post">
    <div class="form">
        <div class="form_row">
            <div class="form_label">Rating</div>
            <div class="form_field">
                <select name="rating" value="<?php echo $review_rating; ?>">
                    <option value="">-- Select one --</option>
                    <option value="0">No stars</option>
                    <option value="1">1 star</option>
                    <option value="2">2 stars</option>
                    <option value="3">3 stars</option>
                    <option value="4">4 stars</option>
                    <option value="5">5 stars</option>
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
