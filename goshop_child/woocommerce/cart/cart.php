<?php
defined( 'ABSPATH' ) || exit;
global $woocommerce;
?>
<?php do_action( 'woocommerce_before_cart' ); ?>
 
<div class="woocommerce-cart-wrapper pt-1 pb-3">
  
  <?php if($free_shipping = get_option('option_shipping_free')) { ?>
  <div class="container">
    <div class="alert alert-success alert-no-icon">
      <svg width="27" aria-hidden="true" focusable="false" data-prefix="fal" data-icon="truck" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path fill="currentColor" d="M632 384h-24V275.9c0-16.8-6.8-33.3-18.8-45.2l-83.9-83.9c-11.8-12-28.3-18.8-45.2-18.8H416V78.6c0-25.7-22.2-46.6-49.4-46.6H49.4C22.2 32 0 52.9 0 78.6v290.8C0 395.1 22.2 416 49.4 416h16.2c-1.1 5.2-1.6 10.5-1.6 16 0 44.2 35.8 80 80 80s80-35.8 80-80c0-5.5-.6-10.8-1.6-16h195.2c-1.1 5.2-1.6 10.5-1.6 16 0 44.2 35.8 80 80 80s80-35.8 80-80c0-5.5-.6-10.8-1.6-16H632c4.4 0 8-3.6 8-8v-16c0-4.4-3.6-8-8-8zM460.1 160c8.4 0 16.7 3.4 22.6 9.4l83.9 83.9c.8.8 1.1 1.9 1.8 2.8H416v-96h44.1zM144 480c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm63.6-96C193 364.7 170 352 144 352s-49 12.7-63.6 32h-31c-9.6 0-17.4-6.5-17.4-14.6V78.6C32 70.5 39.8 64 49.4 64h317.2c9.6 0 17.4 6.5 17.4 14.6V384H207.6zM496 480c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm0-128c-26.1 0-49 12.7-63.6 32H416v-96h160v96h-16.4c-14.6-19.3-37.5-32-63.6-32z" class=""></path></svg>
      <?php
      $cart_total = WC()->cart->cart_contents_total;
      if($cart_total >= $free_shipping){
          echo sprintf( __( 'K tomuto nákupu získavate %s dopravu zadarmo %s', 'goshop' ), '<strong>', '</strong>' ); 
      }else{
          $to_free_shipping = $free_shipping - $cart_total;
          echo sprintf( __( 'Nakúpte ešte za %s %s  a máte dopravu zadarmo %s', 'goshop' ), '<strong>',  wc_price($to_free_shipping) ,'</strong>' );
      }
      ?>
    </div>
  </div>
  <?php } ?>
   

