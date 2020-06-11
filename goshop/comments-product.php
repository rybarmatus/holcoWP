<?php 
global $post;
?>
<div class="row">
    <div class="col-md-6">
      <?php
      if(get_option('comment_registration') && !$user_ID) : ?>  
        <p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">logged in</a> to post a comment.</p><?php else : ?>  
        <form action="https://goshop.goup.sk/wp-comments-post.php" method="post" id="commentform">
          <div class="mb-1"><?= __('Hodnotenie produktu', 'goshop'); ?></div>
          <div class="post_rating_wrapper">
            <p class="stars pointer">
              <span data-score="1" title="1 <?= __('hviezdička', 'goshop'); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="far" data-icon="star" class="svg-inline--fa fa-star star-empty fa-w-18" role="img" viewBox="0 0 576 512"><path fill="currentColor" d="M528.1 171.5L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6zM388.6 312.3l23.7 138.4L288 385.4l-124.3 65.3 23.7-138.4-100.6-98 139-20.2 62.2-126 62.2 126 139 20.2-100.6 98z"/></svg>
                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" class="svg-inline--fa fa-star star-full fa-w-18" role="img" viewBox="0 0 576 512"><path fill="currentColor" d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z"/></svg>
              </span>
              <span data-score="2" title="2 <?= __('hviezdičky', 'goshop'); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="far" data-icon="star" class="svg-inline--fa fa-star star-empty fa-w-18" role="img" viewBox="0 0 576 512"><path fill="currentColor" d="M528.1 171.5L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6zM388.6 312.3l23.7 138.4L288 385.4l-124.3 65.3 23.7-138.4-100.6-98 139-20.2 62.2-126 62.2 126 139 20.2-100.6 98z"/></svg>
                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" class="svg-inline--fa fa-star star-full fa-w-18" role="img" viewBox="0 0 576 512"><path fill="currentColor" d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z"/></svg>
              </span>
              <span data-score="3" title="3 <?= __('hviezdičky', 'goshop'); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="far" data-icon="star" class="svg-inline--fa fa-star star-empty fa-w-18" role="img" viewBox="0 0 576 512"><path fill="currentColor" d="M528.1 171.5L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6zM388.6 312.3l23.7 138.4L288 385.4l-124.3 65.3 23.7-138.4-100.6-98 139-20.2 62.2-126 62.2 126 139 20.2-100.6 98z"/></svg>
                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" class="svg-inline--fa fa-star star-full fa-w-18" role="img" viewBox="0 0 576 512"><path fill="currentColor" d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z"/></svg>
              </span>
              <span data-score="4" title="4 <?= __('hviezdičky', 'goshop'); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="far" data-icon="star" class="svg-inline--fa fa-star star-empty fa-w-18" role="img" viewBox="0 0 576 512"><path fill="currentColor" d="M528.1 171.5L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6zM388.6 312.3l23.7 138.4L288 385.4l-124.3 65.3 23.7-138.4-100.6-98 139-20.2 62.2-126 62.2 126 139 20.2-100.6 98z"/></svg>
                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" class="svg-inline--fa fa-star star-full fa-w-18" role="img" viewBox="0 0 576 512"><path fill="currentColor" d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z"/></svg>
              </span>
              <span data-score="5" title="5 <?= __('hviezdičiek', 'goshop'); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="far" data-icon="star" class="svg-inline--fa fa-star star-empty fa-w-18" role="img" viewBox="0 0 576 512"><path fill="currentColor" d="M528.1 171.5L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6zM388.6 312.3l23.7 138.4L288 385.4l-124.3 65.3 23.7-138.4-100.6-98 139-20.2 62.2-126 62.2 126 139 20.2-100.6 98z"/></svg>
                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" class="svg-inline--fa fa-star star-full fa-w-18" role="img" viewBox="0 0 576 512"><path fill="currentColor" d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z"/></svg>
              </span>
            </p>
         </div>
        <input type="hidden" id="post_rating" name="rating" value="5" />
        <label for="author"><?= __('Meno', 'goshop'); ?></label>
        <input type="text" name="author" class="form-control mb-1" id="author" value="" required />
        <label for="comment"><?= __('Text hodnotenia', 'goshop'); ?></label>
        <textarea name="comment" class="form-control" id="comment" rows="2" required></textarea>
        <input type="hidden" name="comment_parent" id="comment_parent" value="0">
        <input type="hidden" name="comment_post_ID" value="<?= $post->ID; ?>" />
        <input class="btn btn-primary mt-1" name="submit" type="submit" id="submit" value="<?= __('Odoslať komentár', 'goshop'); ?>" />
        <?php do_action('comment_form', $post->ID); ?>  
    </form>  
    <?php endif; ?>
  </div>
  <div class="col-md-6">

    <?php 
    $args = array (
        'post_type' => 'product', 
        'post_id' => $post->ID,
        'status' => 'approve' // Status you can also use 'hold', 'spam', 'trash', 
        );
    $comments = get_comments($args);
    
    if($comments) { ?>  
    
        <h4><?= __('Komentáre', 'goshop'); ?></h4>
        <div class="comments" id="reviews">  
        <?php foreach($comments as $comment) : ?>  
            <div id="comment-<?= $comment->comment_ID ?>" class="comment-wrapper">  
                <?php if ($comment->comment_approved == '0') : ?>  
                    <p>Váš komentár caká na schválenie</p>  
                <?php endif; ?>  
                <div>
                    <small><?= date('d.m.Y', strtotime($comment->comment_date)); ?></small>
                    <span class="comment-author">
                        <?= $comment->comment_author ?>
                    </span>
                    
                <?php
              	if ( $rating = get_comment_meta( $comment->comment_ID, 'rating', true ) ) {
                  echo getCommentStars($rating);
                } ?>
                </div>
                <div class="mb-1 mt-1"><i><?= $comment->comment_content; ?></i></div>
                <!-- <i class="far fa-thumbs-up"></i> <?= $comment->comment_karma ?> <i class="far fa-thumbs-down"></i>-->  
            </div>  
        <?php endforeach; ?>  
        </div>  
    <?php } else { ?>
      <div class="alert alert-danger mt-2"><?= __('Tento produkt zatiaľ nemá hodnotenia', 'goshop'); ?></div>  
    <?php } ?>
  </div> 
</div>

