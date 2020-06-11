<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $goshop_config, $product;
$product_id = $product->get_id();

?>
<div class="product_meta mb-2 mt-3">
    <?php
    if($goshop_config['woo-bundle-products'] and $product->get_type() == 'bundle' ){
        $bundle_items = false;
        if ($bundle_ids_str = get_post_meta($product_id, 'bundle_ids', true)) {
            $bundle_items = bundle_get_bundled(0, $bundle_ids_str, false);
        }
        if($bundle_items){
        ?>
        <div class="akciovy-balicek-wrapper mb-2">
          <h5><?= __('Obsah balíčku','goshop');?></h5>
          <?php
          foreach($bundle_items as $item){ 
            $_product = wc_get_product( $item['id'] );
            $url = get_permalink( $item['id'] ) ;
                        
            ?>
            <a class="item mb-1" href="<?= $url ?>">
              <?php
              $thumb_id = get_post_thumbnail_id( $item['id']);
              
              if ( $_product->is_type( 'variation' ) and !$thumb_id ) {
                $parent_id = $_product->get_parent_id();
                $thumb_id = get_post_thumbnail_id( $parent_id);                  
              } 
                
              if(!$thumb_id){
                  
                  echo '<img class="float-left mr-1" src="'. NO_IMAGE .'" alt="' .$_product->get_name(). '">';
              }else{
                    $image = wp_get_attachment_image_src( $thumb_id , 'thumbnail' );
                    echo '<img class="float-left mr-1 lazy" alt="'.$_product->get_name().'" src="'.NO_IMAGE.'" data-src="'.$image[0].'" width="'.$image[1].'" height="'.$image[2].'">';
              }
              ?>
              <?= $_product->get_name(); ?>
              <div class="float-right">
                  <?= wc_price($_product->get_regular_price()); ?>
                  <?php // get_price(); ?>
              </div>
              <div class="clear"></div>
            </a>
          <?php
          }
          ?>
          </div>
        <?php  
        }
    }
    ?>

    <?php
    $cross_sell_ids = $product->get_cross_sell_ids();
    if(!empty($cross_sell_ids)){
    ?>
        <div class="cross-sells-wrapper mb-2">
          <h5><?= __('Doplnkový predaj','goshop');?></h5>
          <?php
          foreach($cross_sell_ids as $ID){ 
            $_product = wc_get_product( $ID );
            $url = get_permalink( $ID ) ;
            ?>
            <div class="row">
                <div class="col-7">
                    <a class="item d-block mb-1" href="<?= $url ?>">
                      <?php
                      $thumb_id = get_post_thumbnail_id( $ID); 
                      if(!$thumb_id){                     
                            echo '<img width="50" class="additional-sale-image float-left mr-1" data-product-id="'.$_product->get_id().'" src="'. NO_IMAGE .'" alt="' .$_product->get_title(). '">';
                      }else{
                            $image = wp_get_attachment_image_src( $thumb_id , 'thumbnail' );
                            echo '<img class="additional-sale-image lazy float-left mr-1" data-product-id="'.$_product->get_id().'" alt="'.$_product->get_title().'" src="'. LAZY_IMG .'" data-src="'.$image[0].'" width="'.$image[1].'" height="'.$image[2].'">';
                      }
                      ?>
                      <span class="additional-sale-product" data-product-id="<?= $_product->get_id(); ?>"><?= $_product->get_title(); ?></span>
                      -
                      <?= wc_price($_product->get_price()); ?>
                    </a>  
                </div>
                <div class="col-3">
                    <form class="cart add_to_cart_form additional-sale" data-image-src="<?= $image[0] ?>" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $_product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>
                		<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>
                        <div class="quantity">
                		  <label class="screen-reader-text" for="quantity_5"><?= __('Množstvo', 'goshop') ?></label>
                	      <input type="hidden" id="quantity_5" class="" step="1" min="1" max="1" name="quantity" value="1" title="<?= __('Počet', 'goshop') ?>" pattern="[0-9]*" inputmode="numeric" aria-labelledby="množstvo">
                        </div>
                        <input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $_product->get_id() ); ?>" />
                        <button type="submit" class="add_to_cart_button btn-primary btn btn-small">
                            <svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="cart-plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M551.991 64H129.28l-8.329-44.423C118.822 8.226 108.911 0 97.362 0H12C5.373 0 0 5.373 0 12v8c0 6.627 5.373 12 12 12h78.72l69.927 372.946C150.305 416.314 144 431.42 144 448c0 35.346 28.654 64 64 64s64-28.654 64-64a63.681 63.681 0 0 0-8.583-32h145.167a63.681 63.681 0 0 0-8.583 32c0 35.346 28.654 64 64 64 35.346 0 64-28.654 64-64 0-17.993-7.435-34.24-19.388-45.868C506.022 391.891 496.76 384 485.328 384H189.28l-12-64h331.381c11.368 0 21.177-7.976 23.496-19.105l43.331-208C578.592 77.991 567.215 64 551.991 64zM464 416c17.645 0 32 14.355 32 32s-14.355 32-32 32-32-14.355-32-32 14.355-32 32-32zm-256 0c17.645 0 32 14.355 32 32s-14.355 32-32 32-32-14.355-32-32 14.355-32 32-32zm294.156-128H171.28l-36-192h406.876l-40 192zM272 196v-8c0-6.627 5.373-12 12-12h36v-36c0-6.627 5.373-12 12-12h8c6.627 0 12 5.373 12 12v36h36c6.627 0 12 5.373 12 12v8c0 6.627-5.373 12-12 12h-36v36c0 6.627-5.373 12-12 12h-8c-6.627 0-12-5.373-12-12v-36h-36c-6.627 0-12-5.373-12-12z" class=""></path></svg>    
                        </button>
                        <?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
                	</form>
                    
                    
                </div>
              </div>    
              <div class="clear"></div>
                      
          <?php
          }
          ?>
        </div>            
    <?php
    }; 
    
    ?>
    
    
    
	<?php do_action( 'woocommerce_product_meta_start' ); ?>
                                                                                                                                                                                     
	<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>

		<div class="sku_wrapper"><?php esc_html_e( 'SKU:', 'woocommerce' ); ?> <span class="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'woocommerce' ); ?></span></div>

	<?php endif; ?>

	<?php // echo wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted_in">' . _n( 'Category:', 'Categories:', count( $product->get_category_ids() ), 'woocommerce' ) . ' ', '</span>' ); ?>

	<?php // echo wc_get_product_tag_list( $product->get_id(), ', ', '<span class="tagged_as">' . _n( 'Tag:', 'Tags:', count( $product->get_tag_ids() ), 'woocommerce' ) . ' ', '</span>' ); ?>

	<?php do_action( 'woocommerce_product_meta_end' ); ?>


