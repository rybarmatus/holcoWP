<?php
function get_fonts(){
  
  $fonts = '<link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700%7CMontserrat" rel="stylesheet">';
  return $fonts;
  // <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900&display=swap" rel="stylesheet">
};

function image_sizes_custom() {
  
  /*
  blog-thumbnail, akciovy balicek thumbnail, cart-thumbnail, checkout-thumbnail, minicart thumbnail - 50x50 thumbnail
  blog-loop -   250-187  medium
  blog-single - 830x500   large
  */
  add_image_size( 'product-thumbnail', 80, 80, 1 );
  add_image_size( 'product-loop', 150, 150 );
  add_image_size( 'product-single', 466, 466 );
  add_image_size( 'product-desctop-full', 1200, 650 );

}  
add_action( 'after_setup_theme', 'image_sizes_custom' );

function getListPost($post, $classes){ ?>
    <div class="<?= $classes ?> mb-1 loop-item">
      <a title="<?= $post->post_title; ?>" href="<?= get_permalink($post->ID);?>">
        <?php
        $image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'medium' );
        ?>
        <figure>
          <img class="w-max-100 lazy" src="<?= LAZY_IMG ?>" data-src="<?= $image[0] ?>" width="<?= $image[1] ?>" height="<?= $image[2] ?>" alt="<?= $post->post_title; ?>" />
        </figure>
        <div class="content">
           <h5 class="mb-1"><?= $post->post_title; ?></h2>
           <div class="loop-excerpt"><?= $post->post_excerpt; ?></div>
           <small><time datetime="<?= $post->post_date ?>"><?= date('d.m.Y',strtotime($post->post_date)); ?></time></small>
        </div>
      </a>
    </div>
<?php }
