<?php
/**
 * Checkout Payment Section
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/payment.php.
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.3
 */

defined( 'ABSPATH' ) || exit;

if ( ! is_ajax() ) {
	do_action( 'woocommerce_review_order_before_payment' );
}
?>             
<div id="payment" class="woocommerce-checkout-payment">
	
  <?php do_action( 'woocommerce_review_order_before_shipping' ); ?>
    <h4 class="text-center"><?= __('Doprava', 'goshop'); ?></h4>
  <?php wc_cart_totals_shipping_html(); ?>
    <?php do_action( 'woocommerce_review_order_after_shipping' ); ?>
  
  
  <?php if ( WC()->cart->needs_payment() ) : ?>
		<h4 class="text-center"><?= __('Spôsob platby', 'goshop'); ?></h4>
    <div class="wc_payment_methods payment_methods methods">
			<?php
            if ( ! empty( $available_gateways ) ) {
				foreach ( $available_gateways as $gateway ) {
					wc_get_template( 'checkout/payment-method.php', array( 'gateway' => $gateway ) );
				}
			}
			?>
		</div>
        <div class="clear"></div>
	<?php endif; ?>
	
</div>
<?php
if ( ! is_ajax() ) {
	do_action( 'woocommerce_review_order_after_payment' );
}
