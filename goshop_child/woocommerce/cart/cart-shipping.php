<?php
/**
 * Shipping Methods Display
 *
 * In 2.1 we show methods per package. This allows for multiple methods per order if so desired.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-shipping.php.
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;


 
foreach($available_methods as $method){
                
    $flat_rate = new WC_Shipping_Flat_Rate( $method->get_instance_id() );
    
    if( isset($flat_rate->instance_settings['doprava_zadarmo'])){ 
        
        if(isset($available_methods['free_shipping:'.$flat_rate->instance_settings['doprava_zadarmo']])){
            unset($available_methods['flat_rate:'.$method->get_instance_id()]);
        }
    }
    
    

}


/* 
if(isset($available_methods['free_shipping:6'])){
    unset($available_methods['flat_rate:4']);
}
*/
/*
if(isset($available_methods['free_shipping:7'])){
    unset($available_methods['flat_rate:5']);
}
*/

?>

<?php if ( $available_methods ) : ?>
<div id="shipping_method" class="woocommerce-shipping-methods">
	<?php foreach ( $available_methods as $key => $method ) : ?>
		<div class="mb-1">
			<?php
			if ( 1 < count( $available_methods ) ) {
      				printf( '<input type="radio" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d_%2$s" value="%3$s" class="shipping_method" %4$s />', $index, esc_attr( sanitize_title( $method->id ) ), esc_attr( $method->id ), checked( $method->id, $chosen_method, false ) ); // WPCS: XSS ok.
      			} else {
      				printf( '<input type="hidden" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d_%2$s" value="%3$s" class="shipping_method" />', $index, esc_attr( sanitize_title( $method->id ) ), esc_attr( $method->id ) ); // WPCS: XSS ok.
      			}
      			printf( '<label for="shipping_method_%1$s_%2$s">%3$s</label>', $index, esc_attr( sanitize_title( $method->id ) ), wc_cart_totals_shipping_method_label( $method ) ); // WPCS: XSS ok.
      			do_action( 'woocommerce_after_shipping_rate', $method, $index );

            if($key == 'flat_rate:4' or $key == 'free_shipping:6'){ ?>
            
              <div class="zasielkovna_control_wrapper" style="<?php if($chosen_method != 'free_shipping:6' and $chosen_method != 'flat_rate:4'){ echo 'display:none'; } ?>"> 
                <div class="pointer select-zasielkovna-pobocka"><small class="underline"><?= __('Vybrať pobočku', 'goshop'); ?></small></div>
                <div id="zasielkovna_pobocka_view" data-error-text="<?= __('Nevyplnil si pobočku zásielkovne.', 'goshop'); ?>" class="packeta-selector-branch-name"></div>
              </div> 
            
        <?php
       // }
      }
      ?>
		</div>
	<?php endforeach; ?>
</div>
  <?php if ( $show_package_details ) : ?>
		<?php echo '<p class="woocommerce-shipping-contents"><small>' . esc_html( $package_details ) . '</small></p>'; ?>
	<?php endif; ?>

  <?php endif; ?>       
