<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout.
?>

<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

	<?php if ( $checkout->get_checkout_fields() ) : ?>

		<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

		<div class="row" id="customer_details">
			<div class="col-md-6">
      
              <?php do_action( 'woocommerce_checkout_billing' ); ?>
              <?php do_action( 'woocommerce_checkout_shipping' ); // odoslat na inu adresu ?>
              <a class="d-mobile-none back-to-cart mt-2 mb-1" title="Späť do košíka" href="<?= wc_get_cart_url(); ?>">
                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-left" class="svg-inline--fa fa-angle-left fa-w-8" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path fill="currentColor" d="M31.7 239l136-136c9.4-9.4 24.6-9.4 33.9 0l22.6 22.6c9.4 9.4 9.4 24.6 0 33.9L127.9 256l96.4 96.4c9.4 9.4 9.4 24.6 0 33.9L201.7 409c-9.4 9.4-24.6 9.4-33.9 0l-136-136c-9.5-9.4-9.5-24.6-.1-34z"></path></svg> 
                <?= __('Späť do košíka', 'goshop'); ?>
              </a>
            </div>
            <div class="col-md-6 pr-mobile-0 pl-mobile-0">
                 <div class="bg-white checkout-summary-wrapper mb-2">
      		    
                    <?php
                     // checkout and shipping
                     wc_get_template( 'checkout/payment.php' );
                     ?>
                  
                  <h4 class="text-center"><?= __('Zhrnutie objednávky', 'goshop'); ?></h4>
                  <div id="order_review" class="woocommerce-checkout-review-order">
                    <?php // do_action( 'woocommerce_checkout_order_review' ); ?>
                    <?php wc_get_template( 'checkout/review-order.php' ); ?>
                    <div class="form-row place-order">
                    		<noscript>
                    			<?php
                    			/* translators: $1 and $2 opening and closing emphasis tags respectively */
                    			printf( esc_html__( 'Since your browser does not support JavaScript, or it is disabled, please ensure you click the %1$sUpdate Totals%2$s button before placing your order. You may be charged more than the amount stated above if you fail to do so.', 'woocommerce' ), '<em>', '</em>' );
                    			?>
                    			<br /><button type="submit" class="button alt" name="woocommerce_checkout_update_totals" value="<?php esc_attr_e( 'Update totals', 'woocommerce' ); ?>"><?php esc_html_e( 'Update totals', 'woocommerce' ); ?></button>
                    		</noscript>
                    
                    		<?php wc_get_template( 'checkout/terms.php' ); ?>
                    
                    		<?php do_action( 'woocommerce_review_order_before_submit' ); ?>

                            <button type="submit" class="btn btn-success btn-block float-right" name="woocommerce_checkout_place_order" id="place_order" data-value="<?= _('ZÁVÄZNE OBJEDNAŤ') ?>"><?= _('ZÁVÄZNE OBJEDNAŤ') ?></button>
                            <div class="clear"></div>
                    
                    		<?php do_action( 'woocommerce_review_order_after_submit' ); ?>
                    
                    		<?php wp_nonce_field( 'woocommerce-process_checkout', 'woocommerce-process-checkout-nonce' ); ?>
                    </div>
                  </div>
                    
                 </div>
            </div>
		</div>

		<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

	<?php endif; ?>

	

	<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

	

	<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout );
