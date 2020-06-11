<?php
/**
 * Output a single payment method
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/payment-method.php.
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $goshop_config;
?>
<div class="mb-1 wc_payment_method payment_method_<?= esc_attr( $gateway->id ); ?>">
	<input id="payment_method_<?php echo esc_attr( $gateway->id ); ?>" type="radio" class="input-radio" name="payment_method" value="<?php echo esc_attr( $gateway->id ); ?>" <?php checked( $gateway->chosen, true ); ?> data-order_button_text="<?php echo esc_attr( $gateway->order_button_text ); ?>" />

	<label for="payment_method_<?php echo esc_attr( $gateway->id ); ?>">
	   <?= $gateway->get_title(); ?>
  	</label>
    <?php if($gateway->id == 'cod' and WC()->cart->subtotal < get_option('option_cod_fee_limit')) { ?>
        <div class="float-right"><?= wc_price(get_option('option_cod_fee')); ?></div>
    <?php } ?>
    
    <?php if ( $gateway->has_fields() || $gateway->get_description() ) : ?>
		<div class="payment_box payment_method_<?php echo esc_attr( $gateway->id ); ?>" <?php if ( ! $gateway->chosen ) : /* phpcs:ignore Squiz.ControlStructures.ControlSignature.NewlineAfterOpenBrace */ ?>style="display:none;"<?php endif; /* phpcs:ignore Squiz.ControlStructures.ControlSignature.NewlineAfterOpenBrace */ ?>>
			<?php $gateway->payment_fields(); ?>
		  <?php
      if($gateway->id == 'goshop_custom_payment_method_cetelem'){
        echo '<div class="js-modal underline pointer" data-modal=".cetelem-calc">Nastaviť parametre splátok</div>';
      }
      ?>
    
    </div>
	<?php endif; ?>
</div>