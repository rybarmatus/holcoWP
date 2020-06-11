<?php
/**
 * Checkout terms and conditions area.
 *
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

if ( apply_filters( 'woocommerce_checkout_show_terms', true ) && function_exists( 'wc_terms_and_conditions_checkbox_enabled' ) ) {
	do_action( 'woocommerce_checkout_before_terms_and_conditions' );

	?>
	<div class="woocommerce-terms-and-conditions-wrapper">
		<?php
		/**
		 * Terms and conditions hook used to inject content.
		 *
		 * @since 3.4.0.
		 * @hooked wc_checkout_privacy_policy_text() Shows custom privacy policy text. Priority 20.
		 * @hooked wc_terms_and_conditions_page_content() Shows t&c page content. Priority 30.
		 */
	//	do_action( 'woocommerce_checkout_terms_and_conditions' );
		?>

		<p class="form-row validate-required">
		  <input type="hidden" name="terms-field" value="1" />
            <input type="checkbox" required class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" name="terms" <?php checked( apply_filters( 'woocommerce_terms_is_checked_default', isset( $_POST['terms'] ) ), true ); // WPCS: input var ok, csrf ok. ?> id="terms" />
            <label class="" for="terms">
            <?= __('Prečítal/a som si','goshop'); ?> <a href="/obchodne-podmienky/" target="_blank" title="<?= __('Všeobecné obchodné podmienky', 'goshop'); ?>" class="underline"><?= __('Všeobecné obchodné podmienky', 'goshop'); ?></a> <?= __('a súhlasím s nimi', 'goshop'); ?> <span class="required">*</span>
		  </label>
        </p>
        
        <?php
        $heureka_api_kluc = get_option('option_heureka_overene_zakaznikmi_api');
    
        if(!empty($heureka_api_kluc)){
        ?>
        <p>
            <label for="heureka_checkbox">
                <input type="checkbox" name="heureka_overene" id="heureka_checkbox" />
                Súhlasím se zasielaním dotazníku spokojnosti v rámci programu Overené zákazníkmi, ktorý pomáhá zlepšovať naše služby.
            </label>
        </p>
        <?php } ?>
		
	</div>
	<?php

	do_action( 'woocommerce_checkout_after_terms_and_conditions' );
}
