<?php
/**
 * Email Addresses
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-addresses.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates/Emails
 * @version 3.5.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$text_align = is_rtl() ? 'right' : 'left';
$address    = $order->get_formatted_billing_address();
$shipping   = $order->get_formatted_shipping_address();

?><table id="addresses" cellspacing="0" cellpadding="0" style="width: 100%; vertical-align: top; padding:0;text-align: center;font-size:15px;" border="0">
	<tr style="text-align:center">
		<td style="text-align:<?php echo esc_attr( $text_align ); ?>; border:0; padding:0;" valign="top" width="50%">
			<h2 style="text-align:center;margin-bottom:5px;color:#636363"><?php esc_html_e( 'Billing address', 'woocommerce' ); ?></h2>

			<address class="address" style="padding:0;border:0;text-align: center;margin-bottom:20px;color:black;font-style:normal;">
				<?= $order->get_billing_company(); ?>
                
                <?php
                if($ico = get_post_meta( $order->get_id(), '_billing_company_ico', true )){ 
      
                  $dic = get_post_meta( $order->get_id(), '_billing_company_dic', true );
                  $ic_dph = get_post_meta( $order->get_id(), '_billing_company_ic_dhp', true );
                  
                  if($ico){
                      echo '<br>'.__('IČO','goshop'). ': '. $ico; 
                  }
                  
                  
                  if($dic){
                      echo '<br>'.__('DIČ','goshop'). ': '. $dic; 
                  }
                  if($ic_dph){
                      echo '<br>'.__('IČ DPH','goshop'). ': '. $ic_dph; 
                  }
                  
                }
                ?>
                
                <br />
                <?= $order->get_billing_first_name(); ?> <?= $order->get_billing_last_name(); ?>
                <br>
                <?= $order->get_billing_address_1(); ?> <?= $order->get_billing_address_2(); ?>
                <br>
                <?= $order->get_billing_postcode(); ?> <?= $order->get_billing_city(); ?>
                <br>
                <?= WC()->countries->countries[ $order->get_billing_country() ]; ?>
                <br>
                

                <?php if ( $order->get_billing_phone() ) : ?>
					<br /><?php echo esc_html( $order->get_billing_phone() ); ?>
				<?php endif; ?>
				<?php if ( $order->get_billing_email() ) : ?>
					<br /><?php echo esc_html( $order->get_billing_email() ); ?>
				<?php endif; ?>
			</address>
		</td>
    
		<?php if ( ! wc_ship_to_billing_address_only() && $order->needs_shipping_address() && $shipping ) : ?>
			<td style="text-align:<?php echo esc_attr( $text_align ); ?>;padding:0;" valign="top" width="50%">
				<h2 style="text-align: center;margin-bottom:5px;color:#636363"><?php esc_html_e( 'Shipping address', 'woocommerce' ); ?></h2>

				<address class="address" style="padding:0;border:0;text-align: center;color:black;font-style:normal;">
                <?= $order->get_shipping_first_name(); ?> <?= $order->get_shipping_last_name(); ?>
                <br>
                <?= $order->get_shipping_address_1(); ?> <?= $order->get_shipping_address_2(); ?>
                <br>
                <?= $order->get_shipping_postcode(); ?> <?= $order->get_shipping_city(); ?>
                <br>
                <?= WC()->countries->countries[ $order->get_shipping_country() ]; ?>
                
                
                </address>
			</td>
		<?php endif; ?>
	</tr>
</table>