<a rel="nofollow" target="_blank" title="Facebook share" href="https://www.facebook.com/sharer.php?u=<?= THIS_PAGE_URL; ?>">
    <svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="facebook-square" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M400 32H48A48 48 0 0 0 0 80v352a48 48 0 0 0 48 48h137.25V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.27c-30.81 0-40.42 19.12-40.42 38.73V256h68.78l-11 71.69h-57.78V480H400a48 48 0 0 0 48-48V80a48 48 0 0 0-48-48z"></path></svg>
</a>
<a rel="nofollow" target="_blank" title="Twitter share" href="https://twitter.com/intent/tweet?&url=<?= THIS_PAGE_URL ?>&via=<?= get_bloginfo() ?>">
    <svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="twitter" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"></path></svg>   
</a>    
    

<span class="js-print pointer" title="<?= __('Tlačiť', 'goshop'); ?>">
    <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="print" role="img" viewBox="0 0 512 512"><path fill="currentColor" d="M448 192V77.25c0-8.49-3.37-16.62-9.37-22.63L393.37 9.37c-6-6-14.14-9.37-22.63-9.37H96C78.33 0 64 14.33 64 32v160c-35.35 0-64 28.65-64 64v112c0 8.84 7.16 16 16 16h48v96c0 17.67 14.33 32 32 32h320c17.67 0 32-14.33 32-32v-96h48c8.84 0 16-7.16 16-16V256c0-35.35-28.65-64-64-64zm-64 256H128v-96h256v96zm0-224H128V64h192v48c0 8.84 7.16 16 16 16h48v96zm48 72c-13.25 0-24-10.75-24-24 0-13.26 10.75-24 24-24s24 10.74 24 24c0 13.25-10.75 24-24 24z"/></svg>
