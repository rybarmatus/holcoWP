<?php
/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<table class="w-100 checkout-review-table woocommerce-checkout-review-order-table mb-2">
	<tbody>
		<?php
			do_action( 'woocommerce_review_order_before_cart_contents' );

			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				?>
		<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
			<td class="product-name">
  			   <div class="row">
                  <div class="col-3 pr-0">
                    <?php
                    $thumb_id = get_post_thumbnail_id( $_product->get_id()); 
                    
                    if ( $_product->is_type( 'variation' ) and !$thumb_id ) {
                      $parent_id = $_product->get_parent_id();
                      $thumb_id = get_post_thumbnail_id( $parent_id);                  
                    } 
                      
                    if(!$thumb_id){                     
                      echo '<img src="'. NO_IMAGE . '" alt="No image">';
                    }else{
                      $image = wp_get_attachment_image_src( $thumb_id , 'thumbnail' );
                      echo '<img alt="'.$_product->get_name().'" src="'.$image[0].'" width="'.$image[1].'" height="'.$image[2].'">';
                    }
                    ?>
                  </div>
                  <div class="col-9 pl-0">
                      <span class="product-name-text">
                          <?= $_product->get_name(); ?>
                      </span>
                  </div>
               </div>
            </td>
            
			<td class="product-total text-right">
			  <?= $cart_item['quantity'] ?> x
              <?= wc_get_formatted_cart_item_data( $cart_item ); ?>
              <?= WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ); ?>
			</td>
		</tr>
					<?php
				}
			}

			do_action( 'woocommerce_review_order_after_cart_contents' );
		?>
        <tr>
            <td class="text-center" colspan="2">
                <hr class="mt-1 mb-1">
                <?php if(wc_coupons_enabled()){
                  $coupon_code = $coupon = WC()->cart->get_applied_coupons();;
                  if(empty($coupon_code)){ ?>
    			    <div class="row">
                      <div class="col-5 col-md-5 offset-2 pr-0">
                          <input id="kupon_text" class="form-control" placeholder="<?= __('Zľavový kupón','goshop'); ?>" />
                      </div>
                      <div class="col-3 col-md-3 text-left">
                          <div class="btn btn-primary btn-small js-checkout-add-coupon" data-success-msg="<?= __('Kupón bol pridaný', 'goshop'); ?>" data-error-msg="<?= __('Musíte vyplniť kód kupónu', 'goshop'); ?>"><?= __('Uplatniť','goshop'); ?></div>
                      </div>
                    </div>
                    <?php }else {  
                      
                      $_coupon = new WC_Coupon($coupon_code[0]);
                      $coupon_post = get_post( $_coupon->get_id() );
                      $description = ! empty( $coupon_post->post_excerpt ) ? $coupon_post->post_excerpt : null;
                      ?>
                      <?= __('Aktívny kupón','goshop'); ?>: <strong><?= $coupon_code[0]; ?></strong>
                      &nbsp;&nbsp;<a title="<?= __('Odstrániť kupón', 'goshop'); ?>" href="<?= wc_get_cart_url() ?>?remove_coupon=<?= $coupon_code[0]; ?>" data-success_text="<?= __('Kupón bol úspešne odstránený', 'goshop'); ?>" class="remove woocommerce-remove-coupon remove-circle" data-coupon="<?= $coupon_code[0]; ?>"> x</a>
                      <?php if(!empty($description)){ ?>
                        <div><small><?= $description ?></small></div>
                      <?php } ?>
                  <?php } ?>
                  
                <?php } ?>
               <hr class="mt-1 mb-1">
            </td>
        </tr>
        
	</tbody>
	<tfoot>
       <tr class="cart-subtotal">
			<th><?php _e( 'Subtotal', 'woocommerce' ); ?></th>
            <td><?php wc_cart_totals_subtotal_html(); ?></td>
		</tr>

		<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
			<tr class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
				<th><?php wc_cart_totals_coupon_label( $coupon ); ?></th>
                
				<td>
                    <?php
                    if ( is_string( $coupon ) ) {
                        $coupon = new WC_Coupon( $coupon );
                    }
                    $discount_amount_html = '';
                    $amount  = WC()->cart->get_coupon_discount_amount( $coupon->get_code(), WC()->cart->display_cart_ex_tax );
                    $discount_amount_html = '-' . wc_price( $amount );
                
                    if ( $coupon->get_free_shipping() && empty( $amount ) ) {
                        $discount_amount_html = __( 'Free shipping coupon', 'woocommerce' );
                    }
                    echo $discount_amount_html; ?>
                </td>
			</tr>
		<?php endforeach; ?>

      <tr>
        <th>
          <?php
          $packages = WC()->shipping->get_packages();
          foreach ( $packages as $i => $package ) {
      		  
            if(isset( WC()->session->chosen_shipping_methods[ $i ] )){
              $chosen_method = WC()->session->chosen_shipping_methods[ $i ];
            }else{
              continue;
            }

            foreach($package['rates'] as $method){
             
              if($chosen_method == $method->get_id()){
                echo $method->get_label();
                $selected_method = $method;  
              }
            }
          
          }
          ?>
      </th>
      
      <td>
        <?php
        if(isset($selected_method)){ 
            echo wc_price($selected_method->get_cost());
        }
        ?>
      </td>
      </tr>
        <?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
			<tr class="fee">
				<th><?= esc_html( $fee->name ); ?></th>
                <td><?php wc_cart_totals_fee_html( $fee ); ?></td>
			</tr>
		<?php endforeach; ?>

		<?php if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) : ?>
			<?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
				<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
					<tr class="tax-rate tax-rate-<?php echo sanitize_title( $code ); ?>">
						<th><?php echo esc_html( $tax->label ); ?></th>
                        <td><?php echo wp_kses_post( $tax->formatted_amount ); ?></td>
					</tr>
				<?php endforeach; ?>
			<?php else : ?>
				<tr class="tax-total">
					<th><?= esc_html( WC()->countries->tax_or_vat() ); ?></th>
                    <td><?php wc_cart_totals_taxes_total_html(); ?></td>
				</tr>
			<?php endif; ?>
		<?php endif; ?>

		<?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

		<tr class="order-total">
			<th><?php _e( 'Total', 'woocommerce' ); ?></th>
            <td><?php wc_cart_totals_order_total_html(); ?></td>
		</tr>

		<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>

	</tfoot>
</table>  
