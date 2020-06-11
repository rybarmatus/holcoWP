<div class="text-center <?= getSliderItemWrapper($slidesToShow) ?>">
  <h5><?= $post->post_title; ?></h5>
  <div class="text-center">
     <?php if($thumb_id = get_post_thumbnail_id($post->ID)){ ?>
        <img class="d-block w-max-100" src="<?= wp_get_attachment_url( $thumb_id ) ?>" alt="<?= $post->post_title ?>">
     <?php } ?>
  </div>
  <?= $post->post_excerpt; ?>
</div>