</span>


<span class="send_product_by_email js-modal pointer" data-modal=".recommend_product" title="<?= __('Odporučiť produkt', 'goshop'); ?>">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M464 64H48C21.49 64 0 85.49 0 112v288c0 26.51 21.49 48 48 48h416c26.51 0 48-21.49 48-48V112c0-26.51-21.49-48-48-48zm0 48v40.805c-22.422 18.259-58.168 46.651-134.587 106.49-16.841 13.247-50.201 45.072-73.413 44.701-23.208.375-56.579-31.459-73.413-44.701C106.18 199.465 70.425 171.067 48 152.805V112h416zM48 400V214.398c22.914 18.251 55.409 43.862 104.938 82.646 21.857 17.205 60.134 55.186 103.062 54.955 42.717.231 80.509-37.199 103.053-54.947 49.528-38.783 82.032-64.401 104.947-82.653V400H48z"/></svg>
</span>
<div class="modal recommend_product">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
          <?= __('Odporučiť produkt', 'goshop') ?>
          <button type="button" class="close js-modal-close pointer">
            <span aria-hidden="true">×</span>
          </button>
      </div>
      <div class="modal-body">
         <?= do_shortcode('[contact-form-7 id="180" title="Odporučiť produkt"]'); ?>
      </div>
    </div>
  </div>
</div>

<span class="js-copy pointer" data-copy="<?= THIS_PAGE_URL; ?>" data-success_text="<?= __('Url adresa produktu bola skopírovaná', 'goshop'); ?>" title="<?= __('Kopírovať url adresu produktu', 'goshop'); ?>">
    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="link" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M326.612 185.391c59.747 59.809 58.927 155.698.36 214.59-.11.12-.24.25-.36.37l-67.2 67.2c-59.27 59.27-155.699 59.262-214.96 0-59.27-59.26-59.27-155.7 0-214.96l37.106-37.106c9.84-9.84 26.786-3.3 27.294 10.606.648 17.722 3.826 35.527 9.69 52.721 1.986 5.822.567 12.262-3.783 16.612l-13.087 13.087c-28.026 28.026-28.905 73.66-1.155 101.96 28.024 28.579 74.086 28.749 102.325.51l67.2-67.19c28.191-28.191 28.073-73.757 0-101.83-3.701-3.694-7.429-6.564-10.341-8.569a16.037 16.037 0 0 1-6.947-12.606c-.396-10.567 3.348-21.456 11.698-29.806l21.054-21.055c5.521-5.521 14.182-6.199 20.584-1.731a152.482 152.482 0 0 1 20.522 17.197zM467.547 44.449c-59.261-59.262-155.69-59.27-214.96 0l-67.2 67.2c-.12.12-.25.25-.36.37-58.566 58.892-59.387 154.781.36 214.59a152.454 152.454 0 0 0 20.521 17.196c6.402 4.468 15.064 3.789 20.584-1.731l21.054-21.055c8.35-8.35 12.094-19.239 11.698-29.806a16.037 16.037 0 0 0-6.947-12.606c-2.912-2.005-6.64-4.875-10.341-8.569-28.073-28.073-28.191-73.639 0-101.83l67.2-67.19c28.239-28.239 74.3-28.069 102.325.51 27.75 28.3 26.872 73.934-1.155 101.96l-13.087 13.087c-4.35 4.35-5.769 10.79-3.783 16.612 5.864 17.194 9.042 34.999 9.69 52.721.509 13.906 17.454 20.446 27.294 10.606l37.106-37.106c59.271-59.259 59.271-155.699.001-214.959z"></path></svg>
</span>

</div>
