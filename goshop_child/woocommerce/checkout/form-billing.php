<?php
/**
 * Checkout billing information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-billing.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/** @global WC_Checkout $checkout */
global $goshop_config;
?>


<div class="woocommerce-billing-fields">
	<?php if ( wc_ship_to_billing_address_only() && WC()->cart->needs_shipping() ) : ?>

		<h3><?php _e( 'Billing &amp; Shipping', 'woocommerce' ); ?></h3>

	<?php else : ?>

		<h3><?= __('Kontaktné údaje', 'goshop'); ?></h3>
        
        <?php if ( ! is_user_logged_in() && $checkout->is_registration_enabled() ) : ?>
        	<div class="woocommerce-account-fields">
        		<?php if ( ! $checkout->is_registration_required() ) : ?>
                	
          		    
          		<!-- <input class="" id="createaccount" <?php checked( ( true === $checkout->get_value( 'createaccount' ) || ( true === apply_filters( 'woocommerce_create_account_default_checked', false ) ) ), true ) ?> type="checkbox" name="createaccount" value="1" /> <span><?php _e( 'Create an account?', 'woocommerce' ); ?></span> -->
                    <?php 
               if($goshop_config['woo-discounts'] and get_option('discount_for_registered')){
                 $sale = $discount = false;
                 $type = get_option('discount_for_registered_type');
                 $amount  = get_option('discount_for_registered_amount');
                
                 if($type == 1){    
                   $sale = $amount.'%';
                 }else{
                   $sale = $amount.' '.get_woocommerce_currency_symbol();
                 }
               }
              
               if(isset($sale) and $sale){ ?>
                
                <div class="alert alert-success"><?= __('Prihláste sa a získajte zľavu', 'goshop');?> <?= $sale ?></div>
                <span class="btn mb-3 btn-primary btn-small js-modal pointer" data-modal=".login"> <?= __( 'Prihlásiť sa' ); ?></span>
              
               <?php } ?>
              
               
        
        		<?php endif; ?>
        
        		<?php do_action( 'woocommerce_before_checkout_registration_form', $checkout ); ?>
        
        		
        
              <div class="row create-account" style="display: none;">
                <?php foreach ( $checkout->get_checkout_fields( 'account' ) as $key => $field ) : ?>
        			<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
        		<?php endforeach; ?>
                <div class="clear"></div>
        		<div class="text-center checkout-social w-100 mb-2 mb-1">
                  <span class="facebook-login pointer js-facebook-login" success_text="<?= _('Úspešne si sa prihlásil'); ?>"><?= _('Facebook prihlásenie'); ?></span>
                  <span class="google-login pointer js-google-login" success_text="<?= _('Úspešne si sa prihlásil'); ?>"><?= _('Google prihlásenie'); ?></span>
                </div>
              </div>
            
        		<?php do_action( 'woocommerce_after_checkout_registration_form', $checkout ); ?>
        	</div>
        <?php endif; ?> 
    
	<?php endif; ?>

	<?php do_action( 'woocommerce_before_checkout_billing_form', $checkout ); ?>

	<div class="row">
		<?php
		$fields = $checkout->get_checkout_fields( 'billing' );
       
		foreach ( $fields as $key => $field ) {
            if ( isset( $field['country_field'], $fields[ $field['country_field'] ] ) ) {
			    $field['country'] = $checkout->get_value( $field['country_field'] );
			}
            woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
		}
		?>
	</div>

	<?php do_action( 'woocommerce_after_checkout_billing_form', $checkout ); ?>
</div>
