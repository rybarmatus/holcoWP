<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
global $goshop_config, $product;
// $tabs = apply_filters( 'woocommerce_product_tabs', array() );
?>

<div class="tabs-wrapper mt-2">	
    <div class="container">
      <ul class="tabs-nav" role="tablist">
  		  <li class="active" role="tab" data-tab="description" aria-controls="tab-description">
			<a>
                <div class="relative tab-svg-wrapp">
                    <svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="info-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M256 40c118.621 0 216 96.075 216 216 0 119.291-96.61 216-216 216-119.244 0-216-96.562-216-216 0-119.203 96.602-216 216-216m0-32C119.043 8 8 119.083 8 256c0 136.997 111.043 248 248 248s248-111.003 248-248C504 119.083 392.957 8 256 8zm-36 344h12V232h-12c-6.627 0-12-5.373-12-12v-8c0-6.627 5.373-12 12-12h48c6.627 0 12 5.373 12 12v140h12c6.627 0 12 5.373 12 12v8c0 6.627-5.373 12-12 12h-72c-6.627 0-12-5.373-12-12v-8c0-6.627 5.373-12 12-12zm36-240c-17.673 0-32 14.327-32 32s14.327 32 32 32 32-14.327 32-32-14.327-32-32-32z" class=""></path></svg>
                </div>    
                <div class="d-mobile-none">
                    <?= __('Popis', 'goshop'); ?>
                </div>
            </a>
          </li>
          <li role="tab" data-tab="reviews" aria-controls="tab-reviews">
  				  <a>
                <div class="relative tab-svg-wrapp">
                    <svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="comments-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M512 160h-96V64c0-35.3-28.7-64-64-64H64C28.7 0 0 28.7 0 64v160c0 35.3 28.7 64 64 64h32v52c0 7.1 5.8 12 12 12 2.4 0 4.9-.7 7.1-2.4l76.9-43.5V384c0 35.3 28.7 64 64 64h96l108.9 61.6c2.2 1.6 4.7 2.4 7.1 2.4 6.2 0 12-4.9 12-12v-52h32c35.3 0 64-28.7 64-64V224c0-35.3-28.7-64-64-64zM64 256c-17.6 0-32-14.4-32-32V64c0-17.6 14.4-32 32-32h288c17.6 0 32 14.4 32 32v160c0 17.6-14.4 32-32 32H215.6l-7.3 4.2-80.3 45.4V256zm480 128c0 17.6-14.4 32-32 32h-64v49.6l-80.2-45.4-7.3-4.2H256c-17.6 0-32-14.4-32-32v-96h128c35.3 0 64-28.7 64-64v-32h96c17.6 0 32 14.4 32 32z" class=""></path></svg>
                    <div class="tab-badge"><?= $product->get_review_count() ?></div>
                </div>
                <div class="d-mobile-none">
                  <?= __('Recenzie', 'goshop'); ?>
                </div>
            </a>
          </li>
  		  <?php if($goshop_config['product-technology']) { ?>
              <li role="tab" data-tab="download" aria-controls="tab-technology">
  				<a>
                  <div class="relative tab-svg-wrapp">
                    <svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="clipboard-list" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path fill="currentColor" d="M280 240H168c-4.4 0-8 3.6-8 8v16c0 4.4 3.6 8 8 8h112c4.4 0 8-3.6 8-8v-16c0-4.4-3.6-8-8-8zm0 96H168c-4.4 0-8 3.6-8 8v16c0 4.4 3.6 8 8 8h112c4.4 0 8-3.6 8-8v-16c0-4.4-3.6-8-8-8zM112 232c-13.3 0-24 10.7-24 24s10.7 24 24 24 24-10.7 24-24-10.7-24-24-24zm0 96c-13.3 0-24 10.7-24 24s10.7 24 24 24 24-10.7 24-24-10.7-24-24-24zM336 64h-88.6c.4-2.6.6-5.3.6-8 0-30.9-25.1-56-56-56s-56 25.1-56 56c0 2.7.2 5.4.6 8H48C21.5 64 0 85.5 0 112v352c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48V112c0-26.5-21.5-48-48-48zM192 32c13.3 0 24 10.7 24 24s-10.7 24-24 24-24-10.7-24-24 10.7-24 24-24zm160 432c0 8.8-7.2 16-16 16H48c-8.8 0-16-7.2-16-16V112c0-8.8 7.2-16 16-16h48v20c0 6.6 5.4 12 12 12h168c6.6 0 12-5.4 12-12V96h48c8.8 0 16 7.2 16 16v352z" class=""></path></svg>
                    <div class="tab-badge">5</div>
                  </div>        
                  <div class="d-mobile-none">
                    <?= __('Technológie', 'goshop'); ?>
                  </div>  
                </a>
            </li>
          <?php } ?>
          <?php if($goshop_config['product-download']) { ?>    
              <li role="tab" data-tab="download" aria-controls="tab-download">
  				<a>
                    <div class="relative tab-svg-wrapp">
                        <svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="download" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M452 432c0 11-9 20-20 20s-20-9-20-20 9-20 20-20 20 9 20 20zm-84-20c-11 0-20 9-20 20s9 20 20 20 20-9 20-20-9-20-20-20zm144-48v104c0 24.3-19.7 44-44 44H44c-24.3 0-44-19.7-44-44V364c0-24.3 19.7-44 44-44h99.4L87 263.6c-25.2-25.2-7.3-68.3 28.3-68.3H168V40c0-22.1 17.9-40 40-40h96c22.1 0 40 17.9 40 40v155.3h52.7c35.6 0 53.4 43.1 28.3 68.3L368.6 320H468c24.3 0 44 19.7 44 44zm-261.7 17.7c3.1 3.1 8.2 3.1 11.3 0L402.3 241c5-5 1.5-13.7-5.7-13.7H312V40c0-4.4-3.6-8-8-8h-96c-4.4 0-8 3.6-8 8v187.3h-84.7c-7.1 0-10.7 8.6-5.7 13.7l140.7 140.7zM480 364c0-6.6-5.4-12-12-12H336.6l-52.3 52.3c-15.6 15.6-41 15.6-56.6 0L175.4 352H44c-6.6 0-12 5.4-12 12v104c0 6.6 5.4 12 12 12h424c6.6 0 12-5.4 12-12V364z" class=""></path></svg>
                        <div class="tab-badge">5</div>
                    </div>
                    <div class="d-mobile-none">
                        <?= __('Na stiahnutie', 'goshop'); ?> 
                    </div> 
                </a>
            </li>
          <?php } ?>
      </ul>
    </div>
</div>
<div class="container mb-2">       
    <div class="product-description-tab-content tab-content active" data-tab="description" id="tab-description">
	   <?php woocommerce_product_description_tab(); ?>
	</div>
	<div class="tab-content" data-tab="reviews" id="tab-reviews">
	   <?php include(TEMPLATEPATH.'/comments-product.php'); ?>
	</div>
    <?php if($goshop_config['product-download']) { ?>
        <div class="tab-content" data-tab="download" id="tab-download">
		  /single=product/tabs/tabs.php
          <br />
          tab na stiahnutie z goshop config, image typu súboru, na tabe bud enapísané kolko je súborov na stiahnutie, názov súboru a url na súbor	
		</div>
    <?php } ?>    
    <?php if($goshop_config['product-technology']) { ?>
        <div class="tab-content" data-tab="technology" id="tab-technology">
		  /single=product/tabs/tabs.php
          <br />
          tab na stiahnutie z goshop config, image typu súboru, na tabe bud enapísané kolko je súborov na stiahnutie, názov súboru a url na súbor	
		</div>
    <?php } ?>
</div>