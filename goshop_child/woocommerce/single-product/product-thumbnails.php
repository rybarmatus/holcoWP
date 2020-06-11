<?php
die('toto sa nepouziva');

global $product;
$attachment_ids = $product->get_gallery_image_ids();
$product_title = $product->get_title();

$images_count = 4;
if ( $attachment_ids && $product->get_image_id() ) {
    foreach ( $attachment_ids as $key=>$attachment_id ) {
  	if($key < $images_count){
        $thumbnail = wp_get_attachment_image_src($attachment_id, 'thumbnail-80');
        $full_image = wp_get_attachment_image_src($attachment_id, 'full');
        ?>
        <span class="lightgallery-item" itemprop="image" data-src="<?= $full_image[0]; ?>">
            <img class="lazy" src="<?= LOADER; ?>" data-src="<?= $thumbnail[0]; ?>" width="80" height="80" alt="<?= $product_title.' '.$key;?>">
        </span>
    <?php }else{ ?>
        <span class="d-none lightgallery-item" data-src="<?= $full_image[0]?>">
          <img src="<?= $thumbnail[0]?>" width="80" alt="<?= $product_title.' '.$key;?>">
        </span>
    <?php  
    }
  }
  
  $thumb_count = count($attachment_ids);
  if( $thumb_count  > $images_count ){
      echo '<span href="#" title="" class="product_thumbnail_button">
          +'. ($thumb_count-$images_count) .'
      </span>';
  }
}
?>    
<div class="clear"></div>