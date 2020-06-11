<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_mini_cart' ); ?>

<?php if ( ! WC()->cart->is_empty() ) : ?>

	<div class="minicart-header">
        <strong><?= __('Produkty v košíku','goshop'); ?></strong>
    </div>
    <div class="minicart-products-wrapper">
        <table class="w-100">
            <tbody>
		    <?php
			do_action( 'woocommerce_before_mini_cart_contents' );

			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
				$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
                $is_darcek = $_product->is_type('gift');

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					$product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
					$thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image('thumbnail'), $cart_item, $cart_item_key );
					$product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
					$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
					?>
					<tr class="woocommerce-mini-cart-item <?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?>">
						<td class="minicart-remove-product">
              <?php
  			  if(!$is_darcek){
                echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
					'<a href="%s" class="remove-circle remove_from_cart_button" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s">&times;</a>',
					esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
					__( 'Remove this item', 'woocomsmerce' ),
					esc_attr( $product_id ),
					esc_attr( $cart_item_key ),
					esc_attr( $_product->get_sku() )
				), $cart_item_key );
              }
  			  ?>
            </td>
            <td class="minicart-thumbnail">
              <a title="<?= $product_name; ?>" href="<?php echo esc_url( $product_permalink ); ?>">
                  <?= $thumbnail ?>
              </a>  
            </td>
            <td class="minicart-product-name">
              <a title="<?= $product_name; ?>" href="<?php echo esc_url( $product_permalink ); ?>">
	              <?= $product_name; ?>    
                <?= wc_get_formatted_cart_item_data( $cart_item ); ?>
                <?php if($is_darcek){ echo '('._('Darček').')'; } ?>
              </a>
            </td>
            <td class="minicart-price">
              <?php
              if($is_darcek){
                echo '<span class="quantity">1 × <span class="amount">0,00 '.get_woocommerce_currency_symbol().'</span></span>';
              }else{
                 echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf( '%s &times; %s', $cart_item['quantity'], $product_price ) . '</span>', $cart_item, $cart_item_key );
              }
              ?>   
            </td>
        </tr>
					<?php
				}
			endforeach; ?>
                </tbody>
            </table>
			<?php do_action( 'woocommerce_mini_cart_contents' ); ?>
	</div>
    <div class="minicart-footer">
    	<p class="woocommerce-mini-cart__total total"><strong><?php _e( 'Celková suma s DPH', 'goshop' ); ?>:</strong><span class="minicart-total"><?= WC()->cart->get_cart_subtotal(); ?></span></p>
        <?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>
        <a href="/nakupny-kosik" title="Prejsť k nákupu" class="btn btn-success bold btn-block mb-1"><?= __('Prejsť k nákupu'); ?> <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="arrow-right" class="svg-inline--fa fa-arrow-right fa-w-14" role="img" viewBox="0 0 448 512"><path fill="currentColor" d="M190.5 66.9l22.2-22.2c9.4-9.4 24.6-9.4 33.9 0L441 239c9.4 9.4 9.4 24.6 0 33.9L246.6 467.3c-9.4 9.4-24.6 9.4-33.9 0l-22.2-22.2c-9.5-9.5-9.3-25 .4-34.3L311.4 296H24c-13.3 0-24-10.7-24-24v-32c0-13.3 10.7-24 24-24h287.4L190.9 101.2c-9.8-9.3-10-24.8-.4-34.3z"/></svg></a>
        <?php if($free_shipping = get_option('option_shipping_free')) { ?>
        <div class="shipping_text">
          <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="truck" class="svg-inline--fa fa-truck fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" d="M624 352h-16V243.9c0-12.7-5.1-24.9-14.1-33.9L494 110.1c-9-9-21.2-14.1-33.9-14.1H416V48c0-26.5-21.5-48-48-48H48C21.5 0 0 21.5 0 48v320c0 26.5 21.5 48 48 48h16c0 53 43 96 96 96s96-43 96-96h128c0 53 43 96 96 96s96-43 96-96h48c8.8 0 16-7.2 16-16v-32c0-8.8-7.2-16-16-16zM160 464c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm320 0c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm80-208H416V144h44.1l99.9 99.9V256z"/></svg>
          <?php
          $minicart_total = WC()->cart->cart_contents_total;
          
           
          if($minicart_total >= $free_shipping){
              echo sprintf( __( 'K tomuto nákupu získavate %s dopravu zadarmo %s', 'goshop' ), '<strong>', '</strong>' ); 
          }else{
              $to_free_shipping = $free_shipping - $minicart_total;
              echo sprintf( __( 'Nakúpte ešte za %s %s  a máte dopravu zadarmo %s', 'goshop' ), '<strong>',  wc_price($to_free_shipping) ,'</strong>' );
          }
          ?>
        </div>
        <?php } ?>  
    </div>

<?php else : ?>

	<p class="woocommerce-mini-cart__empty-message"><?php _e( 'No products in the cart.', 'woocommerce' ); ?></p>

<?php endif; ?>

<?php do_action( 'woocommerce_after_mini_cart' ); ?>