<div class="container">
<form class="woocommerce-cart-form" action="<?= esc_url( wc_get_cart_url() ); ?>" method="post" success_text="<?= __('Košík bol aktualizovaný', 'goshop'); ?>">
	
    <?php do_action( 'woocommerce_before_cart_table' ); ?>

    <table class="cart-table mt-2" cellspacing="0">
		<thead>
			<tr>
    			<th class="product-name"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
    			<th class="product-quantity"><?php esc_html_e( 'Quantity', 'woocommerce' ); ?></th>
    			<th class="product-subtotal"><?php esc_html_e( 'Total', 'woocommerce' ); ?></th>
          <th class="product-remove">&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			<?php do_action( 'woocommerce_before_cart_contents' ); ?>

			<?php
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
        		$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
                $is_darcek = $_product->is_type('gift');

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
					?>
					<tr class="cart_item mobile-center">
            <td class="product-name">
			 <a title="<?= $_product->get_name(); ?>" href="<?= $product_permalink; ?>">
            <?php
              $thumb_id = get_post_thumbnail_id( $_product->get_id()); 
              
              if ( $_product->is_type( 'variation' ) and !$thumb_id ) {
                $parent_id = $_product->get_parent_id();
                $thumb_id = get_post_thumbnail_id( $parent_id);                  
              } 
              
              if(!$thumb_id){     
                
                  echo '<div class="cart-thumb-wrapp float-left mobile-float-none">';
                  echo '<img src="'. NO_IMAGE .'" alt="No image">';
                  echo '</div>';
              }else{
                $image = wp_get_attachment_image_src( $thumb_id , 'thumbnail' );
                echo '<div class="cart-thumb-wrapp float-left mobile-float-none">';
                    echo '<img src="'.$image[0].'" width="'.$image[1].'" heiht="'.$image[2].'">';
                echo '</div>';
              }
              ?>
              
              <span><?= $_product->get_name(); ?></span>
            </a>                            
            
				<?php

				do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

				// Meta data.
				echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

				// Backorder notification.
				if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
					echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>', $product_id ) );
				}
            ?>
		   	</td>
           	<td class="product-quantity" error_text="<?= __('Prekročili ste maximálny počet kusov pri produkte', 'goshop').' '.$_product->get_name().'. '.__('Na sklade máme', 'goshop').' '.$_product->get_max_purchase_quantity().' '.__('kusov', 'goshop'); ?>">
				<?php
                    if ( $_product->is_sold_individually() || $is_darcek ) {
					$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
				} else {
                ?>							
                  
                  <?php
                  if($_product->get_stock_status() == 'onbackorder'){
                      $max = 99;
                      $max_text = __('Ľutujeme, môžete objednať iba '.$max. ' ks tohto produktu','goshop'); 
                  }else{
                      $max = $_product->get_stock_quantity();
                      $max_text = __('Ľutujeme, máme skladom iba '.$max. ' ks tohto produktu','goshop');  
                  }
                  ?>
                  
                  <div class="quantity quantity-buttons">
            		  <label class="screen-reader-text" for="quantity_5"><?= __('Množstvo', 'goshop') ?></label>
            	      <input type="number" id="quantity_<?= $_product->get_id() ?>" class="" step="1" min="1" max="<?= $max; ?>" name="<?= "cart[{$cart_item_key}][qty]" ?>" value="<?= $cart_item['quantity'] ?>" title="<?= __('Počet', 'goshop') ?>" data-max-text="<?= $max_text; ?>">                                                     
                      <a title="<?= __('Plus', 'goshop') ?>" class="quantity_plus">
                        <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path fill="currentColor" d="M368 224H224V80c0-8.84-7.16-16-16-16h-32c-8.84 0-16 7.16-16 16v144H16c-8.84 0-16 7.16-16 16v32c0 8.84 7.16 16 16 16h144v144c0 8.84 7.16 16 16 16h32c8.84 0 16-7.16 16-16V288h144c8.84 0 16-7.16 16-16v-32c0-8.84-7.16-16-16-16z" class=""></path></svg>
                      </a>
                      <a title="<?= __('Mínus', 'goshop') ?>" class="quantity_minus">
                        <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="minus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path fill="currentColor" d="M368 224H16c-8.84 0-16 7.16-16 16v32c0 8.84 7.16 16 16 16h352c8.84 0 16-7.16 16-16v-32c0-8.84-7.16-16-16-16z" class=""></path></svg>
                      </a>       
            	    </div>
                <?php    
                }
                //	echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
				?>
				</td>
                <td class="product-subtotal">
				<div>
                    <strong>
                        <?= apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); ?>
                    </strong>
                </div>
                <div class="product-quantity-price">
                    <?php
					if(!$is_darcek){
                        echo $cart_item['quantity'];
                        echo 'x ';
                        echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
                    }else{
                        echo __('Darček k nákupu nad', 'goshop'); 
                        echo ' '.get_option('discount_gift_amount');
                        echo get_woocommerce_currency_symbol();                                
                    }
                    ?>
                </div>
		    </td>
            <td class="product-remove">
			     <?php
				 if(!$is_darcek){
  				   echo apply_filters( 'woocommerce_cart_item_remove_link', 
                        sprintf('<a href="%s" class="js-remove-product-from-cart remove-circle" aria-label="%s" data-product_id="%s" success_text="'.__('Produkt bol odstránený z košíka', 'goshop').'" data-product_sku="%s">&times;</a>',
  						esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
  						__( 'Remove this item', 'woocommerce' ),
  						esc_attr( $product_id ),
  						esc_attr( $_product->get_sku() )
  						), $cart_item_key );
                 } ?>
			</td>
			</tr>
			<?php
			}
			}
			?>

			<?php do_action( 'woocommerce_cart_contents' ); ?>
            </tbody>
            <tfoot>
			<tr>
				<td colspan="6" class="actions">
                      <div class="coupon relative">
    					   <div class="container-fluid">	
                            	<div class="row">
                                    <div class="col-md-6 pl-0 order-mobile-2">
                                        <?php
                                        if(wc_coupons_enabled()){
                                            $coupon_code = $woocommerce->cart->get_applied_coupons();
                                            if(empty($coupon_code)){ ?>
                                              <div class="coupon-not-applied">                                          
                                              <label for="coupon_code"><?= __( 'Máte zľavový kupón?', 'goshop' ); ?></label>
                                              <br />
                                              <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?= __( 'Kód kupónu', 'goshop' ); ?>" /> 
                                              <button type="submit" class="btn btn-primary btn-small" id="apply_coupon" success_text="<?= __('Kupón bol akceptovaný', 'goshop'); ?>" empty_text="<?= __('Musíte vyplniť kód kupónu', 'goshop'); ?>" name="apply_coupon">
                                                  <?= __( 'Použiť kupón', 'goshop' ); ?>
                                              </button>
                                              <?php do_action( 'woocommerce_cart_coupon' ); ?>
                                              </div>
                                          <?php
                                          }else { 
                                              $_coupon = new WC_Coupon($coupon_code[0]);
                                              $coupon_post = get_post( $_coupon->get_id() );
                                              $description = ! empty( $coupon_post->post_excerpt ) ? $coupon_post->post_excerpt : null;
                                              ?>
                                              <?= __('Aktívny kupón','goshop'); ?>: <strong><?= $coupon_code[0]; ?></strong>
                                              &nbsp;&nbsp;<a title="<?= __('Odstrániť kupón', 'goshop'); ?>" href="<?= wc_get_cart_url() ?>?remove_coupon=<?= $coupon_code[0]; ?>" success_text="<?= __('Kupón bol úspešne odstránený', 'goshop'); ?>" class="remove-circle js-remove-coupon" data-coupon="<?= $coupon_code[0]; ?>"> x</a>
                                              <?php if(!empty($description)){ ?>
                                                <div><small><?= $description ?></small></div>
                                              <?php } ?>
                                          <?php
                                          }
                                        }  
                                        ?>
                                    </div>
                                    <div class="col-md-6 text-right order-mobile-1 mb-mobile-1">
                                        <button type="submit" class="btn-update-cart disabled" name="update_cart" id="update_cart" value="<?= __( 'Aktualizovať košík', 'goshop' ); ?>"><?= __( 'Aktualizovať košík', 'goshop' ); ?></button>
                                        <?php do_action( 'woocommerce_cart_actions' ); ?>
                                        <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
                                    </div>  
                               </div>     
                        </div>
    				</div>	
                </td>
			</tr>
            <?php do_action( 'woocommerce_after_cart_contents' ); ?>
		</tfoot>
	</table>
	<?php do_action( 'woocommerce_after_cart_table' ); ?>
    
    <?php if(isset($_POST['coupon_code']) and isset($_POST['apply_coupon'])) { 
      $coupon = new \WC_Coupon( $_POST['coupon_code'] ); 
      $discounts = new \WC_Discounts( WC()->cart );
      $coupon_valid = $discounts->is_coupon_valid( $coupon );
      if ( is_wp_error( $coupon_valid ) ) {
      ?>
        <input type="hidden" id="coupon_invalid" value='<?= $coupon_valid->get_error_message(); ?>'>  
      <?php
      } 
      }
    ?>
</form>
</div>

</div>
<div class="cart-summary pt-2">
  <div class="container">
    <div class="row cart-collaterals">
      <div class="col-md-9 mb-mobile-1">
         <?php wc_get_template( 'cart/cart-totals.php' ); ?>
      </div>
      <div class="col-md-3 text-right">
          <a class="continue_to_checkout btn btn-success" title="<?= __('Pokračovať', 'goshop') ?>" href="<?= wc_get_page_permalink( 'checkout' ); ?>"><?= __('Pokračovať','goshop'); ?> 
            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-circle-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M256 8c137 0 248 111 248 248S393 504 256 504 8 393 8 256 119 8 256 8zm113.9 231L234.4 103.5c-9.4-9.4-24.6-9.4-33.9 0l-17 17c-9.4 9.4-9.4 24.6 0 33.9L285.1 256 183.5 357.6c-9.4 9.4-9.4 24.6 0 33.9l17 17c9.4 9.4 24.6 9.4 33.9 0L369.9 273c9.4-9.4 9.4-24.6 0-34z"></path></svg>
          </a>
      </div>
    </div>
  </div>
</div>    

<?php do_action( 'woocommerce_after_cart' );
