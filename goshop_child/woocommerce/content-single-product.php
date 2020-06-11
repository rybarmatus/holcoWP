<?php
/**

 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;
global $goshop_config, $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked wc_print_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

$product_id = $product->get_ID();
?>
<div id="product-<?= $product_id; ?>" <?php wc_product_class(); ?>>
  <div class="container single-product-wrapper">
    <div class="row">
      <div class="col-md-6">
          <?php
              /**
               * Hook: woocommerce_before_single_product_summary.
               *
               * @hooked woocommerce_show_product_sale_flash - 10
               * @hooked woocommerce_show_product_images - 20
               */
              do_action( 'woocommerce_before_single_product_summary' );
          
          if($goshop_config['cpt_poradca']){
                
             require(CONTENT. '/poradca.php');
                
          } ?>

      </div>
      <div class="col-md-6">
  		 
        <h1 class="m-0"><?= $product->get_title(); ?></h1> 
        <div class="bubbles-wrapper mb-1">
          <?php if($goshop_config['cpt_manufacturers']){ ?>
            
            <?php $manufacturer = get_product_brand($product_id); ?>
            <?php if($manufacturer) { ?>
              <a href="<?= get_term_link($manufacturer) ?>" title="<?= __('Zobraziť výrobcu', 'goshop'); ?>">
                  <span class="bubble"><?= $manufacturer->name ?></span>
              </a>
            <?php } ?>
          <?php } ?>
          <?php  
          $terms = get_the_terms( $product_id, 'product_cat' );
          if(!empty($terms)){ 
            foreach($terms as $item){ ?>  
                <a href="<?= get_term_link($item->term_id); ?>" title="<?=$item->name; ?>">
                    <span class="bubble"><?=$item->name; ?></span>
                </a>
            <?php } ?>
          <?php } ?>
        </div>
        
        <div class="row">
            <div class="col-5 col-md-5 pointer scrollTo" data-target="#tab-reviews" data-tab="reviews">
                <?php
                if ( $goshop_config['product-rating'] ) {
                    echo getStars($product,true);
                } ?>
            </div>
                
            <div class="col-5 offset-2 offset-md-0 col-md-3 product-action-icons text-center">
                <div class="row">
                <?php if($goshop_config['product-favourite']) { ?>
                    <div class="col-4">
                      <div class="product-single-buttons favourite pointer">
                        <div class="favourite wrapper<?php if(checkIfFavourite($product_id)) { echo ' added'; } ?>" title="<?= __('Pridať produkt k obľúbeným', 'goshop'); ?>">
                          <div class="not-selected js-add-to-favourite" data-product-id="<?= $product_id ?>">
                              <svg class="not-added" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="far" data-icon="heart" role="img" viewBox="0 0 512 512"><path fill="currentColor" d="M458.4 64.3C400.6 15.7 311.3 23 256 79.3 200.7 23 111.4 15.6 53.6 64.3-21.6 127.6-10.6 230.8 43 285.5l175.4 178.7c10 10.2 23.4 15.9 37.6 15.9 14.3 0 27.6-5.6 37.6-15.8L469 285.6c53.5-54.7 64.7-157.9-10.6-221.3zm-23.6 187.5L259.4 430.5c-2.4 2.4-4.4 2.4-6.8 0L77.2 251.8c-36.5-37.2-43.9-107.6 7.3-150.7 38.9-32.7 98.9-27.8 136.5 10.5l35 35.7 35-35.7c37.8-38.5 97.8-43.2 136.5-10.6 51.1 43.1 43.5 113.9 7.3 150.8z"/></svg>
                          </div>
                          <div class="selected js-remove-from-favourite" data-product-id="<?= $product_id ?>" title="<?= __('Odobrať produkt z obľúbených', 'goshop'); ?>">
                              <svg class="added" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="heart" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M462.3 62.6C407.5 15.9 326 24.3 275.7 76.2L256 96.5l-19.7-20.3C186.1 24.3 104.5 15.9 49.7 62.6c-62.8 53.6-66.1 149.8-9.9 207.9l193.5 199.8c12.5 12.9 32.8 12.9 45.3 0l193.5-199.8c56.3-58.1 53-154.3-9.8-207.9z" class=""></path></svg>
                          </div>
                        </div>
                      </div>
                   </div>
              <?php } ?>
              
              <?php if($goshop_config['product-compare']){ ?>
              <div class="col-4">
                <div class="compare pointer wrapper<?php if(checkProductCompareStatus($product_id)) { echo ' added'; } ?>">
                  <div class="not-selected js-compare" data-product-id="<?= $product_id ?>" title="<?= __('Pridať produkt do porovnávaču', 'goshop'); ?>">
                    <svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="balance-scale-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" class="svg-inline--fa fa-balance-scale-right fa-w-20 fa-3x"><path fill="currentColor" d="M634.4 375.09L525.35 199.12c-3.17-4.75-8.26-7.12-13.35-7.12s-10.18 2.38-13.35 7.12L389.6 375.09c-3.87 5.78-6.09 12.72-5.51 19.64C389.56 460.4 444.74 512 512 512c67.27 0 122.45-51.6 127.91-117.27.57-6.92-1.64-13.86-5.51-19.64zM511.96 238.24L602.27 384H421.02l90.94-145.76zM512 480c-41.28 0-77-26.77-90.42-64h181.2c-13.23 36.87-49.2 64-90.78 64zm17.89-317.21l5.08-15.17c1.4-4.19-.86-8.72-5.05-10.12L379.46 87.15C382.33 79.98 384 72.21 384 64c0-35.35-28.65-64-64-64-29.32 0-53.77 19.83-61.34 46.73L120.24.42c-4.19-1.4-8.72.86-10.12 5.05l-5.08 15.17c-1.4 4.19.86 8.72 5.05 10.12l148.29 49.62c5.91 22.23 23.33 39.58 45.62 45.36V480H104c-4.42 0-8 3.58-8 8v16c0 4.42 3.58 8 8 8h224c4.42 0 8-3.58 8-8V125.74c8.64-2.24 16.5-6.22 23.32-11.58l160.45 53.68c4.18 1.4 8.71-.86 10.12-5.05zM320 96c-17.64 0-32-14.36-32-32s14.36-32 32-32 32 14.36 32 32-14.36 32-32 32zm-64.09 170.73c.58-6.92-1.64-13.86-5.51-19.64L141.35 71.12C138.18 66.38 133.09 64 128 64s-10.18 2.38-13.35 7.12L5.6 247.09c-3.87 5.78-6.09 12.72-5.51 19.64C5.56 332.4 60.74 384 128 384s122.44-51.6 127.91-117.27zM127.96 110.24L218.27 256H37.02l90.94-145.76zM37.58 288h181.2c-13.23 36.87-49.2 64-90.78 64-41.28 0-77-26.77-90.42-64z" class=""></path></svg>
                  </div>
                  <div class="selected js-remove_from_compare" data-product-id="<?= $product_id ?>" title="<?= __('Odobrať produkt z porovnávaču', 'goshop'); ?>">
                      <svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="balance-scale-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" class="svg-inline--fa fa-balance-scale-right fa-w-20 fa-3x"><path fill="currentColor" d="M634.4 375.09L525.35 199.12c-3.17-4.75-8.26-7.12-13.35-7.12s-10.18 2.38-13.35 7.12L389.6 375.09c-3.87 5.78-6.09 12.72-5.51 19.64C389.56 460.4 444.74 512 512 512c67.27 0 122.45-51.6 127.91-117.27.57-6.92-1.64-13.86-5.51-19.64zM511.96 238.24L602.27 384H421.02l90.94-145.76zM512 480c-41.28 0-77-26.77-90.42-64h181.2c-13.23 36.87-49.2 64-90.78 64zm17.89-317.21l5.08-15.17c1.4-4.19-.86-8.72-5.05-10.12L379.46 87.15C382.33 79.98 384 72.21 384 64c0-35.35-28.65-64-64-64-29.32 0-53.77 19.83-61.34 46.73L120.24.42c-4.19-1.4-8.72.86-10.12 5.05l-5.08 15.17c-1.4 4.19.86 8.72 5.05 10.12l148.29 49.62c5.91 22.23 23.33 39.58 45.62 45.36V480H104c-4.42 0-8 3.58-8 8v16c0 4.42 3.58 8 8 8h224c4.42 0 8-3.58 8-8V125.74c8.64-2.24 16.5-6.22 23.32-11.58l160.45 53.68c4.18 1.4 8.71-.86 10.12-5.05zM320 96c-17.64 0-32-14.36-32-32s14.36-32 32-32 32 14.36 32 32-14.36 32-32 32zm-64.09 170.73c.58-6.92-1.64-13.86-5.51-19.64L141.35 71.12C138.18 66.38 133.09 64 128 64s-10.18 2.38-13.35 7.12L5.6 247.09c-3.87 5.78-6.09 12.72-5.51 19.64C5.56 332.4 60.74 384 128 384s122.44-51.6 127.91-117.27zM127.96 110.24L218.27 256H37.02l90.94-145.76zM37.58 288h181.2c-13.23 36.87-49.2 64-90.78 64-41.28 0-77-26.77-90.42-64z" class=""></path></svg>
                  </div>
                </div>
              </div>
            <?php } ?>
            
            <?php if($goshop_config['product-watch-dog']){ ?>
                <div class="col-4 pointer">
                    <span class="js-watch-dog pointer" title="<?= __('Sledovať cenu', 'goshop'); ?>">
                        <svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="dog" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M496 96h-64l-7.16-14.31A32 32 0 0 0 396.22 64H326.6l-27.28-27.28c-3.26-3.26-7.27-4.72-11.2-4.72-8.23 0-16.12 6.39-16.12 16.03V224H160c-19.59 0-37.76 5.93-52.95 16H80c-26.47 0-48-21.53-48-48 0-8.84-7.16-16-16-16s-16 7.16-16 16c0 43.24 34.53 78.36 77.46 79.74C69.12 285.97 64 302.32 64 320v160c0 17.67 14.33 32 32 32h64c17.67 0 32-14.33 32-32v-96h96v96c0 17.67 14.33 32 32 32h64c17.67 0 32-14.33 32-32V240h32c35.35 0 64-28.65 64-64v-64c0-8.84-7.16-16-16-16zM384 480h-64V352H160v128H96V320c0-35.29 28.71-64 64-64h118.06L384 282.48V480zm96-304c0 17.64-14.36 32-32 32h-64v41.52l-80-20V86.66l9.34 9.34h82.88l16 32H480v48zm-112-48c-8.84 0-16 7.16-16 16s7.16 16 16 16 16-7.16 16-16-7.16-16-16-16z" class=""></path></svg>
                    </span>
                </div>
            <?php } ?>
            </div>
            </div>
        </div>    
        
        <?php if ( $product->is_in_stock() ) { ?>
            <p class="price mt-1"><?= __('Cena', 'goshop'); ?>: <?= $product->get_price_html(); ?></p>
        <?php } ?> 
          
            
            
        
        <div class="product_summary">
          
          <?php wc_get_template( 'single-product/short-description.php' ); ?>
          
          
          <?php
          /* 
          if( $product->is_type( 'variable' ) ) {
            wc_get_template( 'single-product/add-to-cart/variable.php' );
          } else{  
            wc_get_template( 'single-product/add-to-cart/simple.php' );
            wc_get_template( 'single-product/add-to-cart/variation-add-to-cart-button.php' );
          }
          */
          ?>
          
          
          
         
          
          <?php
         remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
         remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
         remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
         remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
         
  			/**
  			 * Hook: woocommerce_single_product_summary.
  			 *
  			 * @hooked woocommerce_template_single_title - 5
  			 * @hooked woocommerce_template_single_rating - 10
  			 * @hooked woocommerce_template_single_price - 10
  			 * @hooked woocommerce_template_single_excerpt - 20
  			 * @hooked woocommerce_template_single_add_to_cart - 30
  			 * @hooked woocommerce_template_single_meta - 40
  			 * @hooked woocommerce_template_single_sharing - 50
  			 * @hooked WC_Structured_Data::generate_product_data() - 60
  			 */
        do_action( 'woocommerce_single_product_summary' );
        wc_get_template( 'single-product/meta.php' );
    	?>
      </div>
        
      </div>
    </div>
  </div>
    
    <?php wc_get_template( 'single-product/tabs/tabs.php' ); ?>
    <?php wc_get_template( 'single-product/related.php' ); ?>
    
    
</div>

<?php do_action( 'woocommerce_after_single_product' ); 
