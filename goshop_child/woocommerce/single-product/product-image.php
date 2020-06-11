<?php
/**
 * Single Product Image
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.1
 */

defined( 'ABSPATH' ) || exit;

global $product;
$attachment_ids = $product->get_gallery_image_ids();
$product_title = $product->get_title();
$main_image_id = $product->get_image_id();
?>
<figure class="product-images-wrapper lightgallery">
  <div class="row">
    <div class="col-md-2 product_thumbnails_wrapp order-mobile-2">
        <?php
        $images_count = 3;
        if ( $attachment_ids && $product->get_image_id() ) {
            
            if ( $main_image_id ) {
        	     $large_image = wp_get_attachment_image_src( $main_image_id , 'product-single' );
               $full_image = wp_get_attachment_image_src( $main_image_id , 'full' );
            }
            ?>
            <span class="d-none lightgallery-item" data-key="0" data-gallery-thumb="<?= $full_image[0]?>" title="<?= $product_title.' '.__('hlavný obrázok', 'goshop');?>"  data-src="<?= $full_image[0]?>"></span>
            <img class="lazy js-enlarge-image pointer" src="<?= LAZY_IMG; ?>" data-key="0" data-src="<?= $full_image[0]; ?>" width="80" height="80" alt="<?= __('hlavný obrázok', 'goshop').' obr. ';?>">
            
            <?php
            foreach ( $attachment_ids as $key=>$attachment_id ) {
            	  $thumbnail = wp_get_attachment_image_src($attachment_id, 'product-thumbnail');
                $full_image = wp_get_attachment_image_src($attachment_id, 'full');
                if($key < $images_count){ ?>
                
                  <img class="lazy pointer js-enlarge-image" data-key="<?= $key+1; ?>" data-full-src="<?= $full_image[0]?>" src="<?= LAZY_IMG; ?>" data-src="<?= $thumbnail[0]; ?>" width="80" height="80" alt="<?= $product_title.' obr. '.($key+1);?>">
                
                <?php } ?>
                  <span data-gallery-thumb="<?= $thumbnail[0]; ?>" data-key="<?= $key+1; ?>" class="product-gallery-hidden-item d-none lightgallery-item" data-src="<?= $full_image[0]?>"></span>
              <?php  
              }
        }
          
        $thumb_count = count($attachment_ids);
        if( $thumb_count  > $images_count ){
              echo '<span href="#" data-open="'. ($images_count+1) .'" title="" class="product_thumbnail_button">
                  +'. ($thumb_count-$images_count) .'
              </span>';
        }
        ?>
        <div class="clear"></div>
    </div>
    <div class="col-md-10 order-mobile-1">
        <?php
        if ( $main_image_id ) {
      	     $large_image = wp_get_attachment_image_src( $main_image_id , 'product-single' );
             $full_image = wp_get_attachment_image_src( $main_image_id , 'full' );
             echo '<div class="text-center pointer js-open-lightgallery" data-key="0" data-src="'. $full_image[0] .'"><img alt="'.$product_title.' - '. __('hlavný obrázok', 'goshop')  .' " class="js-large-image product-main-image w-max-100 mobile-h-auto lazy" src="'.LAZY_IMG.'" data-src="'. $large_image[0] .'" width="'.$large_image[1].'" height="'.$large_image[2].'"></div>';
        } else {
      		 echo '<img class="product-main-image src="'.NO_IMAGE.'"" alt="no image">';
      	}
    	?>
    </div>
  </div>
</figure>