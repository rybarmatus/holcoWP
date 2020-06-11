<?php
/**
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product, $goshop_config;

if ( empty( $product ) || !$product->is_visible() || $product->is_type('gift')) {
	return;
}
$product_id = $product->get_id();
?>

<div class="product-loop-item col-sm-8 offset-sm-2 col-md-4 offset-md-0 col-lg-3 mt-1 <?= ($product->is_type('variable')) ? 'product-variable' : ''; ?>">
    <div class="d-mobile-none">
        <?php wc_get_template( 'loop/sale-flash.php' ); ?>
    </div>
    <div class="row">
        <div class="product-loop-image-wrapper col-4 col-md-12 pl-mobile-0 text-center">
          <a href="<?= get_permalink($product->get_id()); ?>" title="<?= $product->get_name(); ?>">
            <?php
            $thumb_id = get_post_thumbnail_id( $product->get_id());
            
            if(!$thumb_id){
            ?>
              <img class="loop-image" src="<?= NO_IMAGE; ?>" alt="<?= $product->get_name(); ?>">
            <?php    
            }else{
            
              $image = wp_get_attachment_image_src( $thumb_id , 'product-loop' );
              
              if (defined('PRODUCT_FILTER')) {
              ?>
                <img class="loop-image" src="<?= $image[0]; ?>" width="<?= $image[1]; ?>" alt="<?= $product->get_name(); ?> height="<?= $image[2]; ?>">
              <?php
              }else {
              ?>
                <img class="loop-image lazy" src="<?= LAZY_IMG; ?>" data-src="<?= $image[0]; ?>" width="<?= $image[1]; ?>" alt="<?= $product->get_name(); ?>" height="<?= $image[2]; ?>">
              <?php
              }
            }
            ?>
          </a>
        </div>
        <div class="product-loop-description-wrapper col-8 col-md-12 pl-mobile-0">
          <a href="<?= get_permalink($product->get_id()); ?>" title="<?= $product->get_name(); ?>">
            <h2 class="mb-1 mb-mobile-0 mobile-left text-center"><?= $product->get_title(); ?></h2>
          </a>
          
          <div class="row price-row">
              <div class="col-6">
                  <?php wc_get_template( 'loop/price.php' ); ?>
              </div>
              <div class="col-6 loop-stars-wrapper">
                  <?= getStars($product, true); ?>
              </div>
          </div>
          
          <div class="row buttons-row mt-1">
            <div class="col-6 product-loop-buttons text-center favourite pointer pr-0 pl-0">
              <?php if($goshop_config['product-favourite']) { ?>
              <div class="favourite wrapper<?php if(checkIfFavourite($product_id)) { echo ' added'; } ?>">
                <div class="not-selected js-add-to-favourite" data-product-id="<?= $product_id ?>">
                    <svg class="not-added" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="far" data-icon="heart" role="img" viewBox="0 0 512 512"><path fill="currentColor" d="M458.4 64.3C400.6 15.7 311.3 23 256 79.3 200.7 23 111.4 15.6 53.6 64.3-21.6 127.6-10.6 230.8 43 285.5l175.4 178.7c10 10.2 23.4 15.9 37.6 15.9 14.3 0 27.6-5.6 37.6-15.8L469 285.6c53.5-54.7 64.7-157.9-10.6-221.3zm-23.6 187.5L259.4 430.5c-2.4 2.4-4.4 2.4-6.8 0L77.2 251.8c-36.5-37.2-43.9-107.6 7.3-150.7 38.9-32.7 98.9-27.8 136.5 10.5l35 35.7 35-35.7c37.8-38.5 97.8-43.2 136.5-10.6 51.1 43.1 43.5 113.9 7.3 150.8z"/></svg>
                    <span class="explainer">
                        <?= __('Obľúbený', 'goshop'); ?>
                    </span>
                </div>
                <div class="selected js-remove-from-favourite" data-product-id="<?= $product_id ?>">
                    <svg class="added" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="heart" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M462.3 62.6C407.5 15.9 326 24.3 275.7 76.2L256 96.5l-19.7-20.3C186.1 24.3 104.5 15.9 49.7 62.6c-62.8 53.6-66.1 149.8-9.9 207.9l193.5 199.8c12.5 12.9 32.8 12.9 45.3 0l193.5-199.8c56.3-58.1 53-154.3-9.8-207.9z" class=""></path></svg>
                    <span class="explainer">
                        <?= __('Obľúbený', 'goshop'); ?>
                    </span>
                </div>
              </div>
              <?php } ?>
            </div>
            <div class="col-6 product-loop-buttons pointer pl-0 pr-0">
                <?php if($goshop_config['product-compare']) { ?>
                  <div class="compare text-center wrapper<?php if(checkProductCompareStatus($product_id)) { echo ' added'; } ?>">
                    <div class="not-selected js-compare" data-product-id="<?= $product_id ?>">
                      <svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="balance-scale-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path fill="currentColor" d="M634.4 375.09L525.35 199.12c-3.17-4.75-8.26-7.12-13.35-7.12s-10.18 2.38-13.35 7.12L389.6 375.09c-3.87 5.78-6.09 12.72-5.51 19.64C389.56 460.4 444.74 512 512 512c67.27 0 122.45-51.6 127.91-117.27.57-6.92-1.64-13.86-5.51-19.64zM511.96 238.24L602.27 384H421.02l90.94-145.76zM512 480c-41.28 0-77-26.77-90.42-64h181.2c-13.23 36.87-49.2 64-90.78 64zm17.89-317.21l5.08-15.17c1.4-4.19-.86-8.72-5.05-10.12L379.46 87.15C382.33 79.98 384 72.21 384 64c0-35.35-28.65-64-64-64-29.32 0-53.77 19.83-61.34 46.73L120.24.42c-4.19-1.4-8.72.86-10.12 5.05l-5.08 15.17c-1.4 4.19.86 8.72 5.05 10.12l148.29 49.62c5.91 22.23 23.33 39.58 45.62 45.36V480H104c-4.42 0-8 3.58-8 8v16c0 4.42 3.58 8 8 8h224c4.42 0 8-3.58 8-8V125.74c8.64-2.24 16.5-6.22 23.32-11.58l160.45 53.68c4.18 1.4 8.71-.86 10.12-5.05zM320 96c-17.64 0-32-14.36-32-32s14.36-32 32-32 32 14.36 32 32-14.36 32-32 32zm-64.09 170.73c.58-6.92-1.64-13.86-5.51-19.64L141.35 71.12C138.18 66.38 133.09 64 128 64s-10.18 2.38-13.35 7.12L5.6 247.09c-3.87 5.78-6.09 12.72-5.51 19.64C5.56 332.4 60.74 384 128 384s122.44-51.6 127.91-117.27zM127.96 110.24L218.27 256H37.02l90.94-145.76zM37.58 288h181.2c-13.23 36.87-49.2 64-90.78 64-41.28 0-77-26.77-90.42-64z" class=""></path></svg>
                      <span class="explainer">
                          <?= __('Porovnať', 'goshop'); ?>
                      </span>
                    </div>
                    <div class="selected js-remove_from_compare" data-product-id="<?= $product_id ?>">
                      <svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="balance-scale-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path fill="currentColor" d="M634.4 375.09L525.35 199.12c-3.17-4.75-8.26-7.12-13.35-7.12s-10.18 2.38-13.35 7.12L389.6 375.09c-3.87 5.78-6.09 12.72-5.51 19.64C389.56 460.4 444.74 512 512 512c67.27 0 122.45-51.6 127.91-117.27.57-6.92-1.64-13.86-5.51-19.64zM511.96 238.24L602.27 384H421.02l90.94-145.76zM512 480c-41.28 0-77-26.77-90.42-64h181.2c-13.23 36.87-49.2 64-90.78 64zm17.89-317.21l5.08-15.17c1.4-4.19-.86-8.72-5.05-10.12L379.46 87.15C382.33 79.98 384 72.21 384 64c0-35.35-28.65-64-64-64-29.32 0-53.77 19.83-61.34 46.73L120.24.42c-4.19-1.4-8.72.86-10.12 5.05l-5.08 15.17c-1.4 4.19.86 8.72 5.05 10.12l148.29 49.62c5.91 22.23 23.33 39.58 45.62 45.36V480H104c-4.42 0-8 3.58-8 8v16c0 4.42 3.58 8 8 8h224c4.42 0 8-3.58 8-8V125.74c8.64-2.24 16.5-6.22 23.32-11.58l160.45 53.68c4.18 1.4 8.71-.86 10.12-5.05zM320 96c-17.64 0-32-14.36-32-32s14.36-32 32-32 32 14.36 32 32-14.36 32-32 32zm-64.09 170.73c.58-6.92-1.64-13.86-5.51-19.64L141.35 71.12C138.18 66.38 133.09 64 128 64s-10.18 2.38-13.35 7.12L5.6 247.09c-3.87 5.78-6.09 12.72-5.51 19.64C5.56 332.4 60.74 384 128 384s122.44-51.6 127.91-117.27zM127.96 110.24L218.27 256H37.02l90.94-145.76zM37.58 288h181.2c-13.23 36.87-49.2 64-90.78 64-41.28 0-77-26.77-90.42-64z" class=""></path></svg>
                      <span class="explainer">
                        <?= __('Porovnať', 'goshop'); ?>
                      </span>
                    </div>
                  </div>
                <?php } ?>
            </div>
            
          </div>
        </div>
        <div class="clear"></div>
    </div>
</div>
